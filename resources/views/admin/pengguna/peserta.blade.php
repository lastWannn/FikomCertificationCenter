@extends('layouts.admin')
@section('title','Manajemen Peserta')
@section('page-title','Manajemen Peserta')
@section('page-content')
<div style="padding:20px 24px;">

  {{-- Stats --}}
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:18px;">
    @foreach([
      ['Total Peserta',$stats['total'],'users','#131218'],
      ['Aktif',$stats['aktif'],'check','#10B981'],
      ['Nonaktif',$stats['nonaktif'],'x','#F59E0B'],
      ['Ditangguhkan',$stats['ditangguhkan'],'alert-triangle','#EF4444'],
    ] as [$lbl,$val,$ic,$c])
    <div class="fcc-card" style="padding:16px 18px;border-left:4px solid {{ $c }};">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
        <p style="color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin:0;">{{ $lbl }}</p>
        <div style="width:32px;height:32px;border-radius:9px;background:{{ $c }}18;display:flex;align-items:center;justify-content:center;">
          @include('components.icon',['name'=>$ic,'size'=>15,'style'=>"color:{$c}"])
        </div>
      </div>
      <p style="margin:0;font-size:24px;font-weight:900;color:#131218;">{{ $val }}</p>
    </div>
    @endforeach
  </div>

  {{-- Filter & Search --}}
  <form method="GET" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
    <div style="position:relative;flex:1;min-width:200px;">
      @include('components.icon',['name'=>'search','size'=>14,'style'=>'position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#C0C4CF;pointer-events:none;'])
      <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
             class="fcc-input" style="padding-left:38px;"
             oninput="clearTimeout(this.searchTimer); this.searchTimer = setTimeout(() => this.form.submit(), 600);">
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('searchInput');
        if (input.value) {
          input.focus();
          const val = input.value; input.value = ''; input.value = val;
        }
      });
    </script>
    <div style="position:relative;" id="statusDropdownContainer">
      <input type="hidden" name="status" id="statusFilter" value="{{ request('status') }}">
      <button type="button" onclick="document.getElementById('statusDropdownList').classList.toggle('hidden')" class="fcc-input" style="width:auto;display:flex;align-items:center;gap:12px;cursor:pointer;background:#FFF;min-width:140px;justify-content:space-between;padding-right:12px;">
        <span id="statusLabel" style="font-weight:600;color:#131218;">
          {{ request('status') === 'aktif' ? 'Aktif' : (request('status') === 'nonaktif' ? 'Nonaktif' : (request('status') === 'ditangguhkan' ? 'Ditangguhkan' : 'Semua Status')) }}
        </span>
        @include('components.icon',['name'=>'chevron-down','size'=>14,'style'=>'color:#9CA3B0;'])
      </button>
      <div id="statusDropdownList" class="hidden" style="position:absolute;top:calc(100% + 6px);left:0;background:#FFF;border:1px solid #E2E4EB;border-radius:12px;box-shadow:0 12px 32px rgba(0,0,0,.08);z-index:100;min-width:100%;overflow:hidden;display:flex;flex-direction:column;padding:6px;">
        @foreach([''=>'Semua Status','aktif'=>'Aktif','nonaktif'=>'Nonaktif','ditangguhkan'=>'Ditangguhkan'] as $v=>$l)
        @php $isActive = request('status', '') === (string)$v; @endphp
        <button type="button" onclick="document.getElementById('statusFilter').value='{{ $v }}'; this.form.submit();" style="width:100%;padding:9px 12px;background:{{ $isActive ? '#F8F9FB' : 'none' }};border:none;border-radius:8px;text-align:left;font-size:13px;cursor:pointer;color:{{ $isActive ? '#131218' : '#6B7280' }};font-weight:{{ $isActive ? '700' : '500' }};display:flex;align-items:center;justify-content:space-between;transition:all .15s;" onmouseover="this.style.background='#F7F8FA';this.style.color='#131218';" onmouseout="this.style.background='{{ $isActive ? '#F8F9FB' : 'none' }}';this.style.color='{{ $isActive ? '#131218' : '#6B7280' }}'">
          {{ $l }}
          @if($isActive) @include('components.icon',['name'=>'check','size'=>14,'style'=>'color:#10B981;']) @endif
        </button>
        @endforeach
      </div>
    </div>
    <a href="{{ route('admin.export.peserta') }}" class="fcc-btn-dark" style="padding:9px 16px;font-size:13px;text-decoration:none;">
      @include('components.icon',['name'=>'download','size'=>13,'style'=>'color:#FFC81A']) Export
    </a>
  </form>

  <div class="fcc-card" style="padding:0;overflow:visible;">
    <table class="admin-table">
      <thead>
        <tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
          @foreach(['Peserta','No. HP','Status Akun','Kegiatan','Terdaftar','Aksi'] as $h)
          <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $h }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse($peserta as $p)
        @php $sc=match($p->status_akun??'aktif'){'aktif'=>['#10B981','Aktif'],'nonaktif'=>['#F59E0B','Nonaktif'],default=>['#EF4444','Ditangguhkan']}; @endphp
        <tr class="tbl-row" style="border-top:1px solid #F0F1F5;{{ $p->status_akun !== 'aktif' ? 'background:#F3F4F6;' : '' }}">
          <td style="padding:12px 14px;">
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:36px;height:36px;border-radius:10px;background:#131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              </div>
              <div style="min-width:0;">
                <p style="margin:0;font-size:13px;font-weight:700;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px;">{{ $p->nama }}</p>
                <p style="margin:0;font-size:11px;color:#9CA3B0;">{{ $p->email }}</p>
              </div>
            </div>
          </td>
          <td style="padding:12px 14px;font-size:13px;color:#6B7280;">
            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $p->no_hp)) }}" target="_blank" style="color:#10B981;text-decoration:none;display:inline-flex;align-items:center;gap:4px;font-weight:600;" title="Hubungi via WhatsApp">
              @include('components.icon',['name'=>'message-circle','size'=>13]) {{ $p->no_hp }}
            </a>
          </td>
          <td style="padding:12px 14px;">
            <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span>
          </td>
          <td style="padding:12px 14px;font-size:13px;font-weight:700;color:#131218;">{{ $p->pendaftaran_count }}</td>
          <td style="padding:12px 14px;font-size:12px;color:#9CA3B0;">{{ $p->created_at->format('d M Y') }}</td>
          <td style="padding:12px 14px;">
            <div style="display:flex;gap:6px;align-items:center;">
              <button type="button" onclick="loadPesertaDetail('{{ route('admin.pengguna.peserta.detail', $p) }}')" style="background:none;border:none;cursor:pointer;color:#3B82F6;display:flex;padding:4px;outline:none;" title="Detail">
                @include('components.icon',['name'=>'eye','size'=>14])
              </button>
              <div style="position:relative;" x-data="{ open:false }">
                <button onclick="toggleDropdown('drop-{{ $p->id }}')"
                    style="background:#FFF;border:1px solid #E2E4EB;border-radius:8px;padding:6px 12px;cursor:pointer;display:flex;align-items:center;gap:6px;font-size:12px;color:#4B5563;font-weight:600;box-shadow:0 1px 2px rgba(0,0,0,.04);transition:all .15s;"
                    onmouseover="this.style.background='#F8F9FB';this.style.borderColor='#D1D5DB';" onmouseout="this.style.background='#FFF';this.style.borderColor='#E2E4EB';">
                  Ubah Status @include('components.icon',['name'=>'chevron-down','size'=>12,'style'=>'color:#9CA3B0;'])
                </button>
                <div id="drop-{{ $p->id }}" style="display:none;position:absolute;right:0;top:calc(100% + 6px);background:#FFF;border:1px solid #E2E4EB;border-radius:12px;box-shadow:0 12px 32px rgba(0,0,0,.1);z-index:100;min-width:180px;padding:6px;">
                  @php
                    $statusActions = [
                      'aktif' => ['Aktifkan', 'check', '#10B981'],
                      'nonaktif' => ['Nonaktifkan', 'x', '#F59E0B'],
                      'ditangguhkan' => ['Tangguhkan', 'lock', '#EF4444']
                    ];
                  @endphp
                  @foreach($statusActions as $sv => $act)
                  <form action="{{ route('admin.pengguna.peserta.toggle', $p) }}" method="POST" style="margin:0 0 2px 0;">
                    @csrf
                    <input type="hidden" name="status" value="{{ $sv }}">
                    <button type="submit" style="width:100%;padding:8px 12px;background:none;border:none;border-radius:6px;text-align:left;font-size:13px;cursor:pointer;color:{{ $act[2] }};font-weight:600;display:flex;align-items:center;gap:8px;transition:all .15s;"
                        onmouseover="this.style.background='{{ $act[2] }}12'" onmouseout="this.style.background='none'">
                      @include('components.icon',['name'=>$act[1],'size'=>14]) {{ $act[0] }}
                    </button>
                  </form>
                  @endforeach
                  <div style="border-top:1px solid #F0F1F5;margin:4px 0;"></div>
                  <form action="{{ route('admin.pengguna.peserta.reset-password', $p) }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" style="width:100%;padding:8px 12px;background:none;border:none;border-radius:6px;text-align:left;font-size:13px;cursor:pointer;color:#3B82F6;font-weight:600;display:flex;align-items:center;gap:8px;transition:all .15s;" onclick="return fccConfirmAction(event, this, 'Reset Password', 'Reset & kirim password baru ke email peserta?', 'Ya, Reset', false)"
                        onmouseover="this.style.background='#3B82F612'" onmouseout="this.style.background='none'">
                      @include('components.icon',['name'=>'mail','size'=>14]) Reset Password
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="padding:48px 24px;text-align:center;">
          <div style="width:64px;height:64px;background:#F8F9FB;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            @include('components.icon',['name'=>'users','size'=>28,'style'=>'color:#A0A3AD'])
          </div>
          <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 6px;">Tidak Ada Peserta</p>
          <p style="font-size:13px;color:#9CA3B0;margin:0;">Tidak ada data peserta yang cocok dengan filter pencarian Anda.</p>
        </td></tr>
        @endforelse
      </tbody>
    </table>
    @if($peserta->hasPages())<div style="padding:12px 16px;border-top:1px solid #E2E4EB;">{{ $peserta->withQueryString()->links() }}</div>@endif
  </div>
</div>

{{-- Container Modal --}}
<div id="peserta-detail-modal" class="hidden" style="position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.55);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;">
  <div id="peserta-detail-content" style="width:100%;max-width:850px;display:flex;justify-content:center;">
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
  
  const statusContainer = document.getElementById('statusDropdownContainer');
  const statusList = document.getElementById('statusDropdownList');
  if (statusContainer && !statusContainer.contains(e.target)) {
    statusList.classList.add('hidden');
  }
});
</script>
<style>
@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
.hidden { display: none !important; }
</style>
@endpush
