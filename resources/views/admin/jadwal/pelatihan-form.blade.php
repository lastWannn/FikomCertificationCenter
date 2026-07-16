@extends('layouts.admin')
@section('title', isset($jadwal) ? 'Edit Jadwal Pelatihan' : 'Tambah Jadwal Pelatihan')
@section('page-title', isset($jadwal) ? 'Edit Jadwal Pelatihan' : 'Tambah Jadwal Pelatihan')
@section('page-content')
@php $jenis='pelatihan'; $program=$pelatihan; @endphp
<div style="padding:20px 24px;max-width:760px;">
  <a href="{{ route('admin.jadwal-pelatihan.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:16px;">
    @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
  </a>
  
@php $edit = isset($jadwal); @endphp
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

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kuota Peserta *</label>
        <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta',$jadwal->kuota_peserta??20) }}"
               min="1" max="500" required class="fcc-input"
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Untuk Peserta *</label>
        <select name="untuk_peserta" required class="fcc-input">
          @foreach(['LP'=>'Laki-laki & Perempuan','L'=>'Laki-laki Saja','P'=>'Perempuan Saja'] as $v=>$l)
          <option value="{{ $v }}" {{ old('untuk_peserta',$jadwal->untuk_peserta??'LP')===$v?'selected':'' }}>{{ $l }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Batas Pendaftaran *</label>
        <input type="date" name="tgl_batas_daftar"
               value="{{ old('tgl_batas_daftar',$jadwal->tgl_batas_daftar?->format('Y-m-d')??'') }}"
               required class="fcc-input"
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Tanggal Pelaksanaan *</label>
        <input type="date" name="tgl_pelaksanaan"
               value="{{ old('tgl_pelaksanaan',$jadwal->tgl_pelaksanaan?->format('Y-m-d')??'') }}"
               required class="fcc-input"
               onkeydown="if(event.key==='Enter')event.preventDefault();">
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jam Mulai *</label>
        <input type="time" name="jam_mulai" value="{{ old('jam_mulai',$jadwal->jam_mulai??'08:00') }}" required class="fcc-input">
      </div>
      <div>
        <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jam Selesai *</label>
        <input type="time" name="jam_selesai" value="{{ old('jam_selesai',$jadwal->jam_selesai??'16:00') }}" required class="fcc-input">
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
    <a href="{{ $jenis==='pelatihan' ? route('admin.jadwal-pelatihan.index') : route('admin.jadwal-sertifikasi.index') }}"
       style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:10px;">
      Batal
    </a>
  </div>
</form>

</div>
@endsection
