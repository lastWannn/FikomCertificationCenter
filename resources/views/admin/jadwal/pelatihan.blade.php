@extends('layouts.admin')
@section('title','Jadwal Pelatihan')
@section('page-title','Jadwal Pelatihan')
@section('page-content')
<div class="fcc-jadwal-container" style="padding:24px;position:relative;">

  {{-- === SKELETON LOADING OVERLAY === --}}
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
    .fcc-jadwal-desktop-table {
      display: block;
    }
    .fcc-jadwal-mobile-list {
      display: none;
    }
    @media (max-width: 768px) {
      .fcc-jadwal-desktop-table {
        display: none !important;
      }
      .fcc-jadwal-mobile-list {
        display: block !important;
      }
    }
    @media (max-width: 640px) {
      .fcc-jadwal-container {
        padding: 14px !important;
      }
      .fcc-jadwal-filter-form {
        flex-direction: column !important;
        align-items: stretch !important;
      }
      .fcc-filter-select {
        width: 100% !important;
        min-width: 0 !important;
      }
      .fcc-btn-tambah-wrap {
        width: 100% !important;
        margin-left: 0 !important;
      }
      .fcc-btn-tambah {
        width: 100% !important;
        display: flex !important;
        justify-content: center !important;
        text-align: center;
        box-sizing: border-box;
      }
      .fcc-pagination-bar {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 12px !important;
      }
      .fcc-pagination-bar > div {
        justify-content: center !important;
        display: flex !important;
        text-align: center;
      }
    }
  </style>

  <div id="jadwal-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
    {{-- Filter Skeleton --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
      <div class="fcc-skeleton-box" style="width:240px;height:38px;border-radius:10px;"></div>
      <div class="fcc-skeleton-box" style="width:140px;height:38px;border-radius:30px;"></div>
    </div>
    {{-- Table Skeleton --}}
    <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.02);">
      <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
      <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
      <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
      <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
    </div>
  </div>

  <script>
    (function() {
      setTimeout(function() {
        var sk = document.getElementById('jadwal-skeleton-overlay');
        if (sk) {
          sk.style.opacity = '0';
          sk.style.visibility = 'hidden';
          setTimeout(function() { sk.style.display = 'none'; }, 350);
        }
      }, 400);
    })();
  </script>

  {{-- Filter --}}
  <form method="GET" class="fcc-jadwal-filter-form" style="display:flex;gap:10px;align-items:center;margin-bottom:18px;flex-wrap:wrap;">
    <select name="pelatihan_id" class="fcc-input fcc-filter-select" style="width:auto;min-width:220px;" onchange="this.form.submit()">
      <option value="">&mdash; Semua Program Pelatihan &mdash;</option>
      @foreach($pelatihan as $p)
      <option value="{{ $p->id }}" {{ request('pelatihan_id')==$p->id?'selected':'' }}>{{ $p->judul }}</option>
      @endforeach
    </select>
    <div class="fcc-btn-tambah-wrap" style="margin-left:auto;">
      <a href="{{ route('admin.pelatihan.index') }}" class="fcc-btn-gold fcc-btn-tambah" style="padding:9px 18px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'plus','size'=>14]) Tambah Jadwal
      </a>
    </div>
  </form>

  <div class="fcc-card" style="padding:0;overflow:hidden;">
    <div class="fcc-jadwal-desktop-table" style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
      <table style="width:100%;min-width:720px;border-collapse:collapse;">
        <thead>
          <tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
            <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;min-width:180px;">Program</th>
            <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;min-width:140px;">Tanggal Pelaksanaan</th>
            <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;min-width:90px;">Kuota</th>
            <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;min-width:110px;">Batas Daftar</th>
            <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;min-width:110px;">Status</th>
            <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;width:140px;min-width:140px;white-space:nowrap;">Aksi</th>
          </tr>
        </thead>
      <tbody>
        @forelse($jadwal as $j)
        @php
          $hasKegiatan = $j->kegiatanPelatihan !== null;
          $kegiatan    = $j->kegiatanPelatihan?->kegiatan;
        @endphp
        <tr style="border-top:1px solid #F0F1F5;cursor:pointer;" class="tbl-row" onclick="if(!event.target.closest('button, a, select, input, form')) window.location.href='{{ $hasKegiatan ? route('admin.kegiatan.show', $kegiatan) : route('admin.pelatihan.show', $j->pelatihan) }}'">
          <td style="padding:12px 14px;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">
              {{ Str::limit($j->pelatihan->judul,35) }}
              @if($j->nama_kegiatan)
              <span style="font-size:10px;font-weight:600;color:#FFC81A;background:#131218;padding:1px 5px;border-radius:4px;margin-left:4px;">{{ $j->nama_kegiatan }}</span>
              @endif
            </p>
            <p style="margin:2px 0 0;font-size:10px;color:#9CA3B0;font-family:monospace;">{{ $j->pelatihan->kode }}</p>
          </td>
          <td style="padding:12px 14px;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $j->tgl_pelaksanaan->format('d M Y') }}</p>
            <p style="margin:2px 0 0;font-size:11px;color:#9CA3B0;">{{ $j->jam_mulai }} &ndash; {{ $j->jam_selesai }}</p>
          </td>
          <td style="padding:12px 14px;">
            @if($hasKegiatan)
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $kegiatan->terisi }}/{{ $j->kuota_peserta }}</p>
            <div style="width:100%;height:4px;background:#E2E4EB;border-radius:2px;margin-top:4px;">
              <div style="height:4px;border-radius:2px;background:{{ $kegiatan->isFull()?'#EF4444':'#FFC81A' }};
                width:{{ min(100,round($kegiatan->terisi/$j->kuota_peserta*100)) }}%;"></div>
            </div>
            @else
            <p style="margin:0;font-size:13px;color:#9CA3B0;">0/{{ $j->kuota_peserta }}</p>
            @endif
          </td>
          <td style="padding:12px 14px;">
            <p style="margin:0;font-size:12px;color:{{ now()->gt($j->tgl_batas_daftar)?'#EF4444':'#6B7280' }};">
              {{ $j->tgl_batas_daftar->format('d M Y') }}
            </p>
          </td>
          <td style="padding:12px 14px;">
            @php $st = $j->kegiatanPelatihan?->kegiatan?->status ?? 'draf'; @endphp
            <form action="{{ route('admin.jadwal-pelatihan.status', $j) }}" method="POST" style="margin:0;">
              @csrf
              <select name="status" onchange="this.form.submit()" title="Ubah Status Publikasi"
                      style="padding:5px 8px;font-size:11px;font-weight:800;border-radius:8px;border:1.5px solid #131218;cursor:pointer;outline:none;
                             background:{{ $st === 'public' ? '#ECFDF5' : ($st === 'comingsoon' ? '#FFFDF5' : '#F8FAFC') }};
                             color:{{ $st === 'public' ? '#059669' : ($st === 'comingsoon' ? '#D97706' : '#64748B') }};">
                <option value="draf" {{ $st === 'draf' ? 'selected' : '' }}>Draft</option>
                <option value="comingsoon" {{ $st === 'comingsoon' ? 'selected' : '' }}>Coming Soon</option>
                <option value="public" {{ $st === 'public' ? 'selected' : '' }}>Publik</option>
              </select>
            </form>
          </td>
          <td style="padding:12px 14px;width:140px;min-width:140px;white-space:nowrap;">
            <div style="display:flex;gap:8px;align-items:center;white-space:nowrap;">
              @if($hasKegiatan)
              <a href="{{ route('admin.kegiatan.show', $kegiatan) }}" style="font-size:11px;color:#3B82F6;font-weight:700;text-decoration:none;white-space:nowrap;">Lihat Kegiatan</a>
              @endif
              <a href="{{ route('admin.jadwal-pelatihan.edit', $j) }}" style="color:#FFC81A;" title="Edit Jadwal">
                @include('components.icon',['name'=>'edit','size'=>15])
              </a>
              <form action="{{ route('admin.jadwal-pelatihan.destroy', $j) }}" method="POST" style="margin:0;" onsubmit="return fccConfirmDelete(event, this, 'Hapus Jadwal', 'Apakah Anda yakin ingin menghapus jadwal pelatihan ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;cursor:pointer;color:#EF4444;display:flex;padding:0;" title="Hapus Jadwal">
                  @include('components.icon',['name'=>'trash','size'=>15])
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="padding:36px;text-align:center;color:#9CA3B0;font-size:14px;">
          Belum ada jadwal pelatihan.
          <a href="{{ route('admin.pelatihan.index') }}" style="color:#FFC81A;font-weight:700;text-decoration:none;"> Tambah dari Pelatihan &rarr;</a>
        </td></tr>
        @endforelse
      </tbody>
    </table>
    </div>

    {{-- Mobile Cards List View (< 768px) --}}
    <div class="fcc-jadwal-mobile-list">
      @forelse($jadwal as $j)
      @php
        $hasKegiatan = $j->kegiatanPelatihan !== null;
        $kegiatan = $j->kegiatanPelatihan?->kegiatan;
        $st = $kegiatan?->status ?? 'draf';
      @endphp
      <div style="padding:16px;border-top:1px solid #F0F1F5;background:#FFF;">
        {{-- Header: Program Judul & Kode --}}
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;margin-bottom:8px;">
          <div style="flex:1;min-width:0;">
            <h4 style="margin:0 0 4px;font-size:14px;font-weight:900;color:#131218;line-height:1.35;word-break:break-word;">
              {{ $j->pelatihan->judul }}
              @if($j->nama_kegiatan)
              <span style="font-size:10px;font-weight:700;color:#FFC81A;background:#131218;padding:2px 6px;border-radius:4px;display:inline-block;margin-left:4px;">{{ $j->nama_kegiatan }}</span>
              @endif
            </h4>
            <span style="font-size:11px;color:#9CA3B0;font-family:monospace;font-weight:700;">{{ $j->pelatihan->kode }}</span>
          </div>
          
          {{-- Status selector --}}
          <form action="{{ route('admin.jadwal-pelatihan.status', $j) }}" method="POST" style="margin:0;flex-shrink:0;">
            @csrf
            <select name="status" onchange="this.form.submit()" title="Ubah Status Publikasi"
                    style="padding:4px 8px;font-size:11px;font-weight:800;border-radius:8px;border:1.5px solid #131218;cursor:pointer;outline:none;
                           background:{{ $st === 'public' ? '#ECFDF5' : ($st === 'comingsoon' ? '#FFFDF5' : '#F8FAFC') }};
                           color:{{ $st === 'public' ? '#059669' : ($st === 'comingsoon' ? '#D97706' : '#64748B') }};">
              <option value="draf" {{ $st === 'draf' ? 'selected' : '' }}>Draft</option>
              <option value="comingsoon" {{ $st === 'comingsoon' ? 'selected' : '' }}>Coming Soon</option>
              <option value="public" {{ $st === 'public' ? 'selected' : '' }}>Publik</option>
            </select>
          </form>
        </div>

        {{-- Details Grid --}}
        <div style="background:#F8FAFC;border:1px solid #E2E4EB;border-radius:12px;padding:12px;margin-bottom:12px;display:grid;grid-template-columns:1fr 1fr;gap:10px;">
          <div>
            <span style="font-size:10px;font-weight:800;color:#64748B;display:block;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:2px;">Pelaksanaan</span>
            <p style="margin:0;font-size:12.5px;font-weight:800;color:#131218;">{{ $j->tgl_pelaksanaan->format('d M Y') }}</p>
            <span style="font-size:11px;color:#9CA3B0;font-weight:600;">{{ $j->jam_mulai }} &ndash; {{ $j->jam_selesai }}</span>
          </div>
          <div>
            <span style="font-size:10px;font-weight:800;color:#64748B;display:block;text-transform:uppercase;letter-spacing:0.4px;margin-bottom:2px;">Batas Daftar</span>
            <p style="margin:0;font-size:12.5px;font-weight:800;color:{{ now()->gt($j->tgl_batas_daftar)?'#EF4444':'#131218' }};">
              {{ $j->tgl_batas_daftar->format('d M Y') }}
            </p>
            @if(now()->gt($j->tgl_batas_daftar))
            <span style="font-size:10px;font-weight:800;color:#EF4444;">Lewat Batas</span>
            @endif
          </div>

          {{-- Kuota Progress --}}
          <div style="grid-column: span 2; border-top: 1px dashed #E2E4EB; padding-top: 8px;">
            <div style="display:flex;justify-content:space-between;font-size:11px;color:#64748B;margin-bottom:4px;font-weight:800;">
              <span>Kuota Peserta</span>
              <span style="color:#131218;">{{ $hasKegiatan ? $kegiatan->terisi : 0 }} / {{ $j->kuota_peserta }}</span>
            </div>
            <div style="height:5px;background:#E2E4EB;border-radius:3px;overflow:hidden;">
              <div style="height:100%;border-radius:3px;
                   background:{{ $hasKegiatan && $kegiatan->isFull() ? '#EF4444' : '#FFC81A' }};
                   width:{{ $hasKegiatan ? min(100,round($kegiatan->terisi/$j->kuota_peserta*100)) : 0 }}%;"></div>
            </div>
          </div>
        </div>

        {{-- Actions Row --}}
        <div style="display:flex;justify-content:flex-end;align-items:center;gap:8px;">
          @if($hasKegiatan)
          <a href="{{ route('admin.kegiatan.show', $kegiatan) }}"
             style="padding:6px 14px;font-size:12px;font-weight:800;color:#2563EB;background:#EFF6FF;border:1px solid #BFDBFE;border-radius:18px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
            @include('components.icon',['name'=>'eye','size'=>13]) Kegiatan
          </a>
          @endif
          <a href="{{ route('admin.jadwal-pelatihan.edit', $j) }}"
             style="padding:6px 14px;font-size:12px;font-weight:800;color:#131218;background:#FFC81A;border:1.5px solid #131218;border-radius:18px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;">
            @include('components.icon',['name'=>'edit','size'=>13]) Edit
          </a>
          <form action="{{ route('admin.jadwal-pelatihan.destroy', $j) }}" method="POST" style="margin:0;" onsubmit="return fccConfirmDelete(event, this, 'Hapus Jadwal', 'Apakah Anda yakin ingin menghapus jadwal pelatihan ini?')">
            @csrf @method('DELETE')
            <button type="submit" style="padding:6px 14px;font-size:12px;font-weight:800;color:#EF4444;background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:18px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;">
              @include('components.icon',['name'=>'trash','size'=>13]) Hapus
            </button>
          </form>
        </div>
      </div>
      @empty
      <div style="padding:36px 20px;text-align:center;color:#9CA3B0;font-size:14px;">
        Belum ada jadwal pelatihan.
        <a href="{{ route('admin.pelatihan.index') }}" style="color:#FFC81A;font-weight:700;text-decoration:none;"> Tambah dari Pelatihan &rarr;</a>
      </div>
      @endforelse
    </div>

    <div class="fcc-pagination-bar" style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
      <div style="display:flex;align-items:center;gap:10px;">
        <form method="GET" action="{{ url()->current() }}" style="margin:0;">
          @if(request()->filled('pelatihan_id'))
            <input type="hidden" name="pelatihan_id" value="{{ request('pelatihan_id') }}">
          @endif
        <select name="per_page" onchange="this.form.submit()" class="fcc-input" style="width:auto;font-size:12.5px;height:34px;padding:0 10px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;font-weight:700;cursor:pointer;color:#131218;outline:none;" title="Jumlah data per halaman">
          <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / hal</option>
          <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 / hal</option>
          <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 / hal</option>
          <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / hal</option>
          <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / hal</option>
        </select>
        </form>
        <span style="font-size:12px;color:#64748B;font-weight:600;">
          Menampilkan {{ $jadwal->firstItem() ?? 0 }} &ndash; {{ $jadwal->lastItem() ?? 0 }} dari {{ $jadwal->total() }} data
        </span>
      </div>
      <div>
        {{ $jadwal->withQueryString()->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
