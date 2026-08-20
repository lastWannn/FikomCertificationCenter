@extends('layouts.admin')
@section('title','Informasi & FAQ')
@section('page-title', 'Informasi & FAQ')
@section('page-content')

{{-- ══ Custom Confirm Delete Modal ════════════════════════════════ --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(19,18,24,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="background:#FFFFFF;border:2.5px solid #131218;border-radius:24px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.35);text-align:center;animation:modalIn .25s ease;">
        <div style="width:56px;height:56px;border-radius:16px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;color:#EF4444;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="confirm-title" style="color:#131218;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Informasi?</h3>
        <p id="confirm-msg" style="color:#64748B;font-size:13.5px;margin:0 0 28px;line-height:1.6;font-weight:500;"></p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="closeConfirm()" style="padding:11px 24px;border-radius:12px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:13.5px;font-weight:800;cursor:pointer;transition:all .2s;">Batal</button>
            <form id="confirm-delete-form" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" style="padding:11px 24px;border-radius:12px;border:1px solid #131218;background:#DC2626;color:#FFF;font-size:13.5px;font-weight:800;cursor:pointer;box-shadow:0 4px 15px rgba(220,38,38,.3);">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- ══ Form Modal (Tambah / Edit) ════════════════════════════════ --}}
<div id="info-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);align-items:flex-start;justify-content:center;overflow-y:auto;padding:24px 0;">
    <div style="background:#FFFFFF;border:2.5px solid #131218;border-radius:24px;padding:32px;max-width:640px;width:90%;box-shadow:0 24px 64px rgba(0,0,0,.35);animation:modalIn .25s ease;margin:auto;position:relative;">
        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;border-bottom:2px solid #E5E7EB;padding-bottom:16px;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                    <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Konten &amp; FAQ</span>
                </div>
                <h2 id="info-modal-title" style="color:#131218;font-size:19px;font-weight:900;margin:0;">Tambah Informasi / FAQ</h2>
            </div>
            <button onclick="closeInfoModal()" style="width:36px;height:36px;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:900;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">&times;</button>
        </div>

        <form id="info-form" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="info-method" value="POST">

            {{-- Jenis --}}
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:8px;text-transform:uppercase;letter-spacing:.8px;">Pilih Jenis Konten *</label>
                <div style="display:flex;gap:10px;">
                    @foreach(['info' => '📢 Informasi / Pengumuman', 'faq' => '❓ FAQ'] as $v => $l)
                    <label style="flex:1;display:flex;align-items:center;gap:10px;cursor:pointer;padding:12px 16px;border:1.5px solid #CBD5E1;border-radius:12px;transition:all .2s;color:#131218;font-size:13.5px;font-weight:800;"
                           id="jenis-label-{{ $v }}"
                           onmouseover="this.style.borderColor='#FFC81A'" 
                           onmouseout="syncJenisStyle()">
                        <input type="radio" name="jenis" id="modal-jenis-{{ $v }}" value="{{ $v }}" style="accent-color:#131218;" onchange="onJenisChange()">
                        {{ $l }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Judul / Pengumuman --}}
            <div style="margin-bottom:16px;">
                <label id="judul-label-m" style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Isi Pengumuman *</label>
                <input type="text" name="judul" id="modal-judul" required placeholder="Tulis teks pengumuman..." class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:600;outline:none;box-sizing:border-box;">
            </div>

            {{-- Isi / Jawaban (hanya FAQ) --}}
            <div id="isi-section-modal" style="margin-bottom:16px;display:none;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Jawaban / Penjelasan *</label>
                <textarea name="isi" id="modal-isi" rows="5" placeholder="Tulis jawaban untuk pertanyaan FAQ ini..." class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:600;outline:none;resize:vertical;box-sizing:border-box;"></textarea>
            </div>

            {{-- Waktu Tayang (hanya Informasi) --}}
            <div id="tayang-section-modal" style="margin-bottom:20px;background:#FFFDF5;border:1.5px solid #FFC81A;border-radius:14px;padding:16px;">
                <p style="font-size:11.5px;font-weight:900;color:#131218;margin:0 0 12px;text-transform:uppercase;letter-spacing:.7px;">⏰ Waktu Tayang Pengumuman</p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:5px;">Mulai Tayang</label>
                        <input type="datetime-local" name="tayang_mulai" id="modal-mulai" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;padding:8px 10px;color:#131218;font-size:13px;font-weight:600;box-sizing:border-box;">
                        <p style="font-size:10.5px;color:#94A3B8;margin:4px 0 0;font-weight:500;">Kosong = langsung aktif</p>
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:5px;">Selesai Tayang</label>
                        <input type="datetime-local" name="tayang_selesai" id="modal-selesai" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;padding:8px 10px;color:#131218;font-size:13px;font-weight:600;box-sizing:border-box;">
                        <p style="font-size:10.5px;color:#94A3B8;margin:4px 0 0;font-weight:500;">Kosong = tidak ada batas</p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div style="border-top:1.5px solid #E2E4EB;padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="closeInfoModal()" style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border:1.5px solid #131218;border-radius:10px;cursor:pointer;">Batal</button>
                <button type="submit" style="padding:10px 22px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

{{-- ══ Styles ════════════════════════════════════════════════════ --}}
<style>
@keyframes modalIn { from { opacity:0;transform:scale(.95) translateY(10px); } to { opacity:1;transform:scale(1) translateY(0); } }
.info-row { background:#FFFFFF; border:2px solid #E5E7EB; border-radius:18px; padding:20px 24px; transition:all .18s; display:flex; align-items:flex-start; justify-content:space-between; gap:16px; box-shadow:0 4px 16px rgba(0,0,0,0.03); }
.info-row:hover { border-color:#131218; transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,0.06); }
</style>

{{-- ══ Main Content ════════════════════════════════════════════ --}}
<div style="padding:24px;">

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Konten &amp; Pusat Bantuan</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Informasi &amp; FAQ</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola teks pengumuman berjalan dan FAQ yang tampil di Landing Page.</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <form method="GET" style="display:flex;gap:6px;margin:0;">
                <select name="jenis" class="fcc-input" style="width:auto;font-size:12.5px;height:38px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;" onchange="this.form.submit()">
                    <option value="">Semua Jenis Konten</option>
                    <option value="info" {{ request('jenis')==='info'?'selected':'' }}>📢 Informasi</option>
                    <option value="faq" {{ request('jenis')==='faq'?'selected':'' }}>❓ FAQ</option>
                </select>
            </form>

            <button onclick="openAddModal()"
                    style="padding:10px 18px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.1);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                    onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                @include('components.icon',['name'=>'plus','size'=>15]) Tambah Informasi / FAQ
            </button>
        </div>
    </div>

    {{-- Content List Rows --}}
    <div style="display:flex;flex-direction:column;gap:14px;">
        @forelse($informasi as $i)
        <div class="info-row">
            <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;flex-wrap:wrap;">
                    @if($i->jenis === 'info')
                        <span style="font-size:11px;font-weight:900;padding:4px 12px;border-radius:12px;background:#FFFDF5;color:#B38F00;border:1px solid #FFC81A;display:inline-block;">
                            📢 INFORMASI
                        </span>
                        @php $isAktif = (!$i->tayang_mulai || $i->tayang_mulai <= now()) && (!$i->tayang_selesai || $i->tayang_selesai >= now()); @endphp
                        <span style="font-size:11px;font-weight:800;padding:4px 12px;border-radius:12px;background:{{ $isAktif ? '#ECFDF5' : '#F1F5F9' }};color:{{ $isAktif ? '#059669' : '#64748B' }};border:1px solid {{ $isAktif ? '#A7F3D0' : '#CBD5E1' }};">
                            {{ $isAktif ? '✓ Aktif Tayang' : '— Tidak Aktif' }}
                        </span>
                    @else
                        <span style="font-size:11px;font-weight:900;padding:4px 12px;border-radius:12px;background:#EEF2FF;color:#4F46E5;border:1px solid #818CF8;display:inline-block;">
                            ❓ FAQ
                        </span>
                    @endif

                    <span style="font-size:11.5px;color:#94A3B8;font-weight:600;">📅 {{ $i->created_at->format('d M Y') }}</span>
                </div>

                <h3 style="font-size:16px;font-weight:900;color:#131218;margin:0 0 6px;">{{ $i->judul }}</h3>
                
                @if($i->jenis === 'faq' && $i->isi)
                <p style="color:#64748B;font-size:13.5px;line-height:1.6;margin:0;font-weight:500;">{{ Str::limit(strip_tags($i->isi), 140) }}</p>
                @elseif($i->jenis === 'info' && $i->tayang_mulai)
                <p style="color:#94A3B8;font-size:12px;margin:0;font-weight:600;">⏰ Jadwal Tayang: {{ $i->tayang_mulai->format('d M Y H:i') }} — {{ $i->tayang_selesai ? $i->tayang_selesai->format('d M Y H:i') : 'Selamanya' }}</p>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div style="display:flex;gap:6px;flex-shrink:0;align-items:center;">
                <button onclick="openEditInfoModal({{ json_encode(['id'=>$i->id,'judul'=>$i->judul,'jenis'=>$i->jenis,'isi'=>$i->isi,'tayang_mulai'=>$i->tayang_mulai?->format('Y-m-d\TH:i'),'tayang_selesai'=>$i->tayang_selesai?->format('Y-m-d\TH:i')]) }})"
                        style="padding:6px 12px;font-size:12px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:8px;border:1.5px solid #131218;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';" title="Edit Data">
                    Edit
                </button>
                <button onclick="confirmInfoDelete('{{ route('admin.informasi.destroy', $i) }}', '{{ addslashes($i->judul) }}')"
                        style="padding:6px 10px;border-radius:8px;border:1px solid #FCA5A5;background:#FEF2F2;color:#EF4444;font-size:12px;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';" title="Hapus">
                    @include('components.icon',['name'=>'trash','size'=>13])
                </button>
            </div>
        </div>
        @empty
        <div class="fcc-card" style="padding:56px;text-align:center;color:#94A3B8;border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;">
            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                @include('components.icon',['name'=>'info','size'=>24,'style'=>'color:#9CA3B0'])
            </div>
            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Data Informasi atau FAQ</p>
            <p style="font-size:12.5px;color:#64748B;margin:0;">Klik tombol "Tambah Informasi / FAQ" untuk membuat pengumuman pertama.</p>
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
        lbl.style.borderColor = active ? '#131218' : '#CBD5E1';
        lbl.style.background = active ? '#FFFDF5' : '#FFF';
        lbl.style.color = '#131218';
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

