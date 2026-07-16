@extends('layouts.admin')
@section('title','Arsip Kegiatan')
@section('page-content')
<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0;">Arsip Kegiatan</h1>
        <a href="{{ route('admin.arsip.create') }}" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;text-decoration:none;">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Arsip
        </a>
    </div>
    <div class="fcc-card" style="padding:0;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                    <th style="padding:12px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Judul</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Tanggal</th>
                    <th style="padding:12px 20px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsip as $a)
                <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                    <td style="padding:12px 20px;font-size:14px;font-weight:700;color:#0F0F14;">{{ $a->judul ?? '-' }}</td>
                    <td style="padding:12px 12px;font-size:13px;color:#6B7280;">{{ Str::limit($a->kegiatan->judul,36) }}</td>
                    <td style="padding:12px 12px;font-size:13px;color:#6B7280;">{{ $a->created_at->format('d M Y') }}</td>
                    <td style="padding:12px 20px;text-align:center;">
                        <div style="display:inline-flex;gap:8px;">
                            <a href="{{ route('admin.arsip.edit', $a) }}" style="color:#FFC81A;display:flex;">@include('components.icon',['name'=>'edit','size'=>16])</a>
                            <form action="{{ route('admin.arsip.destroy', $a) }}" method="POST" onsubmit="return confirm('Hapus arsip ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;cursor:pointer;color:#EF4444;display:flex;padding:0;">@include('components.icon',['name'=>'trash','size'=>16])</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="padding:32px;text-align:center;color:#A0A3AD;font-size:14px;">Belum ada arsip.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($arsip->hasPages())<div style="padding:14px 20px;border-top:1px solid #E2E4EB;">{{ $arsip->withQueryString()->links() }}</div>@endif
    </div>
</div>
@endsection
