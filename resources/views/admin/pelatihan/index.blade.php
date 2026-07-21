@extends('layouts.admin')
@section('title','Pelatihan')
@section('page-content')
<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Program Pelatihan</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Kelola semua program pelatihan yang tersedia.</p>
        </div>
        <button type="button" onclick="document.getElementById('create-modal').classList.remove('hidden')" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:6px;font-weight:700;border-radius:10px;">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Pelatihan
        </button>
    </div>
    <div class="fcc-card" style="padding:0;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                    <th style="padding:12px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Kode</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Judul</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Kategori</th>

                    <th style="padding:12px 20px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelatihan as $p)
                <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                    <td style="padding:12px 20px;font-size:13px;font-weight:700;color:#FFC81A;font-family:monospace;">{{ $p->kode }}</td>
                    <td style="padding:12px 12px;">
                        <p style="font-size:14px;font-weight:700;color:#0F0F14;margin:0;">{{ $p->judul }}</p>
                        <p style="font-size:11px;color:#A0A3AD;margin:2px 0 0;">{{ $p->jadwal()->count() }} jadwal &bull; {{ $p->materi()->count() }} materi</p>
                    </td>
                    <td style="padding:12px 12px;font-size:13px;color:#6B7280;">{{ $p->kategori->nama_kategori ?? '-' }}</td>

                    <td style="padding:12px 20px;text-align:center;">
                        <div style="display:inline-flex;gap:8px;">
                            <a href="{{ route('admin.pelatihan.show', $p) }}" title="Detail" style="color:#3B82F6;display:flex;">@include('components.icon',['name'=>'eye','size'=>16])</a>
                            <a href="{{ route('admin.pelatihan.edit', $p) }}" title="Edit" style="color:#FFC81A;display:flex;">@include('components.icon',['name'=>'edit','size'=>16])</a>
                            <form action="{{ route('admin.pelatihan.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pelatihan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus" style="background:none;border:none;cursor:pointer;color:#EF4444;display:flex;padding:0;">@include('components.icon',['name'=>'trash','size'=>16])</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:32px;text-align:center;color:#A0A3AD;font-size:14px;">Belum ada data pelatihan.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($pelatihan->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;">{{ $pelatihan->links() }}</div>
        @endif
    </div>
</div>

{{-- ── TAMBAH PELATIHAN MODAL ────────────────────────────────────── --}}
<div id="create-modal" class="hidden" style="position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.55);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;">
    <div style="background:#FFF;border-radius:18px;padding:32px 28px;max-width:680px;width:90%;position:relative;box-shadow:0 24px 64px rgba(0,0,0,.18);max-height:90vh;overflow-y:auto;">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" aria-label="Tutup" style="
            position:absolute;top:18px;right:18px;width:28px;height:28px;
            border:none;background:none;cursor:pointer;color:#9CA3B0;
            font-size:20px;line-height:1;border-radius:8px;transition:background .15s;"
            onmouseover="this.style.background='#F7F8FA'"
            onmouseout="this.style.background='none'">&#215;</button>

        <div style="margin-bottom:20px;">
            <h2 style="font-size:18px;font-weight:900;color:#0F0F14;margin:0 0 4px;">Tambah Program Pelatihan</h2>
            <p style="color:#6B7280;font-size:13px;margin:0;">Isi informasi program pelatihan baru.</p>
        </div>

        <form action="{{ route('admin.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:14px;">
                <div>
                    <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kode Program *</label>
                    <input type="text" name="kode" value="{{ old('kode') }}" placeholder="PLT-001" required class="fcc-input">
                    @error('kode')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kategori *</label>
                    <select name="kategori_id" required class="fcc-input">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id')==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Judul Pelatihan *</label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Judul program" required class="fcc-input">
                @error('judul')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Deskripsi / Silabus *</label>
                <textarea name="isi" rows="4" placeholder="Deskripsi lengkap program pelatihan..." required class="fcc-input" style="resize:vertical;">{{ old('isi') }}</textarea>
                @error('isi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Gambar / Poster</label>
                <label style="display:flex;align-items:center;gap:8px;border:1.5px dashed #E2E4EB;border-radius:10px;padding:8px 12px;cursor:pointer;transition:border-color .2s;background:#F8F9FB;"
                       onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                    @include('components.icon',['name'=>'image','size'=>16,'style'=>'color:#A0A3AD'])
                    <span style="font-size:12px;color:#6B7280;">Pilih File Gambar</span>
                    <input type="file" name="gambar" accept="image/*" style="display:none;" onchange="previewGambar(this, 'gambar-preview')">
                </label>
                @error('gambar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- Materi Awal (Opsional) --}}
            <div style="margin-top:20px;border-top:1px solid #E2E4EB;padding-top:16px;">
                <h3 style="font-size:12px;font-weight:900;color:#131218;margin:0 0 12px;text-transform:uppercase;letter-spacing:.5px;">Materi Awal (Opsional)</h3>
                
                <div style="margin-bottom:14px;">
                    <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Judul Materi</label>
                    <input type="text" name="judul_materi" value="{{ old('judul_materi') }}" placeholder="Judul materi pelatihan..." class="fcc-input">
                    @error('judul_materi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:14px;">
                    <div>
                        <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">File Materi</label>
                        <label style="display:flex;align-items:center;gap:8px;border:1.5px dashed #E2E4EB;border-radius:10px;padding:8px 12px;cursor:pointer;transition:border-color .2s;background:#F8F9FB;"
                               onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                            @include('components.icon',['name'=>'upload','size'=>16,'style'=>'color:#A0A3AD'])
                            <span style="font-size:12px;color:#6B7280;">Pilih File</span>
                            <input type="file" name="file_materi" style="display:none;">
                        </label>
                        @error('file_materi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">ATAU Link Tautan Materi</label>
                        <input type="text" name="link_materi" value="{{ old('link_materi') }}" placeholder="https://drive.google.com/..." class="fcc-input">
                        @error('link_materi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Jadwal Awal (Opsional) --}}
            <div style="margin-top:20px;border-top:1px solid #E2E4EB;padding-top:16px;margin-bottom:14px;">
                <h3 style="font-size:12px;font-weight:900;color:#131218;margin:0 0 12px;text-transform:uppercase;letter-spacing:.5px;">Jadwal Awal (Opsional)</h3>
                
                <div style="margin-bottom:14px;">
                    <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Nama Kegiatan / Batch</label>
                    <input type="text" name="jadwal_nama_kegiatan" value="{{ old('jadwal_nama_kegiatan') }}" placeholder="contoh: Pelatihan Javascript Batch 1 (kosongkan jika default)" class="fcc-input">
                    @error('jadwal_nama_kegiatan')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:14px;">
                    <div>
                        <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kuota Peserta</label>
                        <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta', 20) }}" min="1" max="500" class="fcc-input">
                        @error('kuota_peserta')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Untuk Peserta</label>
                        <select name="untuk_peserta" class="fcc-input">
                            <option value="LP" {{ old('untuk_peserta')==='LP'?'selected':'' }}>Laki-laki & Perempuan</option>
                            <option value="L" {{ old('untuk_peserta')==='L'?'selected':'' }}>Laki-laki Saja</option>
                            <option value="P" {{ old('untuk_peserta')==='P'?'selected':'' }}>Perempuan Saja</option>
                        </select>
                        @error('untuk_peserta')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Multi-Biaya Setup --}}
                <div style="margin-bottom:14px;background:#F8F9FB;border:1px solid #E2E4EB;border-radius:10px;padding:12px 14px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                        <label style="font-size:10px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;margin:0;">Jenis Biaya Pendaftaran (Opsional)</label>
                        <button type="button" onclick="addBiayaRow('biaya-container')" style="font-size:11px;color:#3B82F6;background:none;border:none;font-weight:700;cursor:pointer;">+ Tambah Biaya</button>
                    </div>
                    <div id="biaya-container">
                        <div class="biaya-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;">
                            <input type="text" name="nama_jenis_biaya[]" value="{{ old('nama_jenis_biaya.0') }}" placeholder="contoh: Umum" class="fcc-input" style="background:#FFF;">
                            <input type="number" name="nominal_biaya[]" value="{{ old('nominal_biaya.0') }}" placeholder="Nominal (Rp)" class="fcc-input" style="background:#FFF;">
                            <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:6px;">@include('components.icon',['name'=>'trash','size'=>14])</button>
                        </div>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:14px;">
                    <div>
                        <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Batas Pendaftaran</label>
                        <input type="date" name="tgl_batas_daftar" value="{{ old('tgl_batas_daftar') }}" class="fcc-input">
                        @error('tgl_batas_daftar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Tanggal Pelaksanaan</label>
                        <input type="date" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan') }}" class="fcc-input">
                        @error('tgl_pelaksanaan')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:14px;">
                    <div>
                        <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '08:00') }}" class="fcc-input">
                        @error('jam_mulai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:10px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai', '12:00') }}" class="fcc-input">
                        @error('jam_selesai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div style="margin-top:14px;background:#F8F9FB;border:1px solid #E2E4EB;border-radius:10px;padding:12px 14px;">
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                        <input type="checkbox" name="langsung_aktifkan" value="1" checked style="accent-color:#131218;width:16px;height:16px;">
                        <div>
                            <p style="margin:0;font-size:12px;font-weight:700;color:#131218;">Langsung aktifkan sebagai Kegiatan Publik</p>
                            <p style="margin:0;font-size:10px;color:#9CA3B0;">Jika dicentang, jadwal ini akan langsung aktif dan muncul di halaman biaya & pendaftaran.</p>
                        </div>
                    </label>
                </div>
            </div>

            <div style="text-align:center;margin-bottom:14px;">
                <img id="gambar-preview" style="display:none;max-width:200px;margin:0 auto;border-radius:10px;object-fit:cover;max-height:120px;" alt="Preview">
            </div>

            {{-- Actions --}}
            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:14px;">
                <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" style="padding:10px 20px;font-size:13px;font-weight:700;color:#6B7280;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;cursor:pointer;">
                    Batal
                </button>
                <button type="submit" class="fcc-btn-gold" style="padding:10px 24px;font-size:13px;border:none;cursor:pointer;font-weight:700;border-radius:10px;">
                    @include('components.icon',['name'=>'check','size'=>14]) Simpan Pelatihan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
function addBiayaRow(containerId) {
    const container = document.getElementById(containerId);
    const div = document.createElement('div');
    div.className = 'biaya-row';
    div.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;';
    div.innerHTML = `
        <input type="text" name="nama_jenis_biaya[]" placeholder="contoh: Umum" class="fcc-input" style="background:#FFF;">
        <input type="number" name="nominal_biaya[]" placeholder="Nominal (Rp)" class="fcc-input" style="background:#FFF;">
        <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:6px;">@include('components.icon',['name'=>'trash','size'=>14])</button>
    `;
    container.appendChild(div);
}

function previewGambar(input, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        preview.src = e.target.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(file);
}
</script>

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('create-modal').classList.remove('hidden');
});
</script>
@endif
@endpush
