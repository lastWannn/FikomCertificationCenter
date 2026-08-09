@extends('layouts.admin')
@section('title','No. Rekening')
@section('page-content')
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
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Keuangan &amp; Rekening</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Nomor Rekening Pembayaran</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola rekening tujuan pembayaran peserta. Hanya satu rekening yang aktif di website.</p>
        </div>

        @if(auth('admin')->user()?->isSuperAdmin())
        <button onclick="openAddRekeningModal()"
                style="padding:10px 18px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.1);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Rekening Baru
        </button>
        @else
        <span style="font-size:12px;font-weight:800;padding:6px 14px;border-radius:20px;background:#F1F5F9;color:#64748B;border:1.5px solid #CBD5E1;">
            🔒 Mode Lihat Saja (Super Admin Only)
        </span>
        @endif
    </div>

    @if(!auth('admin')->user()?->isSuperAdmin())
    <div style="padding:12px 18px;border-radius:14px;background:#EEF2FF;border:1.5px solid #818CF8;color:#4F46E5;font-size:13px;font-weight:800;margin-bottom:24px;display:flex;align-items:center;gap:8px;">
        <span>ℹ️</span> <span>Informasi: Anda masuk sebagai Admin Biasa. Perubahan nomor rekening hanya dapat dilakukan oleh Super Admin.</span>
    </div>
    @endif

    {{-- Bank Account Cards Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:20px;">
        @forelse($rekening as $r)
        <div class="fcc-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:{{ $r->is_active ? '2.5px solid #131218' : '2px solid #E5E7EB' }};box-shadow:{{ $r->is_active ? '0 6px 24px rgba(0,0,0,0.08)' : '0 4px 16px rgba(0,0,0,0.03)' }};position:relative;transition:all .18s;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;">
                <div style="width:48px;height:48px;border-radius:14px;background:{{ $r->is_active ? '#131218' : '#F1F5F9' }};border:1.5px solid {{ $r->is_active ? '#FFC81A' : '#CBD5E1' }};display:flex;align-items:center;justify-content:center;">
                    @include('components.icon',['name'=>'wallet','size'=>22,'style'=>"color:".($r->is_active?'#FFC81A':'#64748B')])
                </div>
                @if($r->is_active)
                <span style="font-size:11px;font-weight:900;padding:4px 12px;border-radius:12px;background:#FFFDF5;color:#B38F00;border:1px solid #FFC81A;display:inline-block;">
                    ★ REKENING UTAMA AKTIF
                </span>
                @endif
            </div>

            <p style="font-size:17px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $r->bank }}</p>
            <p style="font-size:20px;font-weight:900;color:#131218;font-family:monospace;margin:0 0 6px;letter-spacing:1px;background:#F8FAFC;padding:6px 12px;border-radius:10px;border:1px solid #E2E4EB;display:inline-block;">
                {{ $r->no_rekening }}
            </p>
            <p style="font-size:13.5px;color:#64748B;margin:6px 0 20px;font-weight:600;">a.n. <strong style="color:#131218;">{{ $r->nama_pemilik }}</strong></p>
            
            @if(auth('admin')->user()?->isSuperAdmin())
            <div style="display:flex;gap:8px;flex-wrap:wrap;border-top:1.5px solid #F1F5F9;padding-top:16px;">
                @if(!$r->is_active)
                <form action="{{ route('admin.rekening.aktifkan', $r) }}" method="POST" style="flex:1;">
                    @csrf
                    <button type="submit" style="width:100%;padding:8px 0;border-radius:10px;border:1.5px solid #131218;background:#131218;color:#FFC81A;font-size:12px;font-weight:800;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                        Aktifkan
                    </button>
                </form>
                @endif
                <button type="button" onclick="openEditRekeningModal({{ json_encode($r) }})"
                        style="flex:1;padding:8px 0;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:12px;font-weight:800;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">
                    Edit
                </button>
                <form action="{{ route('admin.rekening.destroy', $r) }}" method="POST" onsubmit="return fccConfirmDelete(event, this, 'Hapus Rekening', 'Apakah Anda yakin ingin menghapus rekening ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="padding:8px 12px;border-radius:10px;border:1px solid #FCA5A5;background:#FEF2F2;color:#EF4444;font-size:12px;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';" title="Hapus Rekening">
                        @include('components.icon',['name'=>'trash','size'=>13])
                    </button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div style="grid-column:1/-1;padding:56px;text-align:center;color:#94A3B8;border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;" class="fcc-card">
            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                @include('components.icon',['name'=>'wallet','size'=>24,'style'=>'color:#9CA3B0'])
            </div>
            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Rekening Terdaftar</p>
            <p style="font-size:12.5px;color:#64748B;margin:0;">Klik tombol "Tambah Rekening Baru" untuk membuat rekening pertama.</p>
        </div>
        @endforelse
    </div>

    @if($rekening->hasPages())
    <div style="margin-top:24px;padding:14px 20px;background:#FFFFFF;border-radius:16px;border:2px solid #E5E7EB;">
        {{ $rekening->links() }}
    </div>
    @endif
</div>

{{-- MODAL REKENING (TAMBAH / EDIT) --}}
@if(auth('admin')->user()?->isSuperAdmin())
<div id="rekening-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;overflow-y:auto;padding:24px 0;">
    <div style="background:#FFFFFF;border:2.5px solid #131218;border-radius:24px;padding:32px;max-width:540px;width:90%;box-shadow:0 24px 64px rgba(0,0,0,.35);animation:modalIn .25s ease;margin:auto;position:relative;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;border-bottom:2px solid #E5E7EB;padding-bottom:16px;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                    <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Form Rekening</span>
                </div>
                <h2 id="rekening-modal-title" style="color:#131218;font-size:19px;font-weight:900;margin:0;">Tambah Rekening Baru</h2>
            </div>
            <button onclick="closeRekeningModal()" style="width:36px;height:36px;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;line-height:1;font-weight:900;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">&times;</button>
        </div>

        <form id="rekening-form" method="POST" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="rekening-method" value="POST">

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Nama Pemilik Rekening *</label>
                <input type="text" name="nama_pemilik" id="f-nama-pemilik" required placeholder="Contoh: Fikom Certification Center" class="fcc-input" style="font-size:13.5px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Nama Bank / Penyedia E-Wallet *</label>
                <input type="text" name="bank" id="f-bank" required placeholder="Contoh: Bank Mandiri, BCA, BNI" class="fcc-input" style="font-size:13.5px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:600;width:100%;">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">Nomor Rekening / Virtual Account *</label>
                <input type="text" name="no_rekening" id="f-no-rekening" required placeholder="Contoh: 1520012345678" class="fcc-input" style="font-size:13.5px;height:42px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;font-family:monospace;width:100%;">
            </div>

            <div style="display:flex;gap:12px;justify-content:flex-end;border-top:1.5px solid #E2E4EB;padding-top:20px;">
                <button type="button" onclick="closeRekeningModal()" style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border:1.5px solid #131218;border-radius:10px;cursor:pointer;">Batal</button>
                <button type="submit" style="padding:10px 22px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;display:inline-flex;align-items:center;gap:6px;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
                    @include('components.icon',['name'=>'check','size'=>15]) <span id="rekening-btn-text">Simpan Rekening</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const STORE_REKENING_URL = '{{ route('admin.rekening.store') }}';
const UPDATE_REKENING_URLS = @json($rekening->getCollection()->mapWithKeys(fn($r) => [$r->id => route('admin.rekening.update', $r)]));

function openAddRekeningModal() {
    document.getElementById('rekening-modal-title').innerText = 'Tambah Rekening Baru';
    document.getElementById('rekening-btn-text').innerText = 'Simpan Rekening';
    document.getElementById('rekening-form').action = STORE_REKENING_URL;
    document.getElementById('rekening-method').value = 'POST';
    document.getElementById('f-nama-pemilik').value = '';
    document.getElementById('f-bank').value = '';
    document.getElementById('f-no-rekening').value = '';
    showModal('rekening-modal');
}

function openEditRekeningModal(rekening) {
    document.getElementById('rekening-modal-title').innerText = 'Edit Nomor Rekening';
    document.getElementById('rekening-btn-text').innerText = 'Perbarui Rekening';
    document.getElementById('rekening-form').action = UPDATE_REKENING_URLS[rekening.id] || `/admin/rekening/${rekening.id}`;
    document.getElementById('rekening-method').value = 'PUT';
    document.getElementById('f-nama-pemilik').value = rekening.nama_pemilik || '';
    document.getElementById('f-bank').value = rekening.bank || '';
    document.getElementById('f-no-rekening').value = rekening.no_rekening || '';
    showModal('rekening-modal');
}

function closeRekeningModal() {
    document.getElementById('rekening-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function showModal(id) {
    const el = document.getElementById(id);
    if(el) {
        el.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

// Backdrop click
document.getElementById('rekening-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeRekeningModal();
});

// Auto re-open on validation errors if any
document.addEventListener('DOMContentLoaded', () => {
    @if($errors->any())
        openAddRekeningModal();
    @endif
});
</script>
@endif
@endsection


