@extends('layouts.admin')
@section('title', isset($jadwal) ? 'Edit Jadwal Sertifikasi' : 'Tambah Jadwal Sertifikasi')
@section('page-title', isset($jadwal) ? 'Edit Jadwal Sertifikasi' : 'Tambah Jadwal Sertifikasi')
@section('page-content')
@php $jenis='sertifikasi'; $program=$sertifikasi; @endphp
<div style="padding:20px 24px;max-width:760px;">
  <a href="{{ route('admin.sertifikasi.show', $program) }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:16px;">
    @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
  </a>

  @if($errors->any())
  <div style="background:#FEF2F2;border:1px solid #FCA5A5;padding:14px 18px;border-radius:12px;margin-bottom:16px;">
      <p style="color:#EF4444;font-size:13px;font-weight:800;margin:0 0 6px;">Gagal menyimpan jadwal:</p>
      <ul style="margin:0;padding-left:20px;color:#B91C1C;font-size:12.5px;">
          @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
  @endif
  
@php $jadwal = $jadwal ?? null; $edit = isset($jadwal); @endphp
<form action="{{ $edit
    ? ($jenis==='pelatihan' ? route('admin.jadwal-pelatihan.update', $jadwal) : route('admin.jadwal-sertifikasi.update', $jadwal))
    : ($jenis==='pelatihan' ? route('admin.jadwal-pelatihan.store', $program) : route('admin.jadwal-sertifikasi.store', $program)) }}"
  method="POST">
  @csrf @if($edit) @method('PUT') @endif

  <div class="fcc-card" style="padding:26px;margin-bottom:16px;">
    <div style="background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;padding:14px 16px;margin-bottom:20px;display:flex;gap:12px;align-items:center;">
      <div style="width:36px;height:36px;border-radius:10px;background:#131218;display:flex;align-items:center;justify-content:center;">
        @include('components.icon',['name'=>$jenis==='pelatihan'?'book-open':'award','size'=>17,'style'=>'color:#FFC81A'])
      </div>
      <div>
        <p style="margin:0;font-size:13px;font-weight:800;color:#131218;">{{ $program->judul }}</p>
        <p style="margin:0;font-size:11px;color:#9CA3B0;font-family:monospace;">{{ $program->kode }}</p>
      </div>
    </div>

    <div style="margin-bottom:14px;">
      <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Nama Kegiatan / Batch (opsional)</label>
      <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan',$jadwal?->nama_kegiatan??'') }}"
             placeholder="contoh: Sertifikasi Javascript Batch 2 (kosongkan jika sama dengan nama program)" class="fcc-input"
             onkeydown="if(event.key==='Enter')event.preventDefault();">
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kuota Peserta *</label>
        <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta',$jadwal?->kuota_peserta??20) }}"
               min="1" max="500" required class="fcc-input"
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Untuk Peserta *</label>
        <select name="untuk_peserta" required class="fcc-input">
          @foreach(['LP'=>'Laki-laki & Perempuan','L'=>'Laki-laki Saja','P'=>'Perempuan Saja'] as $v=>$l)
          <option value="{{ $v }}" {{ old('untuk_peserta',$jadwal?->untuk_peserta??'LP')===$v?'selected':'' }}>{{ $l }}</option>
          @endforeach
        </select>
      </div>
    </div>
    
    {{-- Multi-Biaya Setup --}}
    <div style="margin-top:16px;margin-bottom:14px;background:#F8F9FB;border:1px solid #E2E4EB;border-radius:10px;padding:12px 14px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
            <label style="font-size:10px;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;margin:0;">Jenis Biaya Pendaftaran (Opsional)</label>
            <button type="button" onclick="addBiayaRow('biaya-container')" style="font-size:11px;color:#3B82F6;background:none;border:none;font-weight:700;cursor:pointer;">+ Tambah Biaya</button>
        </div>
        <div id="biaya-container">
            @php $biayaSetup = old('nama_jenis_biaya') ? null : ($jadwal?->biaya_setup ?? []); @endphp
            @if(old('nama_jenis_biaya'))
                @foreach(old('nama_jenis_biaya') as $index => $nama)
                <div class="biaya-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;">
                    <input type="text" name="nama_jenis_biaya[]" value="{{ $nama }}" placeholder="contoh: Umum" class="fcc-input" style="background:#FFF;">
                    <input type="number" name="nominal_biaya[]" value="{{ old('nominal_biaya.'.$index) }}" placeholder="Nominal (Rp)" min="0" max="999999999" class="fcc-input" style="background:#FFF;">
                    <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:6px;">@include('components.icon',['name'=>'trash','size'=>14])</button>
                </div>
                @endforeach
            @elseif(count($biayaSetup) > 0)
                @foreach($biayaSetup as $biaya)
                <div class="biaya-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;">
                    <input type="text" name="nama_jenis_biaya[]" value="{{ $biaya['nama'] }}" placeholder="contoh: Umum" class="fcc-input" style="background:#FFF;">
                    <input type="number" name="nominal_biaya[]" value="{{ $biaya['nominal'] }}" placeholder="Nominal (Rp)" min="0" max="999999999" class="fcc-input" style="background:#FFF;">
                    <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:6px;">@include('components.icon',['name'=>'trash','size'=>14])</button>
                </div>
                @endforeach
            @else
                <div class="biaya-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;">
                    <input type="text" name="nama_jenis_biaya[]" value="" placeholder="contoh: Umum" class="fcc-input" style="background:#FFF;">
                    <input type="number" name="nominal_biaya[]" value="" placeholder="Nominal (Rp)" min="0" max="999999999" class="fcc-input" style="background:#FFF;">
                    <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:6px;">@include('components.icon',['name'=>'trash','size'=>14])</button>
                </div>
            @endif
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Batas Pendaftaran *</label>
        <input type="date" name="tgl_batas_daftar"
               value="{{ old('tgl_batas_daftar',$jadwal?->tgl_batas_daftar?->format('Y-m-d')??'') }}"
               required class="fcc-input"
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Tanggal Pelaksanaan *</label>
        <input type="date" name="tgl_pelaksanaan"
               value="{{ old('tgl_pelaksanaan',$jadwal?->tgl_pelaksanaan?->format('Y-m-d')??'') }}"
               required class="fcc-input"
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jam Mulai *</label>
        <input type="time" name="jam_mulai" value="{{ old('jam_mulai',$jadwal?->jam_mulai??'08:00') }}" required class="fcc-input">
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jam Selesai *</label>
        <input type="time" name="jam_selesai" value="{{ old('jam_selesai',$jadwal?->jam_selesai??'16:00') }}" required class="fcc-input">
      </div>
    </div>
  </div>

  @if(!$edit)
  <div class="fcc-card" style="padding:18px 20px;margin-bottom:16px;">
    <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
      <input type="checkbox" name="langsung_aktifkan" value="1" style="accent-color:#131218;width:16px;height:16px;">
      <div>
        <p style="margin:0;font-size:14px;font-weight:700;color:#131218;">Langsung aktifkan sebagai Kegiatan Publik</p>
        <p style="margin:0;font-size:12px;color:#9CA3B0;">Jika dicentang, jadwal ini akan langsung muncul di halaman publik setelah disimpan.</p>
      </div>
    </label>
  </div>
  @endif

  <div style="display:flex;gap:10px;">
    <button type="submit" class="fcc-btn-dark" style="padding:11px 28px;font-size:14px;">
      @include('components.icon',['name'=>'check','size'=>15,'style'=>'color:#FFC81A'])
      {{ $edit ? 'Perbarui Jadwal' : 'Simpan Jadwal' }}
    </button>
    <a href="{{ route('admin.sertifikasi.show', $program) }}"
       style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:10px;">
      Batal
    </a>
  </div>
</form>

</div>
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
        <input type="number" name="nominal_biaya[]" placeholder="Nominal (Rp)" min="0" max="999999999" class="fcc-input" style="background:#FFF;">
        <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:6px;">@include('components.icon',['name'=>'trash','size'=>14])</button>
    `;
    container.appendChild(div);
}
</script>
@endpush
