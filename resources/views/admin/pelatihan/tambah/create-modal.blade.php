{{-- ── TAMBAH PELATIHAN MODAL ────────────────────────────────────── --}}
<div id="create-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.55);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
    <div style="background:#FFF;border-radius:18px;padding:32px 28px;max-width:580px;width:90%;position:relative;box-shadow:0 24px 64px rgba(0,0,0,.18);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('create-modal').style.display='none'" aria-label="Tutup" style="
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
            
            {{-- KODE PELATIHAN --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px;">KODE <span style="font-weight:500;text-transform:none;color:#9CA3B0;">Pelatihan</span></label>
                <input type="text" name="kode" value="{{ old('kode') }}" placeholder="Contoh: 100-ITFUND1" required class="fcc-input" style="padding:8px 12px;font-size:13px;">
                <p style="font-size:11px;color:#6B7280;margin:4px 0 0;">Catatan: Pengisian kode wajib diawali angka unik, contoh: <strong>100-ITFUND1</strong> (100 = kode unik).</p>
                @error('kode')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- JUDUL PELATIHAN --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px;">JUDUL <span style="font-weight:500;text-transform:none;color:#9CA3B0;">Pelatihan</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Web Development Dasar Batch 1" required class="fcc-input" style="padding:8px 12px;font-size:13px;">
                @error('judul')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- ISI PELATIHAN --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px;">ISI <span style="font-weight:500;text-transform:none;color:#9CA3B0;">Pelatihan</span></label>
                <textarea name="isi" rows="4" placeholder="Tuliskan deskripsi dan detail program pelatihan..." required class="fcc-input" style="resize:vertical;padding:8px 12px;font-size:13px;">{{ old('isi') }}</textarea>
                @error('isi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <hr style="border:none;border-top:1px solid #E2E4EB;margin:16px 0;">

            {{-- KATEGORI --}}
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Kategori Pelatihan</label>
                <select name="kategori_id" required class="fcc-input" style="padding:8px 12px;font-size:13px;">
                    <option value="">Kategori...</option>
                    @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_id')==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <hr style="border:none;border-top:1px solid #E2E4EB;margin:16px 0;">

            {{-- PERSYARATAN & GAMBAR --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                <div>
                    <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Persyaratan Pelatihan</label>
                    <select name="prasyarat_id" class="fcc-input" style="padding:8px 12px;font-size:13px;">
                        <option value="">Pilih Prasyarat...</option>
                        @foreach($pelatihanList as $p)
                        <option value="{{ $p->id }}" {{ old('prasyarat_id')==$p->id?'selected':'' }}>{{ $p->judul }}</option>
                        @endforeach
                    </select>
                    @error('prasyarat_id')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Gambar</label>
                    <label style="display:flex;align-items:center;gap:8px;border:1.5px dashed #E2E4EB;border-radius:10px;padding:8px 12px;cursor:pointer;transition:border-color .2s;background:#F8F9FB;height:38px;"
                           onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                        @include('components.icon',['name'=>'image','size'=>16,'style'=>'color:#A0A3AD'])
                        <span style="font-size:12px;color:#6B7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Pilih File Gambar</span>
                        <input type="file" name="gambar" accept="image/*" style="display:none;" onchange="previewGambar(this, 'gambar-preview')">
                    </label>
                    @error('gambar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>

            <hr style="border:none;border-top:1px solid #E2E4EB;margin:16px 0;">

            {{-- PENGATURAN JADWAL PERDANA --}}
            <div style="margin-bottom:12px;">
                <p style="font-size:12px;font-weight:800;color:#131218;margin:0 0 12px;text-transform:uppercase;letter-spacing:0.5px;">Pengaturan Jadwal Pelaksanaan Pertama</p>
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Tanggal Pelaksanaan</label>
                        <input type="date" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan') }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('tgl_pelaksanaan')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Tanggal Batas Pendaftaran</label>
                        <input type="date" name="tgl_batas_daftar" value="{{ old('tgl_batas_daftar') }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('tgl_batas_daftar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('jam_mulai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('jam_selesai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Kuota Peserta</label>
                        <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta', 20) }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('kuota_peserta')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <hr style="border:none;border-top:1px solid #E2E4EB;margin:16px 0;">

            {{-- LINK DOWNLOAD MATERI --}}
            <div style="margin-bottom:20px;">
                <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Link Download Materi</label>
                <input type="text" name="link_materi" value="{{ old('link_materi') }}" placeholder="Link Download Materi" class="fcc-input" style="padding:8px 12px;font-size:13px;">
                @error('link_materi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="text-align:center;margin-bottom:14px;">
                <img id="gambar-preview" style="display:none;max-width:200px;margin:0 auto;border-radius:10px;object-fit:cover;max-height:120px;" alt="Preview">
            </div>

            {{-- Actions --}}
            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:14px;">
                <button type="button" onclick="document.getElementById('create-modal').style.display='none'" style="padding:10px 20px;font-size:13px;font-weight:700;color:#6B7280;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;cursor:pointer;">
                    Batal
                </button>
                <button type="submit" class="fcc-btn-gold" style="padding:10px 24px;font-size:13px;border:none;cursor:pointer;font-weight:700;border-radius:10px;">
                    @include('components.icon',['name'=>'check','size'=>14]) Simpan Pelatihan
                </button>
            </div>
        </form>

    </div>
</div>
