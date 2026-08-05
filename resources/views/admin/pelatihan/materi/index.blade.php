@extends('layouts.admin')

@section('page-title', 'Materi Pelatihan')
@section('page-content')
<div style="padding:24px;max-width:1200px;margin:0 auto;width:100%;">
    
    {{-- Header Section --}}
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;">Kelola Materi Pelatihan</h1>
            <p style="color:#6B7280;font-size:13.5px;margin:0;">Pilih program pelatihan dan kelola materi pembelajarannya di sini.</p>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div style="background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.25);padding:12px 18px;border-radius:12px;margin-bottom:20px;display:flex;align-items:center;gap:12px;">
        @include('components.icon',['name'=>'check-circle','size'=>18,'style'=>'color:#10B981'])
        <p style="color:#10B981;font-size:13.5px;font-weight:700;margin:0;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- TOP BAR: Searchable Dropdown Pelatihan --}}
    <div class="fcc-card" style="margin-bottom:20px;padding:20px 24px;background:#FFF;border-radius:16px;">
        <form id="select-pelatihan-form" method="GET" action="{{ route('admin.materi.index') }}">
            <input type="hidden" name="pelatihan_id" id="hidden-pelatihan-id" value="{{ $selectedPelatihan ? $selectedPelatihan->id : '' }}">
            
            <label style="font-size:11px;font-weight:800;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">
                Pilih / Cari Program Pelatihan
            </label>
            
            <div style="position:relative;width:100%;">
                <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#FFC81A;pointer-events:none;z-index:2;">
                    @include('components.icon',['name'=>'book-open','size'=>16])
                </div>
                
                {{-- Searchable Input (Langsung Cari di Dropdown ini) --}}
                <input type="text" id="pelatihan-search-input"
                       placeholder="-- Ketik untuk mencari & memilih pelatihan --"
                       value="{{ $selectedPelatihan ? $selectedPelatihan->kode . ' - ' . $selectedPelatihan->judul : '' }}"
                       autocomplete="off"
                       class="fcc-input"
                       style="padding:10px 40px 10px 40px;font-size:13.5px;font-weight:700;color:#131218;width:100%;height:42px;background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:10px;cursor:pointer;"
                       onfocus="toggleDropdownList(true)"
                       oninput="filterDropdownOptions(this.value)">
                       
                <div style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#9CA3B0;pointer-events:none;z-index:2;">
                    @include('components.icon',['name'=>'chevron-down','size'=>16])
                </div>

                {{-- Dropdown options list popup --}}
                <div id="dropdown-options-list" style="display:none;position:absolute;top:100%;left:0;right:0;margin-top:4px;background:#FFF;border:1.5px solid #E2E4EB;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);max-height:260px;overflow-y:auto;z-index:100;">
                    @foreach($pelatihans as $p)
                    <div class="dropdown-opt-item"
                         data-id="{{ $p->id }}"
                         data-text="{{ $p->kode }} - {{ $p->judul }}"
                         onclick="selectProgramItem('{{ $p->id }}', '{{ addslashes($p->kode . ' - ' . $p->judul) }}')"
                         style="padding:11px 16px;font-size:13px;font-weight:600;color:#131218;cursor:pointer;border-bottom:1px solid #F0F1F5;transition:background .15s;"
                         onmouseover="this.style.background='#FFFDF5';this.style.color='#D97706'"
                         onmouseout="this.style.background='#FFF';this.style.color='#131218'">
                        <span style="font-weight:800;color:#D97706;margin-right:6px;font-family:monospace;">[{{ $p->kode }}]</span> {{ $p->judul }}
                    </div>
                    @endforeach
                    <div id="no-options-found" style="display:none;padding:12px 16px;font-size:12.5px;color:#9CA3B0;text-align:center;">
                        Tidak ada pelatihan yang cocok dengan pencarian
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($selectedPelatihan)
    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">
        
        {{-- KIRI: Tabel Materi & Form Tambah --}}
        <div>
            <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:16px;">
                <div style="padding:16px 20px;border-bottom:1px solid #F0F1F5;display:flex;justify-content:space-between;align-items:center;background:#F8F9FB;flex-wrap:wrap;gap:12px;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">
                            Daftar Materi ({{ $selectedPelatihan->materi->count() }})
                        </p>
                        <span style="font-size:11px;font-weight:800;color:#9A7300;background:rgba(255,200,26,.18);padding:4px 10px;border-radius:20px;">
                            Total: {{ $selectedPelatihan->materi->sum('jam_pelajaran') }} JP
                        </span>
                    </div>

                    <button type="button" onclick="document.getElementById('create-modal').style.display='flex'" class="fcc-btn-gold" style="padding:7px 14px;font-size:12px;font-weight:800;border:none;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                        @include('components.icon',['name'=>'plus-circle','size'=>14]) Tambah Materi
                    </button>
                </div>

                <div style="overflow-x:auto;">
                    <table class="admin-table" style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                                <th style="text-align:center;padding:12px 14px;font-weight:800;color:#6B7280;width:50px;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">No</th>
                                <th style="text-align:left;padding:12px 16px;font-weight:800;color:#6B7280;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Judul Materi</th>
                                <th style="text-align:center;padding:12px 14px;font-weight:800;color:#6B7280;width:100px;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">JP</th>
                                <th style="text-align:center;padding:12px 20px;font-weight:800;color:#6B7280;width:120px;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($selectedPelatihan->materi as $index => $mat)
                            <tr class="tbl-row" style="border-bottom:1px solid #F0F1F3;transition:background .15s;" onmouseover="this.style.background='#FAFBFD'" onmouseout="this.style.background='transparent'">
                                <td style="padding:14px;text-align:center;color:#6B7280;font-weight:700;font-size:13px;">{{ $index + 1 }}</td>
                                <td style="padding:14px 16px;font-weight:700;color:#131218;font-size:13.5px;">{{ $mat->judul_materi }}</td>
                                <td style="padding:14px;text-align:center;">
                                    <span style="font-weight:800;font-size:11.5px;color:#9A7300;background:rgba(255,200,26,.15);padding:3px 10px;border-radius:6px;">{{ $mat->jam_pelajaran }} JP</span>
                                </td>
                                <td style="padding:14px 20px;text-align:center;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <button type="button" onclick="openEditModal('{{ route('admin.materi-pelatihan.update', [$selectedPelatihan, $mat]) }}', '{{ addslashes($mat->judul_materi) }}', '{{ $mat->jam_pelajaran }}')" class="fcc-btn-outline-dark" style="padding:5px 10px;font-size:12px;border-radius:6px;" title="Edit Materi">
                                            @include('components.icon',['name'=>'edit','size'=>13]) Edit
                                        </button>
                                        <form action="{{ route('admin.materi-pelatihan.destroy', [$selectedPelatihan, $mat]) }}" method="POST" style="margin:0;" onsubmit="return fccConfirmDelete(event, this, 'Hapus Materi', 'Apakah Anda yakin ingin menghapus materi pelatihan ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="background:#FFF;border:1px solid #FEE2E2;color:#EF4444;padding:5px 10px;border-radius:6px;font-size:12px;font-weight:700;cursor:pointer;" title="Hapus Materi">
                                                @include('components.icon',['name'=>'trash','size'=>13])
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align:center;padding:48px 24px;color:#9CA3B0;">
                                    <div style="width:52px;height:52px;background:#F7F8FA;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                        @include('components.icon',['name'=>'inbox','size'=>24,'style'=>'color:#9CA3B0'])
                                    </div>
                                    <p style="font-weight:700;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Materi</p>
                                    <p style="font-size:12.5px;color:#9CA3B0;margin:0;">Silakan tambahkan materi pertama dengan mengklik tombol Tambah Materi.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KANAN: Info Pelatihan --}}
        <div>
            <div class="fcc-card" style="padding:20px;border-radius:16px;position:sticky;top:24px;">
                <p style="font-size:11px;font-weight:800;color:#9CA3B0;text-transform:uppercase;letter-spacing:1px;margin:0 0 12px;border-bottom:1px solid #E2E4EB;padding-bottom:8px;">Informasi Pelatihan</p>
                
                <div style="margin-bottom:14px;">
                    <p style="margin:0 0 3px;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Kategori</p>
                    <p style="margin:0;font-size:13.5px;font-weight:800;color:#FFC81A;">{{ $selectedPelatihan->kategori->nama_kategori ?? 'Tidak ada kategori' }}</p>
                </div>

                <div style="margin-bottom:16px;">
                    <p style="margin:0 0 3px;font-size:11px;font-weight:700;color:#6B7280;text-transform:uppercase;">Kode Pelatihan</p>
                    <p style="margin:0;font-size:13px;font-weight:700;color:#131218;font-family:monospace;background:#F7F8FA;padding:5px 10px;border-radius:6px;display:inline-block;border:1px solid #E2E4EB;">{{ $selectedPelatihan->kode }}</p>
                </div>

                <p style="font-size:11px;font-weight:700;color:#6B7280;margin:0 0 8px;text-transform:uppercase;">Poster Pelatihan</p>
                @if($selectedPelatihan->gambar)
                    <img src="{{ Storage::url($selectedPelatihan->gambar) }}" alt="Poster" style="width:100%;border-radius:10px;object-fit:cover;aspect-ratio:3/4;border:1px solid #E2E4EB;">
                @else
                    <div style="width:100%;aspect-ratio:3/4;background:#F7F8FA;border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#9CA3B0;border:2px dashed #E2E4EB;">
                        @include('components.icon',['name'=>'image','size'=>28,'style'=>'opacity:.4;margin-bottom:8px;'])
                        <span style="font-size:12px;font-weight:700;">Belum ada poster</span>
                    </div>
                @endif
            </div>
        </div>

    </div>
    @endif
</div>

<script>
function toggleDropdownList(show) {
    const list = document.getElementById('dropdown-options-list');
    if (list) list.style.display = show ? 'block' : 'none';
}

function filterDropdownOptions(query) {
    toggleDropdownList(true);
    const q = query.toLowerCase().trim();
    const items = document.querySelectorAll('.dropdown-opt-item');
    let matchCount = 0;
    items.forEach(item => {
        const text = item.getAttribute('data-text').toLowerCase();
        if (text.includes(q)) {
            item.style.display = 'block';
            matchCount++;
        } else {
            item.style.display = 'none';
        }
    });
    const noMatch = document.getElementById('no-options-found');
    if (noMatch) noMatch.style.display = (matchCount === 0) ? 'block' : 'none';
}

function selectProgramItem(id, text) {
    document.getElementById('hidden-pelatihan-id').value = id;
    document.getElementById('pelatihan-search-input').value = text;
    toggleDropdownList(false);
    document.getElementById('select-pelatihan-form').submit();
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const input = document.getElementById('pelatihan-search-input');
    const list = document.getElementById('dropdown-options-list');
    if (input && list && !input.contains(e.target) && !list.contains(e.target)) {
        toggleDropdownList(false);
    }
});
</script>

{{-- MODALS --}}
@if($selectedPelatihan)
    @include('admin.pelatihan.materi.create-modal')
    @include('admin.pelatihan.materi.edit-modal')
@endif
@endsection
