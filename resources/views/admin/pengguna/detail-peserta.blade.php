@extends('layouts.admin')
@section('title','Detail Peserta')
@section('page-title','Detail Peserta')

@section('page-content')
<div style="padding:24px;">

    {{-- Navigasi Kembali --}}
    <div style="margin-bottom:16px;">
        <a href="{{ route('admin.pengguna.peserta') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;font-weight:700;transition:color .2s;" onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#6B7280'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Peserta
        </a>
    </div>

    {{-- Title Header --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">Detail Informasi Peserta</h1>
        <p style="color:#6B7280;font-size:13.5px;margin:0;">Informasi akun profil lengkap dan riwayat keikutsertaan kegiatan.</p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1.8fr;gap:20px;">
        
        {{-- Left Column: Profil & Information --}}
        <div>
            {{-- Profil Card --}}
            <div class="fcc-card" style="padding:24px;text-align:center;margin-bottom:16px;box-shadow:0 4px 16px rgba(0,0,0,0.04);border-radius:16px;">
                <div style="width:72px;height:72px;border-radius:50%;background:#131218;border:3px solid #FFC81A;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;box-shadow:0 6px 16px rgba(0,0,0,0.12);">
                    <span style="font-size:28px;font-weight:900;color:#FFC81A;">{{ strtoupper(substr($peserta->nama ?? 'P', 0, 1)) }}</span>
                </div>
                <h3 style="font-size:17px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $peserta->nama }}</h3>
                <p style="font-size:12.5px;color:#6B7280;margin:0 0 12px;word-break:break-all;">{{ $peserta->email }}</p>
                
                @php 
                  $sc = match($peserta->status_akun ?? 'aktif') {
                    'aktif' => ['#10B981', 'Aktif'],
                    'nonaktif' => ['#F59E0B', 'Nonaktif'],
                    default => ['#EF4444', 'Ditangguhkan']
                  }; 
                @endphp
                <span style="font-size:11px;font-weight:800;padding:4px 14px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">
                    {{ $sc[1] }}
                </span>

                <div style="margin-top:18px;">
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $peserta->no_hp)) }}" target="_blank" class="fcc-btn-gold" style="display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:9px 18px;font-size:12.5px;border-radius:10px;text-decoration:none;font-weight:800;width:100%;box-sizing:border-box;">
                        @include('components.icon',['name'=>'message-circle','size'=>15]) Hubungi via WhatsApp
                    </a>
                </div>
            </div>

            {{-- Detail Attributes --}}
            <div class="fcc-card" style="padding:18px 20px;box-shadow:0 4px 16px rgba(0,0,0,0.04);border-radius:16px;">
                @foreach([
                    ['Jenis Kelamin', $peserta->kelamin === 'L' ? 'Laki-laki' : ($peserta->kelamin === 'P' ? 'Perempuan' : '-')],
                    ['No. WhatsApp', $peserta->no_hp ?? '-'],
                    ['Instansi / Unit', $peserta->instansi ?? '-'],
                    ['Alamat', $peserta->alamat ?? '-'],
                    ['Tgl Bergabung', $peserta->created_at?->format('d M Y') ?? '-']
                ] as [$l, $v])
                <div style="padding:10px 0;border-top:{{ $loop->first ? 'none' : '1px solid #F0F1F5' }};">
                    <span style="display:block;font-size:10.5px;font-weight:800;color:#9CA3B0;text-transform:uppercase;letter-spacing:.6px;margin-bottom:2px;">{{ $l }}</span>
                    <span style="font-size:13px;color:#131218;font-weight:700;word-break:break-word;">{{ $v }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right Column: Riwayat Pendaftaran --}}
        <div>
            <div class="fcc-card" style="padding:0;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.04);border-radius:16px;">
                <div style="padding:16px 20px;border-bottom:1px solid #E5E7EB;background:#F9FAFB;display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <h4 style="font-size:15px;font-weight:900;color:#131218;margin:0;">Riwayat Pendaftaran</h4>
                        <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">Daftar kegiatan yang pernah diikuti</p>
                    </div>
                    <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;">
                        {{ $peserta->pendaftaran->count() }} Kegiatan
                    </span>
                </div>

                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background:#F3F4F6;border-bottom:1.5px solid #E5E7EB;">
                                <th style="padding:10px 14px;font-size:10.5px;font-weight:800;color:#6B7280;text-align:left;text-transform:uppercase;">Kegiatan</th>
                                <th style="padding:10px 10px;font-size:10.5px;font-weight:800;color:#6B7280;text-align:center;text-transform:uppercase;">Jenis</th>
                                <th style="padding:10px 10px;font-size:10.5px;font-weight:800;color:#6B7280;text-align:center;text-transform:uppercase;">Status</th>
                                <th style="padding:10px 14px;font-size:10.5px;font-weight:800;color:#6B7280;text-align:right;text-transform:uppercase;">Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peserta->pendaftaran as $pd)
                            @php 
                              $ds = match($pd->status_pendaftaran) {
                                'terdaftar' => ['#10B981', 'Terdaftar'],
                                'menunggu_verifikasi' => ['#F59E0B', 'Menunggu'],
                                default => ['#9CA3B0', ucfirst($pd->status_pendaftaran)]
                              }; 
                              $isPel = $pd->kegiatan->jenis_kegiatan === 'pelatihan';
                            @endphp
                            <tr style="border-top:1px solid #F0F1F5;">
                                <td style="padding:12px 14px;">
                                    <p style="margin:0;font-size:13px;font-weight:800;color:#131218;max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        {{ $pd->kegiatan->judul ?? '-' }}
                                    </p>
                                    <span style="font-size:10.5px;color:#6B7280;">
                                        {{ $pd->tgl_daftar?->format('d/m/Y') ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding:12px 10px;text-align:center;">
                                    <span style="font-size:10px;font-weight:800;padding:3px 8px;border-radius:6px;background:{{ $isPel ? 'rgba(255,200,26,.15)' : 'rgba(59,130,246,.12)' }};color:{{ $isPel ? '#9A7300' : '#3B82F6' }};text-transform:uppercase;">
                                        {{ $pd->kegiatan->jenis_kegiatan ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding:12px 10px;text-align:center;">
                                    <span style="font-size:10px;font-weight:800;padding:3px 8px;border-radius:20px;background:{{ $ds[0] }}18;color:{{ $ds[0] }};">
                                        {{ $ds[1] }}
                                    </span>
                                </td>
                                <td style="padding:12px 14px;text-align:right;font-size:12.5px;font-weight:800;color:#131218;">
                                    {{ $pd->pembayaran?->jumlah_bayar_format ?? 'Gratis' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="padding:32px 16px;text-align:center;color:#9CA3B0;font-size:13px;">
                                    Belum ada riwayat pendaftaran kegiatan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
