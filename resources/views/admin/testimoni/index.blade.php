@extends('layouts.admin')
@section('title','Kata Mereka (Testimoni)')
@section('page-title', 'Kata Mereka')
@section('page-content')

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.5);text-align:center;position:relative;animation:modalIn .25s ease;">
        <div id="fcc-confirm-icon" style="width:56px;height:56px;border-radius:16px;background:rgba(239,68,68,.15);border:1.5px solid rgba(239,68,68,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Testimoni?</h3>
        <p id="fcc-confirm-msg" style="color:rgba(255,255,255,.55);font-size:14px;margin:0 0 28px;line-height:1.6;"></p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="closeConfirm()" style="padding:11px 28px;border-radius:12px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">Batal</button>
            <form id="fcc-confirm-form" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" style="padding:11px 28px;border-radius:12px;border:none;background:linear-gradient(135deg,#EF4444,#DC2626);color:#FFF;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 15px rgba(239,68,68,.3);transition:all .2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- ── Form Modal (Create/Edit) ─────────────────────────────────── --}}
<div id="testimoni-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;overflow-y:auto;padding:24px 0;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:580px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,.5);animation:modalIn .25s ease;margin:auto;position:relative;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h2 id="modal-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 4px;">Tambah Testimoni Baru</h2>
                <p style="color:rgba(255,255,255,.4);font-size:13px;margin:0;">Isi ulasan yang akan tampil di Landing Page.</p>
            </div>
            <button onclick="closeTestimoniModal()" style="width:36px;height:36px;border-radius:10px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.6);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;line-height:1;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">&times;</button>
        </div>

        <form id="testimoni-form" method="POST" enctype="multipart/form-data" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div style="display:grid;grid-template-columns:1fr;gap:16px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Nama <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="nama" id="f-nama" required placeholder="Contoh: Budi Santoso" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Keterangan / Status <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="keterangan" id="f-keterangan" required placeholder="Contoh: Mahasiswa Teknik, Mitra Perusahaan" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Rating (Bintang) <span style="color:#EF4444;">*</span></label>
                    <select name="rating" id="f-rating" required style="width:100%;background-color:rgba(255,255,255,.05);background-image:url(&quot;data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23FFF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e&quot;);background-repeat:no-repeat;background-position:right 14px center;background-size:16px;border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 40px 10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;-webkit-appearance:none;appearance:none;cursor:pointer;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                        <option value="5" style="background:#1C1B22;color:#FFF;">⭐⭐⭐⭐⭐ (5) Sangat Puas</option>
                        <option value="4" style="background:#1C1B22;color:#FFF;">⭐⭐⭐⭐ (4) Puas</option>
                        <option value="3" style="background:#1C1B22;color:#FFF;">⭐⭐⭐ (3) Cukup</option>
                        <option value="2" style="background:#1C1B22;color:#FFF;">⭐⭐ (2) Kurang</option>
                        <option value="1" style="background:#1C1B22;color:#FFF;">⭐ (1) Sangat Kurang</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Kata (Ulasan) <span style="color:#EF4444;">*</span></label>
                    <textarea name="kata" id="f-kata" required rows="4" placeholder="Tulis testimoni/ulasan..." style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;resize:vertical;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'"></textarea>
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Upload Foto Profil</label>
                    <input type="file" name="foto" id="f-foto" accept="image/*" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:8px 14px;color:rgba(255,255,255,.6);font-size:13px;outline:none;box-sizing:border-box;cursor:pointer;">
                    <p id="f-foto-hint" style="font-size:11px;color:rgba(255,255,255,.3);margin:5px 0 0;">Format: JPG/PNG, maks 2MB.</p>
                    <div id="f-foto-preview" style="margin-top:10px;display:none;">
                        <img id="f-foto-img" src="" alt="Foto Saat Ini" style="width:48px;height:48px;object-fit:cover;border-radius:50%;border:2px solid rgba(255,200,26,.3);">
                    </div>
                </div>
            </div>

            <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="closeTestimoniModal()" style="padding:11px 24px;border-radius:12px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);font-size:14px;font-weight:700;cursor:pointer;">Batal</button>
                <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Main Content ─────────────────────────────────────────────── --}}
<style>
@keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
.testimoni-card-admin { background:#FFF; border:1.5px solid #E8EAF0; border-radius:16px; padding:20px; transition:all .2s; display:flex; flex-direction:column; justify-content:space-between; }
.testimoni-card-admin:hover { border-color:#FFC81A; box-shadow:0 6px 24px rgba(255,200,26,.12); transform:translateY(-3px); }
input[type="file"]::file-selector-button { cursor: pointer; }
</style>

<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Kata Mereka (Testimoni)</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Kelola ulasan/testimoni dari peserta yang akan tampil di halaman utama.</p>
        </div>
        <button onclick="openTestimoniModal()" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;border:none;cursor:pointer;">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Testimoni
        </button>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:16px;">
        @forelse($testimonis as $t)
        <div class="testimoni-card-admin">
            <div>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                    <div style="width:44px;height:44px;border-radius:50%;background:#F4F5F7;border:1px solid #E0E2E8;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
                        @if($t->foto)
                            <img src="{{ asset('storage/'.$t->foto) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C0C4CF" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        @endif
                    </div>
                    <div>
                        <h3 style="font-size:14px;font-weight:800;color:#0F0F14;margin:0 0 2px;">{{ $t->nama }}</h3>
                        <div style="display:flex;gap:2px;margin-bottom:3px;">
                            @for($i=0;$i<5;$i++)
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="{{ $i < $t->rating ? '#FFC81A' : '#E0E2E8' }}"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                        </div>
                        <p style="font-size:11px;color:#6B7280;margin:0;font-weight:600;">{{ $t->keterangan }}</p>
                    </div>
                </div>
                <div style="background:#F9FAFB;border-radius:10px;padding:12px;margin-bottom:16px;position:relative;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:rgba(255,200,26,.3);position:absolute;top:8px;left:8px;"><path d="M11.3 6.2H5.8c-1.4 0-2.5 1.1-2.5 2.5V14c0 1.4 1.1 2.5 2.5 2.5h2.9l-2.6 3.1h3.7l2.8-3.3V6.2zm10.1 0h-5.5c-1.4 0-2.5 1.1-2.5 2.5V14c0 1.4 1.1 2.5 2.5 2.5h2.9l-2.6 3.1h3.7l2.8-3.3V6.2z"/></svg>
                    <p style="font-size:12px;color:#4B5563;margin:0;line-height:1.5;padding-left:14px;font-style:italic;">
                        "{{ Str::limit($t->kata, 120) }}"
                    </p>
                </div>
            </div>
            
            {{-- Actions --}}
            <div style="display:flex;gap:8px;">
                <button onclick="openEditTestimoniModal({{ $t->id }}, '{{ addslashes($t->nama) }}', '{{ addslashes($t->keterangan) }}', {{ $t->rating }}, '{{ addslashes(preg_replace('/\r|\n/', '\\n', $t->kata)) }}', {{ $t->foto ? "'".asset('storage/'.$t->foto)."'" : 'null' }})"
                    style="flex:1;padding:8px 0;border-radius:10px;border:1.5px solid #E2E4EB;background:#F7F8FA;color:#6B7280;font-size:12px;font-weight:700;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:5px;"
                    onmouseover="this.style.borderColor='#FFC81A';this.style.color='#131218'" onmouseout="this.style.borderColor='#E2E4EB';this.style.color='#6B7280'">
                    @include('components.icon',['name'=>'edit','size'=>13]) Edit
                </button>
                <button onclick="confirmTestimoniDelete('{{ route('admin.testimoni.destroy', $t) }}', '{{ addslashes($t->nama) }}')"
                    style="padding:8px 14px;border-radius:10px;border:1.5px solid rgba(239,68,68,.2);background:rgba(239,68,68,.05);color:#EF4444;font-size:12px;cursor:pointer;transition:all .2s;display:flex;align-items:center;"
                    onmouseover="this.style.background='rgba(239,68,68,.12)'" onmouseout="this.style.background='rgba(239,68,68,.05)'">
                    @include('components.icon',['name'=>'trash','size'=>13])
                </button>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;padding:56px;text-align:center;color:#A0A3AD;" class="fcc-card">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.5" style="margin:0 auto 12px;display:block;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Belum ada data ulasan (Testimoni). Klik "Tambah Testimoni" untuk memulai.
        </div>
        @endforelse
    </div>
</div>

<script>
const STORE_URL = '{{ route('admin.testimoni.store') }}';
const UPDATE_URLS = @json($testimonis->pluck('id')->mapWithKeys(fn($id) => [$id => route('admin.testimoni.update', $id)]));

function openTestimoniModal() {
    document.getElementById('modal-title').innerText = 'Tambah Testimoni Baru';
    document.getElementById('testimoni-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    document.getElementById('f-nama').value = '';
    document.getElementById('f-keterangan').value = '';
    document.getElementById('f-rating').value = '5';
    document.getElementById('f-kata').value = '';
    document.getElementById('f-foto').value = '';
    document.getElementById('f-foto-preview').style.display = 'none';
    document.getElementById('f-foto-hint').innerText = 'Format: JPG/PNG, maks 2MB.';
    showModal('testimoni-modal');
}

function openEditTestimoniModal(id, nama, keterangan, rating, kata, fotoUrl) {
    document.getElementById('modal-title').innerText = 'Edit Testimoni';
    document.getElementById('testimoni-form').action = UPDATE_URLS[id];
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('f-nama').value = nama;
    document.getElementById('f-keterangan').value = keterangan;
    document.getElementById('f-rating').value = rating;
    document.getElementById('f-kata').value = kata.replace(/\\n/g, '\n');
    document.getElementById('f-foto').value = '';
    
    const preview = document.getElementById('f-foto-preview');
    if (fotoUrl) {
        document.getElementById('f-foto-img').src = fotoUrl;
        preview.style.display = 'block';
        document.getElementById('f-foto-hint').innerText = 'Biarkan kosong jika tidak ingin mengubah foto.';
    } else {
        preview.style.display = 'none';
        document.getElementById('f-foto-hint').innerText = 'Format: JPG/PNG, maks 2MB. Opsional.';
    }
    showModal('testimoni-modal');
}

function closeTestimoniModal() {
    document.getElementById('testimoni-modal').style.display = 'none';
}

function confirmTestimoniDelete(url, name) {
    document.getElementById('fcc-confirm-title').innerText = 'Hapus Testimoni?';
    document.getElementById('fcc-confirm-msg').innerText = `Ulasan dari "${name}" akan dihapus secara permanen.`;
    document.getElementById('fcc-confirm-form').action = url;
    showModal('fcc-confirm-modal');
}

function closeConfirm() {
    document.getElementById('fcc-confirm-modal').style.display = 'none';
}

function showModal(id) {
    const el = document.getElementById(id);
    el.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Close on backdrop click
document.getElementById('testimoni-modal').addEventListener('click', function(e) {
    if (e.target === this) closeTestimoniModal();
});
document.getElementById('fcc-confirm-modal').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Watch overflow
[document.getElementById('testimoni-modal'), document.getElementById('fcc-confirm-modal')].forEach(el => {
    const obs = new MutationObserver(() => {
        const visible = document.getElementById('testimoni-modal').style.display !== 'none' ||
                        document.getElementById('fcc-confirm-modal').style.display !== 'none';
        document.body.style.overflow = visible ? 'hidden' : '';
    });
    obs.observe(el, { attributes: true, attributeFilter: ['style'] });
});
</script>
@endsection
