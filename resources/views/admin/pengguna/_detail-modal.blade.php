<div style="background:#FFFFFF;border-radius:24px;padding:32px;max-width:1050px;width:100%;position:relative;box-shadow:0 24px 64px rgba(0,0,0,.35);border:2.5px solid #131218;max-height:90vh;overflow-y:auto;margin:auto;box-sizing:border-box;">
    {{-- Close Button --}}
    <button type="button" onclick="closePesertaModal()" aria-label="Tutup" style="
        position:absolute;top:20px;right:20px;width:38px;height:38px;
        border:1.5px solid #131218;background:#FFFFFF;cursor:pointer;color:#131218;
        font-size:22px;line-height:1;border-radius:12px;transition:all .18s;
        display:flex;align-items:center;justify-content:center;font-weight:900;"
        onmouseover="this.style.background='#FFC81A';"
        onmouseout="this.style.background='#FFFFFF';">&#215;</button>

    {{-- Title Header --}}
    <div style="margin-bottom:24px;border-bottom:2px solid #E5E7EB;padding-bottom:16px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Detail Akun</span>
            <h2 style="font-size:20px;font-weight:900;color:#131218;margin:0;">Informasi Detail Peserta</h2>
        </div>
        <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Informasi profil akun lengkap dan riwayat pendaftaran kegiatan.</p>
    </div>

    <div style="display:grid;grid-template-columns:320px 1fr;gap:24px;align-items:start;">
        
        {{-- Left Column: Profil & Information --}}
        <div>
            {{-- Profil Card --}}
            <div class="fcc-card" style="padding:24px;text-align:center;margin-bottom:16px;box-shadow:0 4px 16px rgba(0,0,0,0.04);border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;">
                <div style="width:72px;height:72px;border-radius:50%;background:#131218;border:3px solid #FFC81A;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;box-shadow:0 6px 16px rgba(0,0,0,0.12);">
                    <span style="font-size:28px;font-weight:900;color:#FFC81A;">{{ strtoupper(substr($peserta->nama ?? 'P', 0, 1)) }}</span>
                </div>
                <h3 style="font-size:17px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $peserta->nama }}</h3>
                <p style="font-size:12.5px;color:#64748B;margin:0 0 12px;word-break:break-all;font-weight:500;">{{ $peserta->email }}</p>
                
                @php 
                  $sc = match($peserta->status_akun ?? 'aktif') {
                    'aktif' => ['#059669', '#ECFDF5', '#A7F3D0', 'Aktif'],
                    'nonaktif' => ['#D97706', '#FEF3C7', '#FCD34D', 'Nonaktif'],
                    default => ['#DC2626', '#FEF2F2', '#FCA5A5', 'Ditangguhkan']
                  }; 
                @endphp
                <span style="font-size:11px;font-weight:800;padding:4px 14px;border-radius:12px;background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[2] }};display:inline-block;">
                    ● Akun {{ $sc[3] }}
                </span>

                <div style="margin-top:18px;">
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $peserta->no_hp)) }}" target="_blank"
                       style="display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 18px;font-size:12.5px;border-radius:12px;text-decoration:none;font-weight:800;width:100%;box-sizing:border-box;background:#131218;color:#FFC81A;border:1.5px solid #131218;transition:all .18s;"
                       onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                        @include('components.icon',['name'=>'message-circle','size'=>15]) Hubungi via WhatsApp
                    </a>
                </div>
            </div>

            {{-- Detail Attributes --}}
            <div class="fcc-card" style="padding:18px 20px;box-shadow:0 4px 16px rgba(0,0,0,0.04);border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;">
                @foreach([
                    ['Jenis Kelamin', $peserta->kelamin === 'L' ? 'Laki-laki' : ($peserta->kelamin === 'P' ? 'Perempuan' : '-')],
                    ['No. WhatsApp', $peserta->no_hp ?? '-'],
                    ['Instansi / Unit', $peserta->instansi ?? '-'],
                    ['Alamat', $peserta->alamat ?? '-'],
                    ['Tgl Bergabung', $peserta->created_at?->format('d M Y') ?? '-']
                ] as [$l, $v])
                <div style="padding:10px 0;border-top:{{ $loop->first ? 'none' : '1px solid #F1F5F9' }};">
                    <span style="display:block;font-size:10.5px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.6px;margin-bottom:2px;">{{ $l }}</span>
                    <span style="font-size:13px;color:#131218;font-weight:800;word-break:break-word;">{{ $v }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right Column: Riwayat Pendaftaran --}}
        <div>
            <div class="fcc-card" style="padding:0;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.04);border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;">
                <div style="padding:16px 20px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <h4 style="font-size:15.5px;font-weight:900;color:#131218;margin:0;">Riwayat Pendaftaran</h4>
                        <p style="margin:2px 0 0;font-size:11.5px;color:#64748B;font-weight:500;">Daftar kegiatan yang pernah diikuti oleh peserta</p>
                    </div>
                    <span style="background:#FFC81A;color:#131218;font-size:11.5px;font-weight:800;padding:4px 12px;border-radius:20px;border:1px solid #131218;">
                        {{ $peserta->pendaftaran->count() }} Kegiatan
                    </span>
                </div>

                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;min-width:560px;">
                        <thead>
                            <tr style="background:#131218;color:#FFFFFF;">
                                <th style="padding:12px 16px;font-size:11px;font-weight:900;color:#FFC81A;text-align:left;text-transform:uppercase;letter-spacing:0.5px;">Kegiatan</th>
                                <th style="padding:12px 12px;font-size:11px;font-weight:900;color:#FFFFFF;text-align:center;text-transform:uppercase;white-space:nowrap;letter-spacing:0.5px;">Jenis</th>
                                <th style="padding:12px 12px;font-size:11px;font-weight:900;color:#FFFFFF;text-align:center;text-transform:uppercase;white-space:nowrap;letter-spacing:0.5px;">Status</th>
                                <th style="padding:12px 16px;font-size:11px;font-weight:900;color:#FFC81A;text-align:right;text-transform:uppercase;white-space:nowrap;letter-spacing:0.5px;">Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peserta->pendaftaran as $pd)
                            @php 
                              $ds = match($pd->status_pendaftaran) {
                                'terdaftar' => ['#059669', '#ECFDF5', '#A7F3D0', 'Terdaftar'],
                                'menunggu_verifikasi' => ['#D97706', '#FEF3C7', '#FCD34D', 'Menunggu'],
                                default => ['#64748B', '#F1F5F9', '#CBD5E1', ucfirst($pd->status_pendaftaran)]
                              }; 
                              $isPel = $pd->kegiatan->jenis_kegiatan === 'pelatihan';
                            @endphp
                            <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                                <td style="padding:14px 16px;vertical-align:middle;">
                                    <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;line-height:1.35;">
                                        {{ $pd->kegiatan->judul ?? '-' }}
                                    </p>
                                    <span style="font-size:11px;color:#64748B;font-weight:600;">
                                        📅 {{ $pd->tgl_daftar?->format('d M Y H:i') ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding:14px 12px;text-align:center;vertical-align:middle;white-space:nowrap;">
                                    <span style="font-size:10.5px;font-weight:800;padding:4px 10px;border-radius:12px;background:{{ $isPel ? '#FFFDF5' : '#EEF2FF' }};color:{{ $isPel ? '#B38F00' : '#4F46E5' }};border:1px solid {{ $isPel ? '#FFC81A' : '#818CF8' }};text-transform:uppercase;">
                                        {{ $pd->kegiatan->jenis_kegiatan ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding:14px 12px;text-align:center;vertical-align:middle;white-space:nowrap;">
                                    <span style="font-size:10.5px;font-weight:800;padding:3px 10px;border-radius:12px;background:{{ $ds[1] }};color:{{ $ds[0] }};border:1px solid {{ $ds[2] }};">
                                        {{ $ds[3] }}
                                    </span>
                                </td>
                                <td style="padding:14px 16px;text-align:right;vertical-align:middle;font-size:13px;font-weight:900;color:#131218;white-space:nowrap;font-family:monospace;">
                                    {{ $pd->pembayaran?->jumlah_bayar_format ?? 'Gratis' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="padding:40px 16px;text-align:center;color:#94A3B8;font-size:13px;">
                                    <div style="width:44px;height:44px;border-radius:12px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                                        @include('components.icon',['name'=>'calendar','size'=>20,'style'=>'color:#9CA3B0'])
                                    </div>
                                    <p style="margin:0;font-weight:800;color:#131218;">Belum ada riwayat pendaftaran kegiatan.</p>
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

