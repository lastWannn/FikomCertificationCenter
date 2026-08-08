@extends('layouts.admin')

@section('page-title', 'Point Peserta Pelatihan')
@section('page-content')
<div style="padding:24px;max-width:1200px;margin:0 auto;width:100%;">

    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Evaluasi Nilai</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Point Peserta Pelatihan</h1>
            </div>
            <p style="color:#64748B;margin:0;font-size:13px;font-weight:500;">Pilih batch jadwal pelatihan di bawah ini untuk menginput dan mengelola nilai/point peserta.</p>
        </div>
    </div>

    {{-- STAT CARDS SUMMARY GRID --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'calendar','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Jadwal Pelatihan</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $jadwal->total() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Batch</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'users','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Peserta Terdaftar</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ \App\Models\Pendaftaran::whereHas('kegiatan', fn($q)=>$q->where('jenis_kegiatan','pelatihan'))->whereIn('status_pendaftaran', ['terdaftar', 'lulus', 'tidak_lulus'])->count() }} 
                    <span style="font-size:12px;font-weight:700;color:#94A3B8;">Peserta</span>
                </p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Peserta Lulus/Dinilai</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">
                    {{ \App\Models\Pendaftaran::whereHas('kegiatan', fn($q)=>$q->where('jenis_kegiatan','pelatihan'))->where('status_pendaftaran', 'lulus')->count() }} 
                    <span style="font-size:12px;font-weight:700;color:#94A3B8;">Orang</span>
                </p>
            </div>
        </div>
    </div>

    {{-- MAIN TABLE CARD --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Batch Pelatihan</h3>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $jadwal->total() }} Data Batch</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:55px;">No</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Program Pelatihan &amp; Batch</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:180px;">Waktu Pelaksanaan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:160px;">Peserta Terdaftar</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $index => $item)
                    @php
                        $terisi = $item->kegiatan ? $item->kegiatan->pendaftaran->whereIn('status_pendaftaran', ['terdaftar', 'lulus', 'tidak_lulus'])->count() : 0;
                    @endphp
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;color:#64748B;font-weight:800;font-size:13px;">
                            <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;">{{ $jadwal->firstItem() + $index }}</span>
                        </td>
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <p style="margin:0 0 3px;font-size:14px;font-weight:900;color:#131218;">
                                {{ $item->pelatihan->judul ?? 'Pelatihan Tidak Ditemukan' }}
                            </p>
                            @if($item->nama_kegiatan)
                            <span style="font-size:11px;font-weight:800;color:#131218;background:#FFC81A;padding:2px 8px;border-radius:6px;border:1px solid #131218;display:inline-block;">
                                {{ $item->nama_kegiatan }}
                            </span>
                            @endif
                        </td>
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;align-items:center;gap:6px;background:#F8FAFC;border:1px solid #CBD5E1;padding:4px 12px;border-radius:20px;font-size:12.5px;font-weight:800;color:#334155;">
                                @include('components.icon',['name'=>'calendar','size'=>14,'style'=>'color:#131218;flex-shrink:0;'])
                                <span>{{ \Carbon\Carbon::parse($item->tgl_pelaksanaan)->translatedFormat('d M Y') }}</span>
                            </div>
                        </td>
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-weight:900;font-size:12.5px;padding:4px 14px;border-radius:20px;border:1px solid #131218;display:inline-block;{{ $terisi >= $item->kuota_peserta ? 'background:#ECFDF5;color:#10B981;border-color:#10B981;' : 'background:#FFC81A;color:#131218;' }}">
                                👥 {{ $terisi }} / {{ $item->kuota_peserta }}
                            </span>
                        </td>
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <a href="{{ route('admin.pelatihan.point.show', $item->id) }}"
                               style="padding:6px 16px;font-size:12px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:20px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:6px;text-decoration:none;white-space:nowrap;transition:all .18s;"
                               onmouseover="this.style.transform='scale(1.04)';" onmouseout="this.style.transform='scale(1)';">
                                @include('components.icon',['name'=>'edit-3','size'=>13]) Input Nilai
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:48px 24px;color:#94A3B8;">
                            <div style="width:52px;height:52px;background:#F7F8FA;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'calendar','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-weight:900;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Jadwal Pelatihan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Jadwal pelatihan yang aktif akan otomatis muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jadwal->hasPages())
        <div style="padding:16px 24px;border-top:1px solid #F1F5F9;">
            {{ $jadwal->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
