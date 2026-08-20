@extends('layouts.peserta')
@section('title', 'Beri Testimoni')
@section('page-title', 'Beri Testimoni')
@section('page-content')

<div style="padding:24px 28px;background:#F6F8FB;min-height:100vh;font-family:'Inter',sans-serif;">

    {{-- ═══ HERO BANNER ═════════════════════════════════════════════ --}}
    <div style="background:linear-gradient(135deg, #131218 0%, #1F1D2B 100%);border-radius:22px;padding:28px 32px;margin-bottom:24px;position:relative;overflow:hidden;border:2px solid #FFC81A;box-shadow:0 12px 36px rgba(19,18,24,0.18);">
        <div style="position:absolute;top:-40px;right:-30px;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle, rgba(255,200,26,0.15) 0%, transparent 70%);pointer-events:none;"></div>
        <div style="position:relative;z-index:2;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:18px;">
            <div>
                <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,200,26,0.15);border:1px solid #FFC81A;padding:4px 12px;border-radius:20px;margin-bottom:10px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#FFC81A;"></span>
                    <span style="font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;">Kata Mereka / Testimoni Peserta</span>
                </div>
                <h1 style="color:#FFFFFF;font-size:22px;font-weight:900;margin:0 0 6px;letter-spacing:-0.02em;">
                    Bagikan Pengalaman Anda di FCC UMI &#11508;
                </h1>
                <p style="color:#94A3B8;font-size:13px;margin:0;font-weight:500;max-width:580px;line-height:1.6;">
                    Ulasan &amp; kesan Anda sangat berarti bagi calon peserta lainnya. Testimoni yang Anda tulis akan langsung tampil pada halaman utama (Landing Page) FIKOM Certification Center.
                </p>
            </div>
            @if($testimoni)
            <div style="background:#24232C;border:1.5px solid #FFC81A;border-radius:16px;padding:14px 20px;text-align:center;">
                <span style="font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;display:block;margin-bottom:4px;">Status Testimoni</span>
                <span style="font-size:12.5px;font-weight:900;padding:4px 12px;border-radius:20px;background:{{ $testimoni->status==='dipublikasikan'?'#ECFDF5':'#FFFDF5' }};color:{{ $testimoni->status==='dipublikasikan'?'#059669':'#D97706' }};border:1px solid {{ $testimoni->status==='dipublikasikan'?'#10B981':'#F59E0B' }};display:inline-block;">
                    {{ $testimoni->status==='dipublikasikan' ? '✓ Dipublikasikan (Live)' : '⌛ Menunggu Peninjauan' }}
                </span>
            </div>
            @endif
        </div>
    </div>

    @if(session('warning'))
    <div style="margin-bottom:24px;padding:16px 20px;background:#FFFBEB;border:2px solid #F59E0B;border-radius:18px;color:#B45309;font-size:13.5px;font-weight:700;display:flex;align-items:center;gap:14px;box-shadow:0 6px 18px rgba(245,158,11,0.18);">
        <div style="width:38px;height:38px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div>
            <p style="margin:0;font-size:14px;font-weight:900;color:#92400E;">Wajib Mengisi Testimoni</p>
            <p style="margin:2px 0 0;font-size:13px;color:#B45309;font-weight:600;">{{ session('warning') }}</p>
        </div>
    </div>
    @endif

    {{-- ═══ MAIN CONTENT CARD ═══════════════════════════════════════ --}}
    <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:24px;align-items:start;">
        
        {{-- Left: Form Testimoni --}}
        <div style="background:#FFFFFF;border-radius:22px;border:2px solid #E5E7EB;padding:28px;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;border-bottom:2px solid #F1F5F9;padding-bottom:14px;">
                <div style="width:36px;height:36px;border-radius:10px;background:#FFC81A;border:1px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;">
                    @include('components.icon',['name'=>'message-square','size'=>18])
                </div>
                <div>
                    <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">
                        {{ $testimoni ? 'Edit Testimoni Saya' : 'Tulis Testimoni Baru' }}
                    </h3>
                    <p style="margin:2px 0 0;font-size:11.5px;color:#64748B;">Lengkapi formulir di bawah ini dengan ulasan jujur Anda.</p>
                </div>
            </div>

            <form action="{{ $testimoni ? route('peserta.testimoni.update', $testimoni->id) : route('peserta.testimoni.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($testimoni)
                    @method('PUT')
                @endif

                {{-- Nama (Auto-filled) --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:900;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.6px;">Nama Lengkap (Akun Anda)</label>
                    <input type="text" value="{{ $peserta->nama }}" readonly style="width:100%;background:#F8FAFC;border:1.5px solid #CBD5E1;border-radius:12px;padding:11px 16px;color:#131218;font-size:13.5px;font-weight:700;outline:none;box-sizing:border-box;">
                </div>

                {{-- Rating Bintang --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:900;color:#64748B;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.6px;">Beri Rating Penilaian *</label>
                    <div style="display:flex;gap:8px;align-items:center;">
                        @php $currentRating = old('rating', $testimoni->rating ?? 5); @endphp
                        <select name="rating" id="rating-select" required style="background:#FFF;border:1.5px solid #131218;border-radius:12px;padding:10px 16px;font-size:14px;font-weight:800;color:#131218;outline:none;cursor:pointer;">
                            <option value="5" {{ $currentRating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 / 5) Sangat Puas</option>
                            <option value="4" {{ $currentRating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 / 5) Puas</option>
                            <option value="3" {{ $currentRating == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 / 5) Cukup</option>
                            <option value="2" {{ $currentRating == 2 ? 'selected' : '' }}>⭐⭐ (2 / 5) Kurang</option>
                            <option value="1" {{ $currentRating == 1 ? 'selected' : '' }}>⭐ (1 / 5) Sangat Kurang</option>
                        </select>
                    </div>
                    @error('rating') <p style="color:#EF4444;font-size:12px;margin:4px 0 0;">{{ $message }}</p> @enderror
                </div>

                {{-- Keterangan / Status --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:900;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.6px;">Keterangan / Status Anda *</label>
                    <input type="text" name="keterangan" id="f-keterangan" value="{{ old('keterangan', $testimoni->keterangan ?? '') }}" required placeholder="Contoh: Peserta Pelatihan Web Dev, Mahasiswa FIKOM UMI" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:12px;padding:11px 16px;color:#131218;font-size:13.5px;font-weight:600;outline:none;box-sizing:border-box;">
                    
                    @if(isset($kegiatanTerdaftar) && $kegiatanTerdaftar->isNotEmpty())
                    <div style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                        <span style="font-size:10.5px;color:#64748B;font-weight:700;">Rekomendasi Label:</span>
                        @foreach($kegiatanTerdaftar->take(3) as $pd)
                        @php $suggest = 'Peserta '.ucfirst($pd->kegiatan->jenis_kegiatan).' '.Str::limit($pd->kegiatan->judul, 25); @endphp
                        <button type="button" onclick="document.getElementById('f-keterangan').value = '{{ addslashes($suggest) }}';" style="font-size:10.5px;font-weight:800;padding:3px 10px;border-radius:20px;background:#F1F5F9;border:1px solid #CBD5E1;color:#131218;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.borderColor='#CBD5E1';">
                            + {{ Str::limit($pd->kegiatan->judul, 22) }}
                        </button>
                        @endforeach
                    </div>
                    @endif
                    @error('keterangan') <p style="color:#EF4444;font-size:12px;margin:4px 0 0;">{{ $message }}</p> @enderror
                </div>

                {{-- Kata / Ulasan --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:900;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.6px;">Ulasan / Kesan Peserta *</label>
                    <textarea name="kata" rows="5" required placeholder="Tuliskan pengalaman Anda mengikuti program pelatihan atau sertifikasi di FIKOM Certification Center..." style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:12px;padding:12px 16px;color:#131218;font-size:13.5px;font-weight:500;outline:none;box-sizing:border-box;resize:vertical;line-height:1.6;">{{ old('kata', $testimoni->kata ?? '') }}</textarea>
                    @error('kata') <p style="color:#EF4444;font-size:12px;margin:4px 0 0;">{{ $message }}</p> @enderror
                </div>

                {{-- Sync Avatar Badge --}}
                <div style="margin-bottom:24px;padding:14px 18px;background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:14px;display:flex;align-items:center;gap:14px;">
                    <div style="width:44px;height:44px;border-radius:50%;background:#FFC81A;border:2px solid #131218;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:18px;color:#131218;flex-shrink:0;">
                        {{ Str::upper(Str::substr($peserta->nama, 0, 1)) }}
                    </div>
                    <div>
                        <p style="margin:0;font-size:12.5px;font-weight:800;color:#131218;">Foto &amp; Nama Otomatis Terhubung</p>
                        <p style="margin:2px 0 0;font-size:11.5px;color:#64748B;">Identitas testimoni disinkronkan secara otomatis sesuai akun resmi Anda ({{ $peserta->nama }}).</p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div style="display:flex;gap:12px;align-items:center;">
                    <button type="submit" style="padding:12px 28px;font-size:13.5px;font-weight:900;background:#131218;color:#FFC81A;border:2px solid #131218;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;gap:8px;box-shadow:0 6px 18px rgba(19,18,24,0.2);transition:all .2s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                        @include('components.icon',['name'=>'check-circle','size'=>16])
                        {{ $testimoni ? 'Simpan Perubahan' : 'Kirim & Simpan Testimoni' }}
                    </button>

                    @if($testimoni)
                    <button type="button" onclick="if(confirm('Apakah Anda yakin ingin menghapus testimoni ini?')) document.getElementById('delete-testimoni-form').submit();" style="padding:12px 20px;font-size:13px;font-weight:800;background:#FEF2F2;color:#EF4444;border:1.5px solid #FCA5A5;border-radius:30px;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';">
                        Hapus Testimoni
                    </button>
                    @endif
                </div>
            </form>

            @if($testimoni)
            <form id="delete-testimoni-form" action="{{ route('peserta.testimoni.destroy', $testimoni->id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>

        {{-- Right: Live Preview Card --}}
        <div style="background:#131218;border-radius:22px;border:2px solid #FFC81A;padding:26px;color:#FFFFFF;box-shadow:0 8px 30px rgba(0,0,0,0.2);position:sticky;top:24px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;border-bottom:1px solid rgba(255,255,255,0.12);padding-bottom:14px;">
                <span style="font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:1px;">Pratinjau Tampilan (Landing Page)</span>
                <span style="width:8px;height:8px;border-radius:50%;background:#10B981;box-shadow:0 0 10px #10B981;"></span>
            </div>

            <div style="background:#1E1D26;border:1.5px solid rgba(255,200,26,0.3);border-radius:18px;padding:24px;position:relative;">
                {{-- Stars --}}
                <div style="display:flex;gap:4px;margin-bottom:14px;">
                    @for($i=0; $i<5; $i++)
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="{{ $i < ($testimoni->rating ?? 5) ? '#FFC81A' : 'rgba(255,255,255,.2)' }}"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    @endfor
                </div>

                {{-- Quote --}}
                <p style="color:#FFFFFF;font-size:14px;line-height:1.65;margin:0 0 24px;font-style:italic;">
                    "{{ $testimoni->kata ?? 'Tulis ulasan Anda pada formulir di samping untuk melihat pratinjau kartu testimoni yang akan tayang di landing page.' }}"
                </p>

                {{-- Author Profile --}}
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:44px;height:44px;border-radius:50%;background:#FFC81A;border:2px solid #FFFFFF;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;color:#131218;">
                        @if($testimoni && $testimoni->foto)
                            <img src="{{ asset('storage/'.$testimoni->foto) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <span style="font-size:17px;font-weight:900;">{{ Str::upper(Str::substr($peserta->nama, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <h4 style="color:#FFFFFF;font-size:14px;font-weight:800;margin:0 0 2px;">{{ $peserta->nama }}</h4>
                        <p style="color:#FFC81A;font-size:11px;margin:0;font-weight:700;">{{ $testimoni->keterangan ?? 'Peserta FIKOM Certification Center' }}</p>
                    </div>
                </div>
            </div>

            <div style="margin-top:20px;text-align:center;">
                <a href="{{ route('landing.index') }}#testimoni" target="_blank" style="color:#FFC81A;font-size:12px;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                    Lihat Section Kata Mereka di Landing Page &rarr;
                </a>
            </div>
        </div>

    </div>

</div>

@endsection
