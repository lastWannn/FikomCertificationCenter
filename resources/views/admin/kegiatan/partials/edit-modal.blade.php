<div id="edit-kegiatan-modal-{{ $kegiatan->id }}" class="fcc-modal-backdrop" style="display:none;position:fixed;inset:0;z-index:999999;background:rgba(19,18,24,.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:16px;" onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;max-width:740px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 24px 60px rgba(0,0,0,0.3);position:relative;padding:32px;text-align:left !important;" onclick="event.stopPropagation()">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('edit-kegiatan-modal-{{ $kegiatan->id }}').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        {{-- Header --}}
        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;text-transform:uppercase;">KEGIATAN AKTIF</span>
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Edit Data Kegiatan</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Perbarui informasi detail, jadwal, kuota, dan rincian biaya kegiatan.</p>
        </div>

        <form action="{{ route('admin.kegiatan.update', $kegiatan) }}" method="POST" style="text-align:left;">
            @csrf
            @method('PUT')

            {{-- Informasi Utama --}}
            <div style="display:grid;grid-template-columns:2fr 1fr 1.3fr;gap:14px;margin-bottom:16px;text-align:left;">
                <div style="text-align:left;">
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Judul / Nama Kegiatan <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->judul ?? $kegiatan->jadwal?->nama_kegiatan) }}" class="fcc-input" required placeholder="Masukkan nama kegiatan..." style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                </div>

                <div style="text-align:left;">
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Kuota Peserta <span style="color:#EF4444;">*</span></label>
                    <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta', $kegiatan->jadwal?->kuota_peserta) }}" class="fcc-input" required min="1" placeholder="Misal: 30" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                </div>

                <div style="text-align:left;">
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Status Publikasi <span style="color:#EF4444;">*</span></label>
                    <select name="status" class="fcc-input" style="padding:9.5px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;background:#FFF;font-weight:700;">
                        <option value="public" {{ old('status', $kegiatan->status ?? 'public') === 'public' ? 'selected' : '' }}>Publik (Terbuka)</option>
                        <option value="comingsoon" {{ old('status', $kegiatan->status) === 'comingsoon' ? 'selected' : '' }}>Coming Soon (Segera Hadir)</option>
                        <option value="draf" {{ old('status', $kegiatan->status) === 'draf' ? 'selected' : '' }}>Draft (Konsep Admin)</option>
                    </select>
                </div>
            </div>

            {{-- Grid Tanggal & Jam --}}
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;margin-bottom:24px;">
                <div style="text-align:left;">
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Batas Daftar</label>
                    <input type="date" name="tgl_batas_daftar" value="{{ old('tgl_batas_daftar', $kegiatan->jadwal?->tgl_batas_daftar?->format('Y-m-d')) }}" class="fcc-input" style="padding:9px 10px;font-size:12.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                </div>

                <div style="text-align:left;">
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Tgl Pelaksanaan</label>
                    <input type="date" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan', $kegiatan->jadwal?->tgl_pelaksanaan?->format('Y-m-d')) }}" class="fcc-input" style="padding:9px 10px;font-size:12.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                </div>

                <div style="text-align:left;">
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $kegiatan->jadwal?->jam_mulai ? substr($kegiatan->jadwal->jam_mulai, 0, 5) : '') }}" class="fcc-input" style="padding:9px 10px;font-size:12.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                </div>

                <div style="text-align:left;">
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $kegiatan->jadwal?->jam_selesai ? substr($kegiatan->jadwal->jam_selesai, 0, 5) : '') }}" class="fcc-input" style="padding:9px 10px;font-size:12.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                </div>
            </div>

            {{-- Biaya Kegiatan --}}
            <div style="background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:16px;padding:20px;margin-bottom:24px;text-align:left;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;text-align:left;">
                    <div style="text-align:left;">
                        <h4 style="font-size:14px;font-weight:900;color:#131218;margin:0 0 2px;text-align:left;">Rincian Biaya Kegiatan</h4>
                        <p style="font-size:11.5px;color:#64748B;margin:0;text-align:left;font-weight:500;">Kosongkan jika kegiatan bersifat gratis.</p>
                    </div>
                    <button type="button" onclick="addBiayaRowModal_{{ $kegiatan->id }}()" style="font-size:11.5px;font-weight:900;color:#131218;background:#FFC81A;border:1px solid #131218;padding:5px 12px;border-radius:16px;cursor:pointer;">
                        + Tambah Biaya
                    </button>
                </div>

                <div id="biaya-container-modal-{{ $kegiatan->id }}" style="text-align:left;">
                    @forelse($kegiatan->biaya as $b)
                    <div class="biaya-row-modal" style="display:flex;gap:10px;align-items:center;margin-bottom:10px;text-align:left;">
                        <input type="text" name="nama_jenis_biaya[]" value="{{ $b->nama_jenis }}" placeholder="Nama Jenis Biaya (Misal: Umum / Mahasiswa)" class="fcc-input" style="flex:2;text-align:left;font-size:13px;border:1.5px solid #CBD5E1;border-radius:10px;">
                        <div style="position:relative;flex:1.2;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:12.5px;font-weight:800;color:#6B7280;">Rp</span>
                            <input type="number" name="nominal_biaya[]" value="{{ (int)$b->nominal }}" placeholder="0" class="fcc-input" style="padding-left:38px;text-align:left;font-size:13px;border:1.5px solid #CBD5E1;border-radius:10px;" onfocus="this.select()">
                        </div>
                        <button type="button" onclick="this.closest('.biaya-row-modal').remove()" style="background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;width:38px;height:38px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .18s;" title="Hapus Biaya"
                                onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';">
                            @include('components.icon', ['name' => 'trash', 'size' => 15])
                        </button>
                    </div>
                    @empty
                    <div class="biaya-row-modal" style="display:flex;gap:10px;align-items:center;margin-bottom:10px;text-align:left;">
                        <input type="text" name="nama_jenis_biaya[]" placeholder="Nama Jenis Biaya (Misal: Umum / Mahasiswa)" class="fcc-input" style="flex:2;text-align:left;font-size:13px;border:1.5px solid #CBD5E1;border-radius:10px;">
                        <div style="position:relative;flex:1.2;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:12.5px;font-weight:800;color:#6B7280;">Rp</span>
                            <input type="number" name="nominal_biaya[]" placeholder="0" class="fcc-input" style="padding-left:38px;text-align:left;font-size:13px;border:1.5px solid #CBD5E1;border-radius:10px;" onfocus="this.select()">
                        </div>
                        <button type="button" onclick="this.closest('.biaya-row-modal').remove()" style="background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;width:38px;height:38px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .18s;" title="Hapus Biaya"
                                onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';">
                            @include('components.icon', ['name' => 'trash', 'size' => 15])
                        </button>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display:flex;gap:12px;justify-content:flex-end;align-items:center;border-top:1.5px solid #E5E7EB;padding-top:18px;">
                <button type="button" onclick="document.getElementById('edit-kegiatan-modal-{{ $kegiatan->id }}').style.display='none'" style="padding:10px 24px;font-size:13.5px;font-weight:800;border-radius:30px;border:1.5px solid #CBD5E1;background:#F8FAFC;color:#64748B;cursor:pointer;">
                    Batal
                </button>
                <button type="submit" style="padding:10px 28px;font-size:13.5px;font-weight:900;border-radius:30px;border:1.5px solid #131218;background:#FFC81A;color:#131218;cursor:pointer;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addBiayaRowModal_{{ $kegiatan->id }}() {
    const container = document.getElementById('biaya-container-modal-{{ $kegiatan->id }}');
    const div = document.createElement('div');
    div.className = 'biaya-row-modal';
    div.style.cssText = 'display:flex;gap:10px;align-items:center;margin-bottom:10px;text-align:left;';
    div.innerHTML = `
        <input type="text" name="nama_jenis_biaya[]" placeholder="Nama Jenis Biaya (Misal: Umum / Mahasiswa)" class="fcc-input" style="flex:2;text-align:left;font-size:13px;border:1.5px solid #CBD5E1;border-radius:10px;">
        <div style="position:relative;flex:1.2;">
            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:12.5px;font-weight:800;color:#6B7280;">Rp</span>
            <input type="number" name="nominal_biaya[]" placeholder="0" class="fcc-input" style="padding-left:38px;text-align:left;font-size:13px;border:1.5px solid #CBD5E1;border-radius:10px;" onfocus="this.select()">
        </div>
        <button type="button" onclick="this.closest('.biaya-row-modal').remove()" style="background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;width:38px;height:38px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;" title="Hapus Biaya">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path></svg>
        </button>
    `;
    container.appendChild(div);
}
</script>
