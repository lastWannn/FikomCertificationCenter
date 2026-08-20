@extends('layouts.admin')
@section('title','Jadwal Pelatihan')
@section('page-title','Jadwal Pelatihan')
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
    #jadwal-skeleton-overlay {
      transition: opacity 0.35s ease, visibility 0.35s ease;
    }
  </style>

  <div id="jadwal-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
    {{-- Filter Skeleton --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
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
  <form method="GET" style="display:flex;gap:10px;align-items:center;margin-bottom:18px;flex-wrap:wrap;">
    <select name="pelatihan_id" class="fcc-input" style="width:auto;min-width:220px;" onchange="this.form.submit()">
      <option value="">— Semua Program Pelatihan —</option>
      @foreach($pelatihan as $p)
      <option value="{{ $p->id }}" {{ request('pelatihan_id')==$p->id?'selected':'' }}>{{ $p->judul }}</option>
      @endforeach
    </select>
    <div style="margin-left:auto;">
      <a href="{{ route('admin.pelatihan.index') }}" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'plus','size'=>14]) Tambah Jadwal
      </a>
    </div>
  </form>

  <div class="fcc-card" style="padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
          @foreach(['Program','Tanggal Pelaksanaan','Kuota','Batas Daftar','Status','Aksi'] as $h)
          <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $h }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse($jadwal as $j)
        @php
          $hasKegiatan = $j->kegiatanPelatihan !== null;
          $kegiatan    = $j->kegiatanPelatihan?->kegiatan;
        @endphp
        <tr style="border-top:1px solid #F0F1F5;" class="tbl-row">
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
            <p style="margin:2px 0 0;font-size:11px;color:#9CA3B0;">{{ $j->jam_mulai }} – {{ $j->jam_selesai }}</p>
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
          <td style="padding:12px 14px;">
            <div style="display:flex;gap:8px;align-items:center;">
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
    @if($jadwal->hasPages())
    <div style="padding:12px 16px;border-top:1px solid #E2E4EB;">{{ $jadwal->withQueryString()->links() }}</div>
    @endif
  </div>
</div>
@endsection
