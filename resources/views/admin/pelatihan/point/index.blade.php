@extends('layouts.admin')

@section('page-content')
<div style="padding:24px;">
    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px;font-weight:900;color:#131218;margin:0 0 4px;letter-spacing:-0.5px;">Point Peserta Pelatihan</h1>
            <p style="color:#6B7280;margin:0;font-size:14px;">Pilih jadwal pelatihan untuk mengelola point/nilai peserta.</p>
        </div>
    </div>

    {{-- LIST JADWAL --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;background:#FFF;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13.5px;">
                <thead>
                    <tr style="background:#F7F8FA;border-bottom:1px solid #E2E4EB;">
                        <th style="text-align:left;padding:14px 24px;font-weight:800;color:#9CA3B0;width:5%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">No</th>
                        <th style="text-align:left;padding:14px 24px;font-weight:800;color:#9CA3B0;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Pelatihan</th>
                        <th style="text-align:center;padding:14px 24px;font-weight:800;color:#9CA3B0;width:15%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Waktu Pelaksanaan</th>
                        <th style="text-align:center;padding:14px 24px;font-weight:800;color:#9CA3B0;width:10%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Kuota</th>
                        <th style="text-align:center;padding:14px 24px;font-weight:800;color:#9CA3B0;width:10%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Terisi</th>
                        <th style="text-align:center;padding:14px 24px;font-weight:800;color:#9CA3B0;width:20%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $index => $item)
                    @php
                        $terisi = $item->kegiatan ? $item->kegiatan->pendaftaran->whereIn('status_pendaftaran', ['terdaftar', 'lulus', 'tidak_lulus'])->count() : 0;
                    @endphp
                    <tr style="border-bottom:1px solid #F0F1F5;transition:background .2s;" onmouseover="this.style.background='#F8F9FB'" onmouseout="this.style.background='none'">
                        <td style="padding:16px 24px;color:#9CA3B0;font-weight:700;">{{ $jadwal->firstItem() + $index }}</td>
                        <td style="padding:16px 24px;font-weight:700;color:#131218;">
                            {{ $item->pelatihan->judul ?? 'Pelatihan Tidak Ditemukan' }}
                        </td>
                        <td style="padding:16px 24px;text-align:center;color:#6B7280;font-weight:600;">
                            {{ \Carbon\Carbon::parse($item->tgl_pelaksanaan)->translatedFormat('d-M-Y') }}
                        </td>
                        <td style="padding:16px 24px;text-align:center;font-weight:700;color:#131218;">
                            {{ $item->kuota_peserta }}
                        </td>
                        <td style="padding:16px 24px;text-align:center;">
                            <span style="font-weight:800;{{ $terisi >= $item->kuota_peserta ? 'color:#10B981;' : 'color:#FFC81A;' }}">
                                {{ $terisi }}
                            </span>
                        </td>
                        <td style="padding:16px 24px;text-align:center;">
                            <a href="{{ route('admin.pelatihan.point.show', $item->id) }}" class="fcc-btn-gold" style="padding:8px 16px;font-size:11.5px;font-weight:800;border:none;border-radius:8px;cursor:pointer;display:inline-block;text-decoration:none;">
                                INPUT NILAI PESERTA
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:48px 24px;color:#9CA3B0;">
                            <div style="width:64px;height:64px;background:#F7F8FA;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                                @include('components.icon',['name'=>'calendar','size'=>28,'style'=>'color:#C0C4CF'])
                            </div>
                            <p style="font-weight:700;color:#6B7280;margin:0 0 4px;font-size:14px;">Belum Ada Jadwal Pelatihan</p>
                            <p style="font-size:12.5px;margin:0;">Jadwal pelatihan yang aktif akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($jadwal->hasPages())
        <div style="padding:16px 24px;border-top:1px solid #F0F1F5;">
            {{ $jadwal->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
