@extends('layouts.admin')
@section('title','Sertifikat Peserta')
@section('page-title','Sertifikat Peserta')
@section('page-content')
<div style="padding:20px 24px;">
  <a href="{{ route('admin.sertifikat.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:16px;">
    @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
  </a>
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
    <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0;">{{ $kegiatan->judul }}</h2>
    <form action="{{ route('admin.sertifikat.terbitkan-semua', $kegiatan) }}" method="POST">
      @csrf
      <div style="display:flex;gap:8px;align-items:center;">
        <input type="date" name="tgl_terbit" value="{{ date('Y-m-d') }}" required class="fcc-input" style="width:auto;">
        <button type="submit" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;" onclick="return fccConfirmAction(event, this, 'Terbitkan Sertifikat', 'Apakah Anda yakin ingin menerbitkan sertifikat untuk semua peserta yang terdaftar?', 'Ya, Terbitkan', false)">
          @include('components.icon',['name'=>'award','size'=>14]) Terbitkan Semua
        </button>
      </div>
    </form>
  </div>
  <div class="fcc-card" style="padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
      <thead><tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
        @foreach(['Peserta','Status Daftar','No. Sertifikat','Tgl Terbit','Aksi'] as $h)
        <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $h }}</th>
        @endforeach
      </tr></thead>
      <tbody>
        @forelse($pendaftaran as $pd)
        @php $sert = $pd->sertifikat; @endphp
        <tr style="border-top:1px solid #F0F1F5;" class="tbl-row">
          <td style="padding:11px 14px;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $pd->peserta->nama }}</p>
            <p style="margin:0;font-size:10px;color:#9CA3B0;">{{ $pd->peserta->email }}</p>
          </td>
          <td style="padding:11px 14px;">
            @php $sc=match($pd->status_pendaftaran){'terdaftar'=>['#10B981','Terdaftar'],'menunggu_verifikasi'=>['#F59E0B','Menunggu'],default=>['#9CA3B0','Lainnya']}; @endphp
            <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span>
          </td>
          <td style="padding:11px 14px;font-size:12px;font-family:monospace;color:{{ $sert?'#3B82F6':'#9CA3B0' }};">
            {{ $sert?->nomor_sertifikat ?? '—' }}
          </td>
          <td style="padding:11px 14px;font-size:12px;color:#6B7280;">{{ $sert?->tgl_terbit?->format('d M Y') ?? '—' }}</td>
          <td style="padding:11px 14px;">
            @if($pd->status_pendaftaran === 'terdaftar' && !$sert)
            <form action="{{ route('admin.sertifikat.terbitkan', $pd) }}" method="POST" style="display:flex;gap:6px;align-items:center;">
              @csrf
              <input type="date" name="tgl_terbit" value="{{ date('Y-m-d') }}" required class="fcc-input" style="width:auto;font-size:12px;padding:5px 8px;">
              <button type="submit" style="background:#131218;color:#FFC81A;border:none;border-radius:7px;padding:5px 10px;font-size:11px;font-weight:700;cursor:pointer;white-space:nowrap;">Terbitkan</button>
            </form>
            @elseif($sert)
            <span style="font-size:11px;font-weight:700;color:#10B981;">&#10003; Diterbitkan</span>
            @else
            <span style="font-size:11px;color:#9CA3B0;">Belum terdaftar</span>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="padding:28px;text-align:center;color:#9CA3B0;font-size:13px;">Belum ada peserta yang terdaftar.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
