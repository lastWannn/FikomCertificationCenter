// Suppress library font warnings
console.warn = () => {};

const fs = require('fs');
const path = require('path');
const { PDFParse } = require('pdf-parse');

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
        const parser = new PDFParse(new Uint8Array(dataBuffer));
        const result = await parser.getText();

        console.log(JSON.stringify({
            status: 'success',
            text: result.text || '',
            pages: result.total || 1
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
