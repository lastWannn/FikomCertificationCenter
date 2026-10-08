@extends('layouts.admin')
@section('title', isset($rekening) ? 'Edit Rekening' : 'Tambah Rekening')
@section('page-content')

<style>
.fcc-rekform-container {
    padding: 24px 28px;
    max-width: 600px;
    box-sizing: border-box;
    width: 100%;
}
.fcc-rekform-btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #131218;
    font-size: 12.5px;
    font-weight: 800;
    text-decoration: none;
    margin-bottom: 14px;
    background: #FFFFFF;
    border: 1.5px solid #131218;
    padding: 6px 14px;
    border-radius: 20px;
    transition: all .18s;
}
.fcc-rekform-btn-back:hover {
    background: #FFC81A;
}
.fcc-rekform-tag {
    background: #FFC81A;
    color: #131218;
    font-size: 11px;
    font-weight: 900;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1px solid #131218;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    margin-bottom: 6px;
}
.fcc-rekform-title {
    font-size: 22px;
    font-weight: 900;
    color: #131218;
    margin: 0;
    letter-spacing: -0.02em;
    font-family: 'Outfit', sans-serif;
    line-height: 1.25;
}
.fcc-rekform-card {
    padding: 30px;
    border-radius: 22px;
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    box-shadow: 0 6px 24px rgba(0,0,0,0.04);
    box-sizing: border-box;
}
.fcc-rekform-label {
    font-size: 11px;
    font-weight: 800;
    color: #64748B;
    display: block;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: .6px;
}
.fcc-rekform-input {
    font-size: 13.5px;
    height: 42px;
    background: #FFF;
    border: 1.5px solid #CBD5E1;
    border-radius: 10px;
    font-weight: 600;
    width: 100% !important;
    box-sizing: border-box;
    padding: 0 14px;
    color: #131218;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.fcc-rekform-input:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
}
.fcc-rekform-actions {
    display: flex;
    gap: 12px;
    margin-top: 26px;
    border-top: 1.5px solid #E2E4EB;
    padding-top: 20px;
    justify-content: flex-end;
}
.fcc-rekform-btn-cancel {
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 800;
    color: #131218;
    text-decoration: none;
    background: #FFFFFF;
    border: 1.5px solid #131218;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 40px;
    box-sizing: border-box;
}
.fcc-rekform-btn-cancel:hover {
    background: #F1F5F9;
}
.fcc-rekform-btn-submit {
    padding: 10px 24px;
    font-size: 13px;
    font-weight: 900;
    background: #131218;
    color: #FFC81A;
    border: 1.5px solid #131218;
    border-radius: 10px;
    cursor: pointer;
    transition: all .18s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 40px;
    box-shadow: 2px 2px 0px #131218;
    box-sizing: border-box;
}
.fcc-rekform-btn-submit:hover {
    background: #FFC81A;
    color: #131218;
    transform: translateY(-1px);
}

@media (max-width: 639px) {
    .fcc-rekform-container {
        padding: 14px 12px;
    }
    .fcc-rekform-card {
        padding: 20px 16px;
        border-radius: 18px;
    }
    .fcc-rekform-title {
        font-size: 20px;
    }
    .fcc-rekform-actions {
        flex-direction: column-reverse;
        gap: 8px;
    }
    .fcc-rekform-btn-cancel,
    .fcc-rekform-btn-submit {
        width: 100%;
        min-height: 42px;
    }
}
</style>

<div class="fcc-rekform-container">

    {{-- Back Button & Header --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.rekening.index') }}" class="fcc-rekform-btn-back">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Rekening
        </a>

        <div>
            <span class="fcc-rekform-tag">Form Rekening</span>
            <h1 class="fcc-rekform-title">{{ isset($rekening) ? 'Edit' : 'Tambah' }} Nomor Rekening</h1>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="fcc-card fcc-rekform-card">
        <form action="{{ isset($rekening) ? route('admin.rekening.update', $rekening) : route('admin.rekening.store') }}" method="POST">
            @csrf
            @if(isset($rekening))
                @method('PUT')
            @endif

            <div style="margin-bottom:18px;">
                <label class="fcc-rekform-label">Nama Pemilik Rekening *</label>
                <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', isset($rekening) ? $rekening->nama_pemilik : '') }}" placeholder="Nama sesuai di buku rekening" required class="fcc-input fcc-rekform-input">
            </div>

            <div style="margin-bottom:18px;">
                <label class="fcc-rekform-label">Nama Bank / Penyedia E-Wallet *</label>
                <input type="text" name="bank" value="{{ old('bank', isset($rekening) ? $rekening->bank : '') }}" placeholder="Contoh: BCA, Mandiri, BRI, BNI" required class="fcc-input fcc-rekform-input">
            </div>

            <div style="margin-bottom:20px;">
                <label class="fcc-rekform-label">Nomor Rekening / Virtual Account *</label>
                <input type="text" name="no_rekening" value="{{ old('no_rekening', isset($rekening) ? $rekening->no_rekening : '') }}" placeholder="Contoh: 1234567890" required class="fcc-input fcc-rekform-input" style="font-family:'JetBrains Mono',monospace;font-weight:700;">
            </div>

            <div class="fcc-rekform-actions">
                <a href="{{ route('admin.rekening.index') }}" class="fcc-rekform-btn-cancel">Batal</a>
                <button type="submit" class="fcc-rekform-btn-submit">
                    @include('components.icon',['name'=>'check','size'=>15]) {{ isset($rekening) ? 'Perbarui Rekening' : 'Simpan Rekening' }}
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
