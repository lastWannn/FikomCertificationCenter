@extends('layouts.admin')
@section('title','Detail Peserta')
@section('page-title','Detail Peserta')
@section('page-content')
<div style="padding:20px 24px;">
  <a href="{{ route('admin.pengguna.peserta') }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:16px;">
    @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
  </a>
  <div style="display:grid;grid-template-columns:1fr 2fr;gap:16px;">
    {{-- Profil Card --}}
    <div>
      <div class="fcc-card" style="padding:24px;text-align:center;margin-bottom:14px;">
        <div style="width:64px;height:64px;border-radius:18px;background:#131218;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <p style="font-size:17px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $peserta->nama }}</p>
        <p style="font-size:12px;color:#9CA3B0;margin:0 0 14px;">{{ $peserta->email }}</p>
        @php $sc=match($peserta->status_akun??'aktif'){'aktif'=>['#10B981','Aktif'],'nonaktif'=>['#F59E0B','Nonaktif'],default=>['#EF4444','Ditangguhkan']}; @endphp
        <span style="font-size:11px;font-weight:700;padding:4px 14px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span>
        
        <div style="margin-top:20px;">
          <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $peserta->no_hp)) }}" target="_blank" class="fcc-btn-gold" style="display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 16px;font-size:12px;border-radius:8px;text-decoration:none;">
            @include('components.icon',['name'=>'message-circle','size'=>14]) Hubungi WA
          </a>
        </div>
      </div>
      <div class="fcc-card" style="padding:20px;">
        @foreach([['Kelamin',$peserta->kelamin==='L'?'Laki-laki':'Perempuan'],['No. HP',$peserta->no_hp],['Instansi',$peserta->instansi??'-'],['Alamat',$peserta->alamat??'-'],['Bergabung',$peserta->created_at->format('d M Y')]] as [$l,$v])
        <div style="padding:9px 0;border-top:1px solid #F0F1F5;display:flex;gap:10px;">
          <span style="min-width:80px;font-size:11px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</span>
          <span style="font-size:13px;color:#131218;font-weight:500;">{{ $v }}</span>
        </div>
        @endforeach
      </div>
    </div>
    {{-- Riwayat Pendaftaran --}}
    <div>
      <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;">
          <p style="font-size:14px;font-weight:800;color:#131218;margin:0;">Riwayat Pendaftaran ({{ $peserta->pendaftaran->count() }})</p>
        </div>
        <table style="width:100%;border-collapse:collapse;">
          <thead><tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
            @foreach(['Kegiatan','Jenis','Status Daftar','Pembayaran','Sertifikat'] as $item) <th style="padding:9px 14px;font-size:10px;font-weight:700;color:#9CA3B0;text-align:left;text-transform:uppercase;letter-spacing:.7px;">{{ $item }}</th> @endforeach
          </tr></thead>
          <tbody>
            @forelse($peserta->pendaftaran as $pd)
            @php $ds=match($pd->status_pendaftaran){'terdaftar'=>['#10B981','✓ Terdaftar'],'menunggu_verifikasi'=>['#F59E0B','Menunggu'],default=>['#9CA3B0','Pending']}; @endphp
            <tr class="tbl-row" style="border-top:1px solid #F0F1F5;">
              <td style="padding:11px 14px;font-size:13px;font-weight:700;color:#131218;max-width:180px;">
                <a href="{{ route('admin.nilai.show', $pd) }}" style="color:#131218;text-decoration:none;display:inline-flex;align-items:center;gap:4px;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#131218'">
                  {{ Str::limit($pd->kegiatan->judul,30) }} @include('components.icon',['name'=>'external-link','size'=>12])
                </a>
              </td>
              <td style="padding:11px 14px;"><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $pd->kegiatan->jenis_kegiatan==='pelatihan'?'rgba(255,200,26,.14)':'rgba(59,130,246,.12)' }};color:{{ $pd->kegiatan->jenis_kegiatan==='pelatihan'?'#9A7300':'#3B82F6' }};">{{ ucfirst($pd->kegiatan->jenis_kegiatan) }}</span></td>
              <td style="padding:11px 14px;"><span style="font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;background:{{ $ds[0] }}18;color:{{ $ds[0] }};">{{ $ds[1] }}</span></td>
              <td style="padding:11px 14px;font-size:12px;color:#6B7280;">{{ $pd->pembayaran?->jumlah_bayar_format ?? 'Gratis' }}</td>
              <td style="padding:11px 14px;font-size:12px;color:{{ $pd->sertifikat?'#10B981':'#9CA3B0' }};">{{ $pd->sertifikat ? '✓ Ada' : '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="padding:24px;text-align:center;color:#9CA3B0;font-size:13px;">Belum ada pendaftaran.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
