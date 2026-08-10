<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;">

    {{-- Card --}}
    <div style="background:#FFF;border-radius:20px;padding:40px 36px;width:100%;max-width:420px;
                box-shadow:0 24px 64px rgba(0,0,0,.3);" class="animate-fadeUp">

        {{-- Logo --}}
        <div style="text-align:center;margin-bottom:32px;">
            <div style="width:56px;height:56px;border-radius:16px;background:#131218;
                        display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5" stroke-linecap="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <h1 style="font-size:20px;font-weight:900;color:#131218;margin:0 0 4px;">Masuk ke FCC</h1>
            <p style="font-size:13px;color:#9CA3B0;margin:0;">FIKOM Certification Center — UMI</p>
        </div>

        {{-- Error global (dari $errors) --}}
        @if($errors->any() && !$errors->has('email') && !$errors->has('password'))
        <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:10px;
                    padding:12px 14px;margin-bottom:18px;color:#DC2626;font-size:13px;font-weight:600;">
            {{ $errors->first() }}
        </div>
        @endif

        <form wire:submit="login">

            {{-- Email --}}
            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;
                              margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">
                    Email
                </label>
                <input type="email"
                       wire:model="email"
                       autocomplete="email"
                       placeholder="email@example.com"
                       class="fcc-input"
                       style="{{ $errors->has('email') ? 'border-color:#EF4444;' : '' }}">
                @error('email')
                <p style="color:#EF4444;font-size:12px;margin:5px 0 0;display:flex;align-items:center;gap:4px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom:20px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;
                              margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">
                    Password
                </label>
                <div style="position:relative;">
                    <input :type="$wire.showPassword ? 'text' : 'password'"
                           wire:model="password"
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="fcc-input"
                           style="padding-right:44px;{{ $errors->has('password') ? 'border-color:#EF4444;' : '' }}">
                    {{-- Toggle show/hide password --}}
                    <button type="button"
                            wire:click="togglePassword"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);
                                   background:none;border:none;cursor:pointer;color:#9CA3B0;padding:0;
                                   display:flex;align-items:center;">
                        @if($showPassword)
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                            <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                            <line x1="1" y1="1" x2="23" y2="23"/>
                        </svg>
                        @else
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        @endif
                    </button>
                </div>
                @error('password')
                <p style="color:#EF4444;font-size:12px;margin:5px 0 0;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me --}}
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
                <input type="checkbox" id="remember" wire:model="remember"
                       style="width:16px;height:16px;accent-color:#FFC81A;cursor:pointer;">
                <label for="remember" style="font-size:13px;color:#6B7280;cursor:pointer;">
                    Ingat saya
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-70"
                    class="fcc-btn-gold"
                    style="width:100%;justify-content:center;padding:12px;font-size:15px;
                           font-weight:800;border:none;cursor:pointer;">
                <span wire:loading.remove>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline;margin-right:6px;vertical-align:middle;">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Masuk
                </span>
                <span wire:loading>Memproses...</span>
            </button>
        </form>

        {{-- Divider --}}
        <div style="display:flex;align-items:center;gap:12px;margin:24px 0;">
            <div style="flex:1;height:1px;background:#E2E4EB;"></div>
            <span style="color:#C0C4CF;font-size:12px;">atau</span>
            <div style="flex:1;height:1px;background:#E2E4EB;"></div>
        </div>

        {{-- Link ke register --}}
        <p style="text-align:center;font-size:14px;color:#6B7280;margin:0;">
            Belum punya akun?
            <a href="{{ route('auth.register') }}"
               style="color:#FFC81A;font-weight:700;text-decoration:none;">
                Daftar Sekarang
            </a>
        </p>

        {{-- Link lupa password --}}
        <p style="text-align:center;font-size:13px;color:#9CA3B0;margin:12px 0 0;">
            <a href="{{ route('auth.forgot') }}"
               style="color:#9CA3B0;text-decoration:none;transition:color .15s;"
               onmouseover="this.style.color='#131218'"
               onmouseout="this.style.color='#9CA3B0'">
                Lupa password?
            </a>
        </p>

    </div>
</div>

<style>
@keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
.animate-fadeUp { animation: fadeUp .5s cubic-bezier(.175,.885,.32,1.275) both; }
@keyframes spin { to { transform: rotate(360deg); } }
</style>
