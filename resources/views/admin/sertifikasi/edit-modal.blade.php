{{-- ── EDIT SERTIFIKASI MODALS (Neo-Brutalist Glassmorphism) ────────────────────────────────────── --}}
@php
  $kategoriList = $kategori ?? \App\Models\Kategori::orderBy('nama_kategori')->get();
  $itemsToLoop = is_iterable($sertifikasi) && !($sertifikasi instanceof \App\Models\Sertifikasi) ? $sertifikasi : [$sertifikasi];
@endphp
@foreach($itemsToLoop as $sEdit)
<div id="edit-modal-{{ $sEdit->id }}" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;" onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:640px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;text-align:left;" onclick="event.stopPropagation()">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('edit-modal-{{ $sEdit->id }}').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;font-family:monospace;">{{ $sEdit->kode }}</span>
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Edit Program Sertifikasi</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Perbarui informasi master program sertifikasi {{ $sEdit->judul }}.</p>
        </div>

        <form action="{{ route('admin.sertifikasi.update', $sEdit) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:14px;">
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Kode Sertifikasi <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="kode" value="{{ old('kode', $sEdit->kode) }}" required readonly class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;background:#F8FAFC;">
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Kategori Program <span style="color:#EF4444;">*</span></label>
                    <select name="kategori_id" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;background:#FFF;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriList as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id', $sEdit->kategori_id)==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Judul Sertifikasi <span style="color:#EF4444;">*</span></label>
                <input type="text" name="judul" value="{{ old('judul', $sEdit->judul) }}" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Deskripsi Program <span style="color:#EF4444;">*</span></label>
                <textarea name="isi" rows="4" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;resize:vertical;">{{ old('isi', $sEdit->isi) }}</textarea>
                <p style="color:#64748B;font-size:11px;margin:4px 0 0;font-weight:500;">💡 <strong>Tips Fasilitas:</strong> Gunakan tanda minus (<code>- </code>) di baris baru untuk menambahkan daftar Fasilitas/Benefit yang akan tampil secara otomatis di halaman kegiatan.</p>
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Gambar / Poster Sampul</label>
                @if($sEdit->gambar || $sEdit->gambar_url)
                <div style="margin-bottom:10px;display:flex;align-items:center;gap:12px;">
                    <img src="{{ $sEdit->gambar_url ?? asset('storage/'.$sEdit->gambar) }}" alt="Preview" style="width:50px;height:50px;border-radius:10px;object-fit:cover;border:1.5px solid #131218;">
                    <span style="font-size:12px;color:#64748B;font-weight:600;">Gambar Sampul Terpasang</span>
                </div>
                @endif
                <label style="display:flex;align-items:center;gap:10px;border:1.5px dashed #CBD5E1;border-radius:12px;padding:12px 16px;cursor:pointer;transition:all .18s;background:#F8FAFC;"
                       onmouseover="this.style.borderColor='#131218';this.style.background='#FFFDF5';" onmouseout="this.style.borderColor='#CBD5E1';this.style.background='#F8FAFC';">
                    @include('components.icon',['name'=>'image','size'=>18,'style'=>'color:#131218'])
                    <span style="font-size:13px;color:#131218;font-weight:700;">Ganti Gambar Sampul</span>
                    <input type="file" name="gambar" accept="image/*" style="display:none;" onchange="previewGambar(this, 'edit-gambar-preview-{{ $sEdit->id }}')">
                </label>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:14px;">
                <button type="button" onclick="document.getElementById('edit-modal-{{ $sEdit->id }}').style.display='none'"
                        style="padding:11px 22px;font-size:13px;font-weight:800;color:#64748B;background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:30px;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
                    Batal
                </button>
                <button type="submit"
                        style="padding:11px 26px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
                        onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                    @include('components.icon',['name'=>'check','size'=>16]) Simpan Sertifikasi
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach
