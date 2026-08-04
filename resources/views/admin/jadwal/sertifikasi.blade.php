@extends('layouts.admin')
@section('title','Jadwal Sertifikasi')
@section('page-title','Jadwal Sertifikasi')
@section('page-content')
<div style="padding:20px 24px;">
  <form method="GET" style="display:flex;gap:10px;align-items:center;margin-bottom:18px;">
    <select name="sertifikasi_id" class="fcc-input" style="width:auto;min-width:220px;" onchange="this.form.submit()">
      <option value="">— Semua Program Sertifikasi —</option>
      @foreach($sertifikasi as $s)
      <option value="{{ $s->id }}" {{ request('sertifikasi_id')==$s->id?'selected':'' }}>{{ $s->judul }}</option>
      @endforeach
    </select>
    <div style="margin-left:auto;">
      <a href="{{ route('admin.sertifikasi.index') }}" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;text-decoration:none;">
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
        @php $hasK = $j->kegiatanSertifikasi !== null; $k = $j->kegiatanSertifikasi?->kegiatan; @endphp
        <tr style="border-top:1px solid #F0F1F5;" class="tbl-row">
          <td style="padding:12px 14px;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">
                {{ Str::limit($j->sertifikasi->judul,35) }}
                @if($j->nama_kegiatan)
                <span style="font-size:10px;font-weight:600;color:#FFC81A;background:#131218;padding:1px 5px;border-radius:4px;margin-left:4px;">{{ $j->nama_kegiatan }}</span>
                @endif
            </p>
            <p style="margin:2px 0 0;font-size:10px;color:#9CA3B0;font-family:monospace;">{{ $j->sertifikasi->kode }}</p>
          </td>
          <td style="padding:12px 14px;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $j->tgl_pelaksanaan->format('d M Y') }}</p>
            <p style="margin:2px 0 0;font-size:11px;color:#9CA3B0;">{{ $j->jam_mulai }} – {{ $j->jam_selesai }}</p>
          </td>
          <td style="padding:12px 14px;font-size:13px;font-weight:700;color:#131218;">
            {{ $hasK ? $k->terisi.'/'.$j->kuota_peserta : '0/'.$j->kuota_peserta }}
          </td>
          <td style="padding:12px 14px;font-size:12px;color:{{ now()->gt($j->tgl_batas_daftar)?'#EF4444':'#6B7280' }};">{{ $j->tgl_batas_daftar->format('d M Y') }}</td>
          <td style="padding:12px 14px;">
            @if($hasK)
            <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:rgba(16,185,129,.12);color:#10B981;">&#10003; Aktif</span>
            @else
            <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:#F7F8FA;color:#9CA3B0;border:1px solid #E2E4EB;">Belum Aktif</span>
            @endif
          </td>
          <td style="padding:12px 14px;">
            <div style="display:flex;gap:8px;align-items:center;">
              @if(!$hasK)
              <form action="{{ route('admin.jadwal-sertifikasi.aktifkan', $j) }}" method="POST">
                @csrf
                <button type="submit" style="background:#131218;border:none;color:#FFC81A;font-size:11px;font-weight:700;padding:5px 10px;border-radius:7px;cursor:pointer;" onclick="return fccConfirmAction(event, this, 'Aktifkan Jadwal', 'Aktifkan jadwal ini sebagai kegiatan publik?', 'Ya, Aktifkan', false)">+ Aktifkan</button>
              </form>
              <a href="{{ route('admin.jadwal-sertifikasi.edit', $j) }}" style="color:#FFC81A;">@include('components.icon',['name'=>'edit','size'=>15])</a>
              <form action="{{ route('admin.jadwal-sertifikasi.destroy', $j) }}" method="POST" onsubmit="return fccConfirmDelete(event, this, 'Hapus Jadwal', 'Apakah Anda yakin ingin menghapus jadwal ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;cursor:pointer;color:#EF4444;display:flex;padding:0;">@include('components.icon',['name'=>'trash','size'=>15])</button>
              </form>
              @else
              <form action="{{ route('admin.jadwal-sertifikasi.nonaktifkan', $j) }}" method="POST">
                @csrf
                <button type="submit" title="Nonaktifkan Kegiatan"
                    style="background:rgba(239,68,68,.1);border:none;color:#EF4444;font-size:11px;font-weight:700;
                           padding:5px 10px;border-radius:7px;cursor:pointer;white-space:nowrap;"
                    onclick="return fccConfirmAction(event, this, 'Nonaktifkan Kegiatan', 'Apakah Anda yakin ingin menonaktifkan kegiatan ini?', 'Ya, Nonaktifkan', true)">
                  Nonaktifkan
                </button>
              </form>
              <a href="{{ route('admin.kegiatan.show', $k) }}" style="font-size:11px;color:#3B82F6;font-weight:700;text-decoration:none;">Lihat Kegiatan</a>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="padding:36px;text-align:center;color:#9CA3B0;font-size:14px;">Belum ada jadwal sertifikasi.</td></tr>
        @endforelse
      </tbody>
    </table>
    @if($jadwal->hasPages())<div style="padding:12px 16px;border-top:1px solid #E2E4EB;">{{ $jadwal->withQueryString()->links() }}</div>@endif
  </div>
</div>
@endsection
