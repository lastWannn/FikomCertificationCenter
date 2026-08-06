@extends('layouts.admin')
@section('title','Kategori')
@section('page-title','Kategori')
@section('page-content')

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.5);text-align:center;position:relative;animation:modalIn .25s ease;">
        <div id="fcc-confirm-icon" style="width:56px;height:56px;border-radius:16px;background:rgba(239,68,68,.15);border:1.5px solid rgba(239,68,68,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Kategori?</h3>
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
<div id="kategori-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;overflow-y:auto;padding:24px 0;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:500px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,.5);animation:modalIn .25s ease;margin:auto;position:relative;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h2 id="modal-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 4px;">Tambah Kategori Baru</h2>
                <p style="color:rgba(255,255,255,.4);font-size:13px;margin:0;">Masukkan nama kategori pelatihan/sertifikasi.</p>
            </div>
            <button onclick="closeKategoriModal()" style="width:36px;height:36px;border-radius:10px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.6);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;line-height:1;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">&times;</button>
        </div>

        <form id="kategori-form" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Nama Kategori <span style="color:#EF4444;">*</span></label>
                <input type="text" name="nama_kategori" id="f-nama" required placeholder="Contoh: Desain Grafis" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'" onkeydown="if(event.key==='Enter')event.preventDefault();">
            </div>

            <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="closeKategoriModal()" style="padding:11px 24px;border-radius:12px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);font-size:14px;font-weight:700;cursor:pointer;">Batal</button>
                <button type="button" onclick="document.getElementById('kategori-form').submit();" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
.kategori-row:hover { background:#FAFAFC; }
</style>

<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;max-width:900px;margin:0 auto 24px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Daftar Kategori</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Kelola semua kategori program pelatihan & sertifikasi.</p>
        </div>
        <button onclick="openKategoriModal()" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;border:none;cursor:pointer;">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Kategori
        </button>
    </div>

    <div class="fcc-card" style="padding:0;overflow:hidden;max-width:900px;margin:0 auto;">
        <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="background:#F7F8FA;border-bottom:2px solid #E2E4EB;">
                <th style="padding:12px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Kategori</th>
                <th style="padding:12px 12px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Pelatihan</th>
                <th style="padding:12px 12px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Sertifikasi</th>
                <th style="padding:12px 20px;text-align:right;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategori as $kat)
            <tr style="border-top:1px solid #F0F1F5; transition: background .15s;" class="kategori-row">
            <td style="padding:16px 20px;">
                <span style="font-size:14px;font-weight:700;color:#131218;">{{ $kat->nama_kategori }}</span>
            </td>
            <td style="padding:16px 12px;text-align:center;">
                <span style="font-size:13px;font-weight:700;color:#131218;background:rgba(255,200,26,.15);color:#D97706;padding:4px 10px;border-radius:20px;">{{ $kat->pelatihan_count }}</span>
            </td>
            <td style="padding:16px 12px;text-align:center;">
                <span style="font-size:13px;font-weight:700;color:#131218;background:rgba(139,92,246,.1);color:#6D28D9;padding:4px 10px;border-radius:20px;">{{ $kat->sertifikasi_count }}</span>
            </td>
            <td style="padding:16px 20px;text-align:right;">
                <div style="display:inline-flex;gap:8px;align-items:center;">
                <button onclick="openEditKategoriModal({{ $kat->id }}, '{{ addslashes($kat->nama_kategori) }}')" title="Edit"
                    style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;transition:color .15s;"
                    onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#9CA3B0'">
                    @include('components.icon',['name'=>'edit','size'=>14])
                </button>
                <button onclick="confirmKategoriDelete('{{ route('admin.kategori.destroy', $kat->hashid) }}', '{{ addslashes($kat->nama_kategori) }}')"
                        style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;transition:color .15s;"
                        onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3B0'">
                    @include('components.icon',['name'=>'trash','size'=>14])
                </button>
                </div>
            </td>
            </tr>
            @empty
            <tr><td colspan="4" style="padding:48px;text-align:center;color:#9CA3B0;font-size:14px;">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
        </table>
        @if($kategori->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;">{{ $kategori->links() }}</div>
        @endif
    </div>
</div>

<script>
const STORE_URL = '{{ route('admin.kategori.store') }}';
const UPDATE_URLS = @json($kategori->pluck('hashid', 'id')->map(fn($hashid) => route('admin.kategori.update', $hashid)));

function openKategoriModal() {
    document.getElementById('modal-title').innerText = 'Tambah Kategori Baru';
    document.getElementById('kategori-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    document.getElementById('f-nama').value = '';
    showModal('kategori-modal');
}

function openEditKategoriModal(id, nama) {
    document.getElementById('modal-title').innerText = 'Edit Kategori';
    document.getElementById('kategori-form').action = UPDATE_URLS[id];
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('f-nama').value = nama;
    showModal('kategori-modal');
}

function closeKategoriModal() {
    document.getElementById('kategori-modal').style.display = 'none';
}

function confirmKategoriDelete(url, name) {
    document.getElementById('fcc-confirm-title').innerText = 'Hapus Kategori?';
    document.getElementById('fcc-confirm-msg').innerText = `Kategori "${name}" akan dihapus. Pelatihan dan Sertifikasi yang terkait mungkin akan kehilangan data kategori ini.`;
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
document.getElementById('kategori-modal').addEventListener('click', function(e) {
    if (e.target === this) closeKategoriModal();
});
document.getElementById('fcc-confirm-modal').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Watch overflow
[document.getElementById('kategori-modal'), document.getElementById('fcc-confirm-modal')].forEach(el => {
    const obs = new MutationObserver(() => {
        const visible = document.getElementById('kategori-modal').style.display !== 'none' ||
                        document.getElementById('fcc-confirm-modal').style.display !== 'none';
        document.body.style.overflow = visible ? 'hidden' : '';
    });
    obs.observe(el, { attributes: true, attributeFilter: ['style'] });
});
</script>
@endsection
