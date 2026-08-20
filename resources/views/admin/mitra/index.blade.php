@extends('layouts.admin')
@section('title','Mitra & Partner')
@section('page-title', 'Mitra & Partner')
@section('page-content')

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(19,18,24,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="background:#FFFFFF;border:2.5px solid #131218;border-radius:24px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.35);text-align:center;position:relative;animation:modalIn .25s ease;">
        <div id="fcc-confirm-icon" style="width:56px;height:56px;border-radius:16px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;color:#EF4444;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#131218;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Mitra?</h3>
        <p id="fcc-confirm-msg" style="color:#64748B;font-size:13.5px;margin:0 0 28px;line-height:1.6;font-weight:500;"></p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button type="button" onclick="closeConfirm()" style="padding:11px 24px;border-radius:12px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:13.5px;font-weight:800;cursor:pointer;transition:all .2s;">Batal</button>
            <form id="fcc-confirm-form" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" style="padding:11px 24px;border-radius:12px;border:1px solid #131218;background:#DC2626;color:#FFF;font-size:13.5px;font-weight:800;cursor:pointer;box-shadow:0 4px 15px rgba(220,38,38,.3);transition:all .2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- ── Form Modal (Create/Edit) ─────────────────────────────────── --}}
<div id="mitra-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;overflow-y:auto;padding:24px 0;">
    <div style="background:#FFFFFF;border:2.5px solid #131218;border-radius:24px;padding:32px;max-width:540px;width:90%;box-shadow:0 24px 64px rgba(0,0,0,.35);animation:modalIn .25s ease;margin:auto;position:relative;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;border-bottom:2px solid #E5E7EB;padding-bottom:16px;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                    <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Kemitraan</span>
                </div>
                <h2 id="modal-title" style="color:#131218;font-size:19px;font-weight:900;margin:0;">Tambah Mitra Baru</h2>
            </div>
            <button type="button" onclick="closeMitraModal()" style="width:36px;height:36px;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;line-height:1;font-weight:900;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">&times;</button>
        </div>

        <form id="mitra-form" method="POST" enctype="multipart/form-data" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="_id" id="form-id" value="">

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Nama Mitra *</label>
                <input type="text" name="nama_mitra" id="f-nama" required placeholder="Contoh: Microsoft Indonesia" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:600;outline:none;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Link Website</label>
                <input type="url" name="link_website" id="f-link" placeholder="https://..." class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:600;outline:none;box-sizing:border-box;">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Upload Logo Mitra</label>
                <input type="file" name="logo" id="f-logo" accept="image/*" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:8px 14px;color:#131218;font-size:13px;outline:none;box-sizing:border-box;cursor:pointer;">
                <p id="f-logo-hint" style="font-size:11px;color:#94A3B8;margin:5px 0 0;font-weight:500;">Format: JPG/PNG/WebP, maks 2MB. Kosongkan jika tidak ingin mengubah logo.</p>
                <div id="f-logo-preview" style="margin-top:12px;display:none;">
                    <img id="f-logo-img" src="" alt="Logo Saat Ini" style="height:52px;border-radius:10px;border:1.5px solid #E2E4EB;padding:4px;background:#FFF;object-fit:contain;">
                    <p style="font-size:11px;color:#64748B;margin:4px 0 0;font-weight:600;">Logo saat ini</p>
                </div>
            </div>

            <div style="border-top:1.5px solid #E2E4EB;padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="closeMitraModal()" style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border:1.5px solid #131218;border-radius:10px;cursor:pointer;">Batal</button>
                <button type="submit" style="padding:10px 22px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Simpan Mitra</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Main Content ─────────────────────────────────────────────── --}}
<style>
@keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
.mitra-card-admin { background:#FFFFFF; border:2px solid #E5E7EB; border-radius:20px; padding:20px; transition:all .18s; cursor:default; box-shadow:0 4px 16px rgba(0,0,0,0.03); }
.mitra-card-admin:hover { border-color:#131218; box-shadow:0 6px 24px rgba(0,0,0,0.06); transform:translateY(-3px); }
input[type="file"]::file-selector-button { cursor: pointer; }
</style>

<div style="padding:24px;">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(16,185,129,0.12);border:1.5px solid rgba(16,185,129,0.3);color:#059669;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#059669;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(239,68,68,0.12);border:1.5px solid rgba(239,68,68,0.3);color:#DC2626;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('error') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#DC2626;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
    </div>
    @endif

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Kemitraan &amp; Partner</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Logo Mitra &amp; Partner</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola logo partner yang tampil di halaman depan website.</p>
        </div>
        <button type="button" onclick="openMitraModal()"
                style="padding:10px 18px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.1);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Mitra Baru
        </button>
    </div>

    {{-- Mitra Cards Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(260px, 1fr));gap:20px;">
        @forelse($mitras as $m)
        <div class="mitra-card-admin">
            {{-- Logo Preview --}}
            <div style="width:100%;height:96px;border-radius:14px;background:#F8FAFC;display:flex;align-items:center;justify-content:center;margin-bottom:16px;border:1.5px dashed #CBD5E1;overflow:hidden;position:relative;">
                @if($m->logo)
                    <img src="{{ asset('storage/'.$m->logo) }}" alt="{{ $m->nama_mitra }}" style="max-width:80%;max-height:75%;object-fit:contain;">
                @else
                    <div style="display:flex;flex-direction:column;align-items:center;gap:4px;color:#94A3B8;">
                        @include('components.icon',['name'=>'users','size'=>22,'style'=>'color:#9CA3B0'])
                        <span style="font-size:11px;font-weight:700;">Tanpa Logo</span>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <h3 style="font-size:15.5px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $m->nama_mitra }}</h3>
            @if($m->link_website)
            <a href="{{ $m->link_website }}" target="_blank" style="font-size:12px;color:#059669;font-weight:700;text-decoration:none;display:flex;align-items:center;gap:4px;margin-bottom:16px;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                {{ Str::limit($m->link_website, 30) }}
            </a>
            @else
            <p style="font-size:12px;color:#94A3B8;margin:0 0 16px;font-weight:500;">Tidak ada link website</p>
            @endif

            {{-- Actions --}}
            <div style="display:flex;gap:8px;">
                <button type="button" onclick="openEditModal({{ json_encode($m) }}, '{{ $m->logo ? asset('storage/'.$m->logo) : '' }}')"
                        style="flex:1;padding:8px 0;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:12px;font-weight:800;cursor:pointer;transition:all .18s;display:flex;align-items:center;justify-content:center;gap:5px;"
                        onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">
                    @include('components.icon',['name'=>'edit','size'=>13]) Edit
                </button>
                <button type="button" onclick="confirmDelete('{{ route('admin.mitra.destroy', $m) }}', {{ json_encode($m->nama_mitra) }})"
                        style="padding:8px 14px;border-radius:10px;border:1px solid #FCA5A5;background:#FEF2F2;color:#EF4444;font-size:12px;cursor:pointer;transition:all .18s;display:flex;align-items:center;"
                        onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';">
                    @include('components.icon',['name'=>'trash','size'=>13])
                </button>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;padding:56px;text-align:center;color:#94A3B8;border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;" class="fcc-card">
            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
            </div>
            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Data Mitra / Partner</p>
            <p style="font-size:12.5px;color:#64748B;margin:0;">Klik "Tambah Mitra Baru" untuk menambahkan partner pertama.</p>
        </div>
        @endforelse
    </div>

    @if($mitras->hasPages())
    <div style="margin-top:24px;padding:14px 20px;background:#FFFFFF;border-radius:16px;border:2px solid #E5E7EB;">
        {{ $mitras->links() }}
    </div>
    @endif
</div>

<script>
const STORE_URL = '{{ route('admin.mitra.store') }}';
const UPDATE_URLS = @json($mitras->getCollection()->mapWithKeys(fn($m) => [$m->id => route('admin.mitra.update', $m->id)]));

// ── Modal helpers ──────────────────────────────────────
function openMitraModal() {
    document.getElementById('modal-title').innerText = 'Tambah Mitra Baru';
    document.getElementById('mitra-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('f-nama').value = '';
    document.getElementById('f-link').value = '';
    document.getElementById('f-logo').value = '';
    document.getElementById('f-logo-preview').style.display = 'none';
    document.getElementById('f-logo-hint').innerText = 'Format: JPG/PNG/WebP, maks 2MB.';
    showModal('mitra-modal');
}

function openEditModal(mitra, logoAssetUrl) {
    document.getElementById('modal-title').innerText = 'Edit Mitra';
    document.getElementById('mitra-form').action = UPDATE_URLS[mitra.id] || `/admin/mitra/${mitra.id}`;
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = mitra.id;
    document.getElementById('f-nama').value = mitra.nama_mitra || '';
    document.getElementById('f-link').value = mitra.link_website || '';
    document.getElementById('f-logo').value = '';
    
    const preview = document.getElementById('f-logo-preview');
    if (logoAssetUrl) {
        document.getElementById('f-logo-img').src = logoAssetUrl;
        preview.style.display = 'block';
        document.getElementById('f-logo-hint').innerText = 'Biarkan kosong jika tidak ingin mengubah logo.';
    } else {
        preview.style.display = 'none';
        document.getElementById('f-logo-hint').innerText = 'Format: JPG/PNG/WebP, maks 2MB. Opsional.';
    }
    showModal('mitra-modal');
}

function closeMitraModal() {
    const modal = document.getElementById('mitra-modal');
    if(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

// ── Confirm Delete ─────────────────────────────────────
function confirmDelete(url, name) {
    document.getElementById('fcc-confirm-title').innerText = 'Hapus Mitra?';
    document.getElementById('fcc-confirm-msg').innerText = `Data mitra "${name}" akan dihapus secara permanen. Tindakan ini tidak bisa dibatalkan.`;
    document.getElementById('fcc-confirm-form').action = url;
    showModal('fcc-confirm-modal');
}

function closeConfirm() {
    const modal = document.getElementById('fcc-confirm-modal');
    if(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function showModal(id) {
    const el = document.getElementById(id);
    if(el) {
        el.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

// Close on backdrop click
document.getElementById('mitra-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeMitraModal();
});
document.getElementById('fcc-confirm-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Re-open modal if validation errors exist
document.addEventListener('DOMContentLoaded', () => {
    @if($errors->any())
        openMitraModal();
    @endif
});
</script>
@endsection



