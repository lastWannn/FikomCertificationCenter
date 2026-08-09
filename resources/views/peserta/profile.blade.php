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

    {{-- ── SUCCESS / ERROR ALERTS ────────────────────────────── --}}
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
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div style="grid-column:1 / -1;">
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Instansi / Universitas / Perusahaan
                            </label>
                            <input type="text" name="instansi" value="{{ old('instansi',$peserta->instansi) }}" placeholder="Contoh: Universitas Muslim Indonesia" class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
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
    </div>

</div>

@endsection

@push('scripts')
<script>
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
