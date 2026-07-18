@extends('layouts.admin')
@section('title','Nilai Peserta')
@section('page-title','Nilai Peserta')
@section('page-content')
<div style="padding:20px 24px;">
  <form method="GET" style="display:flex;gap:10px;margin-bottom:18px;">
    <select name="kegiatan_id" class="fcc-input" style="width:auto;min-width:240px;" onchange="this.form.submit()">
      <option value="">— Pilih Kegiatan —</option>
      @foreach($kegiatan as $k)
      <option value="{{ $k->id }}" {{ request('kegiatan_id')==$k->id?'selected':'' }}>{{ $k->judul }}</option>
      @endforeach
    </select>
  </form>

  @if($pendaftaran->count() > 0)
  <div class="fcc-card" style="padding:0;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
      <thead><tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
        @foreach(['Peserta','Status','Total Nilai','Aksi'] as $h)
        <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $h }}</th>
        @endforeach
      </tr></thead>
      <tbody>
        @foreach($pendaftaran as $pd)
        <tr style="border-top:1px solid #F0F1F5;" class="tbl-row">
          <td style="padding:11px 14px;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $pd->peserta->nama }}</p>
            <p style="margin:0;font-size:10px;color:#9CA3B0;">{{ $pd->peserta->email }}</p>
          </td>
          <td style="padding:11px 14px;">
            <span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:rgba(16,185,129,.12);color:#10B981;">Terdaftar</span>
          </td>
          <td style="padding:11px 14px;font-size:14px;font-weight:800;color:#131218;">
            {{ $pd->nilai->count() > 0 ? number_format($pd->nilai->avg('nilai'),1) : '—' }}
          </td>
          <td style="padding:11px 14px;">
            <a href="{{ route('admin.nilai.show', $pd) }}" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;">Input/Lihat Nilai</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @if($pendaftaran->hasPages())<div style="padding:12px 16px;border-top:1px solid #E2E4EB;">{{ $pendaftaran->withQueryString()->links() }}</div>@endif
  </div>
  @elseif(request('kegiatan_id'))
  <div class="fcc-card" style="padding:40px;text-align:center;color:#9CA3B0;">Belum ada peserta terdaftar untuk kegiatan ini.</div>
  @else
  <div class="fcc-card" style="padding:40px;text-align:center;color:#9CA3B0;">Pilih kegiatan untuk melihat daftar nilai.</div>
  @endif
</div>
@endsection
