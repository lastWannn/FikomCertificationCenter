@extends('layouts.admin')
@section('title','Mitra & Partner')
@section('page-title', 'Mitra & Partner')
@section('page-content')

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.5);text-align:center;position:relative;animation:modalIn .25s ease;">
        <div id="fcc-confirm-icon" style="width:56px;height:56px;border-radius:16px;background:rgba(239,68,68,.15);border:1.5px solid rgba(239,68,68,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Mitra?</h3>
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
<div id="mitra-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;overflow-y:auto;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:580px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,.5);animation:modalIn .25s ease;margin:auto;position:relative;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h2 id="modal-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 4px;">Tambah Mitra Baru</h2>
                <p style="color:rgba(255,255,255,.4);font-size:13px;margin:0;">Isi detail mitra/partner yang akan tampil di Landing Page.</p>
            </div>
            <button onclick="closeMitraModal()" style="width:36px;height:36px;border-radius:10px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.6);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;line-height:1;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">&times;</button>
        </div>

        <form id="mitra-form" method="POST" enctype="multipart/form-data" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="_id" id="form-id" value="">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                <div style="grid-column:span 2;">
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Nama Mitra <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="nama_mitra" id="f-nama" required placeholder="Contoh: Microsoft Indonesia" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Inisial <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="inisial" id="f-inisial" required maxlength="10" placeholder="Misal: MS, CSC" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Urutan Tampil</label>
                    <input type="number" name="urutan" id="f-urutan" min="1" value="1" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Warna Utama</label>
                    <input type="color" name="warna" id="f-warna" value="#059669" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:6px;height:42px;outline:none;cursor:pointer;">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Link Website</label>
                    <input type="url" name="link_website" id="f-link" placeholder="https://..." style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                </div>
                <div style="grid-column:span 2;">
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Upload Logo</label>
                    <input type="file" name="logo" id="f-logo" accept="image/*" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:8px 14px;color:rgba(255,255,255,.6);font-size:13px;outline:none;box-sizing:border-box;cursor:pointer;">
                    <p id="f-logo-hint" style="font-size:11px;color:rgba(255,255,255,.3);margin:5px 0 0;">Format: JPG/PNG, maks 2MB. Kosongkan jika tidak ingin mengubah logo.</p>
                    <div id="f-logo-preview" style="margin-top:10px;display:none;">
                        <img id="f-logo-img" src="" alt="Logo Saat Ini" style="height:48px;border-radius:8px;border:1px solid rgba(255,255,255,.1);">
                        <p style="font-size:11px;color:rgba(255,255,255,.4);margin:4px 0 0;">Logo saat ini</p>
                    </div>
                </div>
            </div>

            <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="closeMitraModal()" style="padding:11px 24px;border-radius:12px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);font-size:14px;font-weight:700;cursor:pointer;">Batal</button>
                <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Main Content ─────────────────────────────────────────────── --}}
<style>
@keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
.mitra-card-admin { background:#FFF; border:1.5px solid #E8EAF0; border-radius:16px; padding:20px; transition:all .2s; cursor:default; }
.mitra-card-admin:hover { border-color:#FFC81A; box-shadow:0 6px 24px rgba(255,200,26,.12); transform:translateY(-3px); }
input[type="number"]::-webkit-outer-spin-button,input[type="number"]::-webkit-inner-spin-button { -webkit-appearance:none; margin:0; }
input[type="file"]::file-selector-button { cursor: pointer; }
</style>

<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Logo Mitra & Partner</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Kelola logo partner yang tampil di Landing Page. Urutan tampil sesuai angka yang diisi.</p>
        </div>
        <button onclick="openMitraModal()" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;border:none;cursor:pointer;">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Mitra
        </button>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(260px, 1fr));gap:16px;">
        @forelse($mitras as $m)
        <div class="mitra-card-admin">
            {{-- Logo Preview --}}
            <div style="width:100%;height:88px;border-radius:10px;background:{{ $m->warna ? $m->warna.'18' : '#F4F5F7' }};display:flex;align-items:center;justify-content:center;margin-bottom:14px;border:1px dashed #E0E2E8;overflow:hidden;position:relative;">
                @if($m->logo)
                    <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}" style="max-width:75%;max-height:70%;object-fit:contain;">
                @else
                    <span style="font-size:26px;font-weight:900;color:{{ $m->warna ?: '#C0C4CF' }}">{{ $m->inisial }}</span>
                @endif
                <span style="position:absolute;top:8px;right:8px;background:rgba(0,0,0,.06);border-radius:6px;padding:2px 8px;font-size:10px;font-weight:700;color:#6B7280;">#{{ $m->urutan ?? '—' }}</span>
            </div>

            {{-- Info --}}
            <h3 style="font-size:15px;font-weight:900;color:#0F0F14;margin:0 0 4px;">{{ $m->nama_mitra }}</h3>
            @if($m->link_website)
            <a href="{{ $m->link_website }}" target="_blank" style="font-size:12px;color:#3B82F6;text-decoration:none;display:flex;align-items:center;gap:4px;margin-bottom:14px;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                {{ Str::limit($m->link_website, 32) }}
            </a>
            @else
            <p style="font-size:12px;color:#C0C4CF;margin:0 0 14px;">Tidak ada link</p>
            @endif

            {{-- Actions --}}
            <div style="display:flex;gap:8px;">
                <button onclick="openEditModal({{ $m->id }}, '{{ addslashes($m->nama_mitra) }}', '{{ addslashes($m->inisial) }}', {{ $m->urutan ?? 1 }}, '{{ addslashes($m->warna ?? '') }}', '{{ addslashes($m->link_website ?? '') }}', {{ $m->logo ? "'".asset('storage/'.$m->logo)."'" : 'null' }})"
                    style="flex:1;padding:8px 0;border-radius:10px;border:1.5px solid #E2E4EB;background:#F7F8FA;color:#6B7280;font-size:12px;font-weight:700;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:5px;"
                    onmouseover="this.style.borderColor='#FFC81A';this.style.color='#131218'" onmouseout="this.style.borderColor='#E2E4EB';this.style.color='#6B7280'">
                    @include('components.icon',['name'=>'edit','size'=>13]) Edit
                </button>
                <button onclick="confirmDelete('{{ route('admin.mitra.destroy', $m) }}', '{{ addslashes($m->nama_mitra) }}')"
                    style="padding:8px 14px;border-radius:10px;border:1.5px solid rgba(239,68,68,.2);background:rgba(239,68,68,.05);color:#EF4444;font-size:12px;cursor:pointer;transition:all .2s;display:flex;align-items:center;"
                    onmouseover="this.style.background='rgba(239,68,68,.12)'" onmouseout="this.style.background='rgba(239,68,68,.05)'">
                    @include('components.icon',['name'=>'trash','size'=>13])
                </button>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;padding:56px;text-align:center;color:#A0A3AD;" class="fcc-card">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.5" style="margin:0 auto 12px;display:block;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Belum ada data mitra. Klik "Tambah Mitra" untuk menambahkan.
        </div>
        @endforelse
    </div>
    @if($mitras->hasPages())
    <div style="margin-top:20px;padding:14px 20px;background:#FFF;border-radius:12px;border:1px solid #E2E4EB;">
        {{ $mitras->links() }}
    </div>
    @endif
</div>

<script>
const STORE_URL = '{{ route('admin.mitra.store') }}';
const UPDATE_URLS = @json($mitras->pluck('id')->mapWithKeys(fn($id) => [$id => route('admin.mitra.update', $id)]));

// ── Modal helpers ──────────────────────────────────────
function openMitraModal() {
    document.getElementById('modal-title').innerText = 'Tambah Mitra Baru';
    document.getElementById('mitra-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('f-nama').value = '';
    document.getElementById('f-inisial').value = '';
    document.getElementById('f-urutan').value = 1;
    document.getElementById('f-warna').value = '#059669';
    document.getElementById('f-link').value = '';
    document.getElementById('f-logo').value = '';
    document.getElementById('f-logo-preview').style.display = 'none';
    document.getElementById('f-logo-hint').innerText = 'Format: JPG/PNG, maks 2MB.';
    showModal('mitra-modal');
}

function openEditModal(id, nama, inisial, urutan, warna, link, logoUrl) {
    document.getElementById('modal-title').innerText = 'Edit Mitra';
    document.getElementById('mitra-form').action = UPDATE_URLS[id];
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = id;
    document.getElementById('f-nama').value = nama;
    document.getElementById('f-inisial').value = inisial;
    document.getElementById('f-urutan').value = urutan;
    document.getElementById('f-warna').value = warna || '#059669';
    document.getElementById('f-link').value = link;
    document.getElementById('f-logo').value = '';
    const preview = document.getElementById('f-logo-preview');
    if (logoUrl) {
        document.getElementById('f-logo-img').src = logoUrl;
        preview.style.display = 'block';
        document.getElementById('f-logo-hint').innerText = 'Biarkan kosong jika tidak ingin mengubah logo.';
    } else {
        preview.style.display = 'none';
        document.getElementById('f-logo-hint').innerText = 'Format: JPG/PNG, maks 2MB. Opsional.';
    }
    showModal('mitra-modal');
}

function closeMitraModal() {
    document.getElementById('mitra-modal').style.display = 'none';
}

// ── Confirm Delete ─────────────────────────────────────
function confirmDelete(url, name) {
    document.getElementById('fcc-confirm-title').innerText = 'Hapus Mitra?';
    document.getElementById('fcc-confirm-msg').innerText = `Data mitra "${name}" akan dihapus secara permanen. Tindakan ini tidak bisa dibatalkan.`;
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
document.getElementById('mitra-modal').addEventListener('click', function(e) {
    if (e.target === this) closeMitraModal();
});
document.getElementById('fcc-confirm-modal').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Auto close modals when not needed
[document.getElementById('mitra-modal'), document.getElementById('fcc-confirm-modal')].forEach(el => {
    const obs = new MutationObserver(() => {
        const visible = document.getElementById('mitra-modal').style.display !== 'none' ||
                        document.getElementById('fcc-confirm-modal').style.display !== 'none';
        document.body.style.overflow = visible ? 'hidden' : '';
    });
    obs.observe(el, { attributes: true, attributeFilter: ['style'] });
});
</script>
@endsection
