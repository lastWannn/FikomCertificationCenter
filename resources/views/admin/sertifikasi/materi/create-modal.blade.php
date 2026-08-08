{{-- ── TAMBAH MATERI SERTIFIKASI MODAL (Neo-Brutalist Glassmorphism) ────────────────────────────────────── --}}
<div id="create-modal" style="display:{{ $errors->has('judul_materi') && !session('materi_id') ? 'flex' : 'none' }};position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:540px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);display:flex;flex-direction:column;">
        
        {{-- Close Button --}}
        <button type="button" onclick="document.getElementById('create-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;">MODUL KURIKULUM</span>
                <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0;">Tambah Modul Materi Baru</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Isi rincian modul materi untuk sertifikasi ini.</p>
        </div>

        <form method="POST" action="{{ route('admin.materi-sertifikasi.store', $selectedSertifikasi) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="urutan" value="{{ $selectedSertifikasi->materi->count() + 1 }}">
            
            {{-- JUDUL MATERI --}}
            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Judul Modul Materi <span style="color:#EF4444;">*</span></label>
                <input type="text" name="judul_materi" value="{{ old('judul_materi') }}" placeholder="Contoh: Unit 1 - Dasar Kompetensi Uji" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                @if($errors->has('judul_materi') && !session('materi_id'))
                    <p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $errors->first('judul_materi') }}</p>
                @endif
            </div>

            {{-- DURASI (JP) --}}
            <div style="margin-bottom:24px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Durasi (JP) <span style="font-weight:500;text-transform:none;color:#94A3B8;">(Opsional)</span></label>
                <input type="text" name="isi" value="{{ old('isi') }}" placeholder="Contoh: 4 atau 4 JP" class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
            </div>

            <div style="display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="document.getElementById('create-modal').style.display='none'"
                        style="padding:11px 22px;font-size:13px;font-weight:800;color:#64748B;background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:30px;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
                    Batal
                </button>
                <button type="submit"
                        style="padding:11px 26px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
                        onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)';">
                    @include('components.icon',['name'=>'check','size'=>16]) Simpan Modul
                </button>
            </div>
        </form>
    </div>
</div>
