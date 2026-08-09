@extends('layouts.admin')
@section('title', 'Materi Sertifikasi')

@section('page-content')
<div style="padding:24px;">
    
    {{-- Header Section --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Modul Kurikulum</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Materi Sertifikasi</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Pilih program sertifikasi dan kelola materi uji kompetensinya di sini.</p>
        </div>

        @if($selectedSertifikasi)
        <button type="button" onclick="document.getElementById('create-modal').style.display='flex'"
                style="padding:10px 22px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(255,200,26,0.35);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            @include('components.icon',['name'=>'plus','size'=>16]) Tambah Materi Baru
        </button>
        @endif
    </div>

    {{-- TOP BAR: Searchable Dropdown Sertifikasi --}}
    <div class="fcc-card" style="margin-bottom:24px;padding:22px 24px;background:#FFF;border-radius:20px;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);">
        <form id="select-sertifikasi-form" method="GET" action="{{ route('admin.sertifikasi.materi.index') }}">
            <input type="hidden" name="sertifikasi_id" id="hidden-sertifikasi-id" value="{{ $selectedSertifikasi ? $selectedSertifikasi->id : '' }}">
            
            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">
                Pilih / Cari Program Sertifikasi Target
            </label>
            
            <div style="position:relative;width:100%;">
                <div style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#131218;pointer-events:none;z-index:2;">
                    @include('components.icon',['name'=>'award','size'=>18])
                </div>
                
                {{-- Searchable Input --}}
                <input type="text" id="sertifikasi-search-input"
                       placeholder="-- Ketik untuk mencari & memilih sertifikasi --"
                       value="{{ $selectedSertifikasi ? $selectedSertifikasi->kode . ' - ' . $selectedSertifikasi->judul : '' }}"
                       autocomplete="off"
                       class="fcc-input"
                       style="padding:10px 42px 10px 44px;font-size:13.5px;font-weight:800;color:#131218;width:100%;height:46px;background:#F8FAFC;border:1.5px solid #CBD5E1;border-radius:12px;cursor:pointer;"
                       onfocus="toggleDropdownList(true)"
                       oninput="filterDropdownOptions(this.value)">
                       
                <div style="position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#64748B;pointer-events:none;z-index:2;">
                    @include('components.icon',['name'=>'chevron-down','size'=>18])
                </div>

                {{-- Dropdown options list popup --}}
                <div id="dropdown-options-list" style="display:none;position:absolute;top:100%;left:0;right:0;margin-top:6px;background:#FFF;border:2px solid #131218;border-radius:14px;box-shadow:0 12px 32px rgba(0,0,0,0.15);max-height:280px;overflow-y:auto;z-index:100;">
                    @foreach($sertifikasis as $s)
                    <div class="dropdown-opt-item"
                         data-id="{{ $s->id }}"
                         data-text="{{ $s->kode }} - {{ $s->judul }}"
                         onclick="selectProgramItem('{{ $s->id }}', '{{ addslashes($s->kode . ' - ' . $s->judul) }}')"
                         style="padding:12px 18px;font-size:13.5px;font-weight:700;color:#131218;cursor:pointer;border-bottom:1px solid #F1F5F9;transition:background .15s;"
                         onmouseover="this.style.background='#FFFDF5';this.style.color='#131218'"
                         onmouseout="this.style.background='#FFF';this.style.color='#131218'">
                        <span style="font-weight:900;color:#131218;background:#FFC81A;padding:2px 8px;border-radius:6px;margin-right:8px;font-family:monospace;font-size:11.5px;border:1px solid #131218;">{{ $s->kode }}</span> {{ $s->judul }}
                    </div>
                    @endforeach
                    <div id="no-options-found" style="display:none;padding:14px 18px;font-size:13px;color:#94A3B8;text-align:center;">
                        Tidak ada sertifikasi yang cocok dengan pencarian
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($selectedSertifikasi)
    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">
        
        {{-- KIRI: Tabel Materi Sertifikasi --}}
        <div>
            <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">
                            Daftar Modul Materi Sertifikasi
                        </h3>
                        <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $selectedSertifikasi->materi->count() }} Modul</span>
                    </div>

                    <button type="button" onclick="document.getElementById('create-modal').style.display='flex'"
                            style="padding:7px 16px;font-size:12px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:20px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:all .18s;"
                            onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                        @include('components.icon',['name'=>'plus','size'=>14]) Tambah Materi
                    </button>
                </div>

                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background:#131218;color:#FFFFFF;">
                                <th style="text-align:center;padding:14px 16px;font-weight:900;color:#FFC81A;width:55px;text-transform:uppercase;font-size:11px;letter-spacing:0.6px;">No</th>
                                <th style="text-align:left;padding:14px 16px;font-weight:900;color:#FFFFFF;text-transform:uppercase;font-size:11px;letter-spacing:0.6px;">Judul & Berkas Materi</th>
                                <th style="text-align:left;padding:14px 16px;font-weight:900;color:#FFFFFF;text-transform:uppercase;font-size:11px;letter-spacing:0.6px;">Durasi (JP)</th>
                                <th style="text-align:center;padding:14px 20px;font-weight:900;color:#FFC81A;width:130px;text-transform:uppercase;font-size:11px;letter-spacing:0.6px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($selectedSertifikasi->materi as $index => $m)
                            <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                                <td style="padding:14px 16px;text-align:center;vertical-align:middle;color:#64748B;font-weight:800;font-size:13px;">
                                    <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;">{{ $index + 1 }}</span>
                                </td>
                                <td style="padding:14px 16px;vertical-align:middle;">
                                    <p style="font-weight:900;color:#131218;font-size:14px;margin:0 0 4px;">{{ $m->judul_materi }}</p>
                                    @if($m->link_materi)
                                    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                        <a href="{{ $m->link_materi }}" target="_blank" style="font-size:11.5px;color:#10B981;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:4px;background:#ECFDF5;padding:2px 10px;border-radius:12px;border:1px solid #A7F3D0;">
                                            @include('components.icon',['name'=>'globe','size'=>12]) Tautan Eksternal
                                        </a>
                                    </div>
                                    @endif
                                </td>
                                <td style="padding:14px 16px;vertical-align:middle;color:#131218;font-size:13.5px;font-weight:800;">
                                    <span style="background:#F1F5F9;border:1px solid #CBD5E1;padding:3px 10px;border-radius:12px;display:inline-block;">
                                        {{ $m->isi ? (str_contains(strtolower($m->isi), 'jp') ? $m->isi : $m->isi . ' JP') : '-' }}
                                    </span>
                                </td>
                                <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                                    <div style="display:inline-flex;align-items:center;gap:6px;">
                                        <button type="button" onclick="openEditModal('{{ route('admin.materi-sertifikasi.update', [$selectedSertifikasi, $m]) }}', '{{ addslashes($m->judul_materi) }}', '{{ addslashes($m->deskripsi ?? $m->isi ?? '') }}')"
                                                style="padding:6px 10px;font-size:12px;font-weight:800;color:#131218;background:#FFC81A;border:1.5px solid #131218;border-radius:20px;cursor:pointer;transition:all .18s;display:inline-flex;align-items:center;justify-content:center;" title="Edit Materi"
                                                onmouseover="this.style.transform='scale(1.04)'" onmouseout="this.style.transform='scale(1)'">
                                            @include('components.icon',['name'=>'edit','size'=>13])
                                        </button>
                                        <form action="{{ route('admin.materi-sertifikasi.destroy', [$selectedSertifikasi, $m]) }}" method="POST" style="margin:0;" onsubmit="return fccConfirmDelete(event, this, 'Hapus Materi', 'Apakah Anda yakin ingin menghapus materi sertifikasi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="padding:6px 9px;font-size:12px;font-weight:800;color:#EF4444;background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:20px;cursor:pointer;transition:all .18s;display:inline-flex;align-items:center;justify-content:center;" title="Hapus Materi"
                                                    onmouseover="this.style.background='#EF4444';this.style.color='#FFF';this.style.borderColor='#EF4444';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                                                @include('components.icon',['name'=>'trash','size'=>13])
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align:center;padding:48px 24px;color:#94A3B8;">
                                    <div style="width:52px;height:52px;background:#F7F8FA;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                        @include('components.icon',['name'=>'book-open','size'=>24,'style'=>'color:#9CA3B0'])
                                    </div>
                                    <p style="font-weight:900;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Materi Terdaftar</p>
                                    <p style="font-size:12.5px;color:#64748B;margin:0;">Klik tombol Tambah Materi di atas untuk membuat modul materi pertama.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KANAN: Sidebar Ringkasan Sertifikasi --}}
        <div>
            <div class="fcc-card" style="padding:22px;border-radius:20px;background:#FFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);position:sticky;top:90px;">
                <div style="margin-bottom:16px;text-align:center;">
                    @if($selectedSertifikasi->gambar_url || $selectedSertifikasi->gambar)
                    <img src="{{ $selectedSertifikasi->gambar_url ?? asset('storage/'.$selectedSertifikasi->gambar) }}" alt="{{ $selectedSertifikasi->judul }}" style="width:100%;height:140px;object-fit:cover;border-radius:14px;border:1.5px solid #131218;margin-bottom:14px;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                    @endif
                    <span style="font-size:11px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 12px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;margin-bottom:8px;">
                        {{ $selectedSertifikasi->kode }}
                    </span>
                    <h3 style="font-size:16px;font-weight:900;color:#131218;margin:0 0 6px;">{{ $selectedSertifikasi->judul }}</h3>
                    <span style="font-size:12px;font-weight:800;color:#131218;background:#F1F5F9;border:1px solid #CBD5E1;padding:3px 12px;border-radius:20px;display:inline-block;">
                        {{ $selectedSertifikasi->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                </div>

                <div style="border-top:1px solid #F1F5F9;padding-top:14px;display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;justify-content:space-between;font-size:12.5px;">
                        <span style="color:#64748B;font-weight:600;">Total Modul Materi</span>
                        <span style="font-weight:900;color:#131218;">{{ $selectedSertifikasi->materi->count() }} Modul</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:12.5px;">
                        <span style="color:#64748B;font-weight:600;">Batch Jadwal Pelaksanaan</span>
                        <span style="font-weight:900;color:#131218;">{{ $selectedSertifikasi->jadwal->count() }} Batch</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @else
    <div class="fcc-card" style="padding:48px 24px;text-align:center;background:#FFF;border-radius:20px;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);">
        <div style="width:64px;height:64px;background:#F8FAFC;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;border:1.5px solid #CBD5E1;">
            @include('components.icon',['name'=>'award','size'=>28,'style'=>'color:#131218'])
        </div>
        <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0 0 6px;">Pilih Program Sertifikasi</h2>
        <p style="color:#64748B;font-size:13.5px;max-width:460px;margin:0 auto;">Silakan cari dan pilih program sertifikasi melalui dropdown di atas untuk mengelola materi uji kompetensinya.</p>
    </div>
    @endif

</div>

@if($selectedSertifikasi)
    @include('admin.sertifikasi.materi.create-modal')
    @include('admin.sertifikasi.materi.edit-modal')
@endif

@endsection

@push('scripts')
<script>
function toggleDropdownList(show) {
    const list = document.getElementById('dropdown-options-list');
    if (list) list.style.display = show ? 'block' : 'none';
}

function filterDropdownOptions(query) {
    const items = document.querySelectorAll('.dropdown-opt-item');
    let hasMatch = false;
    const q = query.toLowerCase();
    
    items.forEach(item => {
        const text = item.getAttribute('data-text').toLowerCase();
        if (text.includes(q)) {
            item.style.display = 'block';
            hasMatch = true;
        } else {
            item.style.display = 'none';
        }
    });

    const noFound = document.getElementById('no-options-found');
    if (noFound) noFound.style.display = hasMatch ? 'none' : 'block';
    toggleDropdownList(true);
}

function selectProgramItem(id, text) {
    document.getElementById('hidden-sertifikasi-id').value = id;
    document.getElementById('sertifikasi-search-input').value = text;
    toggleDropdownList(false);
    document.getElementById('select-sertifikasi-form').submit();
}

document.addEventListener('click', function(e) {
    const searchInput = document.getElementById('sertifikasi-search-input');
    const optionsList = document.getElementById('dropdown-options-list');
    if (searchInput && optionsList && !searchInput.contains(e.target) && !optionsList.contains(e.target)) {
        toggleDropdownList(false);
    }
});
</script>
@endpush
