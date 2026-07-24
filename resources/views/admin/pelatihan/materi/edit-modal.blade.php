{{-- ── EDIT MATERI MODAL ────────────────────────────────────── --}}
<div id="edit-modal" style="display:{{ $errors->has('judul_materi') && session('materi_id') ? 'flex' : 'none' }};position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.55);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
    <div style="background:#FFF;border-radius:18px;padding:32px 28px;max-width:500px;width:90%;position:relative;box-shadow:0 24px 64px rgba(0,0,0,.18);display:flex;flex-direction:column;">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('edit-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:18px;right:18px;width:28px;height:28px;
            border:none;background:none;cursor:pointer;color:#9CA3B0;
            font-size:20px;line-height:1;border-radius:8px;transition:background .15s;"
            onmouseover="this.style.background='#F7F8FA'"
            onmouseout="this.style.background='none'">&#215;</button>

        <div style="margin-bottom:20px;">
            <h2 style="font-size:18px;font-weight:900;color:#0F0F14;margin:0 0 4px;">Edit Materi</h2>
            <p style="color:#6B7280;font-size:13px;margin:0;">Ubah informasi materi pelatihan.</p>
        </div>

        <form id="edit-materi-form" method="POST" action="">
            @csrf
            @method('PUT')
            
            {{-- JUDUL MATERI --}}
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px;">JUDUL <span style="font-weight:500;text-transform:none;color:#9CA3B0;">Materi</span></label>
                <input type="text" id="edit-judul" name="judul_materi" value="{{ old('judul_materi') }}" required class="fcc-input" style="padding:8px 12px;font-size:13px;">
                @if($errors->has('judul_materi') && session('materi_id'))
                    <p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $errors->first('judul_materi') }}</p>
                @endif
            </div>

            {{-- JAM PELAJARAN --}}
            <div style="margin-bottom:24px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px;">JAM PELAJARAN <span style="font-weight:500;text-transform:none;color:#9CA3B0;">(JP)</span></label>
                <input type="number" id="edit-jp" name="jam_pelajaran" value="{{ old('jam_pelajaran') }}" min="1" required class="fcc-input" style="padding:8px 12px;font-size:13px;">
                @if($errors->has('jam_pelajaran') && session('materi_id'))
                    <p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $errors->first('jam_pelajaran') }}</p>
                @endif
            </div>

            <div style="display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="document.getElementById('edit-modal').style.display='none'" style="padding:10px 20px;border-radius:10px;border:1px solid #E2E4EB;background:#FFF;color:#6B7280;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='#F7F8FA';this.style.color='#131218'" onmouseout="this.style.background='#FFF';this.style.color='#6B7280'">Batal</button>
                <button type="submit" class="fcc-btn-gold" style="padding:10px 24px;font-size:13px;font-weight:800;border:none;border-radius:10px;cursor:pointer;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(url, judul, jp) {
        const form = document.getElementById('edit-materi-form');
        form.action = url;
        
        document.getElementById('edit-judul').value = judul;
        document.getElementById('edit-jp').value = jp;
        
        document.getElementById('edit-modal').style.display = 'flex';
    }
</script>
