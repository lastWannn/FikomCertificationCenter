@extends('layouts.admin')
@section('title','Profil Admin')
@section('page-content')
<div style="padding:24px;max-width:640px;margin:0 auto;">
    <div style="margin-bottom:22px;">
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Profil Admin</h1>
        <p style="color:#6B7280;font-size:14px;margin:0;">Kelola informasi akun admin.</p>
    </div>
    <div class="fcc-card" style="padding:28px;">
        <div style="display:flex;align-items:center;gap:18px;margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid #E2E4EB;">
            <div style="width:64px;height:64px;border-radius:18px;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p style="font-size:18px;font-weight:900;color:#0F0F14;margin:0 0 3px;">{{ $admin->nama }}</p>
                <p style="font-size:13px;color:#FFC81A;font-weight:700;margin:0;">Penyelenggara · FIKOM Certification Center</p>
                <p style="font-size:12px;color:#A0A3AD;margin:3px 0 0;">{{ $admin->email }}</p>
            </div>
        </div>
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf @method('PUT')
            @foreach([['nama','Nama Lengkap','text','Nama admin'],['email','Email','email','email@domain.com']] as [$n,$l,$t,$p])
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">{{ $l }} *</label>
                <input type="{{ $t }}" name="{{ $n }}" value="{{ old($n,$admin->$n) }}" placeholder="{{ $p }}" required class="fcc-input"
                       onkeydown="if(event.key==='Enter')event.preventDefault();">
                @error($n)<p style="color:#EF4444;font-size:12px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            @endforeach
            <div style="border-top:1px solid #E2E4EB;padding-top:20px;margin-top:4px;">
                <p style="font-size:13px;font-weight:700;color:#6B7280;margin:0 0 14px;">Ganti Password <span style="font-weight:400;color:#A0A3AD;">(kosongkan jika tidak ingin ubah)</span></p>
                @foreach([['password','Password Baru'],['password_confirmation','Konfirmasi Password Baru']] as [$n,$l])
                <div style="margin-bottom:14px;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">{{ $l }}</label>
                    <input type="password" name="{{ $n }}" placeholder="Minimal 8 karakter" class="fcc-input"
                           onkeydown="if(event.key==='Enter')event.preventDefault();">
                </div>
                @endforeach
            </div>
            <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;margin-top:8px;">
                @include('components.icon',['name'=>'check','size'=>15]) Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
