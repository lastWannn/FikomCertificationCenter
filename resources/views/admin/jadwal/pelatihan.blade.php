@extends('layouts.admin')
@section('title','Jadwal Pelatihan')
@section('page-title','Jadwal Pelatihan')
@section('page-content')
<div style="padding:20px 24px;">

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
          @foreach(['Program','Instruktur','Tanggal Pelaksanaan','Kuota','Batas Daftar','Status','Aksi'] as $h)
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
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ Str::limit($j->pelatihan->judul,35) }}</p>
            <p style="margin:2px 0 0;font-size:10px;color:#9CA3B0;font-family:monospace;">{{ $j->pelatihan->kode }}</p>
          </td>
          <td style="padding:12px 14px;font-size:12px;color:#6B7280;">{{ $j->pelatihan->instruktur->nama ?? '—' }}</td>
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
            @if($hasKegiatan)
            <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:rgba(16,185,129,.12);color:#10B981;">&#10003; Aktif</span>
            @else
            <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:#F7F8FA;color:#9CA3B0;border:1px solid #E2E4EB;">Belum Aktif</span>
            @endif
          </td>
          <td style="padding:12px 14px;">
            <div style="display:flex;gap:8px;align-items:center;">
              @if(!$hasKegiatan)
              <form action="{{ route('admin.jadwal-pelatihan.aktifkan', $j) }}" method="POST">
                @csrf
                <button type="submit" title="Aktifkan sebagai Kegiatan"
                    style="background:#131218;border:none;color:#FFC81A;font-size:11px;font-weight:700;
                           padding:5px 10px;border-radius:7px;cursor:pointer;white-space:nowrap;"
                    onclick="return confirm('Aktifkan jadwal ini sebagai kegiatan publik?')">
                  + Aktifkan
                </button>
              </form>
              <a href="{{ route('admin.jadwal-pelatihan.edit', $j) }}" style="color:#FFC81A;">
                @include('components.icon',['name'=>'edit','size'=>15])
              </a>
              <form action="{{ route('admin.jadwal-pelatihan.destroy', $j) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;cursor:pointer;color:#EF4444;display:flex;padding:0;">
                  @include('components.icon',['name'=>'trash','size'=>15])
                </button>
              </form>
              @else
              <a href="{{ route('admin.kegiatan.show', $kegiatan) }}" style="font-size:11px;color:#3B82F6;font-weight:700;text-decoration:none;white-space:nowrap;">Lihat Kegiatan</a>
              <form action="{{ route('admin.jadwal-pelatihan.nonaktifkan', $j) }}" method="POST">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;color:#EF4444;font-size:11px;font-weight:700;white-space:nowrap;"
                    onclick="return confirm('Nonaktifkan kegiatan ini?')">Nonaktifkan</button>
              </form>
              @endif
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
