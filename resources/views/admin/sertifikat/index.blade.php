@extends('layouts.admin')
@section('title','Manajemen Sertifikat')
@section('page-title','Manajemen Sertifikat')

@section('page-content')
<div style="padding:24px;position:relative;">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <style>
      @keyframes skeletonShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
      }
      .fcc-skeleton-box {
        background: linear-gradient(90deg, #E2E8F0 25%, #F1F5F9 50%, #E2E8F0 75%);
        background-size: 200% 100%;
        animation: skeletonShimmer 1.4s infinite ease-in-out;
        border-radius: 12px;
      }
      #sertifikat-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="sertifikat-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
      </div>
      {{-- Top 2 Cards Skeleton --}}
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:20px;margin-bottom:24px;">
        <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
          <div class="fcc-skeleton-box" style="width:60%;height:20px;margin-bottom:16px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:50px;border-radius:10px;"></div>
        </div>
        <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
          <div class="fcc-skeleton-box" style="width:60%;height:20px;margin-bottom:16px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:50px;border-radius:10px;"></div>
        </div>
      </div>
      {{-- Table Skeleton --}}
      <div style="padding:28px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('sertifikat-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Penerbitan &amp; Sertifikasi</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Manajemen Sertifikat</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Upload template latar sertifikat dan terbitkan sertifikat digital peserta.</p>
        </div>
    </div>

    {{-- Top Section: Upload Latar & Quick Actions --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(340px, 1fr));gap:20px;margin-bottom:24px;">
        
        {{-- Card 1: Upload Template Latar --}}
        <div class="fcc-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
            <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:8px;">
                <div style="width:32px;height:32px;border-radius:10px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;">
                    @include('components.icon',['name'=>'image','size'=>16])
                </div>
                Upload Template Latar Sertifikat
            </h3>

            <form id="upload-latar-form" action="{{ route('admin.sertifikat.upload-latar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- 1. Pilih Kegiatan --}}
                <div style="margin-bottom:14px;">
                    <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                        Pilih Kegiatan *
                    </label>
                    <select id="kegiatan_select" name="kegiatan_id" class="fcc-input" required style="font-size:13px;height:42px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;width:100%;">
                        <option value="" data-has-latar="0">-- Pilih Kegiatan --</option>
                        @foreach($masterGroups as $group)
                        <option value="{{ $group['id'] }}"
                                data-latar="{{ $group['latar_url'] }}"
                                data-has-latar="{{ $group['has_latar'] ? '1' : '0' }}"
                                data-judul="{{ $group['judul'] }}"
                                {{ (string)session('uploaded_kegiatan_id') === (string)$group['id'] ? 'selected' : '' }}>
                            {{ Str::limit($group['judul'], 50) }} ({{ count($group['jadwal_list']) }} Batch) {{ $group['has_latar'] ? ' (✅ Latar Ready)' : ' (⚠️ Belum Ada Latar)' }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- 2. Status & Preview Latar Kegiatan Terpilih --}}
                <div id="latar-status-container" style="margin-bottom:18px;">
                    <div style="padding:14px;border-radius:12px;background:#F8FAFC;border:1.5px dashed #CBD5E1;text-align:center;">
                        <span style="font-size:12px;color:#64748B;font-weight:600;">
                            💡 Pilih kegiatan di atas untuk melihat status &amp; preview template latar.
                        </span>
                    </div>
                </div>

                {{-- 3. Drag & Drop File Input Zone --}}
                <div style="margin-bottom:18px;">
                    <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                        File Template Latar (PNG/JPG, A4 Landscape) *
                    </label>

                    {{-- Dropzone Area --}}
                    <div id="dropzone-box"
                         style="border:2px dashed #CBD5E1;border-radius:14px;padding:20px 16px;background:#F8FAFC;text-align:center;cursor:pointer;transition:all .2s;position:relative;"
                         onclick="document.getElementById('latar_file_input').click()"
                         ondragover="handleDragOver(event)"
                         ondragleave="handleDragLeave(event)"
                         ondrop="handleFileDrop(event)">
                        
                        <input type="file" id="latar_file_input" name="latar" accept="image/png,image/jpeg,image/jpg" required style="display:none;" onchange="handleFileSelected(this)">

                        {{-- Prompt Mode --}}
                        <div id="dropzone-prompt">
                            <div style="width:42px;height:42px;border-radius:12px;background:#FFF;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;color:#131218;box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                                @include('components.icon',['name'=>'upload-cloud','size'=>20])
                            </div>
                            <p style="margin:0 0 4px;font-size:13px;font-weight:800;color:#131218;">
                                Klik atau Seret &amp; Lepas File Latar ke Sini
                            </p>
                            <p style="margin:0;font-size:11px;color:#64748B;font-weight:500;">
                                PNG / JPG (Maks. 5 MB) &bull; A4 Landscape (3508 × 2480 px)
                            </p>
                        </div>

                        {{-- Selected File Preview Mode --}}
                        <div id="dropzone-preview" style="display:none;align-items:center;gap:14px;text-align:left;">
                            <img id="file-preview-img" src="" alt="Preview Latar Baru" style="width:72px;height:50px;object-fit:cover;border-radius:8px;border:1.5px solid #131218;box-shadow:0 2px 8px rgba(0,0,0,0.1);flex-shrink:0;">
                            <div style="flex:1;min-width:0;">
                                <span style="font-size:10px;font-weight:900;color:#10B981;background:#ECFDF5;padding:2px 8px;border-radius:12px;border:1px solid #10B981;text-transform:uppercase;">
                                    File Siap Diupload
                                </span>
                                <p id="file-preview-name" style="margin:4px 0 2px;font-size:12.5px;font-weight:800;color:#131218;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></p>
                                <p id="file-preview-info" style="margin:0;font-size:11px;color:#64748B;font-weight:600;"></p>
                            </div>
                            <button type="button" onclick="cancelSelectedFile(event)" style="background:#F1F5F9;border:1px solid #CBD5E1;border-radius:8px;padding:6px 12px;font-size:11px;font-weight:800;color:#64748B;cursor:pointer;" onmouseover="this.style.background='#FFE4E6';this.style.color='#E11D48';this.style.borderColor='#F43F5E';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
                                ✖ Ganti
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 4. Inline Progress Bar (Hidden by default, shown on submit) --}}
                <div id="upload-inline-progress" style="display:none;margin-bottom:16px;background:#FFFDF5;border:1.5px solid #FFC81A;border-radius:12px;padding:12px 14px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <span style="font-size:11.5px;font-weight:800;color:#131218;display:inline-flex;align-items:center;gap:6px;">
                            <svg style="width:14px;height:14px;animation:spin 1s linear infinite;color:#131218;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="10" stroke-opacity="0.2" />
                                <path d="M12 2 a 10 10 0 0 1 10 10" stroke-linecap="round" />
                            </svg>
                            Mengunggah &amp; Memproses WebP...
                        </span>
                        <span id="upload-progress-text" style="font-size:11.5px;font-weight:900;color:#D97706;">0%</span>
                    </div>
                    <div style="background:#E2E8F0;border-radius:8px;height:8px;width:100%;overflow:hidden;">
                        <div id="upload-progress-bar" style="background:linear-gradient(90deg, #FFC81A, #10B981);height:100%;width:0%;transition:width 0.2s linear;border-radius:8px;"></div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" id="btn-upload-submit" style="width:100%;padding:12px 18px;font-size:13.5px;border-radius:12px;font-weight:900;cursor:pointer;border:1.5px solid #131218;background:#131218;color:#FFC81A;display:inline-flex;align-items:center;justify-content:center;gap:8px;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                    <span id="btn-submit-icon">@include('components.icon',['name'=>'upload','size'=>16])</span>
                    <span id="btn-submit-text">Upload Template Latar</span>
                </button>
            </form>
        </div>

        {{-- Card 2: Kelola Layout & Penerbitan Sertifikat Per Jadwal --}}
        <div class="fcc-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);display:flex;flex-direction:column;justify-content:space-between;">
            <div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:10px;">
                    <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0;display:flex;align-items:center;gap:8px;">
                        <div style="width:32px;height:32px;border-radius:10px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;">
                            @include('components.icon',['name'=>'award','size'=>16])
                        </div>
                        Penerbitan Sertifikat Per Jadwal
                    </h3>

                    {{-- Search Input --}}
                    <input type="text" onkeyup="filterBatchList(this.value)" placeholder="🔍 Cari kegiatan..." style="padding:6px 12px;font-size:12px;border-radius:8px;border:1.5px solid #CBD5E1;width:180px;font-weight:600;">
                </div>

                <div style="display:flex;flex-direction:column;gap:8px;max-height:300px;overflow-y:auto;padding-right:4px;">
                    @foreach($masterGroups as $idx => $group)
                    <div class="master-batch-item" style="background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:12px;padding:12px;">
                        {{-- Master Header --}}
                        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
                            <div style="cursor:pointer;flex:1;" onclick="toggleBatchAccordion('batch-list-{{ $idx }}')">
                                <div style="font-size:13px;font-weight:900;color:#131218;display:flex;align-items:center;gap:6px;">
                                    <span>{{ $group['judul'] }}</span>
                                    <span id="icon-batch-list-{{ $idx }}" style="font-size:10px;color:#64748B;">▼</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:6px;margin-top:2px;">
                                    @if($group['has_latar'])
                                        <span style="font-size:9.5px;font-weight:800;color:#059669;background:#D1FAE5;padding:1px 6px;border-radius:5px;">
                                            ✔ Ready
                                        </span>
                                    @else
                                        <span style="font-size:9.5px;font-weight:800;color:#D97706;background:#FEF3C7;padding:1px 6px;border-radius:5px;">
                                            ⚠️ Tanpa Latar
                                        </span>
                                    @endif
                                    <span style="font-size:11px;color:#64748B;font-weight:700;">({{ count($group['jadwal_list']) }} Batch)</span>
                                </div>
                            </div>
                            
                            {{-- Quick Tools Per Master --}}
                            <div style="display:flex;align-items:center;gap:6px;">
                                <a href="{{ route('admin.sertifikat.preview-sample', $group['id']) }}" target="_blank" title="Lihat Hasil PDF Sampel" style="padding:3.5px 8px;font-size:10.5px;font-weight:800;color:#1E40AF;background:#EFF6FF;border:1px solid #BFDBFE;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
                                    👁️ Sample
                                </a>
                                <a href="{{ route('admin.sertifikat.layout-editor', $group['id']) }}" title="Edit Tata Letak & Font PDF" style="padding:3.5px 8px;font-size:10.5px;font-weight:800;color:#131218;background:#FFC81A;border:1px solid #131218;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
                                    🎨 Layout
                                </a>
                            </div>
                        </div>

                        {{-- Sub-Jadwal Batch List (Collapsible, hidden by default) --}}
                        <div id="batch-list-{{ $idx }}" class="batch-sub-list" style="display:none;flex-direction:column;gap:6px;margin-top:10px;border-top:1px dashed #CBD5E1;padding-top:8px;">
                            @foreach($group['jadwal_list'] as $j)
                            <div style="background:#FFF;border:1px solid #E2E8F0;border-radius:8px;padding:6px 10px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:6px;">
                                <div>
                                    <span style="font-size:11.5px;font-weight:800;color:#131218;">{{ $j['jadwal_nama'] }}</span>
                                    <span style="font-size:10.5px;color:#64748B;margin-left:4px;">({{ $j['tgl_pelaksanaan_format'] }})</span>
                                    <div style="font-size:10px;color:#475569;font-weight:700;">
                                        Peserta: <strong>{{ $j['total_peserta'] }}</strong> | Terbit: <strong style="color:#059669;">{{ $j['total_terbit'] }}</strong>
                                    </div>
                                </div>

                                <a href="{{ route('admin.sertifikat.peserta', $j['kegiatan']) }}" style="padding:3px 8px;font-size:10px;font-weight:800;color:#131218;background:#F1F5F9;border:1px solid #94A3B8;border-radius:6px;text-decoration:none;">
                                    👥 Peserta
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
        function toggleBatchAccordion(id) {
            var elem = document.getElementById(id);
            var icon = document.getElementById('icon-' + id);
            if (elem) {
                if (elem.style.display === 'none' || !elem.style.display) {
                    elem.style.display = 'flex';
                    if (icon) icon.innerText = '▲';
                } else {
                    elem.style.display = 'none';
                    if (icon) icon.innerText = '▼';
                }
            }
        }

        function filterBatchList(query) {
            var q = query.toLowerCase().trim();
            var cards = document.querySelectorAll('.master-batch-item');
            cards.forEach(function(card) {
                var text = card.textContent.toLowerCase();
                if (!q || text.includes(q)) {
                    card.style.display = 'block';
                    if (q) {
                        var sub = card.querySelector('.batch-sub-list');
                        if (sub) sub.style.display = 'flex';
                    }
                } else {
                    card.style.display = 'none';
                }
            });
        }
        </script>

    </div>

    {{-- ═════ LIGHTBOX MODAL FOR FULL IMAGE PREVIEW ═════ --}}
    <div id="latar-modal-overlay" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.85);backdrop-filter:blur(6px);z-index:99998;align-items:center;justify-content:center;padding:24px;" onclick="closeLatarModal()">
        <div style="position:relative;max-width:90%;max-height:90%;display:flex;flex-direction:column;align-items:center;" onclick="event.stopPropagation()">
            <button onclick="closeLatarModal()" style="position:absolute;top:-18px;right:-18px;width:36px;height:36px;border-radius:50%;background:#FFC81A;color:#131218;border:2px solid #131218;font-weight:900;font-size:16px;cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;">
                ✕
            </button>
            <h4 id="modal-latar-title" style="color:#FFF;font-size:15px;font-weight:900;margin:0 0 12px;text-align:center;">Preview Full Template Latar</h4>
            <img id="modal-latar-img" src="" alt="Full Latar Sertifikat" style="max-width:100%;max-height:80vh;border-radius:12px;border:3px solid #FFFFFF;box-shadow:0 12px 36px rgba(0,0,0,0.5);">
        </div>
    </div>

    <style>
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectElem = document.getElementById('kegiatan_select');
            if (selectElem) {
                selectElem.addEventListener('change', updateLatarStatus);
                updateLatarStatus(); // Trigger initial state on load
            }

            var uploadForm = document.getElementById('upload-latar-form');
            if (uploadForm) {
                uploadForm.addEventListener('submit', handleFormSubmit);
            }
        });

        // 1. Update Latar Status & Preview Card based on selected kegiatan
        function updateLatarStatus() {
            var selectElem = document.getElementById('kegiatan_select');
            var container  = document.getElementById('latar-status-container');
            if (!selectElem || !container) return;

            var selectedOpt = selectElem.options[selectElem.selectedIndex];
            var val         = selectElem.value;
            var hasLatar    = selectedOpt.getAttribute('data-has-latar') === '1';
            var latarUrl    = selectedOpt.getAttribute('data-latar');
            var judul       = selectedOpt.getAttribute('data-judul') || '';

            if (!val) {
                container.innerHTML = `
                    <div style="padding:14px;border-radius:12px;background:#F8FAFC;border:1.5px dashed #CBD5E1;text-align:center;">
                        <span style="font-size:12px;color:#64748B;font-weight:600;">
                            💡 Pilih kegiatan di atas untuk melihat status &amp; preview template latar.
                        </span>
                    </div>
                `;
                return;
            }

            if (hasLatar && latarUrl) {
                const editorUrl = "{{ route('admin.sertifikat.layout-editor', ':id') }}".replace(':id', selectedId);
                container.innerHTML = `
                    <div style="background:#ECFDF5;border:1.5px solid #10B981;border-radius:14px;padding:14px;position:relative;transition:all .2s;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;flex-wrap:wrap;gap:8px;">
                            <span style="font-size:11px;font-weight:900;color:#047857;background:#D1FAE5;padding:3px 10px;border-radius:20px;border:1px solid #10B981;text-transform:uppercase;letter-spacing:0.5px;display:inline-flex;align-items:center;gap:4px;">
                                ✅ Template Latar Sudah Terupload
                            </span>
                            <div style="display:flex;gap:6px;">
                                <a href="${editorUrl}"
                                   style="font-size:11px;font-weight:800;color:#FFFFFF;background:#F59E0B;border:1px solid #D97706;padding:4px 10px;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;box-shadow:0 2px 6px rgba(245,158,11,0.25);">
                                    🎨 Atur Koordinat Teks
                                </a>
                                <button type="button" onclick="openLatarModal('${latarUrl}', '${judul.replace(/'/g, "\\'")}')"
                                        style="font-size:11px;font-weight:800;color:#065F46;background:#FFF;border:1px solid #10B981;padding:4px 10px;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;transition:all .15s;"
                                        onmouseover="this.style.background='#10B981';this.style.color='#FFF';" onmouseout="this.style.background='#FFF';this.style.color='#065F46';">
                                    🔍 Zoom
                                </button>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="position:relative;width:96px;height:65px;border-radius:8px;overflow:hidden;border:1.5px solid #059669;box-shadow:0 3px 10px rgba(0,0,0,0.12);flex-shrink:0;cursor:pointer;" onclick="openLatarModal('${latarUrl}', '${judul.replace(/'/g, "\\'")}')">
                                <img src="${latarUrl}" alt="Preview Latar" style="width:100%;height:100%;object-fit:cover;">
                                <div style="position:absolute;bottom:0;left:0;right:0;background:rgba(0,0,0,0.6);color:#FFF;font-size:9px;font-weight:800;text-align:center;padding:2px 0;">A4 Landscape</div>
                            </div>
                            <div>
                                <p style="margin:0 0 2px;font-size:12.5px;font-weight:800;color:#064E3B;">Latar Sertifikat Aktif</p>
                                <p style="margin:0;font-size:11px;color:#047857;font-weight:500;line-height:1.4;">
                                    Kegiatan ini sudah memiliki latar. Unggah file baru di bawah jika ingin memperbarui / mengganti template.
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div style="background:#FFFBEB;border:1.5px solid #F59E0B;border-radius:14px;padding:14px;transition:all .2s;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;border-radius:10px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;color:#D97706;flex-shrink:0;">
                                ⚠️
                            </div>
                            <div>
                                <span style="font-size:11px;font-weight:900;color:#B45309;background:#FEF3C7;padding:2px 8px;border-radius:12px;border:1px solid #F59E0B;text-transform:uppercase;letter-spacing:0.5px;">
                                    Belum Ada Template Latar
                                </span>
                                <p style="margin:4px 0 0;font-size:12px;color:#78350F;font-weight:600;">
                                    Kegiatan ini belum memiliki template latar sertifikat. Silakan upload file PNG/JPG di bawah.
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            }
        }

        // 2. Drag and Drop handlers
        function handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            var box = document.getElementById('dropzone-box');
            if (box) {
                box.style.borderColor = '#FFC81A';
                box.style.background  = '#FFFDF5';
            }
        }

        function handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            var box = document.getElementById('dropzone-box');
            if (box) {
                box.style.borderColor = '#CBD5E1';
                box.style.background  = '#F8FAFC';
            }
        }

        function handleFileDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            handleDragLeave(e);

            var dt = e.dataTransfer;
            var files = dt.files;
            if (files && files.length > 0) {
                var input = document.getElementById('latar_file_input');
                input.files = files;
                handleFileSelected(input);
            }
        }

        // 3. Client-side Image Selection & Preview
        function handleFileSelected(input) {
            var promptZone = document.getElementById('dropzone-prompt');
            var previewZone = document.getElementById('dropzone-preview');
            var previewImg  = document.getElementById('file-preview-img');
            var previewName = document.getElementById('file-preview-name');
            var previewInfo = document.getElementById('file-preview-info');

            if (!input.files || input.files.length === 0) {
                promptZone.style.display = 'block';
                previewZone.style.display = 'none';
                return;
            }

            var file = input.files[0];
            var sizeKb = (file.size / 1024).toFixed(1);
            var sizeText = sizeKb > 1024 ? (sizeKb / 1024).toFixed(2) + ' MB' : sizeKb + ' KB';

            previewName.innerText = file.name;
            previewInfo.innerText = `Ukuran: ${sizeText} | Tipe: ${file.type || 'Gambar'}`;

            var reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                promptZone.style.display = 'none';
                previewZone.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }

        function cancelSelectedFile(e) {
            if (e) e.stopPropagation();
            var input = document.getElementById('latar_file_input');
            input.value = '';
            document.getElementById('dropzone-prompt').style.display = 'block';
            document.getElementById('dropzone-preview').style.display = 'none';
        }

        // 4. Submit Animation & Inline Progress Bar
        function handleFormSubmit(e) {
            var inlineProgress = document.getElementById('upload-inline-progress');
            var pBar           = document.getElementById('upload-progress-bar');
            var pText          = document.getElementById('upload-progress-text');
            var btnText        = document.getElementById('btn-submit-text');
            var btnIcon        = document.getElementById('btn-submit-icon');
            var btnSubmit      = document.getElementById('btn-upload-submit');

            if (inlineProgress) {
                inlineProgress.style.display = 'block';
            }

            if (btnSubmit) {
                btnSubmit.style.pointerEvents = 'none';
                btnSubmit.style.opacity = '0.85';
            }
            if (btnText) btnText.innerText = 'Mengunggah & Memproses...';
            if (btnIcon) btnIcon.innerHTML = `
                <svg style="width:16px;height:16px;animation:spin 1s linear infinite;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="10" stroke-opacity="0.2" />
                    <path d="M12 2 a 10 10 0 0 1 10 10" stroke-linecap="round" />
                </svg>
            `;

            var progress = 10;
            if (pBar) pBar.style.width = '10%';
            if (pText) pText.innerText = '10%';

            var interval = setInterval(function() {
                if (progress < 92) {
                    progress += Math.floor(Math.random() * 12) + 8;
                    if (progress > 92) progress = 92;
                    if (pBar) pBar.style.width = progress + '%';
                    if (pText) pText.innerText = progress + '%';
                } else {
                    clearInterval(interval);
                }
            }, 120);
        }

        // 5. Modal Zoom Preview Functions
        function openLatarModal(url, title) {
            var modal = document.getElementById('latar-modal-overlay');
            var img   = document.getElementById('modal-latar-img');
            var tElem = document.getElementById('modal-latar-title');
            if (modal && img) {
                img.src = url;
                if (tElem && title) tElem.innerText = 'Preview Latar: ' + title;
                modal.style.display = 'flex';
            }
        }

        function closeLatarModal() {
            var modal = document.getElementById('latar-modal-overlay');
            if (modal) modal.style.display = 'none';
        }
    </script>

    {{-- Tabel Sertifikat Diterbitkan (Neo-Brutalist) --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Sertifikat Terbit</h3>
                <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $sertifikat->total() }} Sertifikat</span>
            </div>

            {{-- Search & Filter Form --}}
            <form method="GET" action="{{ route('admin.sertifikat.index') }}" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / no. sertifikat..." class="fcc-input" style="font-size:12.5px;height:38px;padding:0 12px 0 32px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:220px;">
                    <div style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94A3B8;pointer-events:none;">
                        @include('components.icon',['name'=>'search','size'=>14])
                    </div>
                </div>

                <select name="filter_kegiatan" class="fcc-input" style="font-size:12px;height:38px;padding:0 10px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;max-width:180px;">
                    <option value="">-- Semua Kegiatan --</option>
                    @foreach($masterGroups as $group)
                    <option value="{{ $group['id'] }}" {{ request('filter_kegiatan') == $group['id'] ? 'selected' : '' }}>
                        {{ Str::limit($group['judul'], 30) }}
                    </option>
                    @endforeach
                </select>

                <button type="submit" style="height:38px;padding:0 14px;font-size:12px;font-weight:800;background:#131218;color:#FFC81A;border-radius:10px;border:1.5px solid #131218;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
                    Cari
                </button>

                @if(request('q') || request('filter_kegiatan'))
                <a href="{{ route('admin.sertifikat.index') }}" style="height:38px;padding:0 12px;font-size:12px;font-weight:800;background:#F1F5F9;color:#64748B;border-radius:10px;border:1.5px solid #CBD5E1;text-decoration:none;display:inline-flex;align-items:center;">
                    Reset
                </a>
                @endif
            </form>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">No. Sertifikat</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Peserta</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Kegiatan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">Tgl Terbit</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:160px;">File Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sertifikat as $s)
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        
                        {{-- No. Sertifikat --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 10px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">
                                {{ $s->nomor_sertifikat }}
                            </span>
                        </td>

                        {{-- Peserta --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;">{{ $s->pendaftaran->peserta->nama ?? '-' }}</p>
                            <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;">{{ $s->pendaftaran->peserta->email ?? '-' }}</p>
                        </td>

                        {{-- Kegiatan --}}
                        <td style="padding:14px 16px;vertical-align:middle;font-size:13px;color:#131218;font-weight:800;">
                            {{ Str::limit($s->pendaftaran->kegiatan->judul ?? '-', 38) }}
                        </td>

                        {{-- Tgl Terbit --}}
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;font-size:13px;color:#64748B;font-weight:700;">
                            📅 {{ $s->tgl_terbit?->format('d M Y') ?? '-' }}
                        </td>

                        {{-- File Sertifikat --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <a href="{{ route('admin.cetak.sertifikat', $s) }}" target="_blank"
                               style="padding:6px 14px;font-size:12px;font-weight:800;background:#131218;color:#FFC81A;border-radius:8px;border:1px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                               onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                                @include('components.icon',['name'=>'printer','size'=>13]) Lihat PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'award','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Sertifikat Diterbitkan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Sertifikat yang telah diterbitkan untuk peserta akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Pagination Bar --}}
        <div style="padding:16px 24px;border-top:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;">
            <div style="font-size:12.5px;font-weight:700;color:#64748B;">
                Menampilkan <strong style="color:#131218;">{{ $sertifikat->firstItem() ?? 0 }}</strong> - <strong style="color:#131218;">{{ $sertifikat->lastItem() ?? 0 }}</strong> dari <strong style="color:#131218;">{{ $sertifikat->total() }}</strong> Sertifikat Terbit
            </div>
            <div>
                {{ $sertifikat->links() }}
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
