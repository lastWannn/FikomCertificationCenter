@extends('layouts.peserta')
@section('title','Profil Saya')
@section('page-title','Profil Saya')
@section('page-content')

<style>
.profile-wrapper {
    padding: 24px;
    max-width: 1080px;
    margin: 0 auto;
}
.profile-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 22px;
    align-items: start;
}
.profile-avatar-card {
    background: linear-gradient(135deg, #131218, #1C1B22);
    border-radius: 18px;
    padding: 28px 22px;
    text-align: center;
    color: #FFF;
    border: 1px solid rgba(255,200,26,0.15);
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
}
.avatar-box {
    width: 96px;
    height: 96px;
    border-radius: 24px;
    margin: 0 auto 16px;
    background: linear-gradient(135deg, #FFC81A, #FFD84D);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(255,200,26,0.25);
    position: relative;
    overflow: hidden;
}
.avatar-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.form-grid-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.profile-section-card {
    background: #FFF;
    border: 1px solid #E2E4EB;
    border-radius: 18px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.03);
}
@media (max-width: 900px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 640px) {
    .profile-wrapper {
        padding: 16px 12px;
    }
    .form-grid-2col {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-wrapper">

    {{-- ── SUCCESS / ERROR ALERTS ────────────────────────────── --}}
    @if(session('success'))
    <div style="background:rgba(16,185,129,.08);border:1.5px solid rgba(16,185,129,.25);border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
        @include('components.icon',['name'=>'check','size'=>18,'style'=>'color:#10B981;flex-shrink:0'])
        <p style="margin:0;font-size:13px;font-weight:700;color:#059669;">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div style="background:rgba(239,68,68,.08);border:1.5px solid rgba(239,68,68,.25);border-radius:12px;padding:14px 18px;margin-bottom:20px;">
        <p style="margin:0 0 6px;font-size:13px;font-weight:800;color:#DC2626;">Terdapat kesalahan pada input:</p>
        <ul style="margin:0;padding-left:18px;font-size:12px;color:#991B1B;">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('peserta.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="profile-grid">

            {{-- ── KOLOM KIRI: KARTU AVATAR & AKUN ──────────────────── --}}
            <div>
                <div class="profile-avatar-card">
                    <div class="avatar-box" id="avatar-preview-container">
                        @if($peserta->foto)
                        <img id="avatar-preview" src="{{ asset('storage/'.$peserta->foto) }}" alt="Foto Profil">
                        @else
                        <div id="avatar-placeholder" style="display:flex;align-items:center;justify-content:center;height:100%;width:100%;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <img id="avatar-preview" src="" alt="Preview" style="display:none;width:100%;height:100%;object-fit:cover;">
                        @endif
                    </div>

                    <h2 style="font-size:18px;font-weight:900;color:#FFF;margin:0 0 4px;">{{ $peserta->nama }}</h2>
                    <span style="background:rgba(255,200,26,.18);color:#FFC81A;font-size:11px;font-weight:800;padding:3px 12px;border-radius:20px;display:inline-block;margin-bottom:12px;">
                        Peserta Terdaftar
                    </span>
                    <p style="font-size:12px;color:rgba(255,255,255,0.6);margin:0 0 20px;">{{ $peserta->email }}</p>

                    {{-- Tombol Ganti Foto --}}
                    <label class="fcc-btn-outline-dark"
                           style="width:100%;justify-content:center;padding:9px;font-size:12px;cursor:pointer;border-color:rgba(255,255,255,0.2);color:#FFF;border-radius:10px;font-weight:700;">
                        @include('components.icon',['name'=>'image','size'=>14]) Upload Foto Profil
                        <input type="file" name="foto" id="foto-input" accept="image/*" style="display:none" onchange="previewFoto(this)">
                    </label>
                </div>

                {{-- Status Keanggotaan --}}
                <div class="fcc-card" style="padding:18px;margin-top:16px;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:36px;height:36px;border-radius:10px;background:rgba(16,185,129,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            @include('components.icon',['name'=>'shield','size'=>18,'style'=>'color:#10B981'])
                        </div>
                        <div>
                            <p style="font-size:12px;font-weight:800;color:#131218;margin:0 0 2px;">Akun Terverifikasi</p>
                            <p style="font-size:11px;color:#9CA3B0;margin:0;">FIKOM Certification Center</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── KOLOM KANAN: FORM ISIAN ──────────────────────────── --}}
            <div>

                {{-- INFORMASI PRIBADI --}}
                <div class="profile-section-card">
                    <h3 style="font-size:16px;font-weight:900;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:8px;">
                        @include('components.icon',['name'=>'user','size'=>18,'style'=>'color:#FFC81A'])
                        Informasi Pribadi Peserta
                    </h3>

                    <div class="form-grid-2col">
                        <div style="grid-column:1 / -1;">
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Nama Lengkap (Sesuai Sertifikat) *
                            </label>
                            <input type="text" name="nama" value="{{ old('nama',$peserta->nama) }}" required class="fcc-input"
                                   placeholder="Nama lengkap beserta gelar..."
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Email Utama *
                            </label>
                            <input type="email" name="email" value="{{ old('email',$peserta->email) }}" required class="fcc-input"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Nomor HP / WhatsApp *
                            </label>
                            <input type="tel" name="no_hp" value="{{ old('no_hp',$peserta->no_hp) }}" required class="fcc-input"
                                   placeholder="081234567890"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div style="grid-column:1 / -1;">
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Instansi / Universitas / Perusahaan
                            </label>
                            <input type="text" name="instansi" value="{{ old('instansi',$peserta->instansi) }}" placeholder="Contoh: Universitas Muslim Indonesia" class="fcc-input"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div style="grid-column:1 / -1;">
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Alamat Domisili Lengkap
                            </label>
                            <textarea name="alamat" rows="3" placeholder="Alamat domisili peserta..." class="fcc-input" style="resize:none;">{{ old('alamat',$peserta->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- KEAMANAN & PASSWORD --}}
                <div class="profile-section-card">
                    <h3 style="font-size:16px;font-weight:900;color:#131218;margin:0 0 6px;display:flex;align-items:center;gap:8px;">
                        @include('components.icon',['name'=>'lock','size'=>18,'style'=>'color:#FFC81A'])
                        Keamanan & Password
                    </h3>
                    <p style="font-size:12px;color:#9CA3B0;margin:0 0 16px;">
                        Kosongkan bidang password jika tidak ingin mengubah password akun Anda.
                    </p>

                    <div class="form-grid-2col">
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Password Baru
                            </label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter" class="fcc-input"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="fcc-input"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>
                    </div>
                </div>

                {{-- TOMBOL SIMPAN --}}
                <div style="text-align:right;">
                    <button type="submit" class="fcc-btn-gold"
                            style="padding:13px 32px;font-size:15px;border-radius:12px;font-weight:800;display:inline-flex;align-items:center;gap:8px;">
                        @include('components.icon',['name'=>'check','size'=>18])
                        Simpan Perubahan Profil
                    </button>
                </div>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')
<script>
function previewFoto(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('avatar-preview');
        const placeholder = document.getElementById('avatar-placeholder');
        preview.src = e.target.result;
        preview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
