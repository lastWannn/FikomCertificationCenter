{{-- ── TAMBAH PELATIHAN MODAL (Neo-Brutalist Glassmorphism) ────────────────────────────────────── --}}
<div id="create-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;" onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:680px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;" onclick="event.stopPropagation()">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('create-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;text-transform:uppercase;">MASTER DATA</span>
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Tambah Program Pelatihan</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Isi informasi program pelatihan baru.</p>
        </div>

        <form action="{{ route('admin.pelatihan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:14px;">
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Kode Pelatihan <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="kode" value="{{ old('kode') }}" placeholder="Contoh: 100-ITFUND1" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('kode')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Kategori Program <span style="color:#EF4444;">*</span></label>
                    <select name="kategori_id" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;background:#FFF;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id')==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Judul Pelatihan <span style="color:#EF4444;">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Judul program pelatihan" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                @error('judul')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Deskripsi Program <span style="color:#EF4444;">*</span></label>
                <textarea name="isi" rows="3" placeholder="Deskripsi program pelatihan..." required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;resize:vertical;">{{ old('isi') }}</textarea>
                @error('isi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Fasilitas &amp; Benefit Keikutsertaan <span style="font-weight:500;color:#64748B;">(Opsional)</span></label>
                <textarea name="fasilitas_input" rows="3" placeholder="Contoh:&#10;- E-Book & Modul Digital&#10;- Ruang Lab AC & Wi-Fi&#10;- Coffee Break & Lunch" class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;resize:vertical;">{{ old('fasilitas_input') }}</textarea>
                <p style="color:#64748B;font-size:11px;margin:4px 0 0;font-weight:500;">Tuliskan setiap fasilitas tambahan di baris baru untuk ditampilkan secara otomatis di halaman kegiatan.</p>
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Gambar / Poster Sampul</label>
                <label style="display:flex;align-items:center;gap:10px;border:1.5px dashed #CBD5E1;border-radius:12px;padding:12px 16px;cursor:pointer;transition:all .18s;background:#F8FAFC;"
                       onmouseover="this.style.borderColor='#131218';this.style.background='#FFFDF5';" onmouseout="this.style.borderColor='#CBD5E1';this.style.background='#F8FAFC';">
                    @include('components.icon',['name'=>'image','size'=>18,'style'=>'color:#131218'])
                    <span style="font-size:13px;color:#131218;font-weight:700;">Klik untuk Upload Gambar Sampul</span>
                    <input type="file" name="gambar" accept="image/*" style="display:none;" onchange="previewGambar(this, 'gambar-preview')">
                </label>
                @error('gambar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="text-align:center;margin-bottom:14px;">
                <img id="gambar-preview" style="display:none;max-width:200px;margin:0 auto;border-radius:10px;object-fit:cover;max-height:120px;" alt="Preview">
            </div>

            {{-- Actions --}}
            <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:14px;">
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
