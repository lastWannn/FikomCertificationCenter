@extends('layouts.admin')
@section('title','Program Pelatihan')

@section('page-content')
<div style="padding:24px;">

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Katalog Master</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Program Pelatihan</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola master data program pelatihan, materi pembelajaran, dan biaya.</p>
        </div>
        <button type="button" onclick="document.getElementById('create-modal').style.display='flex'"
                style="padding:10px 22px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(255,200,26,0.35);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            @include('components.icon',['name'=>'plus','size'=>16]) Tambah Pelatihan Baru
        </button>
    </div>

    {{-- Stat Cards Grid (Neo-Brutalist) --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);">
                @include('components.icon',['name'=>'book','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Pelatihan</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $pelatihan->total() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;">
                @include('components.icon',['name'=>'tag','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Kategori Pelatihan</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $kategori->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Kategori</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;">
                @include('components.icon',['name'=>'calendar','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Jadwal Terdaftar</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ \App\Models\JadwalPelatihan::count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Batch</span></p>
            </div>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Master Pelatihan</h3>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $pelatihan->total() }} Data</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Kode</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Program Pelatihan</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Kategori</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Status Modul &amp; Jadwal</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelatihan as $p)
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        {{-- Kode --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 10px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">
                                {{ $p->kode }}
                            </span>
                        </td>

                        {{-- Judul --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                @if($p->gambar_url)
                                    <img src="{{ $p->gambar_url }}" alt="{{ $p->judul }}" style="width:42px;height:42px;border-radius:10px;object-fit:cover;border:1.5px solid #131218;flex-shrink:0;">
                                @else
                                    <div style="width:42px;height:42px;border-radius:10px;background:#F1F5F9;border:1.5px solid #CBD5E1;display:flex;align-items:center;justify-content:center;color:#94A3B8;flex-shrink:0;">
                                        @include('components.icon',['name'=>'book','size'=>18])
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.pelatihan.show', $p) }}" style="font-size:14px;font-weight:900;color:#131218;text-decoration:none;margin:0;display:block;transition:color .15s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#131218'">
                                        {{ $p->judul }}
                                    </a>
                                    <span style="font-size:11px;color:#64748B;font-weight:600;">Dibuat: {{ $p->created_at?->format('d M Y') ?? '—' }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td style="padding:14px 16px;vertical-align:middle;white-space:nowrap;">
                            <span style="font-size:11.5px;font-weight:800;color:#475569;background:#F1F5F9;padding:4px 12px;border-radius:20px;border:1px solid #E2E8F0;display:inline-block;white-space:nowrap;">
                                {{ $p->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>

                        {{-- Modul & Jadwal Stats --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <span style="font-size:11px;font-weight:800;color:#131218;background:#FFFDF5;border:1px solid #FFC81A;padding:3px 9px;border-radius:8px;">
                                    📅 {{ $p->jadwal()->count() }} Jadwal
                                </span>
                                <span style="font-size:11px;font-weight:800;color:#3B82F6;background:#EFF6FF;border:1px solid #93C5FD;padding:3px 9px;border-radius:8px;">
                                    📚 {{ $p->materi()->count() }} Materi
                                </span>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;gap:6px;align-items:center;">
                                {{-- Detail Button --}}
                                <a href="{{ route('admin.pelatihan.show', $p) }}" title="Detail Pelatihan"
                                   style="width:32px;height:32px;border-radius:9px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;text-decoration:none;transition:all .18s;"
                                   onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                                    @include('components.icon',['name'=>'eye','size'=>15])
                                </a>

                                {{-- Edit Button --}}
                                <button type="button" onclick="document.getElementById('edit-modal-{{ $p->id }}').style.display='flex'" title="Edit Pelatihan"
                                        style="width:32px;height:32px;border-radius:9px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;cursor:pointer;transition:all .18s;padding:0;"
                                        onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                                    @include('components.icon',['name'=>'edit','size'=>15])
                                </button>

                                {{-- Hapus Button --}}
                                <form action="{{ route('admin.pelatihan.destroy', $p) }}" method="POST" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="fccConfirmDelete(this, 'Hapus Pelatihan', 'Apakah Anda yakin ingin menghapus pelatihan {{ addslashes($p->judul) }}?')" title="Hapus"
                                            style="width:32px;height:32px;border-radius:9px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;color:#EF4444;cursor:pointer;transition:all .18s;padding:0;"
                                            onmouseover="this.style.background='#EF4444';this.style.color='#FFFFFF';this.style.borderColor='#131218';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                                        @include('components.icon',['name'=>'trash','size'=>15])
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:40px 24px;text-align:center;color:#94A3B8;font-size:14px;font-weight:600;">
                            Belum ada data program pelatihan. Klik <strong>Tambah Pelatihan Baru</strong> di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pelatihan->hasPages())
        <div style="padding:16px 24px;border-top:1.5px solid #E5E7EB;background:#F8FAFC;">
            {{ $pelatihan->links() }}
        </div>
        @endif
    </div>
</div>

{{-- ── TAMBAH & EDIT PELATIHAN MODALS ────────────────────────────────────── --}}
@include('admin.pelatihan.tambah.create-modal')
@include('admin.pelatihan.tambah.edit-modal')
@endsection

@push('scripts')
<script>
function addBiayaRow(containerId) {
    const container = document.getElementById(containerId);
    const div = document.createElement('div');
    div.className = 'biaya-row';
    div.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;';
    div.innerHTML = `
        <input type="text" name="nama_jenis_biaya[]" placeholder="contoh: Umum" class="fcc-input" style="background:#FFF;">
        <input type="number" name="nominal_biaya[]" placeholder="Nominal (Rp)" class="fcc-input" style="background:#FFF;">
        <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:6px;">@include('components.icon',['name'=>'trash','size'=>14])</button>
    `;
    container.appendChild(div);
}

function previewGambar(input, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        preview.src = e.target.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(file);
}

function handleImagePreview(input, previewId, labelId, statusId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        const label = document.getElementById(labelId);
        const status = document.getElementById(statusId);
        
        if (preview) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        if (label) {
            label.textContent = 'Ganti File Gambar (' + file.name + ')';
        }
        if (status) {
            status.innerHTML = '✨ <span style="color:#10B981;font-weight:900;">Foto Baru Terpilih:</span> ' + file.name;
        }
    };
    reader.readAsDataURL(file);
}
</script>

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('create-modal').style.display = 'flex';
});
</script>
@endif
@endpush
