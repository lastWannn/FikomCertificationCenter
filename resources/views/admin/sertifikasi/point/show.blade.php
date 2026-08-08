@extends('layouts.admin')
@section('title', 'Evaluasi Nilai — ' . ($jadwal->sertifikasi->judul ?? 'Sertifikasi'))

@section('page-content')
<div style="padding:24px;max-width:1200px;margin:0 auto;width:100%;">

    {{-- HEADER BAR --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">EVALUASI NILAI</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Point Peserta Sertifikasi</h1>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <p style="margin:0;font-size:13.5px;font-weight:800;color:#334155;">
                    Judul: <span style="color:#131218;">{{ $jadwal->sertifikasi->judul ?? '-' }}</span>
                </p>
                <span style="color:#CBD5E1;">&bull;</span>
                <div style="display:inline-flex;align-items:center;gap:6px;background:#F8FAFC;border:1px solid #CBD5E1;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:800;color:#334155;">
                    @include('components.icon',['name'=>'calendar','size'=>13,'style'=>'color:#131218;flex-shrink:0;'])
                    <span>{{ \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.sertifikasi.point.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:9.5px 18px;border-radius:30px;border:1.5px solid #CBD5E1;background:#F1F5F9;font-size:13px;font-weight:800;color:#64748B;text-decoration:none;transition:all .18s;"
           onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Batch
        </a>
    </div>

    @if(session('success'))
    <div style="background:#ECFDF5;border:1.5px solid #10B981;padding:14px 18px;border-radius:14px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
        @include('components.icon',['name'=>'check-circle','size'=>20,'style'=>'color:#10B981'])
        <p style="margin:0;color:#065F46;font-size:13.5px;font-weight:800;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- STAT SUMMARY CARDS GRID --}}
    @php
        $totalPeserta = $pendaftaran->count();
        $sudahDinilai = $pendaftaran->filter(fn($p) => $p->nilai->count() > 0)->count();
        $allAvg = $sudahDinilai > 0 ? number_format($pendaftaran->map(fn($p) => $p->nilai->avg('nilai'))->filter()->avg(), 0) : 0;
    @endphp
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Peserta Terdaftar</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $totalPeserta }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Orang</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'check-circle','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Sudah Dinilai</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $sudahDinilai }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Rata-Rata Point Batch</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $allAvg }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Point</span></p>
            </div>
        </div>
    </div>

    {{-- LIST PESERTA TABEL --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Peserta & Penilaian</h3>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $totalPeserta }} Peserta</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:55px;">No</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:170px;">No. Telepon / HP</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Nama Peserta</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">Rata-Rata Point</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:370px;">Aksi Evaluasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $item)
                    @php
                        $avgPoint = $item->nilai->count() > 0 ? $item->nilai->avg('nilai') : null;
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;color:#64748B;font-weight:800;font-size:13px;">
                            <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;">{{ $index + 1 }}</span>
                        </td>
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <div style="display:inline-flex;align-items:center;gap:6px;background:#F8FAFC;border:1px solid #CBD5E1;padding:3px 10px;border-radius:12px;font-family:monospace;font-size:12.5px;font-weight:700;color:#334155;">
                                @include('components.icon',['name'=>'phone','size'=>13,'style'=>'color:#131218;flex-shrink:0;'])
                                <span>{{ $item->peserta->no_hp ?? '-' }}</span>
                            </div>
                        </td>
                        <td style="padding:14px 16px;vertical-align:middle;font-weight:900;color:#131218;font-size:14px;">
                            {{ $item->peserta->nama ?? 'Peserta Tidak Ditemukan' }}
                        </td>
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            @if($avgPoint !== null)
                                <span style="font-weight:900;font-size:12px;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;display:inline-block;white-space:nowrap;">
                                    🏆 {{ number_format($avgPoint, 0) }} Point
                                </span>
                            @else
                                <span style="font-weight:800;color:#94A3B8;font-size:11.5px;background:#F1F5F9;padding:3px 10px;border-radius:14px;white-space:nowrap;">Belum Dinilai</span>
                            @endif
                        </td>
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;align-items:center;justify-content:center;gap:6px;flex-wrap:nowrap;">
                                <button type="button" onclick="openNilaiModal('{{ $item->id }}', '{{ addslashes($item->peserta->nama ?? '') }}', {{ $item->nilai->toJson() }})"
                                        style="padding:6px 13px;font-size:12px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:20px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;transition:all .18s;"
                                        onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                    @include('components.icon',['name'=>'edit-3','size'=>13]) Input Nilai
                                </button>

                                <a href="{{ route('admin.cetak.penilaian', $item->hashid) }}" target="_blank"
                                   style="padding:6px 13px;font-size:12px;font-weight:800;background:#F1F5F9;color:#131218;border:1.5px solid #CBD5E1;border-radius:20px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;text-decoration:none;white-space:nowrap;transition:all .18s;"
                                   onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#131218';this.style.borderColor='#CBD5E1';">
                                    @include('components.icon',['name'=>'file-text','size'=>13]) Penilaian
                                </a>

                                @if($item->sertifikat)
                                    <a href="{{ route('admin.cetak.sertifikat', $item->sertifikat->hashid) }}" target="_blank"
                                       style="padding:6px 13px;font-size:12px;font-weight:800;background:#ECFDF5;color:#10B981;border:1.5px solid #10B981;border-radius:20px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;text-decoration:none;white-space:nowrap;transition:all .18s;"
                                       onmouseover="this.style.background='#10B981';this.style.color='#FFF';" onmouseout="this.style.background='#ECFDF5';this.style.color='#10B981';">
                                        @include('components.icon',['name'=>'award','size'=>13]) Sertifikat
                                    </a>
                                @else
                                    <button type="button" onclick="alert('Sertifikat belum diterbitkan! Silakan terbitkan sertifikat melalui menu Kelola Sertifikat terlebih dahulu.')"
                                            style="padding:6px 13px;font-size:12px;font-weight:800;background:#F8FAFC;color:#94A3B8;border:1.5px solid #E2E8F0;border-radius:20px;cursor:not-allowed;opacity:0.7;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;" title="Sertifikat Belum Diterbitkan">
                                        @include('components.icon',['name'=>'award','size'=>13]) Sertifikat
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:48px 24px;color:#94A3B8;">
                            <div style="width:52px;height:52px;background:#F7F8FA;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-weight:900;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Peserta</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Tidak ada peserta yang terdaftar pada jadwal sertifikasi ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL INPUT NILAI (Neo-Brutalist Glassmorphism) --}}
<div id="nilai-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:560px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('nilai-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;">INPUT NILAI</span>
                <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0;">Evaluasi Point Peserta</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Masukkan nilai untuk peserta <strong id="peserta-name" style="color:#131218;">-</strong></p>
        </div>

        <form id="nilai-form" method="POST" action="">
            @csrf
            
            @if($jadwal->sertifikasi && $jadwal->sertifikasi->materi && $jadwal->sertifikasi->materi->count() > 0)
                <div style="background:#F8FAFC;border:1.5px solid #CBD5E1;padding:18px;border-radius:16px;margin-bottom:24px;">
                    @foreach($jadwal->sertifikasi->materi as $index => $mat)
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:{{ $loop->last ? '0' : '14px' }};padding-bottom:{{ $loop->last ? '0' : '14px' }};border-bottom:{{ $loop->last ? 'none' : '1px solid #E2E8F0' }};">
                        <div style="flex:1;padding-right:14px;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;">{{ $mat->judul_materi }}</p>
                            <span style="font-size:11px;color:#64748B;font-weight:600;">Modul {{ $loop->iteration }}</span>
                        </div>
                        <div style="width:110px;">
                            <input type="number" name="nilai[{{ $mat->id }}]" id="nilai-input-{{ $mat->id }}" min="0" max="100" placeholder="0 - 100" class="fcc-input" style="padding:9px 12px;font-size:15px;font-weight:900;text-align:center;width:100%;border-radius:10px;border:1.5px solid #131218;background:#FFF;">
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="background:#FEF2F2;border:1.5px solid #FCA5A5;padding:16px;border-radius:14px;margin-bottom:24px;text-align:center;">
                    <p style="margin:0;color:#EF4444;font-size:13px;font-weight:800;">Sertifikasi ini belum memiliki materi. Silakan tambahkan materi sertifikasi terlebih dahulu.</p>
                </div>
            @endif

            <div style="display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="document.getElementById('nilai-modal').style.display='none'"
                        style="padding:11px 22px;font-size:13px;font-weight:800;color:#64748B;background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:30px;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
                    Batal
                </button>
                <button type="submit"
                        style="padding:11px 26px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
                        onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';" {{ (!$jadwal->sertifikasi || !$jadwal->sertifikasi->materi || $jadwal->sertifikasi->materi->count() == 0) ? 'disabled' : '' }}>
                    @include('components.icon',['name'=>'check','size'=>16]) Simpan Nilai
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openNilaiModal(pendaftaranId, namaPeserta, existingNilai) {
        document.getElementById('peserta-name').innerText = namaPeserta;
        
        const baseUrl = '{{ route('admin.sertifikasi.point.index') }}';
        document.getElementById('nilai-form').action = baseUrl + '/{{ $jadwal->id }}/pendaftaran/' + pendaftaranId;
        
        const inputs = document.querySelectorAll('input[name^="nilai["]');
        inputs.forEach(input => input.value = '');

        if (existingNilai && existingNilai.length > 0) {
            existingNilai.forEach(n => {
                const input = document.getElementById('nilai-input-' + n.materi_sertifikasi_id);
                if (input) {
                    input.value = Math.round(n.nilai);
                }
            });
        }
        
        document.getElementById('nilai-modal').style.display = 'flex';
    }
</script>
@endsection
