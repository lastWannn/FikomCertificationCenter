// Suppress library font warnings
console.warn = () => {};

const fs = require('fs');
const path = require('path');

let pkg;
try {
    pkg = require('pdf-parse');
} catch (e) {
    console.log(JSON.stringify({
        status: 'error',
        message: "Module 'pdf-parse' belum terinstall di node_modules. Silakan jalankan 'npm install' di terminal proyek."
    }));
    process.exit(1);
}

async function main() {
    const filePath = process.argv[2];
    if (!filePath) {
        console.log(JSON.stringify({ status: 'error', message: 'No PDF file path provided.' }));
        process.exit(1);
    }

    const resolvedPath = path.resolve(filePath);
    if (!fs.existsSync(resolvedPath)) {
        console.log(JSON.stringify({ status: 'error', message: `File not found at ${resolvedPath}` }));
        process.exit(1);
    }

    try {
        const dataBuffer = fs.readFileSync(resolvedPath);
        let text = '';
        let pages = 1;

        if (pkg.PDFParse) {
            // pdf-parse v2+
            const parser = new pkg.PDFParse(new Uint8Array(dataBuffer));
            const result = await parser.getText();
            text = result.text || '';
            pages = result.total || 1;
        } else if (typeof pkg === 'function') {
            // pdf-parse v1.x
            const result = await pkg(dataBuffer);
            text = result.text || '';
            pages = result.numpages || 1;
        } else {
            throw new Error('Format library pdf-parse tidak dikenali.');
        }

        console.log(JSON.stringify({
            status: 'success',
            text: text,
            pages: pages
        }));
    } catch (err) {
        console.log(JSON.stringify({
            status: 'error',
            message: err.message || 'Failed to parse PDF.'
        }));
        process.exit(1);
    }
}

main();
