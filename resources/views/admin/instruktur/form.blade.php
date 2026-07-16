@extends('layouts.admin')
@section('title', isset($instruktur) ? 'Edit Instruktur' : 'Tambah Instruktur')
@section('page-title', isset($instruktur) ? 'Edit Instruktur' : 'Tambah Instruktur')
@section('page-content')
@php $edit = isset($instruktur); @endphp
<div style="padding:20px 24px;max-width:680px;">
  <a href="{{ route('admin.instruktur.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:16px;">
    @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
  </a>
  <div class="fcc-card" style="padding:28px;">
    <form action="{{ $edit ? route('admin.instruktur.update', $instruktur) : route('admin.instruktur.store') }}" method="POST">
      @csrf @if($edit) @method('PUT') @endif
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        @foreach([
          ['no_identitas','No. Identitas (KTP/NIDN)','text','no_identitas',false],
          ['nama','Nama Lengkap','text','nama',true],
          ['email','Email','email','email',true],
          ['no_hp','No. HP','tel','no_hp',true],
          ['keahlian','Keahlian / Bidang','text','keahlian',true],
        ] as [$n,$l,$t,$key,$req])
        <div>
          <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">
            {{ $l }} {!! $req?'<span style="color:#FFC81A;">*</span>':'' !!}
          </label>
          <input type="{{ $t }}" name="{{ $n }}" value="{{ old($n,$edit?$instruktur->$key:'') }}"
                 {{ $req?'required':'' }} class="fcc-input"
                 onkeydown="if(event.key==='Enter')event.preventDefault();">
          @error($n)<p style="color:#EF4444;font-size:11px;margin:3px 0 0;">{{ $message }}</p>@enderror
        </div>
        @endforeach

        <div>
          <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jenis Kelamin *</label>
          <div style="display:flex;gap:10px;">
            @foreach(['L'=>'Laki-laki','P'=>'Perempuan'] as $v=>$l)
            <label style="flex:1;display:flex;align-items:center;gap:8px;padding:10px 12px;border:1.5px solid #E2E4EB;border-radius:9px;cursor:pointer;font-size:14px;color:#131218;background:#F7F8FA;transition:border-color .18s;"
                   onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
              <input type="radio" name="kelamin" value="{{ $v }}" {{ old('kelamin',$edit?$instruktur->kelamin:'L')===$v?'checked':'' }} required style="accent-color:#131218;">
              {{ $l }}
            </label>
            @endforeach
          </div>
        </div>

        <div style="grid-column:span 2;">
          <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Alamat</label>
          <textarea name="alamat" rows="3" placeholder="Alamat lengkap" class="fcc-input" style="resize:vertical;">{{ old('alamat',$edit?$instruktur->alamat:'') }}</textarea>
        </div>

        <div>
          <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">
            Password {{ $edit?'(kosongkan jika tidak diubah)':'*' }}
          </label>
          <input type="password" name="password" placeholder="Minimal 8 karakter" {{ $edit?'':'required' }}
                 class="fcc-input" onkeydown="if(event.key==='Enter')event.preventDefault();">
        </div>
        @if(!$edit)
        <div>
          <label style="font-size:11px;font-weight:700;color:#9CA3B0;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Konfirmasi Password *</label>
          <input type="password" name="password_confirmation" required placeholder="Ulangi password" class="fcc-input" onkeydown="if(event.key==='Enter')event.preventDefault();">
        </div>
        @endif
      </div>

      <div style="display:flex;gap:10px;margin-top:22px;">
        <button type="submit" class="fcc-btn-dark" style="padding:11px 28px;font-size:14px;">
          @include('components.icon',['name'=>'check','size'=>15,'style'=>'color:#FFC81A'])
          {{ $edit ? 'Perbarui' : 'Simpan Instruktur' }}
        </button>
        <a href="{{ route('admin.instruktur.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:10px;">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
