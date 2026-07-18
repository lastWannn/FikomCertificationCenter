@extends('layouts.admin')
@section('title', isset($rekening) ? 'Edit Rekening' : 'Tambah Rekening')
@section('page-content')
<div style="padding:24px;max-width:560px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.rekening.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0;">{{ isset($rekening) ? 'Edit' : 'Tambah' }} Rekening</h1>
    </div>
    <div class="fcc-card" style="padding:28px;">
        <form action="{{ isset($rekening) ? route('admin.rekening.update', $rekening) : route('admin.rekening.store') }}" method="POST">
            @csrf @if(isset($rekening)) @method('PUT') @endif
            @foreach([['nama_pemilik','Nama Pemilik','Nama sesuai rekening'],['bank','Nama Bank','BRI, BNI, Mandiri, dst'],['no_rekening','Nomor Rekening','1234567890']] as [$n,$l,$p])
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">{{ $l }} *</label>
                <input type="text" name="{{ $n }}" value="{{ old($n,isset($rekening)?$rekening->$n:'') }}" placeholder="{{ $p }}" required class="fcc-input">
            </div>
            @endforeach
            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">
                    @include('components.icon',['name'=>'check','size'=>15]) {{ isset($rekening) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.rekening.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
