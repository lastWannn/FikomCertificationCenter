@extends('layouts.admin')
@section('title','Pelatihan')
@section('page-content')
<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <div>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Program Pelatihan</h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Kelola semua program pelatihan yang tersedia.</p>
        </div>
        <button type="button" onclick="document.getElementById('create-modal').style.display='flex'" class="fcc-btn-gold" style="padding:9px 20px;font-size:14px;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:6px;font-weight:700;border-radius:10px;">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Pelatihan
        </button>
    </div>
    <div class="fcc-card" style="padding:0;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                    <th style="padding:12px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Kode</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Judul</th>
                    <th style="padding:12px 12px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Kategori</th>

                    <th style="padding:12px 20px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelatihan as $p)
                <tr class="tbl-row" style="border-top:1px solid #F0F1F3;">
                    <td style="padding:12px 20px;font-size:13px;font-weight:700;color:#FFC81A;font-family:monospace;">{{ $p->kode }}</td>
                    <td style="padding:12px 12px;">
                        <p style="font-size:14px;font-weight:700;color:#0F0F14;margin:0;">{{ $p->judul }}</p>
                        <p style="font-size:11px;color:#A0A3AD;margin:2px 0 0;">{{ $p->jadwal()->count() }} jadwal &bull; {{ $p->materi()->count() }} materi</p>
                    </td>
                    <td style="padding:12px 12px;font-size:13px;color:#6B7280;">{{ $p->kategori->nama_kategori ?? '-' }}</td>

                    <td style="padding:12px 20px;text-align:center;">
                        <div style="display:inline-flex;gap:8px;">
                            <a href="{{ route('admin.pelatihan.show', $p) }}" title="Detail" style="color:#3B82F6;display:flex;">@include('components.icon',['name'=>'eye','size'=>16])</a>
                            <button type="button" onclick="document.getElementById('edit-modal-{{ $p->id }}').style.display='flex'" title="Edit" style="background:none;border:none;cursor:pointer;color:#FFC81A;display:flex;padding:0;">@include('components.icon',['name'=>'edit','size'=>16])</button>
                            <form action="{{ route('admin.pelatihan.destroy', $p) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" onclick="fccConfirmDelete(this, 'Hapus Pelatihan', 'Apakah Anda yakin ingin menghapus pelatihan ini?')" title="Hapus" style="background:none;border:none;cursor:pointer;color:#EF4444;display:flex;padding:0;">
                                    @include('components.icon',['name'=>'trash','size'=>16])
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:32px;text-align:center;color:#A0A3AD;font-size:14px;">Belum ada data pelatihan.</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($pelatihan->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #E2E4EB;">{{ $pelatihan->links() }}</div>
        @endif
    </div>
</div>

{{-- ── TAMBAH PELATIHAN MODAL ────────────────────────────────────── --}}
@include('admin.pelatihan.tambah.create-modal')
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

</script>

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('create-modal').style.display = 'flex';
});
</script>
@endif
@endpush

{{-- ── EDIT PELATIHAN MODALS ────────────────────────────────────── --}}
@include('admin.pelatihan.tambah.edit-modal')
