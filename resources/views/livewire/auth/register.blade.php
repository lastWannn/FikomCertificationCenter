<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;">

    <div style="background:#FFF;border-radius:20px;padding:40px 36px;width:100%;max-width:560px;
                box-shadow:0 24px 64px rgba(0,0,0,.3);" class="animate-fadeUp">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:28px;">
            <div style="width:52px;height:52px;border-radius:14px;background:#131218;
                        display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5" stroke-linecap="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <h1 style="font-size:20px;font-weight:900;color:#131218;margin:0 0 4px;">Daftar Akun Peserta</h1>
            <p style="font-size:13px;color:#9CA3B0;margin:0;">Gratis · Langsung aktif setelah daftar</p>
        </div>

        <form wire:submit="register">

            {{-- Nama --}}
            <div style="margin-bottom:14px;">
                <label class="form-label-fcc">Nama Lengkap *</label>
                <input type="text" wire:model="nama" placeholder="Nama kamu" class="fcc-input"
                       onkeydown="if(event.key==='Enter')event.preventDefault();">
                @error('nama')<p class="form-error-fcc">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom:14px;">
                <label class="form-label-fcc">Email *</label>
                <input type="email" wire:model.live.debounce.500ms="email"
                       placeholder="email@example.com" class="fcc-input"
                       onkeydown="if(event.key==='Enter')event.preventDefault();">
                @error('email')<p class="form-error-fcc">{{ $message }}</p>@enderror
            </div>

            {{-- No HP + Kelamin --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                <div>
                    <label class="form-label-fcc">No. HP *</label>
                    <input type="text" wire:model="no_hp" placeholder="08xxxxxxxxxx" class="fcc-input"
                           onkeydown="if(event.key==='Enter')event.preventDefault();">
                    @error('no_hp')<p class="form-error-fcc">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label-fcc">Jenis Kelamin *</label>
                    <select wire:model="kelamin" class="fcc-input">
                        <option value="">Pilih...</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    @error('kelamin')<p class="form-error-fcc">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Instansi --}}
            <div style="margin-bottom:14px;">
                <label class="form-label-fcc">Instansi / Asal</label>
                <input type="text" wire:model="instansi" placeholder="Universitas / Perusahaan (opsional)"
                       class="fcc-input" onkeydown="if(event.key==='Enter')event.preventDefault();">
            </div>

            {{-- Password --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:18px;">
                <div>
                    <label class="form-label-fcc">Password *</label>
                    <div style="position:relative;">
                        <input :type="$wire.showPassword ? 'text' : 'password'"
                               wire:model="password" placeholder="Min. 8 karakter" class="fcc-input"
                               style="padding-right:40px;"
                               onkeydown="if(event.key==='Enter')event.preventDefault();">
                        <button type="button" wire:click="togglePassword"
                                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9CA3B0;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                @if($showPassword)
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>
                                @else
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                @endif
                            </svg>
                        </button>
                    </div>
                    @error('password')<p class="form-error-fcc">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label-fcc">Ulangi Password *</label>
                    <input :type="$wire.showPassword ? 'text' : 'password'"
                           wire:model="password_confirmation" placeholder="Ulangi password"
                           class="fcc-input"
                           onkeydown="if(event.key==='Enter')event.preventDefault();">
                </div>
            </div>

            {{-- Agree --}}
            <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:22px;
                        background:#F7F8FA;border-radius:10px;padding:12px 14px;">
                <input type="checkbox" id="agree" wire:model="agree"
                       style="width:16px;height:16px;accent-color:#FFC81A;cursor:pointer;flex-shrink:0;margin-top:2px;">
                <label for="agree" style="font-size:13px;color:#5A6275;cursor:pointer;line-height:1.5;">
                    Saya menyetujui
                    <a href="{{ route('landing.profil') }}" target="_blank"
                       style="color:#FFC81A;font-weight:700;text-decoration:none;">syarat & ketentuan</a>
                    serta kebijakan privasi FCC UMI.
                </label>
            </div>
            @error('agree')<p class="form-error-fcc" style="margin-top:-14px;margin-bottom:12px;">{{ $message }}</p>@enderror

            {{-- Submit --}}
            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-70"
                    class="fcc-btn-dark"
                    style="width:100%;justify-content:center;padding:12px;font-size:15px;font-weight:800;border:none;cursor:pointer;">
                <span wire:loading.remove>Buat Akun Sekarang</span>
                <span wire:loading>Memproses...</span>
            </button>
        </form>

        <p style="text-align:center;font-size:14px;color:#6B7280;margin:20px 0 0;">
            Sudah punya akun?
            <a href="{{ route('auth.login') }}"
               style="color:#FFC81A;font-weight:700;text-decoration:none;">Masuk</a>
        </p>
    </div>
</div>

<style>
.form-label-fcc { font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px; }
.form-error-fcc { color:#EF4444;font-size:12px;margin:4px 0 0; }
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.animate-fadeUp { animation: fadeUp .5s cubic-bezier(.175,.885,.32,1.275) both; }
@keyframes spin { to { transform: rotate(360deg); } }
</style>
