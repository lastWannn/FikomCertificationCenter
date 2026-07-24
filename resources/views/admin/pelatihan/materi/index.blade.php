@extends('layouts.admin')

@section('page-title', 'Materi Pelatihan')
@section('page-content')
<div style="padding:24px 32px;max-width:1100px;margin:0 auto;width:100%;">
    
    {{-- Header Section --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px;font-weight:900;color:#131218;margin:0 0 6px;letter-spacing:-0.5px;">
                Kelola <span style="color:#FFC81A;">Materi</span>
            </h1>
            <p style="color:#6B7280;font-size:14px;margin:0;">Pilih pelatihan dan kelola materi pembelajarannya di sini.</p>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div style="background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.25);padding:14px 18px;border-radius:12px;margin-bottom:24px;display:flex;align-items:center;gap:12px;animation:modalIn .3s ease;">
        @include('components.icon',['name'=>'check-circle','size'=>20,'style'=>'color:#10B981'])
        <p style="color:#10B981;font-size:13.5px;font-weight:700;margin:0;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- TOP BAR: Select Pelatihan --}}
    <div class="fcc-card" style="margin-bottom:24px;padding:24px;background:#FFF;border-radius:16px;box-shadow:0 4px 20px rgba(0,0,0,0.03);">
        <form id="select-pelatihan-form" method="GET" action="{{ route('admin.materi.index') }}">
            <label style="font-size:12px;font-weight:800;color:#9CA3B0;display:block;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">
                Pilih Pelatihan
            </label>
            <div style="position:relative;">
                <div style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#FFC81A;pointer-events:none;">
                    @include('components.icon',['name'=>'book-open','size'=>18])
                </div>
                <select name="pelatihan_id" onchange="document.getElementById('select-pelatihan-form').submit()" class="fcc-input" style="padding:14px 16px 14px 44px;font-size:14.5px;font-weight:700;color:#131218;width:100%;background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:12px;cursor:pointer;appearance:none;transition:all .2s;" onmouseover="this.style.borderColor='#FFC81A';this.style.background='#FFF'" onmouseout="this.style.borderColor='#E2E4EB';this.style.background='#F7F8FA'">
                    <option value="" style="color:#9CA3B0;">-- Silahkan Pilih Judul Pelatihan --</option>
                    @foreach($pelatihans as $p)
                        <option value="{{ $p->id }}" {{ ($selectedPelatihan && $selectedPelatihan->id == $p->id) ? 'selected' : '' }}>
                            {{ $p->kode }} - {{ $p->judul }}
                        </option>
                    @endforeach
                </select>
                <div style="position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#9CA3B0;pointer-events:none;">
                    @include('components.icon',['name'=>'chevron-down','size'=>16])
                </div>
            </div>
        </form>
    </div>

    @if($selectedPelatihan)
    <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">
        
        {{-- KIRI: Tabel Materi & Form Tambah --}}
        <div>
            <div class="fcc-card" style="padding:0;overflow:hidden;margin-bottom:24px;">
                <div style="padding:18px 24px;border-bottom:1px solid #F0F1F5;display:flex;justify-content:space-between;align-items:center;background:#FDFDFE;">
                    <p style="margin:0;font-size:15px;font-weight:800;color:#131218;">
                        Daftar Materi ({{ $selectedPelatihan->materi->count() }})
                    </p>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <span style="font-size:12px;font-weight:700;color:#FFC81A;background:rgba(255,200,26,.15);padding:6px 12px;border-radius:20px;">
                            Total: {{ $selectedPelatihan->materi->sum('jam_pelajaran') }} JP
                        </span>
                        <button type="button" onclick="document.getElementById('create-modal').style.display='flex'" class="fcc-btn-gold" style="padding:8px 16px;font-size:13px;font-weight:800;border:none;border-radius:10px;cursor:pointer;display:flex;align-items:center;gap:6px;">
                            @include('components.icon',['name'=>'plus-circle','size'=>16]) Tambah Materi
                        </button>
                    </div>
                </div>



                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;font-size:13.5px;">
                        <thead>
                            <tr style="background:#F7F8FA;border-bottom:1px solid #E2E4EB;">
                                <th style="text-align:left;padding:14px 24px;font-weight:800;color:#9CA3B0;width:5%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">No</th>
                                <th style="text-align:left;padding:14px 24px;font-weight:800;color:#9CA3B0;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Judul Materi</th>
                                <th style="text-align:center;padding:14px 24px;font-weight:800;color:#9CA3B0;width:15%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">JP</th>
                                <th style="text-align:center;padding:14px 24px;font-weight:800;color:#9CA3B0;width:15%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($selectedPelatihan->materi as $index => $mat)
                            <tr style="border-bottom:1px solid #F0F1F5;transition:background .2s;" onmouseover="this.style.background='#F8F9FB'" onmouseout="this.style.background='none'">
                                <td style="padding:16px 24px;color:#9CA3B0;font-weight:700;">{{ $index + 1 }}</td>
                                <td style="padding:16px 24px;font-weight:700;color:#131218;">{{ $mat->judul_materi }}</td>
                                <td style="padding:16px 24px;text-align:center;">
                                    <span style="font-weight:800;color:#FFC81A;background:rgba(255,200,26,.1);padding:4px 12px;border-radius:8px;">{{ $mat->jam_pelajaran }}</span>
                                </td>
                                <td style="padding:16px 24px;text-align:center;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:8px;">
                                        <button type="button" onclick="openEditModal('{{ route('admin.materi-pelatihan.update', [$selectedPelatihan->id, $mat->id]) }}', '{{ addslashes($mat->judul_materi) }}', '{{ $mat->jam_pelajaran }}')" style="background:#FFF;border:1px solid #E2E4EB;color:#6B7280;width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;box-shadow:0 2px 4px rgba(0,0,0,.02);" onmouseover="this.style.background='#F7F8FA';this.style.borderColor='#FFC81A';this.style.color='#FFC81A';this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#FFF';this.style.borderColor='#E2E4EB';this.style.color='#6B7280';this.style.transform='none'" title="Edit Materi">
                                            @include('components.icon',['name'=>'edit','size'=>15])
                                        </button>
                                        <form action="{{ route('admin.materi-pelatihan.destroy', [$selectedPelatihan->id, $mat->id]) }}" method="POST" style="margin:0;" onsubmit="return confirm('Yakin ingin menghapus materi ini secara permanen?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="background:#FFF;border:1px solid #FEE2E2;color:#EF4444;width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;box-shadow:0 2px 4px rgba(239,68,68,.05);" onmouseover="this.style.background='#FEF2F2';this.style.borderColor='#FCA5A5';this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#FFF';this.style.borderColor='#FEE2E2';this.style.transform='none'" title="Hapus Materi">
                                                @include('components.icon',['name'=>'trash','size'=>15])
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align:center;padding:48px 24px;color:#9CA3B0;">
                                    <div style="width:64px;height:64px;background:#F7F8FA;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                                        @include('components.icon',['name'=>'inbox','size'=>28,'style'=>'color:#C0C4CF'])
                                    </div>
                                    <p style="font-weight:700;color:#6B7280;margin:0 0 4px;font-size:14px;">Belum Ada Materi</p>
                                    <p style="font-size:12.5px;margin:0;">Silakan tambahkan materi pertama melalui form di atas.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KANAN: Info Pelatihan & Poster --}}
        <div>
            <div class="fcc-card" style="padding:20px;position:sticky;top:24px;">
                <p style="font-size:11px;font-weight:800;color:#9CA3B0;text-transform:uppercase;letter-spacing:1px;margin:0 0 12px;border-bottom:1px solid #E2E4EB;padding-bottom:8px;">Informasi Pelatihan</p>
                
                <div style="margin-bottom:16px;">
                    <p style="margin:0 0 4px;font-size:11.5px;font-weight:700;color:#6B7280;">Kategori</p>
                    <p style="margin:0;font-size:14px;font-weight:800;color:#FFC81A;">{{ $selectedPelatihan->kategori->nama_kategori ?? 'Tidak ada kategori' }}</p>
                </div>

                <div style="margin-bottom:20px;">
                    <p style="margin:0 0 4px;font-size:11.5px;font-weight:700;color:#6B7280;">Kode Pelatihan</p>
                    <p style="margin:0;font-size:13.5px;font-weight:700;color:#131218;font-family:monospace;background:#F7F8FA;padding:6px 10px;border-radius:8px;display:inline-block;border:1px solid #E2E4EB;">{{ $selectedPelatihan->kode }}</p>
                </div>

                <p style="font-size:11.5px;font-weight:700;color:#6B7280;margin:0 0 8px;">Poster Pelatihan</p>
                @if($selectedPelatihan->gambar)
                    <img src="{{ Storage::url($selectedPelatihan->gambar) }}" alt="Poster" style="width:100%;border-radius:12px;object-fit:cover;aspect-ratio:3/4;box-shadow:0 8px 24px rgba(0,0,0,0.12);border:1px solid #E2E4EB;">
                @else
                    <div style="width:100%;aspect-ratio:3/4;background:#F7F8FA;border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#9CA3B0;border:2px dashed #E2E4EB;">
                        @include('components.icon',['name'=>'image','size'=>32,'style'=>'opacity:.4;margin-bottom:12px;'])
                        <span style="font-size:12px;font-weight:700;">Belum ada poster</span>
                    </div>
                @endif
            </div>
        </div>

    </div>
    @endif
</div>

{{-- MODALS --}}
@if($selectedPelatihan)
    @include('admin.pelatihan.materi.create-modal')
    @include('admin.pelatihan.materi.edit-modal')
@endif
@endsection
