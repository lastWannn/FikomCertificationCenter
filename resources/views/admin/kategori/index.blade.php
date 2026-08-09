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
</style>

<div style="padding:24px;">

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Klasifikasi &amp; Tagging</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Daftar Kategori</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola semua kategori program pelatihan &amp; sertifikasi.</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <button onclick="openKategoriModal()"
                    style="padding:10px 18px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.1);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                    onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                @include('components.icon',['name'=>'plus','size'=>15]) Tambah Kategori Baru
            </button>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Master Kategori Program</h3>
            </div>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $kategori->total() }} Kategori</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Nama Kategori</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:180px;">Total Pelatihan</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:180px;">Total Sertifikasi</th>
                        <th style="padding:14px 20px;text-align:right;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $kat)
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        
                        {{-- Nama Kategori --}}
                        <td style="padding:16px 20px;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:36px;height:36px;border-radius:10px;background:#FFFDF5;border:1.5px solid #FFC81A;display:flex;align-items:center;justify-content:center;color:#131218;font-weight:900;flex-shrink:0;">
                                    🏷️
                                </div>
                                <span style="font-size:14px;font-weight:900;color:#131218;">{{ $kat->nama_kategori }}</span>
                            </div>
                        </td>

                        {{-- Total Pelatihan --}}
                        <td style="padding:16px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-size:12px;font-weight:800;padding:4px 12px;border-radius:20px;background:#FFFDF5;color:#B38F00;border:1px solid #FFC81A;display:inline-block;">
                                {{ $kat->pelatihan_count }} Program
                            </span>
                        </td>

                        {{-- Total Sertifikasi --}}
                        <td style="padding:16px 16px;text-align:center;vertical-align:middle;">
                            <span style="font-size:12px;font-weight:800;padding:4px 12px;border-radius:20px;background:#EEF2FF;color:#4F46E5;border:1px solid #818CF8;display:inline-block;">
                                {{ $kat->sertifikasi_count }} Program
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:16px 20px;text-align:right;vertical-align:middle;">
                            <div style="display:inline-flex;gap:6px;align-items:center;justify-content:flex-end;">
                                <button onclick="openEditKategoriModal({{ $kat->id }}, '{{ addslashes($kat->nama_kategori) }}')" title="Edit Kategori"
                                        style="width:34px;height:34px;border-radius:8px;border:1.5px solid #CBD5E1;background:#FFF;color:#131218;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;"
                                        onmouseover="this.style.borderColor='#131218';this.style.background='#FFC81A';" onmouseout="this.style.borderColor='#CBD5E1';this.style.background='#FFF';">
                                    @include('components.icon',['name'=>'edit','size'=>14])
                                </button>
                                <button onclick="confirmKategoriDelete('{{ route('admin.kategori.destroy', $kat->hashid) }}', '{{ addslashes($kat->nama_kategori) }}')" title="Hapus Kategori"
                                        style="width:34px;height:34px;border-radius:8px;border:1.5px solid #FCA5A5;background:#FEF2F2;color:#EF4444;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .18s;"
                                        onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';">
                                    @include('components.icon',['name'=>'trash','size'=>14])
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'tag','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Kategori Ditemukan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Klik tombol "Tambah Kategori Baru" untuk menambahkan kategori pertama.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kategori->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;">
            {{ $kategori->links() }}
        </div>
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

