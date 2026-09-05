@extends('layouts.peserta')
@section('title','Sertifikat Saya')
@section('page-title','Sertifikat Saya')
@section('page-content')
<div class="fcc-sertifikat-page-wrap" style="padding:24px 28px;background:#F6F8FB;min-height:100vh;font-family:'Inter',sans-serif;position:relative;">

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

      @media (max-width: 640px) {
        .fcc-sertifikat-page-wrap {
          padding: 14px 12px 32px !important;
        }
        #sertifikat-skeleton-overlay {
          padding: 14px 12px 32px !important;
        }
        .fcc-sertifikat-testimoni-banner {
          padding: 14px 16px !important;
          border-radius: 16px !important;
          flex-direction: column !important;
          align-items: stretch !important;
          gap: 12px !important;
        }
        .fcc-sertifikat-testimoni-banner a {
          width: 100% !important;
          text-align: center !important;
          justify-content: center !important;
          box-sizing: border-box !important;
        }
        .fcc-sertifikat-card {
          padding: 18px 16px !important;
          border-radius: 16px !important;
        }
        .fcc-sertifikat-card-icon {
          width: 48px !important;
          height: 48px !important;
          border-radius: 14px !important;
          margin-bottom: 12px !important;
        }
        .fcc-sertifikat-card h3 {
          font-size: 14px !important;
        }
        .fcc-sertifikat-card-no {
          font-size: 11px !important;
          word-break: break-all !important;
        }
        .fcc-sertifikat-card a, .fcc-sertifikat-card span {
          box-sizing: border-box !important;
        }
      }
    </style>

    <div id="sertifikat-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:280px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
      </div>
      {{-- Grid Cards Skeleton --}}
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:20px;">
        @for($s=0;$s<3;$s++)
        <div style="padding:26px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;text-align:center;">
          <div class="fcc-skeleton-box" style="width:60px;height:60px;border-radius:16px;margin:0 auto 16px;"></div>
          <div class="fcc-skeleton-box" style="width:80%;height:18px;margin:0 auto 10px;"></div>
          <div class="fcc-skeleton-box" style="width:60%;height:14px;margin:0 auto 18px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:40px;border-radius:12px;"></div>
        </div>
        @endfor
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
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Pencapaian &amp; Kompetensi</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Sertifikat Saya</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Lihat, terbitkan, dan unduh sertifikat resmi pelatihan &amp; sertifikasi kompetensi Anda (Aturan 1x Generation).</p>
        </div>
    </div>

    @if(!($hasTestimoni ?? true))
    <div class="fcc-sertifikat-testimoni-banner" style="margin-bottom:24px;padding:16px 20px;background:#FFFBEB;border:2px solid #F59E0B;border-radius:18px;color:#B45309;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;box-shadow:0 6px 18px rgba(245,158,11,0.18);">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:40px;height:40px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <p style="margin:0;font-size:14px;font-weight:900;color:#92400E;">Wajib Mengisi Testimoni Pengalaman</p>
                <p style="margin:2px 0 0;font-size:12.5px;color:#B45309;font-weight:600;">Silakan isi testimoni terlebih dahulu untuk membuka akses penerbitan dan pengunduhan sertifikat.</p>
            </div>
        </div>
        <a href="{{ route('peserta.testimoni') }}" style="padding:9px 18px;font-size:12.5px;font-weight:900;background:#131218;color:#FFC81A;border-radius:20px;text-decoration:none;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(19,18,24,0.15);display:inline-flex;align-items:center;gap:6px;">
            Isi Testimoni Sekarang &rarr;
        </a>
    </div>
    @endif

    @if($pendaftaranList->isEmpty())
    <div class="fcc-card" style="text-align:center;padding:64px 24px;background:#FFFFFF;border-radius:20px;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div style="width:64px;height:64px;border-radius:20px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 6px 16px rgba(255,200,26,0.3);">
            @include('components.icon', ['name' => 'award', 'size' => 30, 'style' => 'color:#131218'])
        </div>
        <h3 style="font-size:17px;font-weight:900;color:#131218;margin:0 0 6px;">Belum Ada Sertifikat Diterbitkan</h3>
        <p style="color:#64748B;font-size:13.5px;margin:0 0 22px;font-weight:500;">Selesaikan pendaftaran program pelatihan atau kelulusan sertifikasi untuk menerbitkan sertifikat digital Anda.</p>
        <a href="{{ route('peserta.jelajahi') }}" class="fcc-btn-gold" style="padding:10px 24px;font-size:13.5px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;border-radius:30px;font-weight:900;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
            @include('components.icon', ['name' => 'compass', 'size' => 16]) Jelajahi Katalog Kegiatan &rarr;
        </a>
    </div>
    @else
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(290px, 1fr));gap:20px;">
        @foreach($pendaftaranList as $pd)
        @php
            $s = $pd->sertifikat;
            $formattedNama = \Illuminate\Support\Str::title(mb_strtolower($pd->peserta->nama));
        @endphp
        <div class="fcc-card fcc-sertifikat-card" style="padding:24px;text-align:center;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);display:flex;flex-direction:column;justify-content:space-between;transition:all .18s;"
             onmouseover="this.style.borderColor='#131218';this.style.transform='translateY(-3px)';"
             onmouseout="this.style.borderColor='#E5E7EB';this.style.transform='translateY(0)';">
            <div>
                <div class="fcc-sertifikat-card-icon" style="width:56px;height:56px;border-radius:16px;background:#131218;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;box-shadow:0 6px 16px rgba(19,18,24,0.25);">
                    @include('components.icon', ['name' => 'award', 'size' => 26, 'style' => 'color:#FFC81A'])
                </div>
                
                <div style="margin-bottom:10px;">
                    @if($s)
                        <span style="background:#D1FAE5;color:#047857;border:1px solid #10B981;font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:12px;text-transform:uppercase;letter-spacing:0.5px;">
                            ✔ Sertifikat Resmi Diterbitkan
                        </span>
                    @elseif(!$pd->transkrip_nilai)
                        <span style="background:#FEF3C7;color:#D97706;border:1px solid #F59E0B;font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:12px;text-transform:uppercase;letter-spacing:0.5px;">
                            ⚠️ Wajib Upload Transkrip
                        </span>
                    @else
                        <span style="background:#EFF6FF;color:#1D4ED8;border:1px solid #93C5FD;font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:12px;text-transform:uppercase;letter-spacing:0.5px;">
                            📄 Transkrip Terunggah
                        </span>
                    @endif
                </div>

                <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0 0 6px;line-height:1.35;">{{ Str::limit($pd->kegiatan->judul ?? '-', 48) }}</h3>
                
                <p style="font-size:12px;color:#475569;margin:0 0 8px;font-weight:700;">
                    Atas Nama: <strong style="color:#0F172A;font-weight:900;">{{ $formattedNama }}</strong>
                </p>

                @if($s)
                    <p style="font-size:11.5px;color:#64748B;margin:0 0 6px;font-weight:600;">
                        No. Sertifikat: <span class="fcc-sertifikat-card-no" style="font-family:monospace;font-weight:900;color:#131218;background:#F1F5F9;padding:2px 8px;border-radius:6px;border:1px solid #CBD5E1;">{{ $s->nomor_sertifikat }}</span>
                    </p>
                    <p style="font-size:11px;color:#94A3B8;margin:0 0 18px;font-weight:700;">Tgl Terbit: {{ $s->tgl_terbit?->translatedFormat('d F Y') ?? '-' }}</p>
                @elseif(!$pd->transkrip_nilai)
                    <p style="font-size:11.5px;color:#B45309;margin:0 0 18px;font-weight:600;background:#FFFBEB;padding:10px 12px;border-radius:10px;border:1px solid #FDE68A;line-height:1.45;">
                        📌 Silakan unggah berkas <strong>Transkrip Nilai</strong> Anda terlebih dahulu agar penerbitan sertifikat dapat diproses oleh Admin.
                    </p>
                @else
                    <div style="background:#F0FDF4;padding:8px 12px;border-radius:10px;border:1px solid #BBF7D0;margin-bottom:18px;font-size:11.5px;color:#166534;font-weight:600;display:flex;align-items:center;justify-content:space-between;gap:6px;">
                        <span style="display:inline-flex;align-items:center;gap:4px;">
                            @include('components.icon',['name'=>'check-circle','size'=>14,'style'=>'color:#10B981'])
                            Berkas Siap Diverifikasi
                        </span>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ $pd->transkrip_url }}" target="_blank" style="color:#2563EB;font-weight:800;text-decoration:underline;font-size:11px;">Lihat</a>
                            <span style="color:#CBD5E1;">|</span>
                            <button type="button" onclick="openUploadModal('{{ $pd->hashid }}', '{{ addslashes($pd->kegiatan->judul ?? '') }}')" style="background:none;border:none;color:#D97706;font-weight:800;cursor:pointer;padding:0;font-size:11px;text-decoration:underline;">Ganti</button>
                        </div>
                    </div>
                @endif
            </div>

            <div>
                @if($s)
                    @if($hasTestimoni ?? true)
                        <a href="{{ route('peserta.sertifikat.download', $s) }}" class="fcc-btn-gold" style="padding:10px 16px;font-size:12.5px;text-decoration:none;justify-content:center;width:100%;border-radius:12px;font-weight:900;box-shadow:0 4px 12px rgba(255,200,26,0.3);display:inline-flex;align-items:center;gap:6px;">
                            @include('components.icon', ['name' => 'download', 'size' => 15]) Unduh Sertifikat (PDF) &rarr;
                        </a>
                    @else
                        <a href="{{ route('peserta.testimoni') }}" style="display:inline-flex;align-items:center;gap:6px;padding:10px 16px;font-size:12px;text-decoration:none;justify-content:center;width:100%;border-radius:12px;font-weight:900;background:#FFFBEB;color:#D97706;border:1.5px solid #F59E0B;box-shadow:0 4px 12px rgba(245,158,11,0.2);">
                            🔒 Isi Testimoni untuk Unduh &rarr;
                        </a>
                    @endif
                @elseif(!$pd->transkrip_nilai)
                    {{-- Tombol Unggah Transkrip Nilai (Menimpa Menunggu Penerbitan) --}}
                    <button type="button" onclick="openUploadModal('{{ $pd->hashid }}', '{{ addslashes($pd->kegiatan->judul ?? '') }}')" class="fcc-btn-gold" style="padding:11px 16px;font-size:12.5px;text-decoration:none;justify-content:center;width:100%;border-radius:12px;font-weight:900;box-shadow:0 4px 14px rgba(255,200,26,0.35);display:inline-flex;align-items:center;gap:6px;border:none;cursor:pointer;">
                        @include('components.icon', ['name' => 'upload', 'size' => 15]) Unggah Transkrip Nilai &rarr;
                    </button>
                @else
                    {{-- Sudah upload transkrip, baru muncul Menunggu Penerbitan oleh Admin --}}
                    <span style="display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:10px 16px;font-size:12px;width:100%;border-radius:12px;font-weight:800;background:#F1F5F9;color:#64748B;border:1.5px solid #CBD5E1;box-sizing:border-box;">
                        🔒 Menunggu Penerbitan oleh Admin
                    </span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- ═══ MODAL UPLOAD TRANSKRIP NILAI ═══════════════════════════════ --}}
<div id="upload-transkrip-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:16px;">
    <div style="background:#FFFFFF;border-radius:24px;max-width:480px;width:100%;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,0.25);border:2px solid #131218;animation:modalZoomIn .2s cubic-bezier(.4,0,.2,1);">
        {{-- Header Modal --}}
        <div style="background:#131218;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:2px solid #FFC81A;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:38px;height:38px;border-radius:10px;background:#FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
                    @include('components.icon', ['name' => 'file-text', 'size' => 20])
                </div>
                <div>
                    <h3 style="margin:0;color:#FFFFFF;font-size:16px;font-weight:900;">Unggah Transkrip Nilai</h3>
                    <p id="upload-modal-judul" style="margin:2px 0 0;color:rgba(255,255,255,0.7);font-size:11.5px;max-width:320px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></p>
                </div>
            </div>
            <button type="button" onclick="closeUploadModal()" style="background:rgba(255,255,255,0.1);border:none;border-radius:8px;color:#FFF;padding:6px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                @include('components.icon', ['name' => 'x', 'size' => 18])
            </button>
        </div>

        {{-- Form Modal --}}
        <form id="upload-transkrip-form" method="POST" enctype="multipart/form-data" style="padding:24px;">
            @csrf
            
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:800;color:#131218;margin-bottom:6px;">Pilih Berkas Transkrip Nilai</label>
                <p style="margin:0 0 12px;font-size:11.5px;color:#64748B;line-height:1.45;">
                    Unggah transkrip nilai akademik Anda dalam format <strong>PDF, JPG, JPEG, atau PNG</strong> (Maksimal 5MB). Sistem kami akan <strong>secara otomatis membaca dan mencocokkan nilai Anda</strong> untuk mempercepat proses verifikasi dan penerbitan sertifikat.
                </p>

                {{-- Custom File Upload Area --}}
                <div id="file-drop-area" style="border:2px dashed #CBD5E1;border-radius:16px;padding:24px 16px;text-align:center;background:#F8FAFC;cursor:pointer;transition:all .2s;" onclick="document.getElementById('input-file-transkrip').click()" ondragover="event.preventDefault();this.style.borderColor='#FFC81A';this.style.background='#FFFDF5';" ondragleave="this.style.borderColor='#CBD5E1';this.style.background='#F8FAFC';" ondrop="handleFileDrop(event)">
                    <input type="file" id="input-file-transkrip" name="transkrip_nilai" accept=".pdf,.jpg,.jpeg,.png" style="display:none;" onchange="handleFileSelect(this)" required>
                    
                    <div style="width:48px;height:48px;border-radius:14px;background:#FFF;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;box-shadow:0 4px 10px rgba(0,0,0,0.03);">
                        @include('components.icon', ['name' => 'upload-cloud', 'size' => 24, 'style' => 'color:#FFC81A'])
                    </div>
                    <p id="file-name-display" style="margin:0 0 4px;font-size:13px;font-weight:800;color:#131218;">
                        Klik untuk memilih berkas transkrip
                    </p>
                    <span id="file-size-display" style="font-size:11px;color:#94A3B8;font-weight:600;">
                        atau seret &amp; lepas file ke sini (PDF/Gambar max 5MB)
                    </span>
                </div>
            </div>

            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeUploadModal()" style="padding:10px 18px;font-size:13px;font-weight:800;border-radius:10px;border:1.5px solid #CBD5E1;background:#FFF;color:#64748B;cursor:pointer;">
                    Batal
                </button>
                <button type="submit" id="btn-submit-transkrip" class="fcc-btn-gold" style="padding:10px 22px;font-size:13px;font-weight:900;border-radius:10px;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 12px rgba(255,200,26,0.35);">
                    @include('components.icon', ['name' => 'check', 'size' => 16]) Simpan &amp; Unggah
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes modalZoomIn {
    from { transform: scale(0.92); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
</style>

<script>
function openUploadModal(hashid, judul) {
    var modal = document.getElementById('upload-transkrip-modal');
    var form = document.getElementById('upload-transkrip-form');
    var judulText = document.getElementById('upload-modal-judul');
    var nameDisp = document.getElementById('file-name-display');
    var sizeDisp = document.getElementById('file-size-display');
    var input = document.getElementById('input-file-transkrip');
    
    if (input) input.value = '';
    if (nameDisp) nameDisp.innerHTML = 'Klik untuk memilih berkas transkrip';
    if (sizeDisp) sizeDisp.innerHTML = 'atau seret &amp; lepas file ke sini (PDF/Gambar max 5MB)';
    
    if (judulText) judulText.innerText = judul;
    if (form) {
        form.action = "{{ url('peserta/sertifikat') }}/" + hashid + "/upload-transkrip";
    }
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeUploadModal() {
    var modal = document.getElementById('upload-transkrip-modal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        showSelectedFileInfo(input.files[0]);
    }
}

function handleFileDrop(e) {
    e.preventDefault();
    var dropArea = document.getElementById('file-drop-area');
    if (dropArea) {
        dropArea.style.borderColor = '#CBD5E1';
        dropArea.style.background = '#F8FAFC';
    }
    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
        var input = document.getElementById('input-file-transkrip');
        input.files = e.dataTransfer.files;
        showSelectedFileInfo(e.dataTransfer.files[0]);
    }
}

function showSelectedFileInfo(file) {
    var nameDisp = document.getElementById('file-name-display');
    var sizeDisp = document.getElementById('file-size-display');
    if (nameDisp) {
        nameDisp.innerHTML = '<span style="color:#059669;">📄 ' + file.name + '</span>';
    }
    if (sizeDisp) {
        var sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        sizeDisp.innerHTML = 'Ukuran: <strong>' + sizeMB + ' MB</strong> — Siap diunggah';
    }
}
</script>
@endsection
