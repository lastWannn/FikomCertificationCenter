@extends('layouts.admin')
@section('title', 'Pengaturan Kontak & Alamat')
@section('page-breadcrumb', 'Pengaturan / Kontak')
@section('page-content')

<style>
/* ─── Global Scoped Styles: Pengaturan Kontak ─────────────────── */
.fcc-kontak-container {
    padding: 24px 28px;
    max-width: 840px;
    margin: 0 auto;
    box-sizing: border-box;
    width: 100%;
}

/* ─── Header ─────────────────────────────────────────────────── */
.fcc-kontak-header {
    margin-bottom: 24px;
    text-align: left;
}
.fcc-kontak-badge-tag {
    font-size: 11px;
    font-weight: 900;
    color: #131218;
    background: #FFC81A;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1px solid #131218;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
    margin-bottom: 6px;
}
.fcc-kontak-title {
    font-size: 24px;
    font-weight: 900;
    color: #131218;
    margin: 0 0 4px;
    letter-spacing: -0.02em;
    font-family: 'Outfit', sans-serif;
    line-height: 1.25;
}
.fcc-kontak-subtitle {
    color: #64748B;
    font-size: 13.5px;
    margin: 0;
    font-weight: 500;
    line-height: 1.45;
}

/* ─── Main Form Card ─────────────────────────────────────────── */
.fcc-kontak-card {
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    border-radius: 22px;
    padding: 32px 34px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.03);
    box-sizing: border-box;
    width: 100%;
}

/* ─── Section Dividers ───────────────────────────────────────── */
.fcc-kontak-section {
    margin-bottom: 28px;
    padding-bottom: 24px;
    border-bottom: 1.5px dashed #E2E8F0;
}
.fcc-kontak-section:last-of-type {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.fcc-kontak-section-title {
    font-size: 13px;
    font-weight: 900;
    color: #131218;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'Outfit', sans-serif;
}
.fcc-kontak-section-icon {
    width: 26px;
    height: 26px;
    border-radius: 8px;
    background: #FFC81A;
    border: 1px solid #131218;
    color: #131218;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* ─── Form Controls ──────────────────────────────────────────── */
.fcc-kontak-form-group {
    margin-bottom: 18px;
}
.fcc-kontak-form-group:last-child {
    margin-bottom: 0;
}
.fcc-kontak-label {
    display: block;
    font-size: 11px;
    font-weight: 800;
    color: #64748B;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: .6px;
}
.fcc-kontak-input {
    width: 100% !important;
    font-size: 13.5px;
    height: 42px;
    background: #FFFFFF;
    border: 1.5px solid #CBD5E1;
    border-radius: 10px;
    font-weight: 600;
    box-sizing: border-box;
    padding: 0 14px;
    color: #131218;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
}
.fcc-kontak-input:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
    background: #FFFFFF;
}
.fcc-kontak-textarea {
    width: 100% !important;
    font-size: 13.5px;
    background: #FFFFFF;
    border: 1.5px solid #CBD5E1;
    border-radius: 10px;
    font-weight: 600;
    padding: 10px 14px;
    resize: vertical;
    box-sizing: border-box;
    color: #131218;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
    line-height: 1.5;
}
.fcc-kontak-textarea:focus {
    border-color: #FFC81A;
    box-shadow: 0 0 0 3px rgba(255, 200, 26, 0.15);
    background: #FFFFFF;
}
.fcc-kontak-grid-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 18px;
}
.fcc-kontak-help-text {
    font-size: 11.5px;
    color: #94A3B8;
    margin: 6px 0 0;
    font-weight: 500;
    line-height: 1.4;
}

/* ─── Maps Preview Container ─────────────────────────────────── */
.fcc-kontak-maps-preview {
    margin-top: 14px;
    background: #F8FAFC;
    border: 1.5px solid #E2E8F0;
    border-radius: 14px;
    padding: 12px;
    box-sizing: border-box;
}
.fcc-kontak-maps-preview-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    gap: 8px;
    flex-wrap: wrap;
}
.fcc-kontak-maps-preview-title {
    font-size: 12px;
    font-weight: 800;
    color: #334155;
    display: flex;
    align-items: center;
    gap: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.fcc-kontak-maps-wrapper {
    width: 100%;
    height: 240px;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #CBD5E1;
    background: #FFFFFF;
    position: relative;
    box-sizing: border-box;
}
.fcc-kontak-maps-wrapper iframe {
    width: 100% !important;
    height: 100% !important;
    border: 0 !important;
    display: block;
}
.fcc-kontak-maps-empty {
    width: 100%;
    height: 140px;
    border-radius: 10px;
    border: 1.5px dashed #CBD5E1;
    background: #FFFFFF;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 16px;
    box-sizing: border-box;
    gap: 6px;
}

/* ─── Form Footer & Submit Button ────────────────────────────── */
.fcc-kontak-form-footer {
    border-top: 1.5px solid #E2E4EB;
    padding-top: 22px;
    margin-top: 26px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
}
.fcc-kontak-btn-submit {
    padding: 10px 24px;
    font-size: 13.5px;
    font-weight: 900;
    background: #131218;
    color: #FFC81A;
    border: 1.5px solid #131218;
    border-radius: 12px;
    cursor: pointer;
    transition: all .15s ease-in-out;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 2px 2px 0px #131218;
    white-space: nowrap;
    min-height: 42px;
    box-sizing: border-box;
}
.fcc-kontak-btn-submit:hover {
    background: #FFC81A;
    color: #131218;
    transform: translateY(-1px);
    box-shadow: 2px 3px 0px #131218;
}
.fcc-kontak-btn-submit:active {
    transform: translateY(1px);
    box-shadow: 1px 1px 0px #131218;
}

/* ─── Responsive Breakpoints ─────────────────────────────────── */
/* Tablet / iPad (640px to 1023px) */
@media (max-width: 1023px) and (min-width: 640px) {
    .fcc-kontak-container {
        padding: 20px 16px;
        max-width: 100%;
    }
    .fcc-kontak-card {
        padding: 24px 22px;
        border-radius: 20px;
    }
    .fcc-kontak-grid-2col {
        gap: 12px;
    }
    .fcc-kontak-maps-wrapper {
        height: 220px;
    }
}

/* Mobile Devices (< 640px) */
@media (max-width: 639px) {
    .fcc-kontak-container {
        padding: 14px 12px;
    }
    .fcc-kontak-header {
        margin-bottom: 16px;
    }
    .fcc-kontak-title {
        font-size: 20px;
    }
    .fcc-kontak-subtitle {
        font-size: 12.5px;
    }
    .fcc-kontak-card {
        padding: 18px 14px;
        border-radius: 18px;
    }
    .fcc-kontak-section {
        margin-bottom: 22px;
        padding-bottom: 18px;
    }
    .fcc-kontak-grid-2col {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .fcc-kontak-input {
        min-height: 40px;
        font-size: 13px;
    }
    .fcc-kontak-textarea {
        font-size: 13px;
    }
    .fcc-kontak-maps-wrapper {
        height: 190px;
    }
    .fcc-kontak-form-footer {
        flex-direction: column;
        padding-top: 18px;
        margin-top: 20px;
    }
    .fcc-kontak-btn-submit {
        width: 100%;
        min-height: 44px;
        justify-content: center;
        font-size: 13.5px;
    }
}
</style>

<div class="fcc-kontak-container">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="padding:12px 18px;border-radius:14px;background:#ECFDF5;border:2px solid #10B981;color:#065F46;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 14px rgba(16,185,129,0.12);">
        <div style="display:flex;align-items:center;gap:10px;">
            @include('components.icon',['name'=>'check','size'=>18,'style'=>'color:#059669;flex-shrink:0'])
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#059669;cursor:pointer;font-size:20px;line-height:1;font-weight:900;">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div style="padding:12px 18px;border-radius:14px;background:#FEF2F2;border:2px solid #EF4444;color:#991B1B;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 14px rgba(239,68,68,0.12);">
        <div style="display:flex;align-items:center;gap:10px;">
            @include('components.icon',['name'=>'x','size'=>18,'style'=>'color:#DC2626;flex-shrink:0'])
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#DC2626;cursor:pointer;font-size:20px;line-height:1;font-weight:900;">&times;</button>
    </div>
    @endif

    {{-- Header --}}
    <div class="fcc-kontak-header">
        <span class="fcc-kontak-badge-tag">Pengaturan Website</span>
        <h1 class="fcc-kontak-title">Informasi Kontak &amp; Alamat</h1>
        <p class="fcc-kontak-subtitle">Atur email, nomor telepon, alamat, dan lokasi Google Maps yang akan ditampilkan di Landing Page publik.</p>
    </div>

    {{-- Form Card --}}
    <div class="fcc-card fcc-kontak-card">
        <form action="{{ route('admin.kontak.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- ── SECTION 1: PENANGGUNG JAWAB & KONTAK ── --}}
            <div class="fcc-kontak-section">
                <div class="fcc-kontak-section-title">
                    <span class="fcc-kontak-section-icon">
                        @include('components.icon',['name'=>'users','size'=>14])
                    </span>
                    <span>1. Penanggung Jawab &amp; Kontak Komunikasi</span>
                </div>

                {{-- Nama Penanggung Jawab --}}
                <div class="fcc-kontak-form-group">
                    <label class="fcc-kontak-label">Nama Kontak / Penanggung Jawab</label>
                    <input type="text" name="nama" class="fcc-input fcc-kontak-input" value="{{ old('nama', $kontak->nama ?? '') }}" placeholder="Contoh: Admin FCC / Wawan">
                    <p class="fcc-kontak-help-text">
                        💡 Jika diisi, di halaman depan nomor telepon akan ditampilkan dengan format: <strong>Nomor (Nama)</strong>.
                    </p>
                </div>

                {{-- Email & Telepon Row --}}
                <div class="fcc-kontak-grid-2col" style="margin-top:16px;">
                    <div>
                        <label class="fcc-kontak-label">Alamat Email Resmi *</label>
                        <input type="email" name="email" required class="fcc-input fcc-kontak-input" value="{{ old('email', $kontak->email ?? '') }}" placeholder="contoh: fcc@fikom.umi.ac.id">
                        @error('email')
                        <p style="color:#EF4444;font-size:11.5px;margin:4px 0 0;font-weight:700;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="fcc-kontak-label">Nomor Telepon / WhatsApp *</label>
                        <input type="text" name="telepon" required class="fcc-input fcc-kontak-input" value="{{ old('telepon', $kontak->telepon ?? '') }}" placeholder="contoh: (0411) 455 855 / 081234567890" oninput="this.value = this.value.replace(/[^0-9\+\-\(\)\/\s]/g, '')">
                        @error('telepon')
                        <p style="color:#EF4444;font-size:11.5px;margin:4px 0 0;font-weight:700;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ── SECTION 2: ALAMAT LENGKAP ── --}}
            <div class="fcc-kontak-section">
                <div class="fcc-kontak-section-title">
                    <span class="fcc-kontak-section-icon">
                        @include('components.icon',['name'=>'map-pin','size'=>14])
                    </span>
                    <span>2. Lokasi &amp; Alamat Fisik Kantor / Kampus</span>
                </div>

                <div class="fcc-kontak-form-group">
                    <label class="fcc-kontak-label">Alamat Lengkap Kantor / Kampus *</label>
                    <textarea name="alamat" required class="fcc-input fcc-kontak-textarea" rows="3" placeholder="Jl. Urip Sumoharjo No.225, Gedung Fakultas Ilmu Komputer, Universitas Muslim Indonesia...">{{ old('alamat', $kontak->alamat ?? '') }}</textarea>
                    @error('alamat')
                    <p style="color:#EF4444;font-size:11.5px;margin:4px 0 0;font-weight:700;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- ── SECTION 3: GOOGLE MAPS EMBED & LIVE PREVIEW ── --}}
            <div class="fcc-kontak-section">
                <div class="fcc-kontak-section-title">
                    <span class="fcc-kontak-section-icon">
                        @include('components.icon',['name'=>'globe','size'=>14])
                    </span>
                    <span>3. Sematan Google Maps (Embed Map)</span>
                </div>

                <div class="fcc-kontak-form-group">
                    <label class="fcc-kontak-label">Kode HTML Embed Google Maps (&lt;iframe&gt;) *</label>
                    <textarea name="maps_embed" id="fcc-maps-input" class="fcc-input fcc-kontak-textarea" rows="4" placeholder='<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>' style="font-family:'JetBrains Mono',monospace;font-size:12px;letter-spacing:0.3px;">{{ old('maps_embed', $kontak->maps_embed ?? '') }}</textarea>
                    
                    <p class="fcc-kontak-help-text">
                        💡 <strong>Cara mendapatkan kode embed:</strong> Buka Google Maps &rarr; Cari lokasi kampus &rarr; Klik tombol <em>Bagikan (Share)</em> &rarr; Pilih tab <em>Sematkan Peta (Embed a map)</em> &rarr; Klik <em>Salin HTML</em> lalu tempelkan di sini.
                    </p>

                    {{-- Live Preview Box --}}
                    <div class="fcc-kontak-maps-preview">
                        <div class="fcc-kontak-maps-preview-header">
                            <span class="fcc-kontak-maps-preview-title">
                                @include('components.icon',['name'=>'map-pin','size'=>13,'style'=>'color:#131218;'])
                                <span>Pratinjau Peta Lokasi (Live Preview)</span>
                            </span>
                            @if(!empty($kontak->maps_embed))
                            <span style="font-size:11px;font-weight:800;color:#059669;background:#ECFDF5;padding:2px 8px;border-radius:12px;border:1px solid #10B981;">
                                ✓ Embed Aktif
                            </span>
                            @else
                            <span style="font-size:11px;font-weight:700;color:#64748B;background:#F1F5F9;padding:2px 8px;border-radius:12px;border:1px solid #CBD5E1;">
                                Belum Terpasang
                            </span>
                            @endif
                        </div>

                        <div id="fcc-maps-preview-box">
                            @if(!empty($kontak->maps_embed))
                            <div class="fcc-kontak-maps-wrapper">
                                {!! $kontak->maps_embed !!}
                            </div>
                            @else
                            <div class="fcc-kontak-maps-empty">
                                <div style="width:36px;height:36px;border-radius:10px;background:#F1F5F9;display:flex;align-items:center;justify-content:center;color:#94A3B8;">
                                    @include('components.icon',['name'=>'map-pin','size'=>18])
                                </div>
                                <p style="font-size:12px;font-weight:800;color:#475569;margin:0;">Belum Ada Sematan Peta</p>
                                <p style="font-size:11px;color:#94A3B8;margin:0;">Salin kode iframe dari Google Maps lalu simpan untuk melihat peta di sini.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── FOOTER SUBMIT ── --}}
            <div class="fcc-kontak-form-footer">
                <button type="submit" class="fcc-kontak-btn-submit">
                    @include('components.icon',['name'=>'check','size'=>16])
                    <span>Simpan Pengaturan Kontak</span>
                </button>
            </div>

        </form>
    </div>

</div>

@endsection
