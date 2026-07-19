@extends('layouts.admin')
@section('title','Informasi & FAQ')
@section('page-title', 'Informasi & FAQ')
@section('page-content')

{{-- ══ Custom Confirm Delete Modal ════════════════════════════════ --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.5);text-align:center;animation:modalIn .25s ease;">
        <div style="width:56px;height:56px;border-radius:16px;background:rgba(239,68,68,.15);border:1.5px solid rgba(239,68,68,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="confirm-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Informasi?</h3>
        <p id="confirm-msg" style="color:rgba(255,255,255,.55);font-size:14px;margin:0 0 28px;line-height:1.6;"></p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="closeConfirm()" style="padding:11px 28px;border-radius:12px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">Batal</button>
            <form id="confirm-delete-form" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" style="padding:11px 28px;border-radius:12px;border:none;background:linear-gradient(135deg,#EF4444,#DC2626);color:#FFF;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 15px rgba(239,68,68,.3);">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- ══ Form Modal (Tambah / Edit) ════════════════════════════════ --}}
<div id="info-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,.65);backdrop-filter:blur(6px);align-items:flex-start;justify-content:center;overflow-y:auto;padding:24px 0;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:640px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,.5);animation:modalIn .25s ease;margin:auto;position:relative;">
        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h2 id="info-modal-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 4px;">Tambah Informasi / FAQ</h2>
                <p style="color:rgba(255,255,255,.4);font-size:13px;margin:0;">Isi form di bawah untuk menambahkan data baru.</p>
            </div>
            <button onclick="closeInfoModal()" style="width:36px;height:36px;border-radius:10px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.6);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">&times;</button>
        </div>

        <form id="info-form" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="info-method" value="POST">

            {{-- Jenis --}}
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.45);margin-bottom:8px;text-transform:uppercase;letter-spacing:.8px;">Jenis *</label>
                <div style="display:flex;gap:10px;">
                    @foreach(['info' => '📢 Informasi / Pengumuman', 'faq' => '❓ FAQ'] as $v => $l)
                    <label style="flex:1;display:flex;align-items:center;gap:10px;cursor:pointer;padding:12px 16px;border:1.5px solid rgba(255,255,255,.1);border-radius:12px;transition:border-color .2s;color:rgba(255,255,255,.7);font-size:14px;"
                           id="jenis-label-{{ $v }}"
                           onmouseover="this.style.borderColor='rgba(255,200,26,.4)'" 
                           onmouseout="syncJenisStyle()">
                        <input type="radio" name="jenis" id="modal-jenis-{{ $v }}" value="{{ $v }}" style="accent-color:#FFC81A;" onchange="onJenisChange()">
                        {{ $l }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Judul / Pengumuman --}}
            <div style="margin-bottom:16px;">
                <label id="judul-label-m" style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.45);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Isi Pengumuman *</label>
                <input type="text" name="judul" id="modal-judul" required placeholder="Tulis teks pengumuman..." style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
            </div>

            {{-- Isi / Jawaban (hanya FAQ) --}}
            <div id="isi-section-modal" style="margin-bottom:16px;display:none;">
                <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.45);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Jawaban / Penjelasan *</label>
                <textarea name="isi" id="modal-isi" rows="5" placeholder="Tulis jawaban untuk pertanyaan FAQ ini..." style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;resize:vertical;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'"></textarea>
            </div>

            {{-- Waktu Tayang (hanya Informasi) --}}
            <div id="tayang-section-modal" style="margin-bottom:20px;background:rgba(255,200,26,.05);border:1.5px solid rgba(255,200,26,.12);border-radius:12px;padding:16px;">
                <p style="font-size:11px;font-weight:800;color:rgba(255,200,26,.8);margin:0 0 12px;text-transform:uppercase;letter-spacing:.7px;">⏰ Waktu Tayang Pengumuman</p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.4);margin-bottom:5px;">Mulai Tayang</label>
                        <input type="datetime-local" name="tayang_mulai" id="modal-mulai" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:8px;padding:8px 10px;color:#FFF;font-size:13px;outline:none;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                        <p style="font-size:10px;color:rgba(255,255,255,.3);margin:4px 0 0;">Kosong = langsung aktif</p>
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:rgba(255,255,255,.4);margin-bottom:5px;">Selesai Tayang</label>
                        <input type="datetime-local" name="tayang_selesai" id="modal-selesai" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:8px;padding:8px 10px;color:#FFF;font-size:13px;outline:none;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                        <p style="font-size:10px;color:rgba(255,255,255,.3);margin:4px 0 0;">Kosong = tidak ada batas</p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="closeInfoModal()" style="padding:11px 24px;border-radius:12px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);font-size:14px;font-weight:700;cursor:pointer;">Batal</button>
                <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ══ Styles ════════════════════════════════════════════════════ --}}
<style>
@keyframes modalIn { from { opacity:0;transform:scale(.95) translateY(10px); } to { opacity:1;transform:scale(1) translateY(0); } }
.info-row { background:#FFF; border:1.5px solid #E8EAF0; border-radius:14px; padding:20px 22px; transition:all .18s; display:flex; align-items:flex-start; justify-content:space-between; gap:12px; }
.info-row:hover { border-color:#FFC81A; box-shadow:0 4px 18px rgba(255,200,26,.1); }
.jenis-badge-info  { background:rgba(16,185,129,.1); color:#10B981; border:1px solid rgba(16,185,129,.2); }
.jenis-badge-faq   { background:rgba(59,130,246,.1); color:#3B82F6; border:1px solid rgba(59,130,246,.2); }
.status-badge-aktif  { background:rgba(16,185,129,.1); color:#10B981; border:1px solid rgba(16,185,129,.2); }
.status-badge-nonaktif { background:rgba(156,163,175,.1); color:#9CA3AF; border:1px solid rgba(156,163,175,.2); }
</style>

{{-- ══ Main Content ════════════════════════════════════════════ --}}
<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Informasi & FAQ</h1>
            <p style="color:#6B7280;font-size:13px;margin:0;">Kelola teks pengumuman berjalan dan FAQ yang tampil di Landing Page.</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <form method="GET" style="display:flex;gap:6px;margin:0;">
                <select name="jenis" class="fcc-input" style="width:auto;border-radius:10px;" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="info" {{ request('jenis')==='info'?'selected':'' }}>📢 Informasi</option>
                    <option value="faq" {{ request('jenis')==='faq'?'selected':'' }}>❓ FAQ</option>
                </select>
            </form>
            <button onclick="openAddModal()" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;border:none;cursor:pointer;">
                @include('components.icon',['name'=>'plus','size'=>15]) Tambah
            </button>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:10px;">
        @forelse($informasi as $i)
        <div class="info-row">
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;flex-wrap:wrap;">
                    <span class="jenis-badge-{{ $i->jenis }}" style="font-size:10px;font-weight:800;padding:3px 10px;border-radius:20px;">{{ $i->jenis === 'info' ? '📢 INFORMASI' : '❓ FAQ' }}</span>
                    @if($i->jenis === 'info')
                        @php $isAktif = (!$i->tayang_mulai || $i->tayang_mulai <= now()) && (!$i->tayang_selesai || $i->tayang_selesai >= now()); @endphp
                        <span class="status-badge-{{ $isAktif ? 'aktif' : 'nonaktif' }}" style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;">
                            {{ $isAktif ? '✓ Aktif Tayang' : '— Tidak Aktif' }}
                        </span>
                    @endif
                    <span style="font-size:11px;color:#A0A3AD;">{{ $i->created_at->format('d M Y') }}</span>
                </div>
                <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 4px;">{{ $i->judul }}</h3>
                @if($i->jenis === 'faq' && $i->isi)
                <p style="color:#6B7280;font-size:13px;line-height:1.6;margin:0;">{{ Str::limit(strip_tags($i->isi), 100) }}</p>
                @elseif($i->jenis === 'info' && $i->tayang_mulai)
                <p style="color:#9CA3AF;font-size:12px;margin:0;">Tayang: {{ $i->tayang_mulai->format('d M Y H:i') }} — {{ $i->tayang_selesai ? $i->tayang_selesai->format('d M Y H:i') : 'Selamanya' }}</p>
                @endif
            </div>
            <div style="display:flex;gap:6px;flex-shrink:0;align-items:center;">
                <button onclick="openEditInfoModal({{ json_encode(['id'=>$i->id,'judul'=>$i->judul,'jenis'=>$i->jenis,'isi'=>$i->isi,'tayang_mulai'=>$i->tayang_mulai?->format('Y-m-d\TH:i'),'tayang_selesai'=>$i->tayang_selesai?->format('Y-m-d\TH:i')]) }})"
                    style="width:34px;height:34px;border-radius:10px;border:1.5px solid #E2E4EB;background:#F7F8FA;color:#9CA3AF;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;"
                    onmouseover="this.style.borderColor='#FFC81A';this.style.color='#131218'" onmouseout="this.style.borderColor='#E2E4EB';this.style.color='#9CA3AF'" title="Edit">
                    @include('components.icon',['name'=>'edit','size'=>15])
                </button>
                <button onclick="confirmInfoDelete('{{ route('admin.informasi.destroy', $i) }}', '{{ addslashes($i->judul) }}')"
                    style="width:34px;height:34px;border-radius:10px;border:1.5px solid rgba(239,68,68,.2);background:rgba(239,68,68,.05);color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;"
                    onmouseover="this.style.background='rgba(239,68,68,.12)'" onmouseout="this.style.background='rgba(239,68,68,.05)'" title="Hapus">
                    @include('components.icon',['name'=>'trash','size'=>15])
                </button>
            </div>
        </div>
        @empty
        <div class="fcc-card" style="padding:56px;text-align:center;color:#A0A3AD;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.5" style="margin:0 auto 12px;display:block;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Belum ada data informasi atau FAQ.
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(method_exists($informasi, 'links'))
    <div style="margin-top:20px;">{{ $informasi->withQueryString()->links() }}</div>
    @endif
</div>

<script>
const UPDATE_INFO_URLS = @json($informasi->getCollection()->mapWithKeys(fn($i) => [$i->id => route('admin.informasi.update', $i)]));
const STORE_INFO_URL  = '{{ route('admin.informasi.store') }}';

// ── Info Modal ─────────────────────────────────────────
function openAddModal() {
    document.getElementById('info-modal-title').innerText = 'Tambah Informasi / FAQ';
    document.getElementById('info-form').action = STORE_INFO_URL;
    document.getElementById('info-method').value = 'POST';
    document.getElementById('modal-judul').value = '';
    document.getElementById('modal-isi').value = '';
    document.getElementById('modal-mulai').value = '';
    document.getElementById('modal-selesai').value = '';
    document.getElementById('modal-jenis-info').checked = true;
    onJenisChange();
    showModal('info-modal');
}

function openEditInfoModal(data) {
    document.getElementById('info-modal-title').innerText = 'Edit ' + (data.jenis === 'info' ? 'Informasi' : 'FAQ');
    document.getElementById('info-form').action = UPDATE_INFO_URLS[data.id];
    document.getElementById('info-method').value = 'PUT';
    document.getElementById('modal-judul').value = data.judul || '';
    document.getElementById('modal-isi').value = data.isi || '';
    document.getElementById('modal-mulai').value = data.tayang_mulai || '';
    document.getElementById('modal-selesai').value = data.tayang_selesai || '';
    const jenisEl = document.getElementById('modal-jenis-' + data.jenis);
    if (jenisEl) jenisEl.checked = true;
    onJenisChange();
    showModal('info-modal');
}

function closeInfoModal() {
    document.getElementById('info-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function onJenisChange() {
    const isFaq = document.getElementById('modal-jenis-faq')?.checked;
    const isiSec = document.getElementById('isi-section-modal');
    const taySec = document.getElementById('tayang-section-modal');
    const judulLbl = document.getElementById('judul-label-m');
    const judulInp = document.getElementById('modal-judul');
    if (isiSec) isiSec.style.display = isFaq ? 'block' : 'none';
    if (taySec) taySec.style.display = isFaq ? 'none' : 'block';
    if (judulLbl) judulLbl.innerText = isFaq ? 'Pertanyaan *' : 'Isi Pengumuman *';
    if (judulInp) judulInp.placeholder = isFaq ? 'Tulis pertanyaan di sini...' : 'Tulis teks pengumuman yang akan berjalan...';
    syncJenisStyle();
}

function syncJenisStyle() {
    const isFaq = document.getElementById('modal-jenis-faq')?.checked;
    ['info', 'faq'].forEach(v => {
        const lbl = document.getElementById('jenis-label-' + v);
        if (!lbl) return;
        const active = (v === 'faq') === isFaq;
        lbl.style.borderColor = active ? '#FFC81A' : 'rgba(255,255,255,.1)';
        lbl.style.background = active ? 'rgba(255,200,26,.05)' : 'transparent';
        lbl.style.color = active ? '#FFC81A' : 'rgba(255,255,255,.7)';
    });
}

// ── Confirm Delete ─────────────────────────────────────
function confirmInfoDelete(url, name) {
    document.getElementById('confirm-title').innerText = 'Hapus Informasi?';
    document.getElementById('confirm-msg').innerText = `"${name}" akan dihapus secara permanen. Tindakan ini tidak bisa dibatalkan.`;
    document.getElementById('confirm-delete-form').action = url;
    showModal('fcc-confirm-modal');
}

function closeConfirm() {
    document.getElementById('fcc-confirm-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function showModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Backdrop click
document.getElementById('info-modal').addEventListener('click', function(e) { if (e.target === this) closeInfoModal(); });
document.getElementById('fcc-confirm-modal').addEventListener('click', function(e) { if (e.target === this) closeConfirm(); });

// Init on page load
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('modal-jenis-info').checked = true;
    onJenisChange();
    @if($errors->any())
        // Re-open modal if there were validation errors
        openAddModal();
    @endif
});
</script>
@endsection
