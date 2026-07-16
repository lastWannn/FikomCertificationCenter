@extends('layouts.admin')
@section('title','Kategori')
@section('page-title','Kategori')
@section('page-content')
<div style="padding:20px 24px;">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
    {{-- Kategori Pelatihan --}}
    <div>
      <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;background:#F7F8FA;display:flex;justify-content:space-between;align-items:center;">
          <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:32px;height:32px;border-radius:9px;background:#131218;display:flex;align-items:center;justify-content:center;">
              @include('components.icon',['name'=>'book-open','size'=>15,'style'=>'color:#FFC81A'])
            </div>
            <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">Kategori Pelatihan</p>
          </div>
          <button onclick="document.getElementById('form-pel').classList.toggle('hidden')"
              class="fcc-btn-dark" style="padding:6px 14px;font-size:12px;border:none;">
            @include('components.icon',['name'=>'plus','size'=>12,'style'=>'color:#FFC81A']) Tambah
          </button>
        </div>

        {{-- Form tambah --}}
        <div id="form-pel" class="hidden" style="padding:14px 18px;background:rgba(255,200,26,.04);border-bottom:1px solid #E2E4EB;">
          <form action="{{ route('admin.kategori.store') }}" method="POST" style="display:flex;gap:8px;">
            @csrf
            <input type="hidden" name="jenis" value="pelatihan">
            <input type="text" name="nama_kategori" placeholder="Nama kategori pelatihan..." required
                   class="fcc-input" style="flex:1;" onkeydown="if(event.key==='Enter')event.preventDefault();">
            <button type="submit" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;flex-shrink:0;">Simpan</button>
          </form>
        </div>

        <table style="width:100%;border-collapse:collapse;">
          <thead><tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
            <th style="padding:9px 16px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;">Kategori</th>
            <th style="padding:9px 12px;text-align:center;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;">Program</th>
            <th style="padding:9px 14px;text-align:right;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;">Aksi</th>
          </tr></thead>
          <tbody>
            @forelse($pelatihan as $kat)
            <tr style="border-top:1px solid #F0F1F5;" class="tbl-row" id="row-pel-{{ $kat->id }}">
              <td style="padding:11px 16px;">
                <span class="view-pel-{{ $kat->id }}" style="font-size:13px;font-weight:600;color:#131218;">{{ $kat->nama_kategori }}</span>
                <input type="text" class="fcc-input edit-inp edit-pel-{{ $kat->id }}" style="display:none;" value="{{ $kat->nama_kategori }}"
                       onkeydown="if(event.key==='Enter')event.preventDefault();">
              </td>
              <td style="padding:11px 12px;text-align:center;">
                <span style="font-size:13px;font-weight:700;color:#131218;">{{ $kat->pelatihan_count }}</span>
              </td>
              <td style="padding:11px 14px;text-align:right;">
                <div style="display:inline-flex;gap:6px;align-items:center;">
                  <button onclick="startEdit('pel',{{ $kat->id }})" title="Edit"
                      class="edit-btn-pel-{{ $kat->id }}"
                      style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;"
                      onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#9CA3B0'">
                    @include('components.icon',['name'=>'edit','size'=>14])
                  </button>
                  <form class="save-form-pel-{{ $kat->id }}" action="{{ route('admin.kategori.update', $kat->hashid) }}" method="POST" style="display:none;">
                    @csrf @method('PUT')
                    <input type="hidden" name="jenis" value="pelatihan">
                    <input type="hidden" name="nama_kategori" class="save-val-pel-{{ $kat->id }}">
                    <button type="submit" style="background:none;border:none;cursor:pointer;color:#10B981;font-size:11px;font-weight:700;white-space:nowrap;">Simpan</button>
                  </form>
                  <form action="{{ route('admin.kategori.destroy', $kat->hashid) }}?jenis=pelatihan" method="POST"
                        onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <input type="hidden" name="jenis" value="pelatihan">
                    <button type="submit" style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;"
                            onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3B0'">
                      @include('components.icon',['name'=>'trash','size'=>14])
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr><td colspan="3" style="padding:24px;text-align:center;color:#9CA3B0;font-size:13px;">Belum ada kategori pelatihan.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Kategori Sertifikasi --}}
    <div>
      <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;background:#F7F8FA;display:flex;justify-content:space-between;align-items:center;">
          <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:32px;height:32px;border-radius:9px;background:#131218;display:flex;align-items:center;justify-content:center;">
              @include('components.icon',['name'=>'award','size'=>15,'style'=>'color:#FFC81A'])
            </div>
            <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">Kategori Sertifikasi</p>
          </div>
          <button onclick="document.getElementById('form-sert').classList.toggle('hidden')"
              class="fcc-btn-dark" style="padding:6px 14px;font-size:12px;border:none;">
            @include('components.icon',['name'=>'plus','size'=>12,'style'=>'color:#FFC81A']) Tambah
          </button>
        </div>

        <div id="form-sert" class="hidden" style="padding:14px 18px;background:rgba(59,130,246,.04);border-bottom:1px solid #E2E4EB;">
          <form action="{{ route('admin.kategori.store') }}" method="POST" style="display:flex;gap:8px;">
            @csrf
            <input type="hidden" name="jenis" value="sertifikasi">
            <input type="text" name="nama_kategori" placeholder="Nama kategori sertifikasi..." required
                   class="fcc-input" style="flex:1;" onkeydown="if(event.key==='Enter')event.preventDefault();">
            <button type="submit" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;flex-shrink:0;">Simpan</button>
          </form>
        </div>

        <table style="width:100%;border-collapse:collapse;">
          <thead><tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
            <th style="padding:9px 16px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;">Kategori</th>
            <th style="padding:9px 12px;text-align:center;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;">Program</th>
            <th style="padding:9px 14px;text-align:right;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;">Aksi</th>
          </tr></thead>
          <tbody>
            @forelse($sertifikasi as $kat)
            <tr style="border-top:1px solid #F0F1F5;" class="tbl-row">
              <td style="padding:11px 16px;font-size:13px;font-weight:600;color:#131218;">{{ $kat->nama_kategori }}</td>
              <td style="padding:11px 12px;text-align:center;font-size:13px;font-weight:700;color:#131218;">{{ $kat->sertifikasi_count }}</td>
              <td style="padding:11px 14px;text-align:right;">
                <form action="{{ route('admin.kategori.destroy', $kat->hashid) }}" method="POST"
                      onsubmit="return confirm('Hapus?')">
                  @csrf @method('DELETE')
                  <input type="hidden" name="jenis" value="sertifikasi">
                  <button type="submit" style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;margin-left:auto;"
                          onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3B0'">
                    @include('components.icon',['name'=>'trash','size'=>14])
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="3" style="padding:24px;text-align:center;color:#9CA3B0;font-size:13px;">Belum ada kategori sertifikasi.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
@vite('resources/js/pages/admin-kategori.js')
@endpush
