@extends('layouts.admin')
@section('title','Arsip Kegiatan')
@section('page-title','Arsip Kegiatan')

@section('page-content')
<div style="padding:24px;">

    {{-- Header & Title --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">Arsip & Dokumentasi Kegiatan</h1>
            <p style="color:#6B7280;font-size:13.5px;margin:0;">Kelola berita acara dan galeri foto dokumentasi pelaksanaan kegiatan yang telah selesai.</p>
        </div>
        <a href="{{ route('admin.arsip.create') }}" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;text-decoration:none;border-radius:10px;font-weight:800;display:inline-flex;align-items:center;gap:6px;">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Arsip Baru
        </a>
    </div>

    {{-- Tabel Arsip --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:16px;">
        <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Judul Arsip</th>
                        <th style="padding:14px 14px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
                        <th style="padding:14px 14px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Dokumentasi Foto</th>
                        <th style="padding:14px 14px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Berita Acara</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $a)
                    @php $fotoCount = count($a->dokumentasi ?? []); @endphp
                    <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                        
                        {{-- Judul Arsip --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:800;color:#131218;">{{ $a->judul ?? '-' }}</p>
                            <p style="margin:0;font-size:11.5px;color:#6B7280;">Dibuat: {{ $a->created_at->format('d M Y') }}</p>
                        </td>

                        {{-- Kegiatan --}}
                        <td style="padding:14px 14px;vertical-align:middle;font-size:13px;color:#374151;font-weight:600;">
                            {{ Str::limit($a->kegiatan->judul ?? '-', 40) }}
                        </td>

                        {{-- Dokumentasi Foto --}}
                        <td style="padding:14px 14px;text-align:center;vertical-align:middle;">
                            @if($fotoCount > 0)
                            <span style="font-size:11.5px;font-weight:800;padding:4px 10px;border-radius:20px;background:rgba(59,130,246,.12);color:#2563EB;display:inline-flex;align-items:center;gap:5px;">
                                @include('components.icon',['name'=>'camera','size'=>13]) {{ $fotoCount }} Foto
                            </span>
                            @else
                            <span style="font-size:11px;color:#9CA3B0;">Belum ada foto</span>
                            @endif
                        </td>

                        {{-- Berita Acara PDF --}}
                        <td style="padding:14px 14px;text-align:center;vertical-align:middle;">
                            @if($a->berita_acara)
                            <a href="{{ asset('storage/'.$a->berita_acara) }}" target="_blank" class="fcc-btn-outline-dark" style="padding:4px 10px;font-size:11.5px;text-decoration:none;border-radius:6px;font-weight:700;display:inline-flex;align-items:center;gap:4px;">
                                @include('components.icon',['name'=>'file-text','size'=>12]) PDF
                            </a>
                            @else
                            <span style="font-size:11px;color:#9CA3B0;">-</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;gap:6px;align-items:center;justify-content:center;">
                                <a href="{{ route('admin.arsip.edit', $a) }}" class="fcc-btn-outline-dark" style="padding:6px 12px;font-size:12px;text-decoration:none;border-radius:8px;font-weight:700;display:inline-flex;align-items:center;gap:4px;" title="Edit Arsip & Dokumentasi">
                                    @include('components.icon',['name'=>'edit','size'=>13]) Edit
                                </a>
                                <form action="{{ route('admin.arsip.destroy', $a) }}" method="POST" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="fccConfirmDelete(this, 'Hapus Arsip Kegiatan Permanen', 'Apakah Anda yakin ingin menghapus arsip kegiatan {{ addslashes($a->judul ?? '') }}? Seluruh data arsip, berita acara, dokumentasi foto, dan riwayat pendaftaran terkait akan dihapus secara permanen.')"
                                            style="background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:4px;transition:all .18s;" title="Hapus Arsip Kegiatan Permanen"
                                            onmouseover="this.style.background='#EF4444';this.style.color='#FFFFFF';this.style.borderColor='#131218';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                                        @include('components.icon',['name'=>'trash','size'=>13]) Hapus
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#9CA3B0;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'archive','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:700;color:#131218;margin:0 0 4px;">Belum Ada Arsip Kegiatan</p>
                            <p style="font-size:12.5px;color:#9CA3B0;margin:0;">Klik tombol Tambah Arsip Baru untuk menambahkan berita acara dan foto dokumentasi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($arsip->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8F9FB;">
            {{ $arsip->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
