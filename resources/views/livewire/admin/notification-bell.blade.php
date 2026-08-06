<div style="position:relative;" wire:poll.3s wire:click.outside="closeDropdown">
    {{-- Bell Icon Button --}}
    <button type="button" wire:click.stop="toggleDropdown"
        style="background:#F7F8FA;border:1.5px solid {{ $totalNotifCount > 0 ? '#FFC81A' : '#E2E4EB' }};color:{{ $totalNotifCount > 0 ? '#131218' : '#9CA3B0' }};
               width:38px;height:38px;border-radius:10px;
               display:flex;align-items:center;justify-content:center;cursor:pointer;position:relative;transition:all .18s;"
        title="Notifikasi Transaksi">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
      @if($totalNotifCount > 0)
      <span style="position:absolute;top:-4px;right:-4px;background:#EF4444;color:#FFF;font-size:10px;font-weight:900;
                   padding:1px 5px;border-radius:10px;min-width:18px;height:18px;display:flex;align-items:center;justify-content:center;
                   box-shadow:0 2px 6px rgba(239,68,68,.4);border:1.5px solid #FFF;">
        {{ $totalNotifCount }}
      </span>
      @endif
    </button>

    {{-- Dropdown Content --}}
    <div id="notif-drop" class="{{ $isOpen ? '' : 'hidden' }}" style="position:absolute;right:0;top:46px;width:320px;
        background:#FFF;border:1px solid #E2E4EB;border-radius:16px;
        box-shadow:0 16px 48px rgba(0,0,0,.15);z-index:999;overflow:hidden;">
      
      <div style="padding:12px 16px;background:#F9FAFB;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
        <span style="font-weight:800;font-size:13.5px;color:#131218;">Notifikasi Transaksi</span>
        @if($totalNotifCount > 0)
        <span style="font-size:10.5px;font-weight:800;background:rgba(239,68,68,.12);color:#EF4444;padding:2px 7px;border-radius:10px;">
          {{ $totalNotifCount }} Menunggu
        </span>
        @endif
      </div>

      <div style="max-height:340px;overflow-y:auto;">
        {{-- List Pembayaran --}}
        @foreach($notifPembayaran as $np)
        <a href="{{ route('admin.pembayaran.index', ['status' => 'menunggu_verifikasi']) }}"
           style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;text-decoration:none;border-bottom:1px solid #F0F1F5;background:#FFFDF5;transition:background .15s;"
           onmouseover="this.style.background='#FEFCE8'" onmouseout="this.style.background='#FFFDF5'">
          <div style="width:34px;height:34px;border-radius:9px;background:rgba(255,200,26,.18);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#B38F00" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          </div>
          <div style="flex:1;min-width:0;">
            <p style="margin:0 0 1px;font-size:12.5px;font-weight:800;color:#131218;line-height:1.3;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
              Pembayaran Baru Masuk
            </p>
            <p style="margin:0 0 3px;font-size:11.5px;color:#4B5563;font-weight:600;">
              {{ $np->pendaftaran?->peserta?->nama ?? 'Peserta' }}
            </p>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:10.5px;color:#9CA3B0;">
              <span style="font-weight:700;color:#B38F00;">{{ $np->nominal_transfer_format }}</span>
              <span>{{ $np->updated_at?->diffForHumans() }}</span>
            </div>
          </div>
        </a>
        @endforeach

        {{-- List Request Perpanjangan --}}
        @foreach($notifPerpanjangan as $nper)
        <a href="{{ route('admin.pembayaran.index', ['status' => 'req_perpanjangan']) }}"
           style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;text-decoration:none;border-bottom:1px solid #F0F1F5;background:#FFFDF5;transition:background .15s;"
           onmouseover="this.style.background='#FEFCE8'" onmouseout="this.style.background='#FFFDF5'">
          <div style="width:34px;height:34px;border-radius:9px;background:rgba(245,158,11,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div style="flex:1;min-width:0;">
            <p style="margin:0 0 1px;font-size:12.5px;font-weight:800;color:#92400E;line-height:1.3;">
              Request Perpanjangan
            </p>
            <p style="margin:0 0 3px;font-size:11.5px;color:#4B5563;font-weight:600;">
              {{ $nper->pendaftaran?->peserta?->nama ?? 'Peserta' }}
            </p>
            <div style="display:flex;justify-content:space-between;align-items:center;font-size:10.5px;color:#9CA3B0;">
              <span style="font-style:italic;">{{ \Illuminate\Support\Str::limit($nper->alasan_perpanjangan ?? 'Minta perpanjangan', 22) }}</span>
              <span>{{ $nper->updated_at?->diffForHumans() }}</span>
            </div>
          </div>
        </a>
        @endforeach

        @if($totalNotifCount == 0)
        <div style="padding:28px 16px;text-align:center;color:#9CA3B0;">
          <div style="width:40px;height:40px;border-radius:12px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3B0" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          </div>
          <p style="margin:0;font-size:12.5px;font-weight:700;color:#131218;">Tidak Ada Notifikasi Baru</p>
          <p style="margin:2px 0 0;font-size:11px;color:#9CA3B0;">Semua transaksi telah diverifikasi.</p>
        </div>
        @endif
      </div>

      @if($totalNotifCount > 0)
      <div style="padding:8px;background:#F9FAFB;border-top:1px solid #E2E4EB;text-align:center;">
        <a href="{{ route('admin.pembayaran.index', ['status' => 'menunggu_verifikasi']) }}"
           style="font-size:11.5px;font-weight:800;color:#3B82F6;text-decoration:none;">
          Lihat Semua Pembayaran Menunggu &rarr;
        </a>
      </div>
      @endif
    </div>
</div>
