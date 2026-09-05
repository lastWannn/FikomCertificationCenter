@extends('layouts.admin')

@section('page-title', 'Point Peserta — ' . ($jadwal->pelatihan->judul ?? 'Detail'))
@section('page-content')
<div style="padding:24px;">

    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">EVALUASI NILAI</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Point Peserta Pelatihan</h1>
            </div>
            <p style="color:#64748B;margin:0;font-size:13px;font-weight:500;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <span style="font-weight:800;color:#131218;">Judul:</span> {{ $jadwal->pelatihan->judul ?? '-' }} 
                <span style="color:#CBD5E1;">&bull;</span> 
                <span style="display:inline-flex;align-items:center;gap:5px;background:#F8FAFC;border:1px solid #CBD5E1;padding:3px 10px;border-radius:14px;font-size:12px;font-weight:800;color:#334155;">
                    @include('components.icon',['name'=>'calendar','size'=>13,'style'=>'color:#131218;flex-shrink:0;'])
                    <span>{{ \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d M Y') }}</span>
                </span>
            </p>
        </div>

        <a href="{{ route('admin.pelatihan.point.index') }}"
           style="padding:10px 22px;font-size:13px;font-weight:900;background:#F1F5F9;color:#64748B;border:1.5px solid #CBD5E1;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;gap:8px;text-decoration:none;transition:all .18s;"
           onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
            &larr; Kembali ke Daftar Batch
        </a>
    </div>

    @if(session('success'))
    <div style="background:#ECFDF5;border:1.5px solid #10B981;padding:12px 18px;border-radius:14px;margin-bottom:20px;display:flex;align-items:center;gap:12px;box-shadow:0 4px 12px rgba(16,185,129,0.1);">
        @include('components.icon',['name'=>'check-circle','size'=>18,'style'=>'color:#10B981'])
        <p style="color:#065F46;font-size:13.5px;font-weight:800;margin:0;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- STAT CARDS SUMMARY GRID --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Peserta Terdaftar</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $pendaftaran->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Orang</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'check-circle','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Sudah Dinilai</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ $pendaftaran->filter(fn($p)=>$p->nilai->count()>0)->count() }} 
                    <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span>
                </p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Rata-Rata Point Batch</p>
                @php
                    $allNilai = $pendaftaran->flatMap(fn($p)=>$p->nilai);
                    $avgBatch = $allNilai->count() > 0 ? $allNilai->avg('nilai') : null;
                @endphp
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ $avgBatch !== null ? number_format($avgBatch, 0) : '—' }}
                    <span style="font-size:12px;font-weight:700;color:#94A3B8;">Point</span>
                </p>
            </div>
        </div>
    </div>

    @php $belumDimulai = $jadwal->tgl_pelaksanaan && \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->gt(now()->startOfDay()); @endphp
    @if($belumDimulai)
    <div style="margin-bottom:18px;padding:16px 20px;background:#FFFDF5;border:1.5px solid #FCD34D;border-radius:16px;display:flex;align-items:center;gap:14px;box-shadow:0 2px 10px rgba(245,158,11,0.08);">
        @include('components.icon',['name'=>'alert-circle','size'=>22,'style'=>'color:#D97706;flex-shrink:0;'])
        <div>
            <h4 style="margin:0 0 2px;font-size:14px;font-weight:900;color:#92400E;">Pelaksanaan Pelatihan Belum Dimulai</h4>
            <p style="margin:0;font-size:12px;color:#B45309;font-weight:600;">Tanggal pelaksanaan pelatihan ini ditetapkan pada <strong>{{ \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d F Y') }}</strong>. Penginputan nilai peserta baru dapat dilakukan pada saat atau setelah tanggal pelaksanaan.</p>
        </div>
    </div>
    @endif

    {{-- LIST PESERTA TABLE CARD --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Peserta &amp; Penilaian</h3>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">
                {{ $pendaftaran->count() }} Peserta
            </span>
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
                                <button type="button" onclick="openNilaiModal('{{ $item->id }}', '{{ addslashes($item->peserta->nama ?? '') }}', {{ $item->nilai->toJson() }}, '{{ $item->transkrip_url }}')"
                                        style="padding:6px 13px;font-size:12px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:20px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;white-space:nowrap;transition:all .18s;"
                                        onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                    @include('components.icon',['name'=>'edit-3','size'=>13]) Input Nilai
                                </button>


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
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Tidak ada peserta yang terdaftar pada jadwal pelatihan ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL INPUT NILAI DENGAN PRATINJAU TRANSKRIP NILAI (Split 2-Column Neo-Brutalist) --}}
<div id="nilai-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.7);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:16px;">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:26px 28px;max-width:1040px;width:96%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.35);max-height:92vh;overflow-y:auto;display:flex;flex-direction:column;">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('nilai-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:18px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;z-index:10;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        {{-- Modal Header --}}
        <div style="margin-bottom:18px;border-bottom:2px solid #E5E7EB;padding-bottom:12px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:3px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;letter-spacing:0.5px;">EVALUASI NILAI</span>
                <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0;">Input Nilai &amp; Transkrip Peserta</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Peserta: <strong id="peserta-name" style="color:#131218;font-size:13.5px;">-</strong></p>
        </div>

        {{-- 2-COLUMN LAYOUT: TRANSCRIPT PREVIEW (LEFT) + MODULE SCORE FORM (RIGHT) --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:22px;align-items:start;">
            
            {{-- KOLOM KIRI: PRATINJAU TRANSKRIP NILAI USER --}}
            <div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span style="font-size:13px;font-weight:900;color:#131218;display:inline-flex;align-items:center;gap:6px;">
                        📄 Lembar Transkrip Nilai
                    </span>
                    <a id="transkrip-open-tab" href="#" target="_blank" style="display:none;font-size:11.5px;font-weight:800;color:#2563EB;text-decoration:underline;">
                        Buka di Tab Baru ↗
                    </a>
                </div>

                {{-- Box Iframe / Preview --}}
                <div id="transkrip-frame-wrap" style="height:460px;border-radius:16px;border:1.5px solid #CBD5E1;background:#F8FAFC;overflow:hidden;position:relative;display:flex;align-items:center;justify-content:center;">
                    <iframe id="preview-transkrip-pdf" src="" style="display:none;width:100%;height:100%;border:none;"></iframe>
                    <img id="preview-transkrip-img" src="" style="display:none;max-width:100%;max-height:100%;object-fit:contain;padding:8px;">
                    
                    <div id="preview-transkrip-empty" style="display:none;text-align:center;padding:24px;">
                        <div style="width:48px;height:48px;border-radius:12px;background:#FEF3C7;color:#D97706;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                            @include('components.icon',['name'=>'alert-circle','size'=>24])
                        </div>
                        <p style="margin:0 0 4px;font-size:14px;font-weight:900;color:#131218;">Belum Ada Transkrip</p>
                        <p style="margin:0;font-size:12px;color:#64748B;max-width:240px;line-height:1.4;">Peserta belum mengunggah dokumen transkrip nilai.</p>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FORM INPUT NILAI PER MODUL --}}
            <div style="display:flex;flex-direction:column;">
                <div style="margin-bottom:10px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;">
                    <span style="font-size:13px;font-weight:900;color:#131218;display:inline-flex;align-items:center;gap:6px;">
                        ✏️ Input Nilai Modul / Materi
                    </span>
                    <span id="badge-auto-extract" style="display:none;font-size:11px;font-weight:800;color:#15803D;background:#DCFCE7;border:1px solid #86EFAC;padding:3px 10px;border-radius:12px;">
                        ✨ Terisi Otomatis dari Transkrip
                    </span>
                </div>
                
                <form id="nilai-form" method="POST" action="" style="display:flex;flex-direction:column;">
                    @csrf
                    
                    <div style="max-height:390px;overflow-y:auto;padding-right:4px;margin-bottom:18px;">
                        @if($jadwal->pelatihan && $jadwal->pelatihan->materi && $jadwal->pelatihan->materi->count() > 0)
                            <div style="background:#F8FAFC;border:1.5px solid #CBD5E1;padding:14px 18px;border-radius:16px;">
                                @foreach($jadwal->pelatihan->materi as $index => $mat)
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:{{ $loop->last ? '0' : '12px' }};padding-bottom:{{ $loop->last ? '0' : '12px' }};border-bottom:{{ $loop->last ? 'none' : '1px solid #E2E8F0' }};">
                                    <div style="flex:1;padding-right:12px;">
                                        <p style="margin:0 0 2px;font-size:13px;font-weight:900;color:#131218;">{{ $mat->judul_materi }}</p>
                                        <span style="font-size:10.5px;color:#64748B;font-weight:600;">⏱️ {{ $mat->jam_pelajaran }} JP</span>
                                    </div>
                                    <div style="width:95px;">
                                        <input type="number" name="nilai[{{ $mat->id }}]" id="nilai-input-{{ $mat->id }}" min="0" max="100" placeholder="0 - 100" class="fcc-input" style="padding:8px 10px;font-size:14px;font-weight:900;text-align:center;width:100%;border-radius:10px;border:1.5px solid #131218;background:#FFF;">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div style="background:#FEF2F2;border:1.5px solid #FCA5A5;padding:16px;border-radius:14px;text-align:center;">
                                <p style="margin:0;color:#EF4444;font-size:13px;font-weight:800;">Pelatihan ini belum memiliki materi.</p>
                            </div>
                        @endif
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:10px;padding-top:10px;border-top:1px solid #E5E7EB;">
                        <button type="button" onclick="document.getElementById('nilai-modal').style.display='none'"
                                style="padding:10px 18px;font-size:12.5px;font-weight:800;color:#64748B;background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:30px;cursor:pointer;transition:all .18s;"
                                onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
                            Batal
                        </button>
                        <button type="submit"
                                style="padding:10px 24px;font-size:13px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
                                onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';" {{ (!$jadwal->pelatihan || !$jadwal->pelatihan->materi || $jadwal->pelatihan->materi->count() == 0) ? 'disabled' : '' }}>
                            @include('components.icon',['name'=>'check','size'=>15]) Simpan Nilai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openNilaiModal(pendaftaranId, namaPeserta, existingNilai, transkripUrl) {
        document.getElementById('peserta-name').innerText = namaPeserta;
        
        const baseUrl = '{{ route('admin.pelatihan.point.index') }}';
        document.getElementById('nilai-form').action = baseUrl + '/{{ $jadwal->id }}/pendaftaran/' + pendaftaranId;
        
        const inputs = document.querySelectorAll('input[name^="nilai["]');
        inputs.forEach(input => input.value = '');

        const autoBadge = document.getElementById('badge-auto-extract');
        if (existingNilai && existingNilai.length > 0) {
            existingNilai.forEach(n => {
                const input = document.getElementById('nilai-input-' + n.materi_pelatihan_id);
                if (input) {
                    input.value = Math.round(n.nilai);
                }
            });
            if (autoBadge) autoBadge.style.display = (transkripUrl && transkripUrl.trim() !== '') ? 'inline-block' : 'none';
        } else {
            if (autoBadge) autoBadge.style.display = 'none';
        }

        // Tampilkan Pratinjau Transkrip Nilai
        const pdfFrame = document.getElementById('preview-transkrip-pdf');
        const imgPreview = document.getElementById('preview-transkrip-img');
        const emptyBox = document.getElementById('preview-transkrip-empty');
        const openTabBtn = document.getElementById('transkrip-open-tab');

        pdfFrame.style.display = 'none';
        pdfFrame.src = '';
        imgPreview.style.display = 'none';
        imgPreview.src = '';
        emptyBox.style.display = 'none';
        openTabBtn.style.display = 'none';

        if (transkripUrl && transkripUrl.trim() !== '') {
            openTabBtn.href = transkripUrl;
            openTabBtn.style.display = 'inline-block';
            
            const lower = transkripUrl.toLowerCase();
            if (lower.includes('.pdf')) {
                pdfFrame.src = transkripUrl;
                pdfFrame.style.display = 'block';
            } else {
                imgPreview.src = transkripUrl;
                imgPreview.style.display = 'block';
            }
        } else {
            emptyBox.style.display = 'block';
        }
        
        document.getElementById('nilai-modal').style.display = 'flex';
    }
</script>
@endsection
