@extends('layouts.admin')

@section('page-title', 'Materi Pelatihan')
@section('page-content')
<div style="padding:24px;max-width:1200px;margin:0 auto;width:100%;">
    
    {{-- Header Section --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Modul Kurikulum</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Materi Pelatihan</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Pilih program pelatihan untuk mengelola modul materi pembelajarannya.</p>
        </div>

        @if($selectedPelatihan)
        <button type="button" onclick="document.getElementById('create-modal').style.display='flex'"
                style="padding:10px 22px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(255,200,26,0.35);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            @include('components.icon',['name'=>'plus','size'=>16]) Tambah Materi Baru
        </button>
        @endif
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div style="background:#ECFDF5;border:1.5px solid #10B981;padding:12px 18px;border-radius:14px;margin-bottom:20px;display:flex;align-items:center;gap:12px;box-shadow:0 4px 12px rgba(16,185,129,0.1);">
        @include('components.icon',['name'=>'check-circle','size'=>18,'style'=>'color:#10B981'])
        <p style="color:#065F46;font-size:13.5px;font-weight:800;margin:0;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- TOP BAR: Searchable Dropdown Pelatihan --}}
    <div class="fcc-card" style="margin-bottom:24px;padding:20px 24px;background:#FFFFFF;border-radius:18px;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);">
        <form id="select-pelatihan-form" method="GET" action="{{ route('admin.materi.index') }}">
            <input type="hidden" name="pelatihan_id" id="hidden-pelatihan-id" value="{{ $selectedPelatihan ? $selectedPelatihan->id : '' }}">
            
            <label style="font-size:11px;font-weight:800;color:#64748B;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.5px;">
                Pilih / Cari Program Pelatihan
            </label>
            
            <div style="position:relative;width:100%;">
                <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#FFC81A;pointer-events:none;z-index:2;display:flex;align-items:center;">
                    @include('components.icon',['name'=>'book-open','size'=>16])
                </div>
                
                <input type="text" id="pelatihan-search-input"
                       placeholder="-- Ketik untuk mencari & memilih pelatihan --"
                       value="{{ $selectedPelatihan ? $selectedPelatihan->kode . ' - ' . $selectedPelatihan->judul : '' }}"
                       autocomplete="off"
                       class="fcc-input"
                       style="padding:10px 40px 10px 40px;font-size:13.5px;font-weight:800;color:#131218;width:100%;height:44px;background:#F8FAFC;border:1.5px solid #E2E4EB;border-radius:12px;cursor:pointer;transition:all .18s;"
                       onfocus="toggleDropdownList(true);this.style.borderColor='#131218';this.style.background='#FFF';"
                       onblur="this.style.borderColor='#E2E4EB';"
                       oninput="filterDropdownOptions(this.value)">
                       
                <div style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#64748B;pointer-events:none;z-index:2;display:flex;align-items:center;">
                    @include('components.icon',['name'=>'chevron-down','size={16}'])
                </div>

                {{-- Dropdown options list popup --}}
                <div id="dropdown-options-list" style="display:none;position:absolute;top:105%;left:0;right:0;background:#FFFFFF;border:1.5px solid #131218;border-radius:14px;box-shadow:0 12px 32px rgba(0,0,0,0.12);max-height:280px;overflow-y:auto;z-index:100;">
                    @foreach($pelatihans as $p)
                    <div class="dropdown-opt-item"
                         data-id="{{ $p->id }}"
                         data-text="{{ $p->kode }} - {{ $p->judul }}"
                         onclick="selectProgramItem('{{ $p->id }}', '{{ addslashes($p->kode . ' - ' . $p->judul) }}')"
                         style="padding:11px 16px;font-size:13px;font-weight:700;color:#131218;cursor:pointer;border-bottom:1px solid #F1F5F9;transition:all .15s;display:flex;align-items:center;gap:10px;"
                         onmouseover="this.style.background='#FFFDF5';this.style.color='#131218';"
                         onmouseout="this.style.background='#FFF';this.style.color='#131218';">
                        <span style="font-weight:900;background:#FFC81A;color:#131218;padding:2px 8px;border-radius:6px;font-family:monospace;font-size:11px;border:1px solid #131218;">{{ $p->kode }}</span>
                        <span>{{ $p->judul }}</span>
                    </div>
                    @endforeach
                    <div id="no-options-found" style="display:none;padding:14px 18px;font-size:12.5px;color:#94A3B8;text-align:center;font-weight:600;">
                        Tidak ada program pelatihan yang cocok dengan pencarian
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if($selectedPelatihan)

    {{-- STAT CARDS SUMMARY GRID --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'book-open','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Modul Materi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $selectedPelatihan->materi->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Modul</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'clock','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Durasi (JP)</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $selectedPelatihan->materi->sum('jam_pelajaran') }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Jam Pelajaran</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;overflow:hidden;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'tag','size'=>20])
            </div>
            <div style="min-width:0;flex:1;">
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Kategori Program</p>
                <p style="margin:2px 0 0;font-size:14px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $selectedPelatihan->kategori->nama_kategori ?? 'Umum' }}">{{ $selectedPelatihan->kategori->nama_kategori ?? 'Umum' }}</p>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">
        
        {{-- KIRI: Tabel Materi --}}
        <div>
            <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                    <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Modul Materi</h3>
                    <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">
                        {{ $selectedPelatihan->materi->count() }} Modul &bull; {{ $selectedPelatihan->materi->sum('jam_pelajaran') }} JP
                    </span>
                </div>

                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="background:#131218;color:#FFFFFF;">
                                <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:55px;">No</th>
                                <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Judul Topik Materi</th>
                                <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:120px;">Durasi (JP)</th>
                                <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($selectedPelatihan->materi as $index => $mat)
                            <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                                <td style="padding:14px 16px;text-align:center;color:#64748B;font-weight:800;font-size:13px;">
                                    <span style="display:inline-flex;width:28px;height:28px;border-radius:8px;background:#F1F5F9;border:1px solid #CBD5E1;align-items:center;justify-content:center;color:#131218;font-weight:900;">{{ $index + 1 }}</span>
                                </td>
                                <td style="padding:14px 16px;font-weight:900;color:#131218;font-size:14px;">
                                    {{ $mat->judul_materi }}
                                </td>
                                <td style="padding:14px 16px;text-align:center;">
                                    <span style="font-weight:900;font-size:11.5px;color:#131218;background:#FFC81A;border:1px solid #131218;padding:3px 10px;border-radius:20px;display:inline-block;">
                                        ⏱️ {{ $mat->jam_pelajaran }} JP
                                    </span>
                                </td>
                                <td style="padding:14px 20px;text-align:center;">
                                    <div style="display:flex;align-items:center;justify-content:center;gap:8px;">
                                        <button type="button" onclick="openEditModal('{{ route('admin.materi-pelatihan.update', [$selectedPelatihan, $mat]) }}', '{{ addslashes($mat->judul_materi) }}', '{{ $mat->jam_pelajaran }}')"
                                                style="padding:5px 12px;font-size:12px;font-weight:800;color:#131218;background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:20px;cursor:pointer;transition:all .18s;display:inline-flex;align-items:center;gap:4px;"
                                                onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#131218';this.style.borderColor='#CBD5E1';">
                                            @include('components.icon',['name'=>'edit','size'=>13]) Edit
                                        </button>
                                        <form action="{{ route('admin.materi-pelatihan.destroy', [$selectedPelatihan, $mat]) }}" method="POST" style="margin:0;" onsubmit="return fccConfirmDelete(event, this, 'Hapus Materi', 'Apakah Anda yakin ingin menghapus materi pelatihan ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="padding:5px 9px;font-size:12px;font-weight:800;color:#EF4444;background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:20px;cursor:pointer;transition:all .18s;display:inline-flex;align-items:center;justify-content:center;" title="Hapus Materi"
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
                                        @include('components.icon',['name'=>'inbox','size'=>24,'style'=>'color:#9CA3B0'])
                                    </div>
                                    <p style="font-weight:900;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Modul Materi</p>
                                    <p style="font-size:12.5px;color:#64748B;margin:0;font-weight:500;">Silakan tambahkan modul materi pertama dengan mengklik tombol Tambah Materi di atas.</p>
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
            <div class="fcc-card" style="padding:20px;border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;box-shadow:0 4px 16px rgba(0,0,0,0.03);position:sticky;top:24px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;border-bottom:1px solid #E2E4EB;padding-bottom:10px;">
                    <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:3px 10px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">{{ $selectedPelatihan->kode }}</span>
                    <p style="font-size:12px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;margin:0;">Informasi Program</p>
                </div>
                
                <h3 style="font-size:15px;font-weight:900;color:#131218;margin:0 0 14px;line-height:1.4;">{{ $selectedPelatihan->judul }}</h3>

                <div style="margin-bottom:14px;">
                    <p style="margin:0 0 4px;font-size:10.5px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Kategori Program</p>
                    <span style="font-size:12px;font-weight:900;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:14px;border:1px solid #131218;display:inline-block;max-width:100%;word-break:break-word;line-height:1.35;">{{ $selectedPelatihan->kategori->nama_kategori ?? 'Tidak ada kategori' }}</span>
                </div>

                <p style="font-size:10.5px;font-weight:800;color:#64748B;margin:0 0 6px;text-transform:uppercase;letter-spacing:0.5px;">Poster Sampul</p>
                @if($selectedPelatihan->gambar_url || $selectedPelatihan->gambar)
                    <img src="{{ $selectedPelatihan->gambar_url ?? asset('storage/'.$selectedPelatihan->gambar) }}" alt="Poster" style="width:100%;border-radius:12px;object-fit:cover;aspect-ratio:3/4;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.08);">
                @else
                    <div style="width:100%;aspect-ratio:3/4;background:#F8FAFC;border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#94A3B8;border:1.5px dashed #CBD5E1;">
                        @include('components.icon',['name'=>'image','size'=>28,'style'=>'opacity:.4;margin-bottom:8px;'])
                        <span style="font-size:12px;font-weight:700;color:#64748B;">Belum Ada Poster</span>
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
            item.style.display = 'flex';
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
