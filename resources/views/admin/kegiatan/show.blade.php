@extends('layouts.admin')
@section('title','Detail Kegiatan')
@section('page-title','Detail Kegiatan')
@section('page-content')
<div style="padding:20px 24px;">
  @php $isPel = $kegiatan->jenis_kegiatan==='pelatihan'; @endphp

  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px;">
    <div>
      <a href="{{ route('admin.kegiatan.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:8px;">
        @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
      </a>
      <h1 style="font-size:20px;font-weight:900;color:#131218;margin:0;">{{ $kegiatan->judul }}</h1>
    </div>
    <div style="display:flex;gap:8px;">
      <a href="{{ route('admin.presensi.show', $kegiatan) }}" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'clipboard-list','size'=>14]) Presensi
      </a>
      <a href="{{ route('admin.sertifikat.peserta', $kegiatan) }}" class="fcc-btn-dark" style="padding:9px 16px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'file-text','size'=>14,'style'=>'color:#FFC81A']) Sertifikat
      </a>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
    {{-- Kiri --}}
    <div>
      {{-- Info --}}
      <div class="fcc-card" style="padding:22px;margin-bottom:14px;">
        <p style="font-size:14px;font-weight:800;color:#131218;margin:0 0 14px;">Informasi Kegiatan</p>
        @foreach([
          ['Jenis',ucfirst($kegiatan->jenis_kegiatan)],
          ['Judul',$kegiatan->judul],
          ['Tanggal',$kegiatan->jadwal?->tgl_pelaksanaan?->format('d F Y')??'—'],
          ['Waktu',($kegiatan->jadwal?->jam_mulai??'—').' – '.($kegiatan->jadwal?->jam_selesai??'—')],
          ['Batas Daftar',$kegiatan->jadwal?->tgl_batas_daftar?->format('d M Y')??'—'],
          $isPel ? ['Instruktur',$kegiatan->kegiatanPelatihan?->jadwalPelatihan?->pelatihan?->instruktur?->nama??'—'] : ['Kategori',$kegiatan->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi?->kategori?->nama_kategori??'—'],
        ] as [$l,$v])
        <div style="display:flex;padding:9px 0;border-top:1px solid #F0F1F5;">
          <span style="min-width:140px;font-size:12px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</span>
          <span style="font-size:14px;color:#131218;font-weight:500;">{{ $v }}</span>
        </div>
        @endforeach
      </div>

      {{-- Biaya --}}
      <div class="fcc-card" style="padding:22px;margin-bottom:14px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
          <p style="font-size:14px;font-weight:800;color:#131218;margin:0;">Biaya Kegiatan</p>
          <a href="{{ route('admin.biaya.create') }}?kegiatan_id={{ $kegiatan->id }}" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;">+ Tambah Biaya</a>
        </div>
        @forelse($kegiatan->biaya as $b)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-top:1px solid #F0F1F5;">
          <span style="font-size:13px;color:#131218;font-weight:600;">{{ $b->nama_jenis }}</span>
          <div style="display:flex;align-items:center;gap:10px;">
            <span style="font-size:14px;font-weight:900;color:#131218;">{{ $b->nominal_format }}</span>
            <form action="{{ route('admin.biaya.destroy', $b) }}" method="POST" onsubmit="return confirm('Hapus biaya ini?')">
              @csrf @method('DELETE')
              <button type="submit" style="background:none;border:none;cursor:pointer;color:#EF4444;display:flex;padding:0;">@include('components.icon',['name'=>'trash','size'=>14])</button>
            </form>
          </div>
        </div>
        @empty
        <p style="color:#9CA3B0;font-size:13px;margin:0;">Tidak ada biaya — kegiatan ini <strong style="color:#10B981;">gratis</strong>.</p>
        @endforelse
      </div>

      {{-- Peserta terdaftar --}}
      <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
          <p style="font-size:14px;font-weight:800;color:#131218;margin:0;">
            Peserta ({{ $kegiatan->pendaftaran->count() }})
          </p>
          <a href="{{ route('admin.presensi.export', $kegiatan) }}" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;display:flex;align-items:center;gap:5px;">
            @include('components.icon',['name'=>'download','size'=>12]) Export CSV
          </a>
        </div>
        <table style="width:100%;border-collapse:collapse;">
          <thead><tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
            @foreach(['Nama','Status Daftar','Pembayaran','Kehadiran'] as $h)
            <th style="padding:9px 14px;font-size:10px;font-weight:700;color:#9CA3B0;text-align:left;text-transform:uppercase;letter-spacing:.7px;">{{ $h }}</th>
            @endforeach
          </tr></thead>
          <tbody>
            @forelse($kegiatan->pendaftaran as $pd)
            @php
            $dS=match($pd->status_pendaftaran){'terdaftar'=>['#10B981','Terdaftar'],'menunggu_verifikasi'=>['#F59E0B','Menunggu'],'ditolak'=>['#EF4444','Ditolak'],default=>['#9CA3B0','Menunggu Bayar']};
            $hS=match($pd->status_kehadiran){'hadir'=>['#10B981','Hadir'],'tidak_hadir'=>['#EF4444','Tidak Hadir'],default=>['#9CA3B0','Belum']};
            @endphp
            <tr style="border-top:1px solid #F0F1F5;" class="tbl-row">
              <td style="padding:10px 14px;">
                <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $pd->peserta->nama }}</p>
                <p style="margin:0;font-size:10px;color:#9CA3B0;">{{ $pd->peserta->email }}</p>
              </td>
              <td style="padding:10px 14px;"><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $dS[0] }}18;color:{{ $dS[0] }};">{{ $dS[1] }}</span></td>
              <td style="padding:10px 14px;font-size:12px;color:#6B7280;">{{ $pd->pembayaran?->jumlah_bayar_format ?? 'Gratis' }}</td>
              <td style="padding:10px 14px;"><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $hS[0] }}18;color:{{ $hS[0] }};">{{ $hS[1] }}</span></td>
            </tr>
            @empty
            <tr><td colspan="4" style="padding:20px;text-align:center;color:#9CA3B0;font-size:13px;">Belum ada peserta yang mendaftar.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Kanan: stat cards --}}
    <div>
      @foreach([
        ['Terdaftar',$kegiatan->pendaftaran->where('status_pendaftaran','terdaftar')->count(),'check','#10B981'],
        ['Menunggu Verifikasi',$kegiatan->pendaftaran->where('status_pendaftaran','menunggu_verifikasi')->count(),'clock','#F59E0B'],
        ['Pembayaran Masuk','Rp '.number_format($kegiatan->pendaftaran->sum(fn($p)=>$p->pembayaran?->jumlah_bayar??0),0,',','.'),'credit-card','#3B82F6'],
        ['Hadir',$kegiatan->pendaftaran->where('status_kehadiran','hadir')->count(),'users','#131218'],
      ] as [$l,$v,$ic,$c])
      <div class="fcc-card" style="padding:16px 18px;margin-bottom:12px;display:flex;align-items:center;gap:14px;">
        <div style="width:40px;height:40px;border-radius:11px;background:{{ $c=='#131218'?'#131218':$c.'18' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          @include('components.icon',['name'=>$ic,'size'=>18,'style'=>"color:".($c=='#131218'?'#FFC81A':$c)])
        </div>
        <div>
          <p style="margin:0;font-size:20px;font-weight:900;color:#131218;">{{ $v }}</p>
          <p style="margin:0;font-size:11px;color:#9CA3B0;">{{ $l }}</p>
        </div>
      </div>
      @endforeach

      {{-- Danger zone --}}
      <div style="background:rgba(239,68,68,.05);border:1px solid rgba(239,68,68,.2);border-radius:12px;padding:16px;margin-top:4px;">
        <p style="font-size:13px;font-weight:800;color:#EF4444;margin:0 0 8px;">Danger Zone</p>
        <p style="font-size:12px;color:#6B7280;margin:0 0 12px;line-height:1.6;">Menghapus kegiatan akan menghapus semua data pendaftaran yang terkait.</p>
        <form action="{{ route('admin.kegiatan.destroy', $kegiatan) }}" method="POST" onsubmit="return confirm('Yakin hapus kegiatan ini? Tindakan ini tidak bisa dibatalkan.')">
          @csrf @method('DELETE')
          <button type="submit" style="width:100%;padding:9px;border-radius:9px;border:1.5px solid rgba(239,68,68,.3);background:rgba(239,68,68,.08);color:#EF4444;font-size:13px;font-weight:700;cursor:pointer;">
            Hapus Kegiatan
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
