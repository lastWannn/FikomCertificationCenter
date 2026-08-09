@extends('layouts.admin')
@section('title', isset($rekening) ? 'Edit Rekening' : 'Tambah Rekening')
@section('page-content')
<div style="padding:24px;max-width:600px;">

    {{-- Back Button & Header --}}
    <div style="margin-bottom:24px;">
        <a href="{{ route('admin.rekening.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#131218;font-size:12.5px;font-weight:800;text-decoration:none;margin-bottom:12px;background:#FFFFFF;border:1.5px solid #131218;padding:6px 14px;border-radius:20px;transition:all .18s;"
           onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Rekening
        </a>

        <div style="display:flex;align-items:center;gap:10px;margin-top:6px;">
            <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Form Rekening</span>
            <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">{{ isset($rekening) ? 'Edit' : 'Tambah' }} Nomor Rekening</h1>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="fcc-card" style="padding:32px;border-radius:24px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 6px 24px rgba(0,0,0,0.04);">
        <form action="{{ isset($rekening) ? route('admin.rekening.update', $rekening) : route('admin.rekening.store') }}" method="POST">
            @csrf @if(isset($rekening)) @method('PUT') @endif

            @foreach([['nama_pemilik','Nama Pemilik Rekening *','Nama sesuai di buku rekening'],['bank','Nama Bank / Penyedia E-Wallet *','Contoh: BCA, Mandiri, BRI, BNI'],['no_rekening','Nomor Rekening / Virtual Account *','Contoh: 1234567890']] as [$n,$l,$p])
            <div style="margin-bottom:20px;">
                <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.6px;">{{ $l }}</label>
                <input type="text" name="{{ $n }}" value="{{ old($n,isset($rekening)?$rekening->$n:'') }}" placeholder="{{ $p }}" required class="fcc-input" style="font-size:13.5px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>
            @endforeach

            <div style="display:flex;gap:12px;margin-top:28px;border-top:1.5px solid #E2E4EB;padding-top:20px;justify-content:flex-end;">
                <a href="{{ route('admin.rekening.index') }}" style="padding:10px 18px;font-size:13px;font-weight:800;color:#131218;text-decoration:none;background:#FFFFFF;border:1.5px solid #131218;border-radius:10px;">Batal</a>
                <button type="submit" style="padding:10px 24px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;display:inline-flex;align-items:center;gap:6px;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                    @include('components.icon',['name'=>'check','size'=>15]) {{ isset($rekening) ? 'Perbarui Rekening' : 'Simpan Rekening' }}
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

