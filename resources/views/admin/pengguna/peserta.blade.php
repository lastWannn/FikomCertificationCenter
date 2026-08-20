@extends('layouts.admin')
@section('title','Manajemen Peserta')
@section('page-title','Manajemen Peserta')

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
      #peserta-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="peserta-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
      </div>
      {{-- 3 Stat Cards Skeleton --}}
      <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:16px;margin-bottom:24px;">
        @for($sc=0;$sc<3;$sc++)
        <div style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:14px;">
          <div class="fcc-skeleton-box" style="width:44px;height:44px;border-radius:12px;flex-shrink:0;"></div>
          <div style="flex:1;">
            <div class="fcc-skeleton-box" style="width:65%;height:12px;margin-bottom:6px;"></div>
            <div class="fcc-skeleton-box" style="width:40%;height:20px;"></div>
          </div>
        </div>
        @endfor
      </div>
      {{-- Table Skeleton --}}
      <div style="padding:28px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
          <div class="fcc-skeleton-box" style="width:180px;height:20px;"></div>
          <div style="display:flex;gap:10px;">
            <div class="fcc-skeleton-box" style="width:160px;height:36px;border-radius:10px;"></div>
            <div class="fcc-skeleton-box" style="width:140px;height:36px;border-radius:10px;"></div>
          </div>
        </div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('peserta-skeleton-overlay');
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
              <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Pengguna &amp; Hak Akses</span>
              <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Manajemen Peserta</h1>
          </div>
          <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola data akun peserta, status keaktifan, dan histori pendaftaran kegiatan.</p>
      </div>
  </div>

  {{-- Livewire Peserta Manager Component --}}
  @livewire('admin.peserta-manager')
</div>

{{-- Container Modal Detail --}}
<div id="peserta-detail-modal" class="hidden" style="position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.55);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;">
  <div id="peserta-detail-content" style="width:100%;max-width:1080px;display:flex;justify-content:center;padding:16px;box-sizing:border-box;">
    {{-- Content loaded via AJAX --}}
  </div>
</div>
@endsection

@push('scripts')
@vite('resources/js/pages/admin-pengguna.js')
<script>
function loadPesertaDetail(url) {
  const modal = document.getElementById('peserta-detail-modal');
  const content = document.getElementById('peserta-detail-content');
  
  modal.classList.remove('hidden');
  setTimeout(() => modal.style.opacity = '1', 10);
  content.innerHTML = `
    <div style="background:#FFF;padding:40px 60px;border-radius:18px;display:flex;flex-direction:column;align-items:center;gap:14px;box-shadow:0 24px 64px rgba(0,0,0,.18);">
      <div style="width:34px;height:34px;border:3px solid #E2E4EB;border-top-color:#FFC81A;border-radius:50%;animation:spin 1s linear infinite;"></div>
      <span style="font-size:13px;font-weight:700;color:#9CA3B0;">Mengambil data...</span>
    </div>
  `;

  fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
  .then(res => res.text())
  .then(html => content.innerHTML = html)
  .catch(err => {
    content.innerHTML = `
      <div style="background:#FFF;padding:32px;border-radius:18px;text-align:center;box-shadow:0 24px 64px rgba(0,0,0,.18);">
        <p style="color:#EF4444;font-weight:700;margin:0 0 10px;">Gagal memuat data.</p>
        <button onclick="closePesertaModal()" style="padding:8px 16px;border-radius:8px;border:1px solid #E2E4EB;background:#F7F8FA;cursor:pointer;">Tutup</button>
      </div>
    `;
  });
}

function closePesertaModal() {
  const modal = document.getElementById('peserta-detail-modal');
  modal.style.opacity = '0';
  setTimeout(() => modal.classList.add('hidden'), 200);
}

document.addEventListener('click', function(e) {
  if (e.target === document.getElementById('peserta-detail-modal')) closePesertaModal();
});
</script>
<style>
@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
.hidden { display: none !important; }
</style>
@endpush
