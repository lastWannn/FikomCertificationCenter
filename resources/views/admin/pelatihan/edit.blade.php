@extends('layouts.admin')
@section('title','Edit Pelatihan')
@section('page-content')
<div style="padding:24px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.pelatihan.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Edit Pelatihan</h1>
        <p style="color:#6B7280;font-size:14px;margin:0;">Perbarui informasi program: <strong>{{ $pelatihan->judul }}</strong></p>
    </div>
    
    @php $edit = isset($pelatihan); @endphp
    <form action="{{ $edit ? route('admin.pelatihan.update', $pelatihan) : route('admin.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($edit) @method('PUT') @endif
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
            {{-- Kolom kiri --}}
            <div>
                <div class="fcc-card" style="padding:24px;margin-bottom:16px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 18px;">Informasi Program</h3>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kode Program *</label>
                        <input type="text" name="kode" value="{{ old('kode',$pelatihan->kode??'') }}" placeholder="PLT-001" required class="fcc-input" {{ $edit?'readonly':'' }}>
                        @error('kode')<p style="color:#EF4444;font-size:12px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Judul Pelatihan *</label>
                        <input type="text" name="judul" value="{{ old('judul',$pelatihan->judul??'') }}" placeholder="Judul program pelatihan" required class="fcc-input">
                        @error('judul')<p style="color:#EF4444;font-size:12px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Deskripsi / Silabus *</label>
                        <textarea name="isi" rows="8" placeholder="Deskripsi lengkap program pelatihan..." required class="fcc-input" style="resize:vertical;">{{ old('isi',$pelatihan->isi??'') }}</textarea>
                        @error('isi')<p style="color:#EF4444;font-size:12px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="fcc-card" style="padding:24px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 18px;">Link & Materi</h3>
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Link Materi (Google Drive, YouTube, dst)</label>
                        <input type="url" name="link_materi" value="{{ old('link_materi',$pelatihan->link_materi??'') }}" placeholder="https://" class="fcc-input">
                    </div>
                </div>
            </div>
            {{-- Kolom kanan --}}
            <div>
                <div class="fcc-card" style="padding:24px;margin-bottom:16px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 18px;">Pengaturan</h3>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kategori *</label>
                        <select name="kategori_id" required class="fcc-input">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id',$pelatihan->kategori_id??'')==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="fcc-card" style="padding:24px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 14px;">Gambar / Poster</h3>
                    @if($edit && $pelatihan->gambar)
                    <img src="{{ asset('storage/'.$pelatihan->gambar) }}" alt="Poster" style="width:100%;border-radius:10px;margin-bottom:12px;object-fit:cover;max-height:160px;">
                    @endif
                    <label style="display:flex;flex-direction:column;align-items:center;justify-content:center;border:2px dashed #E2E4EB;border-radius:10px;padding:24px;cursor:pointer;gap:8px;transition:border-color .2s;"
                           onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                        @include('components.icon',['name'=>'image','size'=>28,'style'=>'color:#A0A3AD'])
                        <span style="font-size:13px;color:#6B7280;">Klik untuk upload gambar</span>
                        <span style="font-size:11px;color:#A0A3AD;">JPG, PNG, max 2MB</span>
                        <input type="file" name="gambar" accept="image/*" style="display:none;" onchange="previewGambar(this)">
                    </label>
                    <img id="gambar-preview" style="display:none;width:100%;border-radius:10px;margin-top:10px;object-fit:cover;max-height:140px;" alt="Preview">
                </div>
            </div>
        </div>
        {{-- Actions --}}
        <div style="display:flex;gap:10px;margin-top:18px;">
            <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">
                @include('components.icon',['name'=>'check','size'=>15]) {{ $edit ? 'Perbarui Pelatihan' : 'Simpan Pelatihan' }}
            </button>
            <a href="{{ route('admin.pelatihan.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;display:flex;align-items:center;gap:8px;">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection
@push('scripts')
@vite('resources/js/pages/admin-pelatihan-form.js')
@endpush
