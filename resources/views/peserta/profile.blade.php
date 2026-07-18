@extends('layouts.peserta')
@section('title','Profil Saya')
@section('page-title','Profil Saya')
@section('page-content')
<div style="padding:24px;max-width:680px;">
    <div class="fcc-card" style="padding:28px;">
        <div style="display:flex;align-items:center;gap:18px;margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid #E2E4EB;">
            <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#FFC81A,#FFD84D);display:flex;align-items:center;justify-content:center;flex-shrink:0;position:relative;">
                @if($peserta->foto)
                <img src="{{ asset('storage/'.$peserta->foto) }}" style="width:60px;height:60px;border-radius:16px;object-fit:cover;" alt="Foto">
                @else
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                @endif
            </div>
            <div>
                <p style="font-size:18px;font-weight:900;color:#0F0F14;margin:0 0 3px;">{{ $peserta->nama }}</p>
                <p style="font-size:13px;color:#FFC81A;font-weight:700;margin:0;">Peserta</p>
                <p style="font-size:12px;color:#A0A3AD;margin:3px 0 0;">{{ $peserta->email }}</p>
            </div>
        </div>
        <form action="{{ route('peserta.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div style="grid-column:span 2;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Nama Lengkap *</label>
                    <input type="text" name="nama" value="{{ old('nama',$peserta->nama) }}" required class="fcc-input"
                           onkeydown="if(event.key==='Enter')event.preventDefault();">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Email *</label>
                    <input type="email" name="email" value="{{ old('email',$peserta->email) }}" required class="fcc-input"
                           onkeydown="if(event.key==='Enter')event.preventDefault();">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">No. HP *</label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp',$peserta->no_hp) }}" required class="fcc-input"
                           onkeydown="if(event.key==='Enter')event.preventDefault();">
                </div>
                <div style="grid-column:span 2;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Instansi / Asal</label>
                    <input type="text" name="instansi" value="{{ old('instansi',$peserta->instansi) }}" placeholder="Universitas / Perusahaan" class="fcc-input"
                           onkeydown="if(event.key==='Enter')event.preventDefault();">
                </div>
                <div style="grid-column:span 2;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Alamat</label>
                    <textarea name="alamat" rows="3" placeholder="Alamat lengkap" class="fcc-input" style="resize:vertical;">{{ old('alamat',$peserta->alamat) }}</textarea>
                </div>
                <div style="grid-column:span 2;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Foto Profil</label>
                    <input type="file" name="foto" accept="image/*" class="fcc-input" style="padding:8px;">
                </div>
            </div>
            <div style="border-top:1px solid #E2E4EB;padding-top:18px;margin-top:16px;">
                <p style="font-size:13px;font-weight:700;color:#6B7280;margin:0 0 12px;">Ganti Password <span style="font-weight:400;color:#A0A3AD;">(kosongkan jika tidak diubah)</span></p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Password Baru</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter" class="fcc-input"
                               onkeydown="if(event.key==='Enter')event.preventDefault();">
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Konfirmasi</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password" class="fcc-input"
                               onkeydown="if(event.key==='Enter')event.preventDefault();">
                    </div>
                </div>
            </div>
            <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;margin-top:18px;">
                @include('components.icon',['name'=>'check','size'=>15]) Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
