@extends('layouts.admin')
@section('title','Arsip Kegiatan')
@section('page-title','Arsip Kegiatan')

@section('page-content')
<div style="padding:24px;">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(16,185,129,0.12);border:1.5px solid rgba(16,185,129,0.3);color:#059669;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#059669;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(239,68,68,0.12);border:1.5px solid rgba(239,68,68,0.3);color:#DC2626;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('error') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#DC2626;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
    </div>
    @endif

    {{-- Header & Title --}}
    <div style="margin-bottom:24px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
            <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Dokumentasi &amp; Galeri</span>
            <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Arsip &amp; Dokumentasi Kegiatan</h1>
        </div>
        <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola berita acara dan galeri foto dokumentasi pelaksanaan kegiatan yang telah selesai.</p>
    </div>

    {{-- Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);">
        <div style="overflow-x:auto;">
            <table class="admin-table" style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:16px 20px;text-align:left;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;">Judul Arsip</th>
                        <th style="padding:16px 14px;text-align:left;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;">Kegiatan</th>
                        <th style="padding:16px 14px;text-align:center;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;">Dokumentasi Foto</th>
                        <th style="padding:16px 14px;text-align:center;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;">Berita Acara</th>
                        <th style="padding:16px 20px;text-align:center;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $a)
                    @php $fotoCount = count($a->dokumentasi ?? []); @endphp
                    <tr class="tbl-row" style="border-top:1px solid #F1F5F9;">
                        
                        {{-- Judul Arsip --}}
                        <td style="padding:16px 20px;vertical-align:middle;">
                            <p style="margin:0 0 3px;font-size:14px;font-weight:900;color:#131218;">{{ $a->judul ?? '-' }}</p>
                            <span style="font-size:11px;color:#64748B;font-weight:600;">Dibuat: {{ $a->created_at->format('d M Y') }}</span>
                        </td>

                        {{-- Kegiatan --}}
                        <td style="padding:16px 14px;vertical-align:middle;font-size:13px;color:#334155;font-weight:700;">
                            {{ Str::limit($a->kegiatan->judul ?? '-', 45) }}
                        </td>

                        {{-- Dokumentasi Foto --}}
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
                            @if($fotoCount > 0)
                            <span style="font-size:11.5px;font-weight:800;padding:5px 12px;border-radius:20px;background:#EEF2FF;color:#4F46E5;border:1px solid #C7D2FE;display:inline-flex;align-items:center;gap:6px;">
                                @include('components.icon',['name'=>'camera','size'=>13]) {{ $fotoCount }} Foto
                            </span>
                            @else
                            <span style="font-size:11.5px;color:#94A3B8;font-weight:600;">Belum ada foto</span>
                            @endif
                        </td>

                        {{-- Berita Acara PDF --}}
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
                            @if($a->berita_acara)
                            <a href="{{ asset('storage/'.$a->berita_acara) }}" target="_blank" style="padding:5px 12px;font-size:11.5px;font-weight:800;text-decoration:none;border-radius:20px;background:#FFFFFF;color:#131218;border:1.5px solid #131218;display:inline-flex;align-items:center;gap:4px;transition:all .18s;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">
                                @include('components.icon',['name'=>'file-text','size'=>12]) Lihat PDF
                            </a>
                            @else
                            <span style="font-size:11.5px;color:#94A3B8;font-weight:600;">-</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:16px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;gap:8px;align-items:center;justify-content:center;">
                                <a href="{{ route('admin.arsip.edit', $a) }}"
                                   style="padding:7px 14px;font-size:12px;font-weight:800;text-decoration:none;border-radius:10px;background:#FFFFFF;color:#131218;border:1.5px solid #131218;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                                   onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';" title="Edit Arsip & Dokumentasi">
                                    @include('components.icon',['name'=>'edit','size'=>13]) Edit
                                </a>
                                <form action="{{ route('admin.arsip.destroy', $a) }}" method="POST" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="fccConfirmDelete(this, 'Hapus Arsip Kegiatan Permanen', 'Apakah Anda yakin ingin menghapus arsip kegiatan {{ addslashes($a->judul ?? '') }}? Seluruh data arsip, berita acara, dokumentasi foto, dan riwayat pendaftaran terkait akan dihapus secara permanen.')"
                                            style="background:#FEF2F2;border:1px solid #FCA5A5;color:#EF4444;padding:7px 12px;border-radius:10px;font-size:12px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:4px;transition:all .18s;" title="Hapus Arsip Kegiatan Permanen"
                                            onmouseover="this.style.background='#EF4444';this.style.color='#FFFFFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';">
                                        @include('components.icon',['name'=>'trash','size'=>13]) Hapus
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:56px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F8FAFC;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'archive','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Arsip Kegiatan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Arsip kegiatan akan secara otomatis dibuat dari kegiatan yang telah selesai dilaksanakan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($arsip->hasPages())
        <div style="padding:14px 20px;border-top:2px solid #E5E7EB;background:#FFFFFF;">
            {{ $arsip->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

