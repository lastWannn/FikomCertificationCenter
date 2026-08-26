<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Berita Acara — {{ $arsip->judul }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>

    {{-- PDF.js Library --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #131218; color: #FFFFFF; height: 100vh; overflow: hidden; display: flex; flex-direction: column; }
        
        /* Toolbar */
        .viewer-header { height: 64px; background: #131218; border-bottom: 1.5px solid rgba(255,200,26,0.25); display: flex; align-items: center; justify-content: space-between; padding: 0 24px; gap: 16px; flex-shrink: 0; z-index: 10; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: rgba(255,255,255,0.06); border: 1.5px solid rgba(255,255,255,0.15); color: #FFFFFF; border-radius: 10px; font-size: 13px; font-weight: 700; text-decoration: none; transition: all 0.2s; }
        .btn-back:hover { background: #FFC81A; color: #131218; border-color: #FFC81A; }
        
        .doc-info { display: flex; align-items: center; gap: 12px; max-width: 45%; overflow: hidden; }
        .doc-title { font-size: 14px; font-weight: 800; color: #FFFFFF; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .doc-badge { font-size: 10px; font-weight: 900; background: rgba(255,200,26,0.15); color: #FFC81A; border: 1px solid rgba(255,200,26,0.3); padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; flex-shrink: 0; }
        
        .nav-controls { display: flex; align-items: center; gap: 8px; background: #1E1D26; padding: 4px 12px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); }
        .btn-icon { background: none; border: none; color: #FFFFFF; cursor: pointer; padding: 4px; border-radius: 6px; display: flex; align-items: center; justify-content: center; opacity: 0.8; transition: all 0.2s; }
        .btn-icon:hover { opacity: 1; background: rgba(255,255,255,0.1); color: #FFC81A; }
        .page-indicator { font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.8); min-width: 70px; text-align: center; }

        .header-actions { display: flex; align-items: center; gap: 10px; }
        .btn-download { display: inline-flex; align-items: center; gap: 8px; padding: 9px 18px; background: #FFC81A; color: #131218; border: 1.5px solid #131218; border-radius: 10px; font-size: 13px; font-weight: 900; text-decoration: none; box-shadow: 0 4px 12px rgba(255,200,26,0.3); transition: all 0.2s; }
        .btn-download:hover { background: #FFFFFF; color: #131218; border-color: #FFFFFF; }
        
        /* Main Container */
        .viewer-body { flex: 1; position: relative; background: #1E1D26; width: 100%; height: calc(100vh - 64px); overflow-y: auto; overflow-x: auto; padding: 24px 0; display: flex; flex-direction: column; align-items: center; }
        
        .pdf-page-canvas { background: #FFFFFF; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border-radius: 4px; max-width: 95%; }
        
        /* Loading & Fallback */
        .status-box { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; text-align: center; padding: 24px; color: rgba(255,255,255,0.8); }
        .spinner { width: 40px; height: 40px; border: 4px solid rgba(255,200,26,0.2); border-top-color: #FFC81A; border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 16px; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>

    {{-- HEADER TOOLBAR --}}
    <header class="viewer-header">
        <a href="{{ route('landing.arsip.show', $arsip) }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Detail
        </a>

        <div class="doc-info">
            <span class="doc-badge">Berita Acara</span>
            <span class="doc-title">{{ $arsip->judul }}</span>
        </div>

        @if($extension === 'pdf')
        <div class="nav-controls" id="pdfControls" style="display:none;">
            <button class="btn-icon" id="prevPage" title="Halaman Sebelumnya">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <span class="page-indicator"><span id="pageNum">1</span> / <span id="pageCount">-</span></span>
            <button class="btn-icon" id="nextPage" title="Halaman Selanjutnya">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
            <div style="width:1px; height:16px; background:rgba(255,255,255,0.2); margin:0 4px;"></div>
            <button class="btn-icon" id="zoomOut" title="Perkecil">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
            <button class="btn-icon" id="zoomIn" title="Perbesar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
        </div>
        @endif

        <div class="header-actions">
            <a href="{{ route('landing.arsip.pdf-raw', $arsip) }}" target="_blank" class="btn-back" style="border-color:rgba(255,200,26,0.3); color:#FFC81A;" title="Buka File Mentah">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Tab Baru
            </a>
        </div>
    </header>

    {{-- MAIN CONTAINER --}}
    <main class="viewer-body" id="viewerContainer">
        @if($extension === 'pdf')
            <div class="status-box" id="loadingBox">
                <div class="spinner"></div>
                <p style="font-size:14px; font-weight:700; margin-bottom:4px;">Memuat Dokumen PDF...</p>
                <p style="font-size:12px; color:rgba(255,255,255,0.5);">Mohon tunggu sebentar</p>
            </div>
            
            <div id="pdfCanvasContainer" style="display:flex; flex-direction:column; align-items:center; width:100%;"></div>

            {{-- FALLBACK IFRAME (Jika JS dimatikan/gagal) --}}
            <noscript>
                <iframe src="{{ route('landing.arsip.pdf-raw', $arsip) }}" style="width:100%; height:100%; border:none;"></iframe>
            </noscript>
        @else
            <div class="status-box">
                <div style="width:64px; height:64px; border-radius:18px; background:rgba(255,200,26,0.12); border:1.5px solid #FFC81A; display:flex; align-items:center; justify-content:center; margin-bottom:20px; color:#FFC81A;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 1-2 2v16a2 2 0 0 1 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <h2 style="font-size:20px; font-weight:900; margin-bottom:8px;">Dokumen {{ strtoupper($extension) }}</h2>
                <p style="color:rgba(255,255,255,0.7); font-size:14px; max-width:480px; margin-bottom:24px; line-height:1.6;">
                    File dokumen ini berformat <strong>.{{ $extension }}</strong>. Silakan klik tombol di bawah untuk mengunduh dan membaca isinya.
                </p>
                <a href="{{ route('landing.arsip.pdf-raw', $arsip) }}" download class="btn-download" style="padding:12px 28px; font-size:14.5px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Unduh Dokumen (.{{ strtoupper($extension) }})
                </a>
            </div>
        @endif
    </main>

    @if($extension === 'pdf')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const url = "{{ route('landing.arsip.pdf-raw', $arsip) }}";
            const loadingBox = document.getElementById('loadingBox');
            const canvasContainer = document.getElementById('pdfCanvasContainer');
            const controls = document.getElementById('pdfControls');
            
            if (typeof pdfjsLib === 'undefined') {
                // Fallback to iframe if CDN fails
                canvasContainer.innerHTML = '<iframe src="' + url + '" style="width:100%; height:calc(100vh - 64px); border:none;"></iframe>';
                if (loadingBox) loadingBox.style.display = 'none';
                return;
            }

            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

            let pdfDoc = null;
            let currentScale = 1.3;

            pdfjsLib.getDocument(url).promise.then(function (pdf) {
                pdfDoc = pdf;
                if (loadingBox) loadingBox.style.display = 'none';
                if (controls) controls.style.display = 'flex';
                document.getElementById('pageCount').textContent = pdf.numPages;

                renderAllPages();
            }).catch(function (error) {
                console.error("PDF.js Error:", error);
                if (loadingBox) loadingBox.style.display = 'none';
                // Fallback ke iframe
                canvasContainer.innerHTML = '<iframe src="' + url + '" style="width:100%; height:calc(100vh - 64px); border:none;"></iframe>';
            });

            function renderAllPages() {
                canvasContainer.innerHTML = '';
                for (let pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
                    renderPage(pageNum);
                }
            }

            function renderPage(num) {
                pdfDoc.getPage(num).then(function (page) {
                    const viewport = page.getViewport({ scale: currentScale });
                    const canvas = document.createElement('canvas');
                    canvas.className = 'pdf-page-canvas';
                    canvas.id = 'pdf-page-' + num;
                    const ctx = canvas.getContext('2d');

                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    canvasContainer.appendChild(canvas);

                    const renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    page.render(renderContext);
                });
            }

            // Controls
            document.getElementById('zoomIn').addEventListener('click', function() {
                currentScale += 0.2;
                renderAllPages();
            });

            document.getElementById('zoomOut').addEventListener('click', function() {
                if (currentScale > 0.6) {
                    currentScale -= 0.2;
                    renderAllPages();
                }
            });

            // Scroll position page tracking
            const viewerContainer = document.getElementById('viewerContainer');
            viewerContainer.addEventListener('scroll', function() {
                const canvases = document.querySelectorAll('.pdf-page-canvas');
                canvases.forEach((canvas, idx) => {
                    const rect = canvas.getBoundingClientRect();
                    if (rect.top >= 0 && rect.top <= window.innerHeight / 2) {
                        document.getElementById('pageNum').textContent = idx + 1;
                    }
                });
            });
        });
    </script>
    @endif

</body>
</html>
