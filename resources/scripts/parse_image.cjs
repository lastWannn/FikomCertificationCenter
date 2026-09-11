// Suppress library font warnings
console.warn = () => {};

const fs = require('fs');
const path = require('path');

let createWorker;
try {
    const tesseract = require('tesseract.js');
    createWorker = tesseract.createWorker;
} catch (e) {
    console.log(JSON.stringify({
        status: 'error',
        message: "Module 'tesseract.js' belum terinstall. Silakan jalankan 'npm install' di terminal proyek."
    }));
    process.exit(1);
}

async function main() {
    const filePath = process.argv[2];
    if (!filePath) {
        console.log(JSON.stringify({ status: 'error', message: 'No image file path provided.' }));
        process.exit(1);
    }

    const resolvedPath = path.resolve(filePath);
    if (!fs.existsSync(resolvedPath)) {
        console.log(JSON.stringify({ status: 'error', message: `File not found at ${resolvedPath}` }));
        process.exit(1);
    }

    try {
        const worker = await createWorker('eng');
        
        // 1. Pass pertama: Ekstraksi seluruh teks dan deteksi garis/blok
        const firstPass = await worker.recognize(resolvedPath, {}, { blocks: true });
        
        const lines = [];
        if (firstPass.data && firstPass.data.blocks) {
            for (const block of firstPass.data.blocks) {
                if (!block.paragraphs) continue;
                for (const para of block.paragraphs) {
                    if (!para.lines) continue;
                    for (const line of para.lines) {
                        lines.push({
                            text: line.text.trim(),
                            bbox: line.bbox
                        });
                    }
                }
            }
        }

        // 2. Deteksi baris-baris materi/tabel yang nilainya mungkin berada di kolom sebelah kanan
        const fullLines = [];
        for (const item of lines) {
            let lineText = item.text;
            
            // Jika baris berisi judul materi tabel (misal Y di atas 1000, X di sebelah kiri) tapi belum memuat tanda % atau angka nilai
            if (item.bbox && item.bbox.x0 < 800 && item.bbox.y0 > 1000 && !lineText.includes('%')) {
                // Coba scan kolom nilai di sebelah kanan pada baris Y yang sama
                try {
                    const cellRes = await worker.recognize(resolvedPath, {
                        rectangle: {
                            left: 1150,
                            top: Math.max(0, item.bbox.y0 - 15),
                            width: 200,
                            height: Math.max(45, (item.bbox.y1 - item.bbox.y0) + 30)
                        }
                    });
                    const scoreText = (cellRes.data.text || '').trim();
                    if (scoreText && (scoreText.includes('%') || !isNaN(parseInt(scoreText)))) {
                        lineText += ' ' + scoreText;
                    }
                } catch (e) {
                    // Ignore cell crop failure
                }
            }
            
            fullLines.push(lineText);
        }

        await worker.terminate();

        const finalText = fullLines.length > 0 ? fullLines.join('\n') : (firstPass.data.text || '');

        console.log(JSON.stringify({
            status: 'success',
            text: finalText
        }));
    } catch (err) {
        console.log(JSON.stringify({
            status: 'error',
            message: err.message || 'Gagal memproses OCR gambar.'
        }));
        process.exit(1);
    }
}

main();
