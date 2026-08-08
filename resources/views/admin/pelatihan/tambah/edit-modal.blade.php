{{-- ── EDIT PELATIHAN MODALS (Neo-Brutalist Glassmorphism) ────────────────────────────────────── --}}
@php
  $kategoriList = $kategori ?? \App\Models\Kategori::orderBy('nama_kategori')->get();
  $allPelatihanList = $pelatihanList ?? \App\Models\Pelatihan::orderBy('judul')->get();
  $itemsToLoop = is_iterable($pelatihan) && !($pelatihan instanceof \App\Models\Pelatihan) ? $pelatihan : [$pelatihan];
@endphp
@foreach($itemsToLoop as $pEdit)
<div id="edit-modal-{{ $pEdit->id }}" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;" onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:620px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;" onclick="event.stopPropagation()">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('edit-modal-{{ $pEdit->id }}').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;font-family:monospace;">{{ $pEdit->kode }}</span>
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Edit Program Pelatihan</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Perbarui informasi master program pelatihan {{ $pEdit->judul }}.</p>
        </div>

        <form action="{{ route('admin.pelatihan.update', $pEdit) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- KODE PELATIHAN --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px;">KODE <span style="font-weight:500;text-transform:none;color:#9CA3B0;">Pelatihan</span></label>
                <input type="text" name="kode" value="{{ old('kode', $pEdit->kode) }}" required class="fcc-input" style="padding:8px 12px;font-size:13px;background:#F8F9FB;" readonly>
                @error('kode')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- JUDUL PELATIHAN --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px;">JUDUL <span style="font-weight:500;text-transform:none;color:#9CA3B0;">Pelatihan</span></label>
                <input type="text" name="judul" value="{{ old('judul', $pEdit->judul) }}" required class="fcc-input" style="padding:8px 12px;font-size:13px;">
                @error('judul')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- ISI PELATIHAN --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px;">ISI <span style="font-weight:500;text-transform:none;color:#9CA3B0;">Pelatihan</span></label>
                <textarea name="isi" rows="4" required class="fcc-input" style="resize:vertical;padding:8px 12px;font-size:13px;">{{ old('isi', $pEdit->isi) }}</textarea>
                @error('isi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <hr style="border:none;border-top:1px solid #E2E4EB;margin:16px 0;">

            {{-- KATEGORI --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Kategori Pelatihan</label>
                <select name="kategori_id" required class="fcc-input" style="padding:8px 12px;font-size:13px;">
                    <option value="">Pilih Kategori...</option>
                    @foreach($kategoriList as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_id', $pEdit->kategori_id)==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_id')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- LINK MATERI --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Link Download Materi</label>
                <input type="text" name="link_materi" value="{{ old('link_materi', $pEdit->link_materi) }}" placeholder="Link Download Materi" class="fcc-input" style="padding:8px 12px;font-size:13px;">
                @error('link_materi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- PERSYARATAN --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Persyaratan Pelatihan</label>
                <select name="prasyarat_id" class="fcc-input" style="padding:8px 12px;font-size:13px;">
                    <option value="">Tidak ada (Opsional)</option>
                    @foreach($allPelatihanList as $p)
                        @if($p->id != $pEdit->id)
                            <option value="{{ $p->id }}" {{ old('prasyarat_id', $pEdit->prasyarat_id)==$p->id?'selected':'' }}>{{ $p->judul }}</option>
                        @endif
                    @endforeach
                </select>
                @error('prasyarat_id')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- GAMBAR / POSTER --}}
            <div style="margin-bottom:20px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Foto Poster / Sampul Pelatihan</label>
                
                {{-- Preview Box --}}
                <div style="display:flex;align-items:center;gap:14px;margin-bottom:10px;background:#F8FAFC;border:1.5px solid #E2E8F0;padding:12px;border-radius:14px;">
                    <img id="gambar-preview-{{ $pEdit->id }}" 
                         src="{{ $pEdit->gambar_url ?? '' }}" 
                         style="{{ $pEdit->gambar_url ? 'display:block;' : 'display:none;' }}width:80px;height:80px;border-radius:12px;object-fit:cover;border:1.5px solid #131218;box-shadow:0 4px 10px rgba(0,0,0,0.1);flex-shrink:0;" 
                         alt="Preview Poster">
                    
                    <div style="flex:1;min-width:0;">
                        <p id="gambar-status-{{ $pEdit->id }}" style="margin:0 0 4px;font-size:12.5px;font-weight:800;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {!! $pEdit->gambar_url ? '📷 Poster Saat Ini Terpasang' : '📷 Belum Ada Foto Poster' !!}
                        </p>
                        <p style="margin:0;font-size:11px;color:#64748B;font-weight:500;">Pilih file gambar baru (JPG, PNG, WebP) untuk mengganti poster ini.</p>
                    </div>
                </div>

                {{-- Upload Input Label --}}
                <label style="display:flex;align-items:center;justify-content:center;gap:8px;border:1.5px dashed #131218;border-radius:12px;padding:10px 14px;cursor:pointer;transition:all .18s;background:#FFFDF5;"
                       onmouseover="this.style.background='#FFC81A'" onmouseout="this.style.background='#FFFDF5'">
                    @include('components.icon',['name'=>'image','size'=>18])
                    <span id="gambar-label-{{ $pEdit->id }}" style="font-size:12.5px;font-weight:800;color:#131218;">
                        {{ $pEdit->gambar_url ? 'Pilih Foto Poster Baru...' : 'Upload File Gambar Poster...' }}
                    </span>
                    <input type="file" name="gambar" accept="image/*" style="display:none;" 
                           onchange="handleImagePreview(this, 'gambar-preview-{{ $pEdit->id }}', 'gambar-label-{{ $pEdit->id }}', 'gambar-status-{{ $pEdit->id }}')">
                </label>
                @error('gambar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <hr style="border:none;border-top:1px solid #E2E4EB;margin:16px 0;">

            @php $jadwalEdit = $pEdit->jadwal()->latest()->first(); @endphp
            {{-- PENGATURAN JADWAL TERAKHIR --}}
            <div style="margin-bottom:12px;">
                <p style="font-size:12px;font-weight:800;color:#131218;margin:0 0 12px;text-transform:uppercase;letter-spacing:0.5px;">Edit Jadwal Pelaksanaan (Batch Terakhir)</p>
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Tanggal Pelaksanaan</label>
                        <input type="date" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan', $jadwalEdit?->tgl_pelaksanaan?->format('Y-m-d')) }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('tgl_pelaksanaan')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Tanggal Batas Pendaftaran</label>
                        <input type="date" name="tgl_batas_daftar" value="{{ old('tgl_batas_daftar', $jadwalEdit?->tgl_batas_daftar?->format('Y-m-d')) }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('tgl_batas_daftar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Jam Mulai</label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jadwalEdit?->jam_mulai ? date('H:i', strtotime($jadwalEdit->jam_mulai)) : '') }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('jam_mulai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Jam Selesai</label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwalEdit?->jam_selesai ? date('H:i', strtotime($jadwalEdit->jam_selesai)) : '') }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('jam_selesai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:600;color:#6B7280;display:block;margin-bottom:4px;">Kuota Peserta</label>
                        <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta', $jadwalEdit?->kuota_peserta) }}" class="fcc-input" style="padding:8px 12px;font-size:13px;width:100%;">
                        @error('kuota_peserta')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px;">
                <button type="button" onclick="document.getElementById('edit-modal-{{ $pEdit->id }}').style.display='none'" style="padding:10px 20px;font-size:13px;font-weight:700;color:#6B7280;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;cursor:pointer;">
                    Batal
                </button>
                <button type="submit" class="fcc-btn-gold" style="padding:10px 24px;font-size:13px;border:none;cursor:pointer;font-weight:700;border-radius:10px;">
                    @include('components.icon',['name'=>'check','size'=>14]) Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach
