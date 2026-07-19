@extends('layouts.admin')
@section('title', isset($informasi) ? 'Edit Informasi' : 'Tambah Informasi')
@section('page-content')
<div style="padding:24px;max-width:800px;">
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.informasi.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0;">{{ isset($informasi) ? 'Edit' : 'Tambah' }} Informasi / FAQ</h1>
    </div>
    <div class="fcc-card" style="padding:28px;">
        <form action="{{ isset($informasi) ? route('admin.informasi.update', $informasi) : route('admin.informasi.store') }}" method="POST">
            @csrf @if(isset($informasi)) @method('PUT') @endif

            {{-- Jenis --}}
            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Jenis *</label>
                <div style="display:flex;gap:12px;">
                    @foreach(['info'=>'📢 Informasi / Pengumuman','faq'=>'❓ FAQ'] as $v=>$l)
                    <label id="label-jenis-{{ $v }}" style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px;color:#0F0F14;padding:10px 16px;border:1.5px solid #E2E4EB;border-radius:9px;flex:1;transition:border-color .18s;"
                           onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor=(document.querySelector('[name=jenis][value=\'{{ $v }}\']').checked)?'#FFC81A':'#E2E4EB'">
                        <input type="radio" name="jenis" value="{{ $v }}" id="jenis-{{ $v }}"
                               {{ old('jenis',isset($informasi)?$informasi->jenis:'info')===$v?'checked':'' }} required style="accent-color:#FFC81A;"
                               onchange="toggleTayangSection()">
                        {{ $l }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Judul / Informasi --}}
            <div style="margin-bottom:16px;">
                <label id="judul-label" style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Isi Pengumuman / Informasi *</label>
                <input type="text" name="judul" id="judul-input" value="{{ old('judul',isset($informasi)?$informasi->judul:'') }}" placeholder="Tulis pengumuman di sini..." required class="fcc-input">
            </div>

            {{-- Isi — hanya untuk FAQ --}}
            <div id="isi-section" style="margin-bottom:20px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Isi / Jawaban *</label>
                <textarea name="isi" id="isi-textarea" rows="7" placeholder="Isi konten atau jawaban..." required class="fcc-input" style="resize:vertical;">{{ old('isi',isset($informasi)?$informasi->isi:'') }}</textarea>
            </div>

            {{-- Waktu Tayang — hanya untuk Informasi/Pengumuman --}}
            <div id="tayang-section" style="margin-bottom:24px;padding:20px;background:#FFFBEA;border:1.5px solid #FFC81A22;border-radius:12px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;">
                    @include('components.icon',['name'=>'clock','size'=>15,'style'=>'color:#FFC81A'])
                    <p style="font-size:12px;font-weight:800;color:#92400E;margin:0;text-transform:uppercase;letter-spacing:.7px;">Waktu Tayang Pengumuman</p>
                </div>
                <p style="font-size:12.5px;color:#78716C;margin:0 0 14px;line-height:1.6;">
                    Atur kapan pengumuman ini ditampilkan ke publik. Kosongkan kedua kolom jika ingin selalu aktif.
                </p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Mulai Tayang</label>
                        <input type="datetime-local" name="tayang_mulai"
                               value="{{ old('tayang_mulai', isset($informasi) && $informasi->tayang_mulai ? $informasi->tayang_mulai->format('Y-m-d\TH:i') : '') }}"
                               class="fcc-input" style="font-size:13px;">
                        <p style="font-size:11px;color:#9CA3AF;margin:4px 0 0;">Kosong = langsung aktif</p>
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Selesai Tayang</label>
                        <input type="datetime-local" name="tayang_selesai"
                               value="{{ old('tayang_selesai', isset($informasi) && $informasi->tayang_selesai ? $informasi->tayang_selesai->format('Y-m-d\TH:i') : '') }}"
                               class="fcc-input" style="font-size:13px;">
                        <p style="font-size:11px;color:#9CA3AF;margin:4px 0 0;">Kosong = tidak ada batas waktu</p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div style="display:flex;gap:10px;">
                <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">
                    @include('components.icon',['name'=>'check','size'=>15]) {{ isset($informasi) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.informasi.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;">Batal</a>
            </div>
        </form>
    </div>
</div>
<script>
    function toggleTayangSection() {
        const isFaq = document.getElementById('jenis-faq')?.checked;
        
        // Handle label & placeholder dinamis untuk Judul/Informasi
        const jLBL = document.getElementById('judul-label');
        const jINP = document.getElementById('judul-input');
        if (jLBL && jINP) {
            if (isFaq) {
                jLBL.innerHTML = 'Pertanyaan (FAQ) *';
                jINP.placeholder = 'Tulis pertanyaan FAQ di sini...';
            } else {
                jLBL.innerHTML = 'Isi Pengumuman / Informasi *';
                jINP.placeholder = 'Tulis teks pengumuman yang akan berjalan di banner...';
            }
        }
        
        // Handle Tayang Section (Hanya untuk Informasi)
        const tayangSec = document.getElementById('tayang-section');
        if (tayangSec) {
            tayangSec.style.display = isFaq ? 'none' : 'block';
            if (isFaq) {
                tayangSec.querySelectorAll('input[type="datetime-local"]').forEach(i => i.value = '');
            }
        }

        // Handle Isi/Jawaban Section (Hanya untuk FAQ)
        const isiSec = document.getElementById('isi-section');
        const isiTextarea = document.getElementById('isi-textarea');
        if (isiSec && isiTextarea) {
            isiSec.style.display = isFaq ? 'block' : 'none';
            if (isFaq) {
                isiTextarea.setAttribute('required', 'required');
            } else {
                isiTextarea.removeAttribute('required');
                isiTextarea.value = '';
            }
        }
    }
    document.addEventListener('DOMContentLoaded', toggleTayangSection);
</script>
@endsection
