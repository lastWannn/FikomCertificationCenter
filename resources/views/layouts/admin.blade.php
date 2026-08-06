@extends('layouts.app')
@section('content')
<div style="display:flex;height:100vh;overflow:hidden;background:#F7F8FA;font-family:'Inter',sans-serif;">

  {{-- ═══ SIDEBAR ══════════════════════════════════════════════ --}}
  <aside id="sidebar" style="width:256px;min-width:256px;height:100vh;background:#131218;
      border-right:1px solid rgba(255,200,26,.12);display:flex;flex-direction:column;
      transition:width .26s cubic-bezier(.4,0,.2,1),min-width .26s cubic-bezier(.4,0,.2,1);
      z-index:100;flex-shrink:0;overflow:hidden;">

    {{-- Logo --}}
    <div id="sb-logo" style="padding:18px 16px;border-bottom:1px solid rgba(255,200,26,.1);
        display:flex;align-items:center;gap:11px;flex-shrink:0;">
      <img src="{{ asset('images/logo.png') }}" alt="Logo FCC UMI" style="height:38px;width:auto;object-fit:contain;flex-shrink:0;">
      <div id="sb-brand">
        <p style="margin:0;color:#FFF;font-weight:900;font-size:12.5px;">FCC Admin</p>
        <p style="margin:0;color:#FFC81A;font-size:8px;letter-spacing:2px;text-transform:uppercase;">Certification Center</p>
      </div>
    </div>

    {{-- Navigation --}}
    <nav style="flex:1;padding:10px 0;overflow-y:auto;overflow-x:hidden;">
      @php
      $currentRoute = Route::currentRouteName();
      function sbActive(string $prefix): bool {
          return str_starts_with(Route::currentRouteName() ?? '', $prefix);
      }
      $menuGroups = [
          [
              'label' => 'PROGRAM',
              'items' => [
                  ['route'=>'admin.dashboard',           'icon'=>'layout-dashboard', 'label'=>'Dashboard'],
                  [
                      'route'    => 'admin.pelatihan.index',
                      'icon'     => 'book-open',
                      'label'    => 'Pelatihan',
                      'children' => [
                          ['route'=>'admin.pelatihan.index',             'label'=>'Tambah Pelatihan'],
                          ['route'=>'admin.materi.index',                'label'=>'Materi Pelatihan'],
                          ['route'=>'admin.pelatihan.point.index',       'label'=>'Point Peserta Pelatihan'],
                      ]
                  ],
                  [
                      'route'    => 'admin.sertifikasi.index',
                      'icon'     => 'award',
                      'label'    => 'Sertifikasi',
                      'children' => [
                          ['route'=>'admin.sertifikasi.index',           'label'=>'Tambah Sertifikasi'],
                          ['route'=>'admin.sertifikasi.materi.index',    'label'=>'Materi Sertifikasi'],
                          ['route'=>'admin.sertifikasi.point.index',     'label'=>'Point Peserta Sertifikasi'],
                      ]
                  ],
              ],
          ],
          [
              'label' => 'KEGIATAN',
              'items' => [
                  ['route'=>'admin.kegiatan.index',      'icon'=>'zap',              'label'=>'Kegiatan Aktif'],
                  ['route'=>'admin.arsip.index',         'icon'=>'archive',          'label'=>'Arsip Kegiatan'],
              ],
          ],
          [
              'label' => 'TRANSAKSI',
              'items' => [
                  ['route'=>'admin.pembayaran.index',    'icon'=>'check-square',     'label'=>'Pembayaran'],
                  ['route'=>'admin.presensi.index',      'icon'=>'clipboard-list',   'label'=>'Presensi'],
                  ['route'=>'admin.sertifikat.index',    'icon'=>'file-text',        'label'=>'Sertifikat'],
              ],
          ],
          [
              'label' => 'MASTER DATA',
              'items' => [
                  ['route'=>'admin.kategori.index',      'icon'=>'filter',           'label'=>'Kategori'],
              ],
          ],
          [
              'label' => 'PENGGUNA',
              'items' => [
                  ['route'=>'admin.pengguna.peserta',    'icon'=>'users',            'label'=>'Manajemen Peserta'],
              ],
          ],
          [
              'label' => 'LAPORAN',
              'items' => [
                  ['route'=>'admin.laporan.index',       'icon'=>'trending-up',      'label'=>'Laporan & Statistik'],
              ],
          ],
          [
              'label' => 'KONTEN',
              'items' => [
                  ['route'=>'admin.informasi.index',     'icon'=>'info',             'label'=>'Informasi & FAQ'],
                  ['route'=>'admin.mitra.index',         'icon'=>'users',            'label'=>'Mitra / Partner'],
                  ['route'=>'admin.testimoni.index',     'icon'=>'message-square',   'label'=>'Kata Mereka'],
                  ['route'=>'admin.rekening.index',      'icon'=>'wallet',           'label'=>'No. Rekening'],
                  ['route'=>'admin.kontak.edit',         'icon'=>'map-pin',          'label'=>'Kontak & Alamat'],
              ],
          ],
      ];
      @endphp

      @foreach($menuGroups as $group)
        <div class="sb-section-label">{{ $group['label'] }}</div>
        @foreach($group['items'] as $item)
          @php
            $isActive = sbActive(explode('.index',$item['route'])[0]);
          @endphp

          @if(!empty($item['children']))
            @php
              $groupId = 'sb-group-'.\Illuminate\Support\Str::slug($item['label']);
              $isGroupActive = $isActive || collect($item['children'])->contains(function($c) {
                  if (isset($c['route'])) return sbActive(explode('.index', $c['route'])[0]);
                  if (isset($c['url'])) return request()->fullUrl() == url($c['url']);
                  return false;
              });
            @endphp
            <div class="sb-dropdown">
              <a href="{{ isset($item['route']) ? route($item['route']) : 'javascript:void(0)' }}" 
                 class="sidebar-link {{ $isGroupActive ? 'active' : '' }}"
                 style="text-decoration:none;display:flex;justify-content:space-between;align-items:center;">
                <div style="display:flex;align-items:center;gap:.75rem;">
                  @include('components.icon',['name'=>$item['icon'],'size'=>17,'class'=>'sb-icon'])
                  <span class="sb-lbl" style="font-size:13.5px;white-space:nowrap;">{{ $item['label'] }}</span>
                </div>
                <button type="button" onclick="event.preventDefault(); const c=document.getElementById('{{ $groupId }}'); c.style.display=c.style.display==='none'?'block':'none'; this.querySelector('.sb-chevron').style.transform=c.style.display==='none'?'rotate(0deg)':'rotate(90deg)';"
                        style="background:none;border:none;padding:4px;cursor:pointer;color:inherit;display:flex;align-items:center;justify-content:center;">
                  <svg class="sb-chevron" style="transition:transform .25s;flex-shrink:0;opacity:.6;transform:{{ $isGroupActive ? 'rotate(90deg)' : 'rotate(0deg)' }}" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
              </a>
              <div id="{{ $groupId }}" class="sb-children" style="display:{{ $isGroupActive ? 'block' : 'none' }};padding:0;border-left:1px solid rgba(255,255,255,.15);margin:2px 0 2px 33.5px;">
                @foreach($item['children'] as $child)
                  @php 
                    $childActive = isset($child['route']) ? sbActive(explode('.index',$child['route'])[0]) : request()->fullUrl() == url($child['url']); 
                    // Special logic: if route is index, but we are on create, index should not be active!
                    if (isset($child['route']) && $child['route'] == 'admin.pelatihan.index' && Route::currentRouteName() != 'admin.pelatihan.index') {
                        $childActive = false;
                    }
                    if (isset($child['route']) && $child['route'] == 'admin.sertifikasi.index' && Route::currentRouteName() != 'admin.sertifikasi.index') {
                        $childActive = false;
                    }
                    if (isset($child['route']) && $child['route'] == 'admin.pelatihan.create' && Route::currentRouteName() == 'admin.pelatihan.create') {
                        $childActive = true;
                    }
                    
                    $childHref = isset($child['route']) ? route($child['route']) : $child['url'];
                  @endphp
                  <a href="{{ $childHref }}"
                     class="sidebar-link {{ $childActive ? 'active' : '' }}"
                     style="padding:6px 12px 6px 0;margin:2px 0;min-height:30px;font-weight:{{ $childActive ? '600' : '400' }};display:flex;align-items:center;gap:10px;border-radius:0 6px 6px 0;">
                    <span style="width:16px;height:1px;background:{{ $childActive ? '#FFC81A' : 'rgba(255,255,255,.15)' }};display:inline-block;flex-shrink:0;"></span>
                    <span class="sb-lbl" style="font-size:12px;color:{{ $childActive ? '#FFF' : 'rgba(255,255,255,.5)' }};">{{ $child['label'] }}</span>
                  </a>
                @endforeach
              </div>
            </div>
          @else
            <a href="{{ route($item['route']) }}"
               class="sidebar-link {{ $isActive ? 'active' : '' }}"
               style="text-decoration:none;">
              @include('components.icon',['name'=>$item['icon'],'size'=>17,'class'=>'sb-icon'])
              <span class="sb-lbl" style="font-size:13.5px;white-space:nowrap;">{{ $item['label'] }}</span>
            </a>
          @endif
        @endforeach
      @endforeach
    </nav>

    {{-- Bottom --}}
    <div style="border-top:1px solid rgba(255,200,26,.1);padding:8px 0;flex-shrink:0;">
      <a href="{{ route('landing.index') }}" target="_blank"
         class="sidebar-link" style="text-decoration:none;">
        @include('components.icon',['name'=>'home','size'=>16,'class'=>'sb-icon'])
        <span class="sb-lbl" style="font-size:13.5px;">Lihat Website</span>
      </a>
      <a href="{{ route('admin.profile') }}" class="sidebar-link {{ sbActive('admin.profile')?'active':'' }}" style="text-decoration:none;">
        @include('components.icon',['name'=>'user','size'=>16,'class'=>'sb-icon'])
        <span class="sb-lbl" style="font-size:13.5px;">Profil Admin</span>
      </a>
      <form action="{{ route('auth.logout') }}" method="POST" style="margin:0;">
        @csrf
        <button type="submit" class="sidebar-link logout-btn"
            style="width:100%;border:none;background:none;cursor:pointer;text-align:left;">
          @include('components.icon',['name'=>'log-out','size'=>16,'style'=>'color:#EF4444;'])
          <span class="sb-lbl" style="font-size:13.5px;color:#EF4444;">Keluar</span>
        </button>
      </form>
    </div>
  </aside>

  {{-- ═══ MAIN ════════════════════════════════════════════════════ --}}
  <div style="flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0;">

    {{-- Header --}}
    <header style="height:62px;background:#FFF;border-bottom:1px solid #E2E4EB;
        display:flex;align-items:center;padding:0 20px;gap:12px;flex-shrink:0;
        box-shadow:0 1px 0 #E2E4EB;">
      <button id="sb-toggle" onclick="toggleSidebar()"
          style="background:none;border:1.5px solid #E2E4EB;color:#9CA3B0;
                 padding:6px 8px;border-radius:8px;display:flex;cursor:pointer;transition:all .18s;"
          onmouseover="this.style.borderColor='#FFC81A';this.style.color='#131218'"
          onmouseout="this.style.borderColor='#E2E4EB';this.style.color='#9CA3B0'">
        <svg id="sb-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
      </button>

      {{-- Breadcrumb / page title --}}
      <div style="flex:1;min-width:0;">
        <p style="margin:0;font-size:15px;font-weight:700;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
          @yield('page-title','Dashboard')
        </p>
        @hasSection('page-breadcrumb')
        <p style="margin:0;font-size:11px;color:#9CA3B0;">@yield('page-breadcrumb')</p>
        @endif
      </div>

      {{-- Search --}}
      <div style="position:relative;display:none;" id="header-search">
        <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#C0C4CF;pointer-events:none;"
             width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" placeholder="Cari…" class="fcc-input"
               style="padding:7px 12px 7px 32px;width:220px;font-size:13px;"
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>

      {{-- Livewire Realtime Notification Bell Component --}}
      @livewire('admin.notification-bell')

      {{-- Admin info --}}
      <a href="{{ route('admin.profile') }}"
         style="display:flex;align-items:center;gap:10px;background:#F7F8FA;
                border:1.5px solid #E2E4EB;border-radius:10px;padding:5px 12px 5px 5px;
                text-decoration:none;transition:border-color .18s;"
         onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
        <div style="width:30px;height:30px;border-radius:8px;background:#131218;
            display:flex;align-items:center;justify-content:center;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
        <div>
          <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ auth('admin')->user()->nama ?? 'Admin' }}</p>
          <p style="margin:0;font-size:10px;color:#FFC81A;font-weight:600;">Penyelenggara</p>
        </div>
      </a>
    </header>

    {{-- Content --}}
    <main style="flex:1;overflow:auto;background:#F7F8FA;">
      @yield('page-content')
    </main>
  </div>
</div>

@include('components.fcc-modal')

@push('scripts')
<script>
document.addEventListener('click', function(e) {
    const drop = document.getElementById('notif-drop');
    if (drop && !drop.contains(e.target)) {
        drop.classList.add('hidden');
    }
});

// Dynamic Premium File Alert Modal
window.fccShowFileAlert = function(title, message) {
    let alertModal = document.getElementById('fcc-global-file-alert');
    if (!alertModal) {
        alertModal = document.createElement('div');
        alertModal.id = 'fcc-global-file-alert';
        alertModal.style = 'display:none;position:fixed;inset:0;z-index:100000;background:rgba(0,0,0,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;font-family:sans-serif;';
        alertModal.innerHTML = `
            <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:400px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.5);text-align:center;animation:fccModalIn .25s ease;">
                <div style="width:56px;height:56px;border-radius:16px;background:rgba(239,68,68,.15);border:1.5px solid rgba(239,68,68,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <h3 id="fcc-file-alert-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 8px;font-family:inherit;">Format Tidak Sesuai</h3>
                <p id="fcc-file-alert-msg" style="color:rgba(255,255,255,.55);font-size:14px;margin:0 0 24px;line-height:1.6;font-family:inherit;"></p>
                <button onclick="document.getElementById('fcc-global-file-alert').style.display='none'" style="padding:11px 28px;border-radius:12px;border:none;background:linear-gradient(135deg,#FFC81A,#FFD84D);color:#111;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 15px rgba(255,200,26,.3);transition:all .2s;font-family:inherit;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Mengerti</button>
            </div>
            <style>
                @keyframes fccModalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
            </style>
        `;
        document.body.appendChild(alertModal);
        
        alertModal.addEventListener('click', function(evt) {
            if (evt.target === this) this.style.display = 'none';
        });
    }
    document.getElementById('fcc-file-alert-title').innerText = title;
    document.getElementById('fcc-file-alert-msg').innerText = message;
    alertModal.style.display = 'flex';
};

// Global File Input Change Listener
document.addEventListener('change', function(e) {
    if (e.target && e.target.type === 'file') {
        const input = e.target;
        if (!input.files || input.files.length === 0) return;
        const file = input.files[0];
        
        // 1. Extension Validation
        const accept = input.getAttribute('accept');
        if (accept) {
            const fileName = file.name.toLowerCase();
            const fileExt = '.' + fileName.split('.').pop();
            let allowed = false;
            const acceptTypes = accept.split(',').map(t => t.trim());
            
            for (let type of acceptTypes) {
                if (type === 'image/*') {
                    if (['.jpg', '.jpeg', '.png', '.webp', '.gif', '.svg'].includes(fileExt)) {
                        allowed = true;
                        break;
                    }
                } else if (type.startsWith('.')) {
                    if (type === fileExt) {
                        allowed = true;
                        break;
                    }
                } else if (type === 'application/pdf') {
                    if (fileExt === '.pdf') {
                        allowed = true;
                        break;
                    }
                }
            }
            
            if (!allowed) {
                window.fccShowFileAlert('Ekstensi File Salah', `Format file "${file.name}" tidak didukung. Tipe file yang diperbolehkan: ${accept}`);
                input.value = '';
                return;
            }
        }
        
        // 2. Size Validation
        let maxBytes = 2 * 1024 * 1024; // Default 2MB
        let sizeText = '2 MB';
        
        // Adjust max size based on input properties or names
        if (input.name === 'file_materi') {
            maxBytes = 20 * 1024 * 1024; // 20MB
            sizeText = '20 MB';
        } else if (input.name === 'bukti_bayar') {
            maxBytes = 5 * 1024 * 1024; // 5MB
            sizeText = '5 MB';
        } else if (input.name === 'berita_acara') {
            maxBytes = 10 * 1024 * 1024; // 10MB
            sizeText = '10 MB';
        }
        
        if (file.size > maxBytes) {
            window.fccShowFileAlert('Ukuran File Terlalu Besar', `Ukuran file "${file.name}" melebihi batas maksimal yang diperbolehkan (${sizeText}).`);
            input.value = '';
            return;
        }
    }
});

// Auto-hide alerts after 3.5 seconds
setTimeout(() => {
    document.querySelectorAll('.fcc-alert').forEach(alert => {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        alert.style.marginBottom = '-' + alert.offsetHeight + 'px';
        setTimeout(() => {
            const wrapper = alert.parentElement;
            alert.remove();
            if(wrapper && wrapper.children.length === 0) wrapper.remove();
        }, 500);
    });
}, 3500);
</script>
@endpush
@endsection

{{-- CSS Sidebar dimuat via resources/css/app.css --}}

{{-- JS Sidebar dimuat via resources/js/components/sidebar.js (diimport app.js) --}}
