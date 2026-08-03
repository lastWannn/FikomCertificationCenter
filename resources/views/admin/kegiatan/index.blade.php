@extends('layouts.admin')
@section('title','Kegiatan Aktif')
@section('page-title','Kegiatan Aktif')
@section('page-content')
<div style="padding:20px 24px;">
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px;">
    <p style="color:#6B7280;font-size:14px;margin:0;">Semua kegiatan yang sedang aktif dan terlihat oleh publik.</p>
    <div style="display:flex;gap:8px;">
      <form method="GET" style="display:flex;gap:8px;">
        <select name="jenis" class="fcc-input" style="width:auto;" onchange="this.form.submit()">
          <option value="">Semua Jenis</option>
          <option value="pelatihan"   {{ request('jenis')==='pelatihan'?'selected':'' }}>Pelatihan</option>
          <option value="sertifikasi" {{ request('jenis')==='sertifikasi'?'selected':'' }}>Sertifikasi</option>
        </select>
      </form>
      <a href="{{ route('admin.jadwal-pelatihan.index') }}" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'plus','size'=>13]) Jadwal Baru
      </a>
    </div>
  </div>

  <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:14px;">
    <div style="overflow-x:auto;">
      <table style="width:100%;border-collapse:collapse;text-align:left;">
        <thead>
          <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
            <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Kegiatan</th>
            <th style="padding:14px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;text-align:center;">Jenis</th>
            <th style="padding:14px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Jadwal</th>
            <th style="padding:14px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;text-align:center;">Kuota & Peserta</th>
            <th style="padding:14px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;text-align:center;">Status Biaya</th>
            <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;text-align:center;width:150px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($kegiatan as $k)
          @php $isPel = $k->jenis_kegiatan==='pelatihan'; @endphp
          <tr style="border-top:1px solid #F0F1F3;transition:background .18s;" onmouseover="this.style.background='#FAFBFD'" onmouseout="this.style.background='transparent'">
            <td style="padding:16px 20px;">
              <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:{{ $isPel?'rgba(255,200,26,.14)':'rgba(59,130,246,.12)' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                  @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>18,'style'=>'color:'.($isPel?'#9A7300':'#3B82F6')])
                </div>
                <div>
                  <p style="margin:0 0 2px;font-size:14px;font-weight:800;color:#131218;line-height:1.3;">{{ $k->judul }}</p>
                  @if($k->isFull())
                  <span style="font-size:10px;font-weight:700;padding:1px 7px;border-radius:10px;background:rgba(239,68,68,.12);color:#EF4444;">Kuota Penuh</span>
                  @endif
                </div>
              </div>
            </td>
            <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
              <span style="font-size:10.5px;font-weight:800;padding:4px 10px;border-radius:6px;background:{{ $isPel?'rgba(255,200,26,.14)':'rgba(59,130,246,.12)' }};color:{{ $isPel?'#9A7300':'#3B82F6' }};text-transform:uppercase;">
                {{ ucfirst($k->jenis_kegiatan) }}
              </span>
            </td>
            <td style="padding:16px 14px;vertical-align:middle;font-size:12.5px;color:#4B5563;font-weight:600;">
              <div>
                <p style="margin:0;font-weight:700;color:#131218;">{{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'TBA' }}</p>
                <p style="margin:2px 0 0;font-size:11px;color:#9CA3B0;">
                  {{ $k->jadwal?->jam_mulai ? substr($k->jadwal->jam_mulai, 0, 5) : '' }} &ndash; {{ $k->jadwal?->jam_selesai ? substr($k->jadwal->jam_selesai, 0, 5) : '' }}
                </p>
              </div>
            </td>
            <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
              <div style="display:inline-block;min-width:110px;">
                <div style="display:flex;justify-content:space-between;font-size:11px;color:#6B7280;margin-bottom:4px;font-weight:700;">
                  <span>Terisi</span>
                  <span style="color:#131218;">{{ $k->terisi }} / {{ $k->kuota }}</span>
                </div>
                <div style="height:5px;background:#E2E4EB;border-radius:3px;">
                  <div style="height:5px;border-radius:3px;transition:width .3s;
                    background:{{ $k->isFull()?'#EF4444':($k->terisi/$k->kuota>0.8?'#F59E0B':'#131218') }};
                    width:{{ $k->kuota>0?min(100,round($k->terisi/$k->kuota*100)):0 }}%;"></div>
                </div>
              </div>
            </td>
            <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
              <span style="font-size:12.5px;font-weight:800;color:#131218;">
                @if($k->biaya->isEmpty()) <span style="color:#10B981;">Gratis</span>
                @else Rp {{ number_format($k->biaya->min('nominal'),0,',','.') }}+
                @endif
              </span>
            </td>
            <td style="padding:16px 20px;text-align:center;vertical-align:middle;">
              <div style="display:flex;gap:6px;justify-content:center;">
                <a href="{{ route('admin.kegiatan.show', $k) }}" class="fcc-btn-dark" style="padding:6px 12px;font-size:12px;text-decoration:none;" title="Lihat Detail">
                  @include('components.icon',['name'=>'eye','size'=>13,'style'=>'color:#FFC81A']) Detail
                </a>
                <a href="{{ route('admin.pembayaran.index',['kegiatan_id'=>$k->id]) }}"
                   style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;
                          border:1.5px solid #E2E4EB;background:#F7F8FA;color:#6B7280;text-decoration:none;transition:all .18s;"
                   title="Lihat Pembayaran"
                   onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                  @include('components.icon',['name'=>'credit-card','size'=>13])
                </a>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="padding:48px;text-align:center;color:#9CA3B0;">
              <div style="width:60px;height:60px;border-radius:18px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                @include('components.icon',['name'=>'zap','size'=>28,'style'=>'color:#9CA3B0'])
              </div>
              <p style="font-size:15px;font-weight:700;color:#131218;margin:0 0 6px;">Belum Ada Kegiatan Aktif</p>
              <p style="font-size:13px;color:#9CA3B0;margin:0 0 20px;">Aktifkan jadwal pelatihan atau sertifikasi untuk mulai menerima pendaftaran.</p>
              <div style="display:flex;gap:10px;justify-content:center;">
                <a href="{{ route('admin.jadwal-pelatihan.index') }}" class="fcc-btn-dark" style="padding:10px 20px;font-size:13px;text-decoration:none;">
                  @include('components.icon',['name'=>'book-open','size'=>14,'style'=>'color:#FFC81A']) Jadwal Pelatihan
                </a>
                <a href="{{ route('admin.jadwal-sertifikasi.index') }}" class="fcc-btn-outline-dark" style="padding:10px 20px;font-size:13px;">
                  @include('components.icon',['name'=>'award','size'=>14]) Jadwal Sertifikasi
                </a>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  @if($kegiatan->hasPages())
  <div style="margin-top:18px;">{{ $kegiatan->withQueryString()->links() }}</div>
  @endif
</div>
@endsection
