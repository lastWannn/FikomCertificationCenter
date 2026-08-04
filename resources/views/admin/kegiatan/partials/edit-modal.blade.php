<div id="edit-kegiatan-modal-{{ $kegiatan->id }}" class="fcc-modal-backdrop" style="display:none;position:fixed;inset:0;z-index:999999;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:16px;" onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#FFF;border-radius:24px;max-width:740px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 24px 64px rgba(0,0,0,.3);position:relative;padding:32px;text-align:left !important;" onclick="event.stopPropagation()">
        
        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;border-bottom:1.5px solid #F0F1F5;padding-bottom:18px;">
            <div style="display:flex;align-items:center;gap:14px;text-align:left;">
                <div style="width:48px;height:48px;border-radius:14px;background:rgba(255,200,26,.16);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    @include('components.icon', ['name' => 'edit', 'size' => 22, 'style' => 'color:#B38F00'])
                </div>
                <div style="text-align:left;">
                    <h3 style="font-size:18px;font-weight:900;color:#131218;margin:0 0 3px;text-align:left;line-height:1.2;">Edit Data Kegiatan</h3>
                    <p style="font-size:13px;color:#6B7280;margin:0;text-align:left;">Perbarui informasi detail, jadwal, kuota, dan rincian biaya.</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('edit-kegiatan-modal-{{ $kegiatan->id }}').style.display='none'"
                    style="background:none;border:none;cursor:pointer;font-size:26px;color:#9CA3B0;line-height:1;padding:4px 8px;border-radius:8px;transition:all .15s;"
                    onmouseover="this.style.background='#F7F8FA';this.style.color='#131218'"
                    onmouseout="this.style.background='none';this.style.color='#9CA3B0'">&times;</button>
        </div>

        <form action="{{ route('admin.kegiatan.update', $kegiatan) }}" method="POST" style="text-align:left;">
            @csrf
            @method('PUT')

            {{-- Informasi Utama --}}
            <div style="display:grid;grid-template-columns:2.2fr 1fr;gap:16px;margin-bottom:18px;text-align:left;">
                <div style="text-align:left;">
                    <label style="font-size:12.5px;font-weight:700;color:#374151;margin-bottom:6px;display:block;text-align:left;">Judul / Nama Kegiatan <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->jadwal?->nama_kegiatan) }}" class="fcc-input" required placeholder="Masukkan nama kegiatan..." style="text-align:left;font-size:13.5px;">
                </div>

                <div style="text-align:left;">
                    <label style="font-size:12.5px;font-weight:700;color:#374151;margin-bottom:6px;display:block;text-align:left;">Kuota Peserta <span style="color:#EF4444;">*</span></label>
                    <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta', $kegiatan->jadwal?->kuota_peserta) }}" class="fcc-input" required min="1" placeholder="Misal: 30" style="text-align:left;font-size:13.5px;">
                </div>
            </div>

            {{-- Jadwal & Waktu --}}
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;margin-bottom:20px;text-align:left;">
                <div style="text-align:left;">
                    <label style="font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;display:block;text-align:left;">Tgl Pelaksanaan</label>
                    <input type="date" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan', $kegiatan->jadwal?->tgl_pelaksanaan?->format('Y-m-d')) }}" class="fcc-input" style="text-align:left;font-size:12.5px;">
                </div>

                <div style="text-align:left;">
                    <label style="font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;display:block;text-align:left;">Jam Mulai</label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $kegiatan->jadwal?->jam_mulai ? substr($kegiatan->jadwal->jam_mulai, 0, 5) : '') }}" class="fcc-input" style="text-align:left;font-size:12.5px;">
                </div>

                <div style="text-align:left;">
                    <label style="font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;display:block;text-align:left;">Jam Selesai</label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $kegiatan->jadwal?->jam_selesai ? substr($kegiatan->jadwal->jam_selesai, 0, 5) : '') }}" class="fcc-input" style="text-align:left;font-size:12.5px;">
                </div>

                <div style="text-align:left;">
                    <label style="font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;display:block;text-align:left;">Batas Daftar</label>
                    <input type="date" name="tgl_batas_daftar" value="{{ old('tgl_batas_daftar', $kegiatan->jadwal?->tgl_batas_daftar?->format('Y-m-d')) }}" class="fcc-input" style="text-align:left;font-size:12.5px;">
                </div>
            </div>

            {{-- Biaya Kegiatan --}}
            <div style="background:#F9FAFB;border:1.5px solid #E5E7EB;border-radius:16px;padding:20px;margin-bottom:24px;text-align:left;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;text-align:left;">
                    <div style="text-align:left;">
                        <h4 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 2px;text-align:left;">Rincian Biaya Kegiatan</h4>
                        <p style="font-size:11.5px;color:#9CA3B0;margin:0;text-align:left;">Kosongkan jika kegiatan bersifat gratis.</p>
                    </div>
                    <button type="button" onclick="addBiayaRowModal_{{ $kegiatan->id }}()" class="fcc-btn-gold" style="padding:7px 14px;font-size:12px;cursor:pointer;font-weight:800;">
                        + Tambah Biaya
                    </button>
                </div>

                <div id="biaya-container-modal-{{ $kegiatan->id }}" style="text-align:left;">
                    @forelse($kegiatan->biaya as $b)
                    <div class="biaya-row-modal" style="display:flex;gap:10px;align-items:center;margin-bottom:10px;text-align:left;">
                        <input type="text" name="nama_jenis_biaya[]" value="{{ $b->nama_jenis }}" placeholder="Nama Jenis Biaya (Misal: Umum / Mahasiswa)" class="fcc-input" style="flex:2;text-align:left;font-size:13px;">
                        <div style="position:relative;flex:1.2;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:12.5px;font-weight:800;color:#6B7280;">Rp</span>
                            <input type="number" name="nominal_biaya[]" value="{{ (int)$b->nominal }}" placeholder="0" class="fcc-input" style="padding-left:38px;text-align:left;font-size:13px;">
                        </div>
                        <button type="button" onclick="this.closest('.biaya-row-modal').remove()" style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#EF4444;width:38px;height:38px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;" title="Hapus Biaya">
                            @include('components.icon', ['name' => 'trash', 'size' => 15])
                        </button>
                    </div>
                    @empty
                    <div class="biaya-row-modal" style="display:flex;gap:10px;align-items:center;margin-bottom:10px;text-align:left;">
                        <input type="text" name="nama_jenis_biaya[]" placeholder="Nama Jenis Biaya (Misal: Umum / Mahasiswa)" class="fcc-input" style="flex:2;text-align:left;font-size:13px;">
                        <div style="position:relative;flex:1.2;">
                            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:12.5px;font-weight:800;color:#6B7280;">Rp</span>
                            <input type="number" name="nominal_biaya[]" placeholder="0" class="fcc-input" style="padding-left:38px;text-align:left;font-size:13px;">
                        </div>
                        <button type="button" onclick="this.closest('.biaya-row-modal').remove()" style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#EF4444;width:38px;height:38px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;" title="Hapus Biaya">
                            @include('components.icon', ['name' => 'trash', 'size' => 15])
                        </button>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display:flex;gap:12px;justify-content:flex-end;align-items:center;border-top:1.5px solid #F0F1F5;padding-top:18px;">
                <button type="button" onclick="document.getElementById('edit-kegiatan-modal-{{ $kegiatan->id }}').style.display='none'" class="fcc-btn-outline-dark" style="padding:10px 24px;font-size:13.5px;font-weight:700;border-radius:12px;">
                    Batal
                </button>
                <button type="submit" class="fcc-btn-gold" style="padding:10px 28px;font-size:13.5px;font-weight:800;border-radius:12px;cursor:pointer;">
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
        <input type="text" name="nama_jenis_biaya[]" placeholder="Nama Jenis Biaya (Misal: Umum / Mahasiswa)" class="fcc-input" style="flex:2;text-align:left;font-size:13px;">
        <div style="position:relative;flex:1.2;">
            <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:12.5px;font-weight:800;color:#6B7280;">Rp</span>
            <input type="number" name="nominal_biaya[]" placeholder="0" class="fcc-input" style="padding-left:38px;text-align:left;font-size:13px;">
        </div>
        <button type="button" onclick="this.closest('.biaya-row-modal').remove()" style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);color:#EF4444;width:38px;height:38px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;" title="Hapus Biaya">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path></svg>
        </button>
    `;
    container.appendChild(div);
}
</script>
