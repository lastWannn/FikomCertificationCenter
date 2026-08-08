{{-- ── TAMBAH PELATIHAN MODAL (Neo-Brutalist Glassmorphism) ────────────────────────────────────── --}}
<div id="create-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:620px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('create-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;text-transform:uppercase;">Master Data</span>
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Tambah Program Pelatihan</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Isi informasi detail program pelatihan baru.</p>
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
            <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:16px;">
                <button type="button" onclick="document.getElementById('create-modal').style.display='none'"
                        style="padding:11px 22px;font-size:13px;font-weight:800;color:#64748B;background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:30px;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
                    Batal
                </button>
                <button type="submit"
                        style="padding:11px 26px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
                        onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                    @include('components.icon',['name'=>'check','size'=>16]) Simpan Pelatihan
                </button>
            </div>
        </form>

    </div>
</div>
