@extends('layouts.admin')
@section('title','Kategori')
@section('page-title','Kategori')
@section('page-content')
<div style="padding:20px 24px;">
  <div class="fcc-card" style="padding:0;overflow:hidden;max-width:900px;margin:0 auto;">
    <div style="padding:16px 20px;border-bottom:1px solid #E2E4EB;background:#F7F8FA;display:flex;justify-content:space-between;align-items:center;">
      <div style="display:flex;align-items:center;gap:10px;">
        <div style="width:36px;height:36px;border-radius:10px;background:#131218;display:flex;align-items:center;justify-content:center;">
          @include('components.icon',['name'=>'filter','size'=>16,'style'=>'color:#FFC81A'])
        </div>
        <div>
          <h2 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Daftar Kategori</h2>
          <p style="margin:2px 0 0;font-size:12px;color:#9CA3B0;">Kelola semua kategori program pelatihan & sertifikasi.</p>
        </div>
      </div>
      <button onclick="document.getElementById('form-tambah').classList.toggle('hidden')"
          class="fcc-btn-dark" style="padding:8px 16px;font-size:12.5px;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:6px;border-radius:8px;font-weight:700;">
        @include('components.icon',['name'=>'plus','size'=>13,'style'=>'color:#FFC81A']) Tambah Kategori
      </button>
    </div>

    {{-- Form tambah --}}
    <div id="form-tambah" class="hidden" style="padding:16px 20px;background:rgba(255,200,26,.04);border-bottom:1px solid #E2E4EB;">
      <form action="{{ route('admin.kategori.store') }}" method="POST" style="display:flex;gap:10px;max-width:500px;">
        @csrf
        <input type="text" name="nama_kategori" placeholder="Nama kategori baru..." required
               class="fcc-input" style="flex:1;" onkeydown="if(event.key==='Enter')event.preventDefault();">
        <button type="submit" class="fcc-btn-gold" style="padding:10px 20px;font-size:13px;flex-shrink:0;cursor:pointer;border:none;border-radius:8px;font-weight:700;">Simpan</button>
      </form>
    </div>

    <table style="width:100%;border-collapse:collapse;">
      <thead><tr style="background:#F7F8FA;border-bottom:2px solid #E2E4EB;">
        <th style="padding:12px 20px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Kategori</th>
        <th style="padding:12px 12px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Pelatihan</th>
        <th style="padding:12px 12px;text-align:center;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Sertifikasi</th>
        <th style="padding:12px 20px;text-align:right;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Aksi</th>
      </tr></thead>
      <tbody>
        @forelse($kategori as $kat)
        <tr style="border-top:1px solid #F0F1F5;" class="tbl-row" id="row-{{ $kat->id }}">
          <td style="padding:14px 20px;">
            <!-- View mode -->
            <span class="view-mode-{{ $kat->id }}" style="font-size:14px;font-weight:700;color:#131218;">{{ $kat->nama_kategori }}</span>
            
            <!-- Edit mode form -->
            <form class="edit-mode-{{ $kat->id }} hidden" action="{{ route('admin.kategori.update', $kat->hashid) }}" method="POST" style="display:flex;gap:8px;align-items:center;">
                @csrf @method('PUT')
                <input type="text" name="nama_kategori" value="{{ $kat->nama_kategori }}" required class="fcc-input" style="padding:6px 10px;font-size:13px;max-width:320px;">
                <button type="submit" class="fcc-btn-gold" style="padding:8px 16px;font-size:12.5px;cursor:pointer;border:none;border-radius:8px;font-weight:700;">Simpan</button>
                <button type="button" onclick="toggleEdit({{ $kat->id }})" style="background:none;border:1.5px solid #E2E4EB;color:#6B7280;padding:8px 16px;border-radius:8px;font-size:12.5px;cursor:pointer;font-weight:700;">Batal</button>
            </form>
          </td>
          <td style="padding:14px 12px;text-align:center;">
            <span style="font-size:13px;font-weight:700;color:#131218;">{{ $kat->pelatihan_count }}</span>
          </td>
          <td style="padding:14px 12px;text-align:center;">
            <span style="font-size:13px;font-weight:700;color:#131218;">{{ $kat->sertifikasi_count }}</span>
          </td>
          <td style="padding:14px 20px;text-align:right;">
            <div class="view-mode-{{ $kat->id }}" style="display:inline-flex;gap:8px;align-items:center;">
              <button onclick="toggleEdit({{ $kat->id }})" title="Edit"
                  style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;transition:color .15s;"
                  onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#9CA3B0'">
                @include('components.icon',['name'=>'edit','size'=>14])
              </button>
              <form action="{{ route('admin.kategori.destroy', $kat->hashid) }}" method="POST"
                    onsubmit="return confirm('Hapus kategori ini?')" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;transition:color .15s;"
                        onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3B0'">
                  @include('components.icon',['name'=>'trash','size'=>14])
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" style="padding:32px;text-align:center;color:#9CA3B0;font-size:14px;">Belum ada kategori.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
function toggleEdit(id) {
    const viewModes = document.querySelectorAll('.view-mode-' + id);
    const editModes = document.querySelectorAll('.edit-mode-' + id);
    
    viewModes.forEach(el => el.classList.toggle('hidden'));
    editModes.forEach(el => el.classList.toggle('hidden'));
}
</script>
@endpush
