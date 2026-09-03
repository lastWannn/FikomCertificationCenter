@extends('layouts.peserta')
@section('title','Profil Saya')
@section('page-title','Profil Saya')
@section('page-content')

<style>
.profile-wrapper {
    padding: 24px 28px;
    background: #F6F8FB;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    position: relative;
}
.profile-grid {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 24px;
    align-items: start;
}
.profile-avatar-card {
    background: #131218;
    border-radius: 20px;
    padding: 32px 24px;
    text-align: center;
    color: #FFF;
    border: 2px solid #FFC81A;
    box-shadow: 0 6px 24px rgba(19,18,24,0.18);
}
.avatar-box {
    width: 104px;
    height: 104px;
    border-radius: 24px;
    margin: 0 auto 18px;
    background: #FFC81A;
    border: 3px solid #131218;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(255,200,26,0.3);
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
    border: 2px solid #E5E7EB;
    border-radius: 20px;
    padding: 28px;
    margin-bottom: 22px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
@media (max-width: 900px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 640px) {
    .profile-wrapper {
        padding: 16px 14px;
    }
    .form-grid-2col {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-wrapper">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <style>
      @keyframes skeletonShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
      }
      .fcc-skeleton-box {
        background: linear-gradient(90deg, #E2E8F0 25%, #F1F5F9 50%, #E2E8F0 75%);
        background-size: 200% 100%;
        animation: skeletonShimmer 1.4s infinite ease-in-out;
        border-radius: 12px;
      }
      #profile-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="profile-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:280px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
      </div>
      {{-- Grid Skeleton --}}
      <div class="profile-grid">
        <div class="fcc-skeleton-box" style="width:100%;height:340px;border-radius:20px;"></div>
        <div>
          <div class="fcc-skeleton-box" style="width:100%;height:260px;border-radius:20px;margin-bottom:20px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:180px;border-radius:20px;"></div>
        </div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('profile-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Pengaturan Akun</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Profil Saya</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola informasi identitas pribadi, foto profil, dan kata sandi akun Anda.</p>
        </div>
        <div>
            <button type="button" onclick="openPasswordModal()" class="fcc-btn-gold" style="padding:9px 18px;font-size:12.5px;border-radius:30px;font-weight:900;box-shadow:0 4px 12px rgba(255,200,26,0.3);display:inline-flex;align-items:center;gap:6px;cursor:pointer;">
                @include('components.icon',['name'=>'lock','size'=>15,'style'=>'color:#131218']) Ubah Kata Sandi
            </button>
        </div>
    </div>

    {{-- ── PENDING EMAIL OTP ALERT ───────────────────────────────────── --}}
    @if(!empty($peserta->pending_email))
    <div style="background:#FFFBEB;border:2px solid #F59E0B;border-radius:18px;padding:18px 22px;margin-bottom:24px;box-shadow:0 6px 18px rgba(245,158,11,0.18);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:42px;height:42px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <p style="margin:0;font-size:14.5px;font-weight:900;color:#92400E;">Pergantian Email Menunggu Verifikasi OTP</p>
                <p style="margin:3px 0 0;font-size:13px;color:#B45309;font-weight:600;">Kode OTP 4-digit telah dikirim ke <strong>{{ $peserta->pending_email }}</strong>. Masukkan OTP untuk mengaktifkan email baru ini.</p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <button type="button" onclick="openOtpEmailModal()" style="padding:9px 18px;font-size:12.5px;font-weight:900;background:#131218;color:#FFC81A;border-radius:24px;border:1.5px solid #131218;cursor:pointer;box-shadow:0 4px 12px rgba(19,18,24,0.15);">
                🔑 Masukkan OTP &rarr;
            </button>
            <form action="{{ route('peserta.profile.cancel-email-change') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" onclick="return confirm('Batalkan pergantian email?')" style="padding:8px 14px;font-size:12px;font-weight:800;background:#FFFFFF;color:#DC2626;border-radius:24px;border:1.5px solid #FCA5A5;cursor:pointer;">
                    Batal
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- ── SUCCESS / ERROR / INFO ALERTS ────────────────────────────── --}}
    @if(session('warning'))
    <div style="background:#FFFBEB;border:2px solid #F59E0B;border-radius:16px;padding:16px 20px;margin-bottom:22px;display:flex;align-items:center;gap:14px;box-shadow:0 4px 16px rgba(245,158,11,0.12);">
        <div style="width:40px;height:40px;border-radius:12px;background:#F59E0B;color:#FFF;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @include('components.icon',['name'=>'alert-triangle','size'=>20,'style'=>'color:#FFF;'])
        </div>
        <div>
            <h4 style="margin:0 0 2px;font-size:14.5px;font-weight:900;color:#B45309;">Lengkapi Informasi Data Diri</h4>
            <p style="margin:0;font-size:13px;color:#92400E;font-weight:600;">{{ session('warning') }}</p>
        </div>
    </div>
    @elseif(!$peserta->isProfileComplete())
    <div style="background:#FFFBEB;border:2px solid #F59E0B;border-radius:16px;padding:16px 20px;margin-bottom:22px;display:flex;align-items:center;gap:14px;box-shadow:0 4px 16px rgba(245,158,11,0.12);">
        <div style="width:40px;height:40px;border-radius:12px;background:#F59E0B;color:#FFF;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @include('components.icon',['name'=>'alert-triangle','size'=>20,'style'=>'color:#FFF;'])
        </div>
        <div>
            <h4 style="margin:0 0 2px;font-size:14.5px;font-weight:900;color:#B45309;">Data Profil Belum Lengkap</h4>
            <p style="margin:0;font-size:13px;color:#92400E;font-weight:600;">Harap lengkapi informasi data diri Anda (Nama Lengkap, Email, No. HP, Instansi, dan Pekerjaan) terlebih dahulu untuk dapat menggunakan seluruh fitur FIKOM Certification Center.</p>
        </div>
    </div>
    @endif

    @if(session('info'))
    <div style="background:#FFFBEB;border:2px solid #F59E0B;border-radius:14px;padding:14px 20px;margin-bottom:22px;display:flex;align-items:center;gap:12px;box-shadow:0 4px 14px rgba(245,158,11,0.15);">
        @include('components.icon',['name'=>'info','size'=>20,'style'=>'color:#D97706;flex-shrink:0'])
        <p style="margin:0;font-size:13.5px;font-weight:800;color:#92400E;">{{ session('info') }}</p>
    </div>
    @endif

    @if(session('success'))
    <div style="background:#ECFDF5;border:2px solid #10B981;border-radius:14px;padding:14px 20px;margin-bottom:22px;display:flex;align-items:center;gap:12px;box-shadow:0 4px 14px rgba(16,185,129,0.12);">
        @include('components.icon',['name'=>'check','size'=>20,'style'=>'color:#059669;flex-shrink:0'])
        <p style="margin:0;font-size:13.5px;font-weight:800;color:#065F46;">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div style="background:#FEF2F2;border:2px solid #EF4444;border-radius:14px;padding:16px 20px;margin-bottom:22px;">
        <p style="margin:0 0 6px;font-size:13.5px;font-weight:900;color:#DC2626;">Terdapat kesalahan pada input:</p>
        <ul style="margin:0;padding-left:20px;font-size:12.5px;color:#991B1B;font-weight:600;">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="profile-form" action="{{ route('peserta.profile.update') }}" method="POST" enctype="multipart/form-data">
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
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#131218" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <img id="avatar-preview" src="" alt="Preview" style="display:none;width:100%;height:100%;object-fit:cover;">
                        @endif
                    </div>

                    <h2 style="font-size:18px;font-weight:900;color:#FFF;margin:0 0 4px;">{{ $peserta->nama }}</h2>
                    <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:3px 12px;border-radius:20px;display:inline-block;margin-bottom:12px;text-transform:uppercase;border:1px solid #131218;">
                        Peserta Terdaftar
                    </span>
                    <p style="font-size:12px;color:#CBD5E1;margin:0 0 20px;font-weight:600;">{{ $peserta->email }}</p>

                    {{-- Tombol Ganti Foto --}}
                    <label class="fcc-btn-gold"
                           style="width:100%;justify-content:center;padding:10px;font-size:12.5px;cursor:pointer;border-radius:12px;font-weight:900;box-shadow:0 4px 12px rgba(255,200,26,0.3);display:inline-flex;align-items:center;gap:6px;">
                        @include('components.icon',['name'=>'image','size'=>15]) Upload Foto Profil
                        <input type="file" name="foto" id="foto-input" accept="image/*" style="display:none" onchange="previewFoto(this)">
                    </label>
                </div>

                {{-- Status Keanggotaan --}}
                <div class="fcc-card" style="padding:20px;margin-top:18px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div style="width:40px;height:40px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            @include('components.icon',['name'=>'shield','size'=>20,'style'=>'color:#059669'])
                        </div>
                        <div>
                            <p style="font-size:13px;font-weight:900;color:#131218;margin:0 0 2px;">Akun Terverifikasi</p>
                            <p style="font-size:11.5px;color:#64748B;margin:0;font-weight:600;">FIKOM Certification Center</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── KOLOM KANAN: FORM ISIAN ──────────────────────────── --}}
            <div>

                {{-- INFORMASI PRIBADI --}}
                <div class="profile-section-card">
                    <h3 style="font-size:17px;font-weight:900;color:#131218;margin:0 0 18px;display:flex;align-items:center;gap:10px;">
                        @include('components.icon',['name'=>'user','size'=>20,'style'=>'color:#131218'])
                        Informasi Pribadi Peserta
                    </h3>

                    <div class="form-grid-2col">
                        <div style="grid-column:1 / -1;">
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Nama Lengkap (Sesuai Sertifikat) *
                            </label>
                            <input type="text" name="nama" value="{{ old('nama',$peserta->nama) }}" required class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                                   placeholder="Nama lengkap beserta gelar..."
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Email Utama *
                            </label>
                            <input type="email" name="email" value="{{ old('email',$peserta->email) }}" required class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Nomor HP / WhatsApp *
                            </label>
                            <input type="tel" name="no_hp" value="{{ old('no_hp',$peserta->no_hp) }}" required class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                                   placeholder="081234567890"
                                   oninput="this.value = this.value.replace(/[^0-9\+\-\(\)\/\s]/g, '')"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                            @error('no_hp')<p style="color:#EF4444;font-size:11.5px;margin:4px 0 0;font-weight:600;">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Instansi / Perusahaan *
                            </label>
                            <input type="text" name="instansi" value="{{ old('instansi',$peserta->instansi) }}" required placeholder="Contoh: Universitas Muslim Indonesia" class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Pekerjaan / Status *
                            </label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan',$peserta->pekerjaan) }}" required placeholder="Contoh: Mahasiswa, Pegawai, Dosen, Pelajar, Umum..." class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div style="grid-column:1 / -1;">
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Alamat Domisili Lengkap
                            </label>
                            <textarea name="alamat" rows="3" placeholder="Alamat domisili peserta..." class="fcc-input" style="resize:none;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;">{{ old('alamat',$peserta->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL SIMPAN --}}
                <div style="text-align:right;">
                    <button type="submit" class="fcc-btn-gold"
                            style="padding:12px 32px;font-size:14px;border-radius:30px;font-weight:900;display:inline-flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
                        @include('components.icon',['name'=>'check','size'=>18])
                        Simpan Perubahan Profil &rarr;
                    </button>
                </div>

            </div>

        </div>

    </form>

    {{-- ═══ POPUP MODAL UBAH KATA SANDI ══════════════════════════ --}}
    <div id="password-modal" onclick="if(event.target===this)closePasswordModal()" style="display:{{ $errors->has('password') ? 'flex' : 'none' }};position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.6);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:20px;box-sizing:border-box;">
      <div style="background:#FFFFFF;border-radius:24px;border:2px solid #E5E7EB;max-width:520px;width:100%;box-shadow:0 24px 60px rgba(0,0,0,0.25);overflow:hidden;position:relative;animation:modalPop 0.25s ease-out;">
        {{-- Modal Header --}}
        <div style="background:#131218;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;">
          <div style="display:flex;align-items:center;gap:10px;">
            <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;text-transform:uppercase;letter-spacing:0.5px;">Keamanan Akun</span>
            <span style="color:#FFFFFF;font-size:14px;font-weight:900;">Ubah Kata Sandi</span>
          </div>
          <button type="button" onclick="closePasswordModal()" style="background:rgba(255,255,255,0.1);border:none;color:#FFFFFF;width:32px;height:32px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:900;transition:all .18s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">&times;</button>
        </div>

        {{-- Modal Body --}}
        <div style="padding:26px 28px;">
          <p style="font-size:13px;color:#64748B;margin:0 0 20px;font-weight:500;">Masukkan kata sandi baru Anda di bawah ini untuk memperbarui keamanan akun Anda.</p>

          <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:24px;">
            <div>
              <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                Kata Sandi Baru *
              </label>
              <input type="password" form="profile-form" name="password" placeholder="Minimal 8 karakter" class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                     onkeydown="if(event.key==='Enter')event.preventDefault();">
            </div>

            <div>
              <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                Konfirmasi Kata Sandi Baru *
              </label>
              <input type="password" form="profile-form" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                     onkeydown="if(event.key==='Enter')event.preventDefault();">
            </div>
          </div>

          <div style="display:flex;gap:12px;justify-content:flex-end;">
            <button type="button" onclick="closePasswordModal()" style="padding:10px 18px;border-radius:12px;border:1.5px solid #CBD5E1;background:#F1F5F9;color:#131218;font-size:13px;font-weight:800;cursor:pointer;">
              Batal
            </button>
            <button type="submit" form="profile-form" class="fcc-btn-gold" style="padding:10px 22px;border-radius:12px;font-size:13px;font-weight:900;box-shadow:0 4px 12px rgba(255,200,26,0.3);">
              Simpan Kata Sandi &rarr;
            </button>
          </div>
        </div>
      </div>
    {{-- ═══ MODAL KHUSUS VERIFIKASI OTP EMAIL BARU ════════════════ --}}
    @php
        $activeOtpHint = $otpHint ?? session('otp_hint');
    @endphp
    <div id="email-otp-modal" class="no-print" style="display:{{ (session('require_otp_change_email') || $errors->has('otp') || !empty($peserta->pending_email)) ? 'flex' : 'none' }};position:fixed;inset:0;z-index:999999;background:rgba(19,18,24,.8);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:20px;box-sizing:border-box;pointer-events:auto;">
      <div style="background:#FFFFFF;border-radius:24px;border:2.5px solid #131218;max-width:480px;width:100%;box-shadow:0 24px 60px rgba(0,0,0,0.4);overflow:hidden;position:relative;animation:modalPop 0.25s ease-out;z-index:1000000;">
        
        {{-- Modal Header Dark & Yellow --}}
        <div style="background:#131218;padding:22px 26px;display:flex;justify-content:space-between;align-items:center;border-bottom:3px solid #FFC81A;">
          <div style="display:flex;align-items:center;gap:10px;">
            <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;text-transform:uppercase;letter-spacing:0.5px;">Verifikasi Keamanan</span>
            <span style="color:#FFFFFF;font-size:14.5px;font-weight:900;">Verifikasi Email Baru</span>
          </div>
          <button type="button" onclick="closeOtpEmailModal()" style="background:rgba(255,255,255,0.15);border:none;color:#FFFFFF;width:32px;height:32px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:900;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">&times;</button>
        </div>

        {{-- Modal Body --}}
        <div style="padding:28px 30px;text-align:center;">
          <div style="width:58px;height:58px;border-radius:20px;background:#131218;border:2px solid #FFC81A;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;box-shadow:0 8px 20px rgba(255,200,26,0.3);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>

          <h3 style="font-size:18px;font-weight:900;color:#131218;margin:0 0 6px;">Masukkan Kode OTP 4 Digit</h3>
          <p style="font-size:13px;color:#64748B;margin:0 0 14px;font-weight:500;line-height:1.5;">
            Kode OTP verifikasi 4-digit telah dikirimkan ke:
          </p>

          {{-- Target Email Badge --}}
          <div style="background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:30px;padding:8px 18px;display:inline-flex;align-items:center;gap:8px;margin-bottom:18px;">
            <span style="width:9px;height:9px;border-radius:50%;background:#10B981;"></span>
            <strong id="target-pending-email" style="font-size:13.5px;color:#131218;font-family:monospace;">{{ $peserta->pending_email ?? session('pending_email', '-') }}</strong>
          </div>

          {{-- Dev OTP Hint Badge --}}
          <div id="otp-dev-hint-badge" style="display:{{ $activeOtpHint ? 'block' : 'none' }};margin:0 auto 18px;background:#FEF3C7;border:1.5px solid #F59E0B;color:#92400E;padding:8px 16px;border-radius:14px;font-size:12.5px;font-weight:800;max-width:360px;">
            🔑 Mode Testing Dev: Kode OTP Anda = <strong id="dev-otp-code" style="font-family:monospace;font-size:15px;color:#131218;letter-spacing:2px;">{{ $activeOtpHint }}</strong>
          </div>

          {{-- 4 Digit OTP Box Inputs --}}
          <div style="display:flex;justify-content:center;gap:12px;margin-bottom:20px;" id="otp-digit-container">
            <input type="text" maxlength="1" id="otp-digit-1" class="otp-box-input" autocomplete="off" inputmode="numeric" style="width:56px;height:62px;border-radius:14px;border:2.5px solid #CBD5E1;text-align:center;font-size:28px;font-weight:900;color:#131218;background:#FFFFFF;font-family:monospace;transition:all .18s;cursor:text;position:relative;z-index:1000000;" onfocus="this.style.borderColor='#131218';this.select();" onblur="this.style.borderColor='#CBD5E1';">
            <input type="text" maxlength="1" id="otp-digit-2" class="otp-box-input" autocomplete="off" inputmode="numeric" style="width:56px;height:62px;border-radius:14px;border:2.5px solid #CBD5E1;text-align:center;font-size:28px;font-weight:900;color:#131218;background:#FFFFFF;font-family:monospace;transition:all .18s;cursor:text;position:relative;z-index:1000000;" onfocus="this.style.borderColor='#131218';this.select();" onblur="this.style.borderColor='#CBD5E1';">
            <input type="text" maxlength="1" id="otp-digit-3" class="otp-box-input" autocomplete="off" inputmode="numeric" style="width:56px;height:62px;border-radius:14px;border:2.5px solid #CBD5E1;text-align:center;font-size:28px;font-weight:900;color:#131218;background:#FFFFFF;font-family:monospace;transition:all .18s;cursor:text;position:relative;z-index:1000000;" onfocus="this.style.borderColor='#131218';this.select();" onblur="this.style.borderColor='#CBD5E1';">
            <input type="text" maxlength="1" id="otp-digit-4" class="otp-box-input" autocomplete="off" inputmode="numeric" style="width:56px;height:62px;border-radius:14px;border:2.5px solid #CBD5E1;text-align:center;font-size:28px;font-weight:900;color:#131218;background:#FFFFFF;font-family:monospace;transition:all .18s;cursor:text;position:relative;z-index:1000000;" onfocus="this.style.borderColor='#131218';this.select();" onblur="this.style.borderColor='#CBD5E1';">
          </div>

          {{-- Error Container --}}
          <div id="otp-error-msg" style="display:none;background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:10px;padding:10px 14px;font-size:12.5px;color:#DC2626;font-weight:700;margin-bottom:18px;"></div>

          {{-- Action Submit Button --}}
          <button type="button" id="btn-verify-otp" onclick="submitEmailOtpAjax()" class="fcc-btn-gold" style="width:100%;padding:13px;font-size:14px;border-radius:14px;font-weight:900;justify-content:center;box-shadow:0 6px 18px rgba(255,200,26,0.35);margin-bottom:18px;cursor:pointer;">
            Verifikasi &amp; Simpan Email Baru &rarr;
          </button>

          {{-- Resend & Cancel Footer Row --}}
          <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding-top:16px;border-top:1px solid #E2E8F0;font-size:12.5px;">
            <div>
              <span id="otp-timer-label" style="color:#64748B;font-weight:600;">Kirim ulang dalam <strong id="otp-timer-count" style="color:#131218;font-family:monospace;">01:00</strong></span>
              <button type="button" id="btn-resend-otp" onclick="resendEmailOtpAjax()" style="display:none;background:none;border:none;color:#D97706;font-weight:900;cursor:pointer;padding:0;text-decoration:underline;">
                🔄 Kirim Ulang Kode OTP
              </button>
            </div>
            <button type="button" onclick="cancelEmailChangeAjax()" style="background:none;border:none;color:#EF4444;font-weight:700;cursor:pointer;padding:0;text-decoration:underline;">
              Batal Pergantian
            </button>
          </div>

        </div>
      </div>
    </div>

</div>

@endsection

@push('modals')
{{-- ═══ POPUP MODAL UBAH KATA SANDI ══════════════════════════ --}}
<div id="password-modal" onclick="if(event.target===this)closePasswordModal()" style="display:{{ $errors->has('password') ? 'flex' : 'none' }};position:fixed;inset:0;z-index:999999;background:rgba(19,18,24,.75);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:20px;box-sizing:border-box;">
  <div style="background:#FFFFFF;border-radius:24px;border:2px solid #E5E7EB;max-width:520px;width:100%;box-shadow:0 24px 60px rgba(0,0,0,0.25);overflow:hidden;position:relative;">
    {{-- Modal Header --}}
    <div style="background:#131218;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;border-bottom:3px solid #FFC81A;">
      <div style="display:flex;align-items:center;gap:10px;">
        <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;text-transform:uppercase;letter-spacing:0.5px;">Keamanan Akun</span>
        <span style="color:#FFFFFF;font-size:14px;font-weight:900;">Ubah Kata Sandi</span>
      </div>
      <button type="button" onclick="closePasswordModal()" style="background:rgba(255,255,255,0.1);border:none;color:#FFFFFF;width:32px;height:32px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:900;">&times;</button>
    </div>

    {{-- Modal Body --}}
    <div style="padding:26px 28px;">
      <p style="font-size:13px;color:#64748B;margin:0 0 20px;font-weight:500;">Masukkan kata sandi baru Anda di bawah ini untuk memperbarui keamanan akun Anda.</p>

      <form action="{{ route('peserta.profile.update') }}" method="POST">
        @csrf @method('PUT')
        <input type="hidden" name="nama" value="{{ $peserta->nama }}">
        <input type="hidden" name="email" value="{{ $peserta->email }}">
        <input type="hidden" name="no_hp" value="{{ $peserta->no_hp }}">

        <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:24px;">
          <div>
            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
              Kata Sandi Baru *
            </label>
            <input type="password" name="password" required placeholder="Minimal 8 karakter" class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;">
          </div>

          <div>
            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
              Konfirmasi Kata Sandi Baru *
            </label>
            <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi baru" class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;">
          </div>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;">
          <button type="button" onclick="closePasswordModal()" style="padding:10px 18px;border-radius:12px;border:1.5px solid #CBD5E1;background:#F1F5F9;color:#131218;font-size:13px;font-weight:800;cursor:pointer;">
            Batal
          </button>
          <button type="submit" class="fcc-btn-gold" style="padding:10px 22px;border-radius:12px;font-size:13px;font-weight:900;box-shadow:0 4px 12px rgba(255,200,26,0.3);">
            Simpan Kata Sandi &rarr;
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- ═══ MODAL KHUSUS VERIFIKASI OTP EMAIL BARU (IDENTIK AUTH REGISTER) ════════════════ --}}
@php
    $activeOtpHint = $otpHint ?? session('otp_hint');
@endphp
<div id="email-otp-modal" class="no-print" style="display:{{ (session('require_otp_change_email') || $errors->has('otp') || !empty($peserta->pending_email)) ? 'flex' : 'none' }};position:fixed;inset:0;background:rgba(14,13,20,0.88);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);z-index:999999;align-items:center;justify-content:center;padding:20px;box-sizing:border-box;">
  <div style="background:#131218;width:100%;max-width:420px;border-radius:24px;padding:36px 32px;box-shadow:0 24px 64px rgba(0,0,0,0.7);border:1.5px solid rgba(255,200,26,0.25);text-align:center;position:relative;">

    {{-- Mail Icon Box --}}
    <div style="width:64px;height:64px;border-radius:20px;background:rgba(255,200,26,0.12);border:1.5px solid rgba(255,200,26,0.3);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    </div>

    <h3 style="color:#FFFFFF;font-size:22px;font-weight:900;margin:0 0 8px;letter-spacing:-0.5px;">Verifikasi Email Baru</h3>
    <p style="color:rgba(255,255,255,0.65);font-size:13.5px;line-height:1.5;margin:0 0 20px;">
      Kami telah mengirimkan 4 digit kode OTP ke <br>
      <strong id="target-pending-email" style="color:#FFC81A;font-weight:800;word-break:break-all;">{{ $peserta->pending_email ?? session('pending_email', '-') }}</strong>
    </p>

    {{-- 4 Separate Individual Digit Boxes (.otp-box) --}}
    <form action="{{ route('peserta.profile.verify-email-otp') }}" method="POST">
      @csrf
      <input type="hidden" name="otp" id="otp-hidden-field">

      <div style="display:flex;gap:12px;justify-content:center;margin-bottom:22px;">
        <input type="text" maxlength="1" id="otp-1" class="profile-otp-box" autocomplete="off" inputmode="numeric" required autofocus style="width:48px;height:52px;background:rgba(255,255,255,0.05);border:1.5px solid rgba(255,255,255,0.15);border-radius:12px;text-align:center;font-size:22px;font-weight:900;color:#FFFFFF;transition:all 0.2s ease;outline:none;" onfocus="this.style.borderColor='#FFC81A';this.style.background='rgba(255,200,26,0.08)';this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)';this.select();" onblur="this.style.borderColor='rgba(255,255,255,0.15)';this.style.background='rgba(255,255,255,0.05)';this.style.boxShadow='none';">
        <input type="text" maxlength="1" id="otp-2" class="profile-otp-box" autocomplete="off" inputmode="numeric" required style="width:48px;height:52px;background:rgba(255,255,255,0.05);border:1.5px solid rgba(255,255,255,0.15);border-radius:12px;text-align:center;font-size:22px;font-weight:900;color:#FFFFFF;transition:all 0.2s ease;outline:none;" onfocus="this.style.borderColor='#FFC81A';this.style.background='rgba(255,200,26,0.08)';this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)';this.select();" onblur="this.style.borderColor='rgba(255,255,255,0.15)';this.style.background='rgba(255,255,255,0.05)';this.style.boxShadow='none';">
        <input type="text" maxlength="1" id="otp-3" class="profile-otp-box" autocomplete="off" inputmode="numeric" required style="width:48px;height:52px;background:rgba(255,255,255,0.05);border:1.5px solid rgba(255,255,255,0.15);border-radius:12px;text-align:center;font-size:22px;font-weight:900;color:#FFFFFF;transition:all 0.2s ease;outline:none;" onfocus="this.style.borderColor='#FFC81A';this.style.background='rgba(255,200,26,0.08)';this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)';this.select();" onblur="this.style.borderColor='rgba(255,255,255,0.15)';this.style.background='rgba(255,255,255,0.05)';this.style.boxShadow='none';">
        <input type="text" maxlength="1" id="otp-4" class="profile-otp-box" autocomplete="off" inputmode="numeric" required style="width:48px;height:52px;background:rgba(255,255,255,0.05);border:1.5px solid rgba(255,255,255,0.15);border-radius:12px;text-align:center;font-size:22px;font-weight:900;color:#FFFFFF;transition:all 0.2s ease;outline:none;" onfocus="this.style.borderColor='#FFC81A';this.style.background='rgba(255,200,26,0.08)';this.style.boxShadow='0 0 0 3px rgba(255,200,26,0.2)';this.select();" onblur="this.style.borderColor='rgba(255,255,255,0.15)';this.style.background='rgba(255,255,255,0.05)';this.style.boxShadow='none';">
      </div>

      @if($errors->has('otp'))
      <div style="color:#EF4444;font-size:13px;margin-bottom:18px;font-weight:700;">
        {{ $errors->first('otp') }}
      </div>
      @endif

      <button type="submit" style="width:100%;justify-content:center;background:#FFC81A;color:#131218;font-weight:800;font-size:13.5px;padding:12px 22px;border-radius:100px;border:none;cursor:pointer;box-shadow:0 6px 16px rgba(255,200,26,0.25);transition:all .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        Verifikasi &amp; Simpan Email Baru
      </button>
    </form>

    {{-- Resend & Cancel Footer --}}
    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:20px;padding-top:16px;border-top:1px dashed rgba(255,255,255,0.15);font-size:12px;">
      <div>
        <span id="resend-timer-wrapper" style="color:rgba(255,255,255,0.6);font-weight:600;">
          Kirim ulang dalam <strong id="resend-countdown" style="color:#FFC81A;font-family:monospace;font-size:13px;">01:00</strong>
        </span>
        <form action="{{ route('peserta.profile.resend-email-otp') }}" method="POST" id="resend-otp-form" style="margin:0;display:none;">
          @csrf
          <button type="submit" style="background:none;border:none;color:#FFC81A;font-weight:800;cursor:pointer;padding:0;text-decoration:underline;">
            🔄 Kirim Ulang Kode OTP
          </button>
        </form>
      </div>

      <form action="{{ route('peserta.profile.cancel-email-change') }}" method="POST" style="margin:0;">
        @csrf
        <button type="submit" onclick="return confirm('Membatalkan pergantian email?')" style="background:none;border:none;color:rgba(255,255,255,0.5);font-weight:700;cursor:pointer;padding:0;text-decoration:underline;" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
          Batal Pergantian
        </button>
      </form>
    </div>

  </div>
</div>
@endpush

@push('scripts')
<script>
let resendTimerInterval = null;

function startResendCountdown(seconds = 60) {
    if (resendTimerInterval) clearInterval(resendTimerInterval);

    const wrapper = document.getElementById('resend-timer-wrapper');
    const countEl = document.getElementById('resend-countdown');
    const formEl = document.getElementById('resend-otp-form');

    if (wrapper) wrapper.style.display = 'inline';
    if (formEl) formEl.style.display = 'none';

    let rem = seconds;
    const updateDisplay = () => {
        const m = String(Math.floor(rem / 60)).padStart(2, '0');
        const s = String(rem % 60).padStart(2, '0');
        if (countEl) countEl.innerText = `${m}:${s}`;
    };

    updateDisplay();
    resendTimerInterval = setInterval(() => {
        rem--;
        if (rem <= 0) {
            clearInterval(resendTimerInterval);
            if (wrapper) wrapper.style.display = 'none';
            if (formEl) formEl.style.display = 'inline';
        } else {
            updateDisplay();
        }
    }, 1000);
}

function openPasswordModal() {
    var modal = document.getElementById('password-modal');
    if (modal) modal.style.display = 'flex';
}

function closePasswordModal() {
    var modal = document.getElementById('password-modal');
    if (modal) {
        modal.style.display = 'none';
        var p1 = document.querySelector('input[name="password"]');
        var p2 = document.querySelector('input[name="password_confirmation"]');
        if (p1) p1.value = '';
        if (p2) p2.value = '';
    }
}

function openOtpEmailModal(email = null, hint = null) {
    var modal = document.getElementById('email-otp-modal');
    if (email) {
        var badge = document.getElementById('target-pending-email');
        if (badge) badge.innerText = email;
    }
    if (hint) {
        var hintBadge = document.getElementById('otp-dev-hint-badge');
        var hintCode = document.getElementById('dev-otp-code');
        if (hintBadge && hintCode) {
            hintCode.innerText = hint;
            hintBadge.style.display = 'block';
        }
    }
    if (modal) {
        modal.style.display = 'flex';
    }
    const firstBox = document.getElementById('otp-1');
    if (firstBox) setTimeout(() => { firstBox.focus(); firstBox.select(); }, 150);

    startResendCountdown(60);
}

function closeOtpEmailModal() {
    var modal = document.getElementById('email-otp-modal');
    if (modal) {
        modal.style.setProperty('display', 'none', 'important');
    }
}

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

document.addEventListener('DOMContentLoaded', function() {
    const boxes = [
        document.getElementById('otp-1'),
        document.getElementById('otp-2'),
        document.getElementById('otp-3'),
        document.getElementById('otp-4')
    ];
    const hiddenField = document.getElementById('otp-hidden-field');

    function syncOtp() {
        const val = boxes.map(b => b ? b.value : '').join('');
        if (hiddenField) hiddenField.value = val;
    }

    boxes.forEach((box, idx) => {
        if (!box) return;

        box.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 1 && idx < 3) {
                boxes[idx + 1].focus();
                boxes[idx + 1].select();
            }
            syncOtp();
        });

        box.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace') {
                if (!this.value && idx > 0) {
                    boxes[idx - 1].focus();
                    boxes[idx - 1].select();
                }
            } else if (e.key === 'ArrowLeft' && idx > 0) {
                boxes[idx - 1].focus();
            } else if (e.key === 'ArrowRight' && idx < 3) {
                boxes[idx + 1].focus();
            }
        });

        box.addEventListener('paste', function(e) {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
            if (text.length >= 4) {
                [0, 1, 2, 3].forEach(i => {
                    if (boxes[i]) boxes[i].value = text[i] || '';
                });
                if (boxes[3]) boxes[3].focus();
                syncOtp();
            }
        });
    });

    const otpForm = document.querySelector('#email-otp-modal form');
    if (otpForm) {
        otpForm.addEventListener('submit', function(e) {
            syncOtp();
            if (!hiddenField.value || hiddenField.value.length < 4) {
                e.preventDefault();
                alert('Harap isi 4 digit kode OTP secara lengkap.');
                if (boxes[0]) boxes[0].focus();
            }
        });
    }

    @if(session('require_otp_change_email') || !empty($peserta->pending_email))
        openOtpEmailModal("{{ $peserta->pending_email ?? session('pending_email') }}", "{{ $activeOtpHint }}");
    @endif
});
</script>
@endpush
