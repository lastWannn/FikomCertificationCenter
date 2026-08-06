@extends('layouts.admin')
@section('title', isset($arsip) ? 'Edit Arsip Kegiatan' : 'Tambah Arsip Kegiatan')
@section('page-content')
<div style="padding:24px;max-width:760px;margin:0 auto;width:100%;">
    
    {{-- Header --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.arsip.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;font-weight:600;" onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#6B7280'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Daftar Arsip
        </a>
        <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">{{ isset($arsip) ? 'Edit' : 'Tambah' }} Arsip Kegiatan</h1>
        <p style="color:#6B7280;font-size:13.5px;margin:0;">Lengkapi berita acara, ringkasan, dan dokumentasi foto-foto kegiatan.</p>
    </div>

    {{-- Card Form --}}
    <div class="fcc-card" style="padding:28px;border-radius:16px;">
        <form action="{{ isset($arsip) ? route('admin.arsip.update', $arsip) : route('admin.arsip.store') }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @if(isset($arsip)) @method('PUT') @endif

            @if(!isset($arsip))
            <div style="margin-bottom:18px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Pilih Kegiatan *</label>
                <select name="kegiatan_id" required class="fcc-input" style="font-size:13.5px;height:40px;">
                    <option value="">-- Pilih Kegiatan Selesai --</option>
                    @foreach($kegiatan as $k)
                    <option value="{{ $k->id }}">{{ $k->judul }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div style="margin-bottom:18px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Judul Arsip *</label>
                <input type="text" name="judul" value="{{ old('judul', isset($arsip) ? $arsip->judul : '') }}" placeholder="Judul ringkasan atau dokumentasi kegiatan" required class="fcc-input" style="font-size:13.5px;height:40px;">
            </div>

            <div style="margin-bottom:18px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">Ringkasan / Deskripsi Kegiatan</label>
                <textarea name="ringkasan" rows="4" placeholder="Tuliskan ringkasan hasil pelaksanaan kegiatan..." class="fcc-input" style="resize:vertical;font-size:13px;padding:10px 14px;">{{ old('ringkasan', isset($arsip) ? $arsip->ringkasan : '') }}</textarea>
            </div>

            <div style="margin-bottom:22px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">File Berita Acara (PDF / Lampiran)</label>
                <input type="file" name="berita_acara" accept=".pdf,.doc,.docx,.zip" class="fcc-input" style="padding:8px;font-size:12.5px;">
                @if(isset($arsip) && $arsip->berita_acara)
                <div style="margin-top:8px;font-size:12px;color:#10B981;display:flex;align-items:center;gap:6px;font-weight:700;">
                    @include('components.icon',['name'=>'file-text','size'=>14])
                    File terlampir: <a href="{{ asset('storage/'.$arsip->berita_acara) }}" target="_blank" style="color:#3B82F6;text-decoration:underline;">{{ basename($arsip->berita_acara) }}</a>
                </div>
                @endif
            </div>

            <hr style="border:none;border-top:1.5px dashed #E2E4EB;margin:22px 0;">

            {{-- UPLOAD FOTO DOKUMENTASI KEGIATAN --}}
            <div style="margin-bottom:24px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.7px;">
                    Upload Foto-Foto Dokumentasi Kegiatan
                </label>
                <p style="font-size:12px;color:#6B7280;margin:0 0 12px;">Anda dapat memilih sekaligus beberapa foto kegiatan (PNG, JPG, WEBP).</p>
                
                {{-- Input File Multiple --}}
                <label style="display:flex;align-items:center;justify-content:center;gap:10px;border:2px dashed #E2E4EB;border-radius:12px;padding:20px;cursor:pointer;background:#F8F9FB;transition:all .2s;"
                       onmouseover="this.style.borderColor='#FFC81A';this.style.background='#FFFDF5'"
                       onmouseout="this.style.borderColor='#E2E4EB';this.style.background='#F8F9FB'">
                    @include('components.icon',['name'=>'camera','size'=>22,'style'=>'color:#FFC81A'])
                    <div>
                        <p style="margin:0;font-size:13.5px;font-weight:800;color:#131218;">Klik untuk Pilih Foto Kegiatan</p>
                        <p style="margin:2px 0 0;font-size:11.5px;color:#9CA3B0;">Dapat memilih lebih dari 1 file foto sekaligus</p>
                    </div>
                    <input type="file" name="dokumentasi[]" accept="image/*" multiple style="display:none;" onchange="previewFotoDokumentasi(this)">
                </label>

                {{-- Preview Foto Baru yang Baru Dipilih --}}
                <div id="new-foto-preview-container" style="display:none;margin-top:14px;">
                    <p style="font-size:11px;font-weight:800;color:#6B7280;margin:0 0 8px;text-transform:uppercase;">Foto Baru Dipilih:</p>
                    <div id="new-foto-preview-grid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(90px, 1fr));gap:10px;"></div>
                </div>

                {{-- Foto Dokumentasi Yang Sudah Ter-upload Sebelumnya --}}
                @if(isset($arsip) && !empty($arsip->dokumentasi))
                <div style="margin-top:18px;">
                    <p style="font-size:11px;font-weight:800;color:#131218;margin:0 0 10px;text-transform:uppercase;">
                        Dokumentasi Foto Tersimpan ({{ count($arsip->dokumentasi) }} foto):
                    </p>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(110px, 1fr));gap:12px;">
                        @foreach($arsip->dokumentasi as $img)
                        <div style="position:relative;border-radius:10px;overflow:hidden;border:1.5px solid #E2E4EB;background:#F7F8FA;aspect-ratio:4/3;group:hover;">
                            <img src="{{ asset('storage/'.$img) }}" alt="Dokumentasi" style="width:100%;height:100%;object-fit:cover;">
                            
                            {{-- Checkbox Hapus Foto --}}
                            <label style="position:absolute;top:6px;right:6px;background:rgba(239,68,68,.9);color:#FFF;padding:3px 6px;border-radius:6px;font-size:10px;font-weight:800;cursor:pointer;display:flex;align-items:center;gap:3px;box-shadow:0 2px 6px rgba(0,0,0,.2);">
                                <input type="checkbox" name="delete_dokumentasi[]" value="{{ $img }}" style="cursor:pointer;accent-color:#EF4444;"> Hapus
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Buttons --}}
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:28px;">
                <a href="{{ route('admin.arsip.index') }}" class="fcc-btn-outline-dark" style="padding:10px 20px;font-size:13px;text-decoration:none;border-radius:10px;">
                    Batal
                </a>
                <button type="submit" class="fcc-btn-gold" style="padding:10px 28px;font-size:13px;border-radius:10px;font-weight:800;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                    @include('components.icon',['name'=>'check','size'=>15]) {{ isset($arsip) ? 'Simpan Perubahan' : 'Simpan Arsip' }}
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function previewFotoDokumentasi(input) {
    const container = document.getElementById('new-foto-preview-container');
    const grid = document.getElementById('new-foto-preview-grid');
    grid.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        container.style.display = 'block';
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgWrap = document.createElement('div');
                imgWrap.style.cssText = 'position:relative;border-radius:8px;overflow:hidden;border:1px solid #E2E4EB;aspect-ratio:4/3;background:#000;';
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width:100%;height:100%;object-fit:cover;';
                imgWrap.appendChild(img);
                grid.appendChild(imgWrap);
            }
            reader.readAsDataURL(file);
        });
    } else {
        container.style.display = 'none';
    }
}
</script>
@endsection
