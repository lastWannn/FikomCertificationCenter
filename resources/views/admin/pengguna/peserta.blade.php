@extends('layouts.admin')
@section('title','Manajemen Peserta')
@section('page-title','Manajemen Peserta')

@section('page-content')
<div style="padding:20px 24px;">
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
