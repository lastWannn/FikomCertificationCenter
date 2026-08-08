@extends('layouts.public')
@section('title','Arsip Kegiatan')
@section('page-content')
<div style="padding-top:84px; background:#131218; min-height:100vh;">
    {{-- Hero Header --}}
    <div style="background:#131218; padding:40px 24px 44px; text-align:center; position:relative; overflow:hidden; border-bottom:1.5px solid rgba(255,200,26,0.2);">
        <!-- Subtle Glow -->
        <div style="position:absolute; top:-50%; left:50%; transform:translateX(-50%); width:600px; height:600px; border-radius:50%; background:radial-gradient(circle, rgba(255,200,26,0.07), transparent 70%); pointer-events:none;"></div>
        
        <div style="position:relative; z-index:1; max-width:800px; margin:0 auto;">
            <div style="display:inline-block; font-size:10.5px; font-weight:900; padding:5px 16px; border-radius:100px; text-transform:uppercase; letter-spacing:1.5px; background:#FFC81A; color:#131218; margin-bottom:14px; box-shadow:0 4px 12px rgba(255,200,26,0.25);">
                ARSIP KEGIATAN
            </div>
            <h1 style="color:#FFFFFF; font-size:clamp(26px,4vw,40px); font-weight:900; margin:0 0 12px; letter-spacing:-0.5px; line-height:1.2;">
                Dokumentasi <span style="color:#FFC81A;">Kegiatan Selesai</span>
            </h1>
            <p style="color:rgba(255,255,255,0.75); font-size:15px; margin:0; line-height:1.6; font-weight:500;">
                Arsip &amp; riwayat seluruh program pelatihan dan sertifikasi kompetensi yang telah berhasil dilaksanakan oleh FIKOM UMI.
            </p>
        </div>
    </div>

    {{-- Main Body Section (Clean Light Surface Theme) --}}
    <div style="background:#F8F9FA; padding:48px 24px 72px;">
        <div style="max-width:1150px; margin:0 auto;">
            
            {{-- DESKTOP TABLE VIEW (Tampilan Tabel untuk Desktop) --}}
            <div class="fcc-arsip-desktop-view" style="background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:18px; box-shadow:0 8px 30px rgba(0,0,0,0.04); overflow:hidden; margin-bottom:32px;">
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; text-align:left;">
                        <thead>
                            <tr style="background:#131218; color:#FFFFFF; border-bottom:2px solid #FFC81A;">
                                <th style="padding:16px 20px; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.8px; width:60px; text-align:center;">#</th>
                                <th style="padding:16px 20px; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.8px;">Nama Kegiatan / Program</th>
                                <th style="padding:16px 16px; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.8px; width:140px;">Tanggal</th>
                                <th style="padding:16px 20px; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.8px;">Ringkasan</th>
                                <th style="padding:16px 16px; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.8px; text-align:center; width:150px;">Dokumentasi</th>
                                <th style="padding:16px 20px; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.8px; text-align:center; width:130px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($arsips as $index => $a)
                            @php
                                $fotoCount = count($a->dokumentasi ?? []);
                                $jenis = $a->kegiatan->jenis_kegiatan ?? 'Kegiatan';
                                $judul = $a->judul ?? ($a->kegiatan->judul ?? 'Arsip Kegiatan');
                                $rowNum = $loop->iteration + ($arsips->currentPage() - 1) * $arsips->perPage();
                            @endphp
                            <tr class="fcc-arsip-table-row" style="border-bottom:1px solid #F1F5F9; transition:all 0.2s ease;">
                                <td style="padding:18px 20px; text-align:center; font-weight:800; color:#64748B; font-size:13px; vertical-align:middle;">
                                    {{ $rowNum }}
                                </td>
                                <td style="padding:18px 20px; vertical-align:middle;">
                                    <div style="display:flex; flex-direction:column; gap:6px;">
                                        <a href="{{ route('landing.arsip.show', $a) }}" style="color:#0F172A; font-size:14.5px; font-weight:800; text-decoration:none; line-height:1.4; transition:color 0.2s;" onmouseover="this.style.color='#D97706'" onmouseout="this.style.color='#0F172A'">
                                            {{ $judul }}
                                        </a>
                                        <div>
                                            <span style="font-size:10px; font-weight:900; padding:3px 10px; border-radius:100px; text-transform:uppercase; letter-spacing:0.5px; {{ $jenis === 'pelatihan' ? 'background:#EFF6FF; color:#1D4ED8; border:1px solid #BFDBFE;' : 'background:#FEF3C7; color:#D97706; border:1px solid #FDE68A;' }}">
                                                {{ ucfirst($jenis) }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding:18px 16px; vertical-align:middle;">
                                    <div style="display:flex; align-items:center; gap:6px; color:#475569; font-size:12.5px; font-weight:600; white-space:nowrap;">
                                        @include('components.icon',['name'=>'calendar','size'=>14,'style'=>'color:#D97706'])
                                        <span>{{ $a->created_at->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td style="padding:18px 20px; vertical-align:middle;">
                                    <p style="color:#64748B; font-size:13px; line-height:1.5; margin:0; font-weight:500;">
                                        {{ Str::limit($a->ringkasan ?? 'Kegiatan telah selesai dilaksanakan dengan sukses oleh panitia FIKOM UMI.', 90) }}
                                    </p>
                                </td>
                                <td style="padding:18px 16px; text-align:center; vertical-align:middle;">
                                    <div style="display:flex; flex-direction:column; gap:4px; align-items:center;">
                                        @if($fotoCount > 0)
                                        <span style="font-size:11px; font-weight:800; padding:4px 10px; border-radius:20px; background:#EFF6FF; color:#2563EB; border:1px solid #BFDBFE; display:inline-flex; align-items:center; gap:4px; white-space:nowrap;">
                                            @include('components.icon',['name'=>'camera','size'=>12]) {{ $fotoCount }} Foto
                                        </span>
                                        @endif
                                        @if($a->berita_acara)
                                        <span style="font-size:11px; font-weight:800; padding:4px 10px; border-radius:20px; background:#F0FDF4; color:#166534; border:1px solid #BBF7D0; display:inline-flex; align-items:center; gap:4px; white-space:nowrap;">
                                            @include('components.icon',['name'=>'file-text','size'=>12]) Berita Acara
                                        </span>
                                        @endif
                                        @if($fotoCount == 0 && !$a->berita_acara)
                                        <span style="font-size:12px; color:#94A3B8; font-weight:500;">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td style="padding:18px 20px; text-align:center; vertical-align:middle;">
                                    <a href="{{ route('landing.arsip.show', $a) }}" style="display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:8px 14px; background:#131218; color:#FFC81A; border-radius:10px; font-size:12px; font-weight:800; text-decoration:none; border:1px solid #131218; transition:all 0.2s ease; white-space:nowrap;" onmouseover="this.style.background='#FFC81A'; this.style.color='#131218';" onmouseout="this.style.background='#131218'; this.style.color='#FFC81A';">
                                        <span>Detail</span>
                                        @include('components.icon',['name'=>'arrow-right','size'=>12])
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align:center; padding:56px 24px; color:#64748B; font-size:15px; font-weight:600;">
                                    <div style="width:56px; height:56px; border-radius:50%; background:#F1F5F9; display:flex; align-items:center; justify-content:center; margin:0 auto 14px;">
                                        @include('components.icon',['name'=>'file-text','size'=>26,'style'=>'color:#94A3B8'])
                                    </div>
                                    Belum ada arsip kegiatan yang dipublikasikan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- MOBILE CARD VIEW (Tampilan Mobile - Responsive Grid) --}}
            <div class="fcc-arsip-mobile-view">
                <div style="display:grid; grid-template-columns:1fr; gap:20px;">
                    @forelse($arsips as $a)
                    @php
                        $jenis = $a->kegiatan->jenis_kegiatan ?? 'Kegiatan';
                        $judul = $a->judul ?? ($a->kegiatan->judul ?? 'Arsip Kegiatan');
                    @endphp
                    <div style="overflow:hidden; transition:all 0.3s ease; background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:18px; box-shadow:0 6px 20px rgba(0,0,0,0.04); display:flex; flex-direction:column; justify-content:space-between;">
                        <div style="padding:20px;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; gap:10px;">
                                <span style="font-size:10px; font-weight:900; padding:4px 10px; border-radius:6px; background:#FFC81A; color:#131218; border:1px solid #131218; text-transform:uppercase;">
                                    {{ ucfirst($jenis) }}
                                </span>
                                <div style="display:flex; align-items:center; gap:4px; color:#D97706; font-size:12px; font-weight:800;">
                                    @include('components.icon',['name'=>'calendar','size'=>12,'style'=>'color:#D97706'])
                                    <span>{{ $a->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            <h3 style="color:#0F172A; font-size:16px; font-weight:900; margin:0 0 8px; line-height:1.4;">
                                <a href="{{ route('landing.arsip.show', $a) }}" style="color:inherit; text-decoration:none;">{{ $judul }}</a>
                            </h3>
                            <p style="color:#475569; font-size:13.5px; line-height:1.6; margin:0 0 16px; font-weight:500;">
                                {{ Str::limit($a->ringkasan ?? 'Kegiatan telah selesai dilaksanakan dengan sukses oleh panitia FIKOM UMI.', 110) }}
                            </p>
                            <a href="{{ route('landing.arsip.show', $a) }}" style="display:flex; align-items:center; justify-content:center; gap:6px; padding:10px 16px; background:#131218; color:#FFC81A; border-radius:10px; font-size:13px; font-weight:800; text-decoration:none; width:100%; box-sizing:border-box;">
                                <span>Lihat Detail Arsip</span>
                                @include('components.icon',['name'=>'arrow-right','size'=>14])
                            </a>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center; padding:48px 24px; color:#64748B; font-size:15px; font-weight:600; background:#FFFFFF; border:1.5px solid #E2E8F0; border-radius:18px;">
                        Belum ada arsip kegiatan yang dipublikasikan.
                    </div>
                    @endforelse
                </div>
            </div>

            @if($arsips->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;" class="fcc-pagination-light">
                {{ $arsips->links() }}
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

<style>
/* Responsive Display Logic */
.fcc-arsip-desktop-view { display: block; }
.fcc-arsip-mobile-view { display: none; }

@media (max-width: 767px) {
    .fcc-arsip-desktop-view { display: none !important; }
    .fcc-arsip-mobile-view { display: block !important; }
}

/* Hover effects for table rows */
.fcc-arsip-table-row:hover {
    background-color: #F8FAFC !important;
}

/* Pagination Styling */
.fcc-pagination-light nav { display: flex; align-items: center; justify-content: center; }
.fcc-pagination-light nav svg { width: 20px; height: 20px; }
.fcc-pagination-light nav a, .fcc-pagination-light nav span.relative { background: #FFFFFF !important; border: 1.5px solid #E2E8F0 !important; color: #0F172A !important; margin: 0 4px; border-radius: 8px !important; box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important; font-weight: 700 !important; }
.fcc-pagination-light nav span[aria-current="page"] span { background: #131218 !important; color: #FFC81A !important; border-color: #131218 !important; }
.fcc-pagination-light nav a:hover { background: #F1F5F9 !important; border-color: #CBD5E1 !important; }
</style>
