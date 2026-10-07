@extends('layouts.admin')
@section('title','Arsip Kegiatan')
@section('page-title','Arsip Kegiatan')

@section('page-content')
<style>
  @keyframes skeletonShimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
  }
  .fcc-skeleton-box {
    background: linear-gradient(90deg, #E2E8F0 25%, #F1F5F9 50%, #E2E8F0 75%);
    background-size: 200% 100%;
    animation: skeletonShimmer 1.4s infinite ease-in-out;
    border-radius: 12px;
  }
  #arsip-skeleton-overlay {
    transition: opacity 0.35s ease, visibility 0.35s ease;
  }

  .fcc-arsip-container {
    padding: 24px;
    box-sizing: border-box;
    width: 100%;
    position: relative;
  }
  .fcc-arsip-header-title {
    font-size: 22px;
    font-weight: 900;
    color: #131218;
    margin: 0;
    letter-spacing: -0.02em;
    line-height: 1.25;
  }
  .fcc-arsip-badge {
    background: #FFC81A;
    color: #131218;
    font-size: 11px;
    font-weight: 900;
    padding: 3px 10px;
    border-radius: 20px;
    border: 1px solid #131218;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    width: fit-content;
  }
  .fcc-arsip-header-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
  }
  .fcc-arsip-subtitle {
    color: #64748B;
    font-size: 13px;
    margin: 0;
    font-weight: 500;
  }
  .fcc-text-desktop {
    display: inline;
  }
  .fcc-text-mobile {
    display: none;
  }
  .fcc-arsip-desktop-table {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  .fcc-arsip-mobile-list {
    display: none;
  }
  .fcc-arsip-col-nowrap {
    white-space: nowrap !important;
  }

  /* ═══ TABLET (768px – 1023px) ═══ */
  @media (min-width: 768px) and (max-width: 1023px) {
    .fcc-arsip-container {
      padding: 18px 16px !important;
    }
    .fcc-arsip-col-nowrap {
      white-space: nowrap !important;
    }
  }

  /* ═══ SMALL TABLET / PHABLET (640px – 767px) ═══ */
  @media (min-width: 640px) and (max-width: 767px) {
    .fcc-arsip-container {
      padding: 16px 14px !important;
    }
    .fcc-arsip-col-nowrap {
      white-space: nowrap !important;
    }
  }

  /* ═══ MOBILE (< 640px) ═══ */
  @media (max-width: 639px) {
    .fcc-arsip-container {
      padding: 14px 10px !important;
    }
    .fcc-text-desktop {
      display: none !important;
    }
    .fcc-text-mobile {
      display: inline !important;
    }
    .fcc-arsip-header-row {
      flex-direction: column !important;
      align-items: flex-start !important;
      gap: 6px !important;
      margin-bottom: 6px !important;
    }
    .fcc-arsip-header-title {
      font-size: 20px !important;
    }
    .fcc-arsip-subtitle {
      font-size: 12px !important;
      line-height: 1.4 !important;
    }
    .fcc-arsip-desktop-table {
      display: none !important;
    }
    .fcc-arsip-mobile-list {
      display: block !important;
    }
    .fcc-arsip-pagination-bar {
      flex-direction: column !important;
      align-items: stretch !important;
      gap: 12px !important;
    }
    .fcc-arsip-pagination-bar > div {
      justify-content: center !important;
      width: 100% !important;
      display: flex !important;
    }
  }

  /* ═══ COMPACT MOBILE (< 420px) ═══ */
  @media (max-width: 419px) {
    .fcc-arsip-container {
      padding: 12px 8px !important;
    }
    .fcc-arsip-header-title {
      font-size: 18px !important;
    }
    .fcc-arsip-mobile-actions {
      flex-wrap: wrap !important;
    }
    .fcc-arsip-mobile-actions > * {
      flex: 1 1 auto !important;
      justify-content: center !important;
      text-align: center !important;
    }
  }
</style>

<div class="fcc-arsip-container">

    {{-- === SKELETON LOADING OVERLAY === --}}
    <div id="arsip-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:100%;max-width:320px;">
          <div class="fcc-skeleton-box" style="width:110px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:200px;height:12px;"></div>
        </div>
      </div>
      {{-- Table Skeleton --}}
      <div style="padding:28px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('arsip-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(16,185,129,0.12);border:1.5px solid rgba(16,185,129,0.3);color:#059669;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#059669;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div style="padding:12px 18px;border-radius:12px;background:rgba(239,68,68,0.12);border:1.5px solid rgba(239,68,68,0.3);color:#DC2626;font-weight:800;font-size:13px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;">
        <span>{{ session('error') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#DC2626;cursor:pointer;font-size:18px;font-weight:900;">&times;</button>
    </div>
    @endif

    {{-- Header & Title --}}
    <div style="margin-bottom:24px;">
        <div class="fcc-arsip-header-row">
            <span class="fcc-arsip-badge">
                <span class="fcc-text-desktop">Dokumentasi &amp; Galeri</span>
                <span class="fcc-text-mobile">Dokumentasi</span>
            </span>
            <h1 class="fcc-arsip-header-title">
                <span class="fcc-text-desktop">Arsip &amp; Dokumentasi Kegiatan</span>
                <span class="fcc-text-mobile">Arsip Kegiatan</span>
            </h1>
        </div>
        <p class="fcc-arsip-subtitle">Kelola berita acara dan galeri foto dokumentasi pelaksanaan kegiatan yang telah selesai.</p>
    </div>

    {{-- Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);">
        {{-- Desktop & Tablet Table (≥ 640px) --}}
        <div class="fcc-arsip-desktop-table">
            <table class="admin-table" style="width:100%;min-width:860px;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th class="fcc-arsip-col-nowrap" style="padding:16px 20px;text-align:left;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;min-width:240px;">Judul Arsip</th>
                        <th class="fcc-arsip-col-nowrap" style="padding:16px 14px;text-align:left;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;min-width:220px;">Kegiatan</th>
                        <th style="padding:16px 14px;text-align:center;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;width:140px;min-width:140px;white-space:nowrap;">Dokumentasi Foto</th>
                        <th style="padding:16px 14px;text-align:center;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;width:130px;min-width:130px;white-space:nowrap;">Berita Acara</th>
                        <th style="padding:16px 20px;text-align:center;font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;width:150px;min-width:150px;white-space:nowrap;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $a)
                    @php $fotoCount = count($a->dokumentasi ?? []); @endphp
                    <tr class="tbl-row" style="border-top:1px solid #F1F5F9;">
                        
                        {{-- Judul Arsip --}}
                        <td style="padding:16px 20px;vertical-align:middle;">
                            <p style="margin:0 0 3px;font-size:14px;font-weight:900;color:#131218;">{{ $a->judul ?? '-' }}</p>
                            <span style="font-size:11px;color:#64748B;font-weight:600;">Dibuat: {{ $a->created_at->format('d M Y') }}</span>
                        </td>

                        {{-- Kegiatan --}}
                        <td style="padding:16px 14px;vertical-align:middle;font-size:13px;color:#334155;font-weight:700;">
                            {{ Str::limit($a->kegiatan->judul ?? '-', 45) }}
                        </td>

                        {{-- Dokumentasi Foto --}}
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
                            @if($fotoCount > 0)
                            <span style="font-size:11.5px;font-weight:800;padding:5px 12px;border-radius:20px;background:#EEF2FF;color:#4F46E5;border:1px solid #C7D2FE;display:inline-flex;align-items:center;gap:6px;">
                                @include('components.icon',['name'=>'camera','size'=>13]) {{ $fotoCount }} Foto
                            </span>
                            @else
                            <span style="font-size:11.5px;color:#94A3B8;font-weight:600;">Belum ada foto</span>
                            @endif
                        </td>

                        {{-- Berita Acara PDF --}}
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
                            @if($a->berita_acara)
                            <a href="{{ asset('storage/'.$a->berita_acara) }}" target="_blank" style="padding:5px 12px;font-size:11.5px;font-weight:800;text-decoration:none;border-radius:20px;background:#FFFFFF;color:#131218;border:1.5px solid #131218;display:inline-flex;align-items:center;gap:4px;transition:all .18s;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">
                                @include('components.icon',['name'=>'file-text','size'=>12]) Lihat PDF
                            </a>
                            @else
                            <span style="font-size:11.5px;color:#94A3B8;font-weight:600;">-</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:16px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;gap:8px;align-items:center;justify-content:center;">
                                <a href="{{ route('admin.arsip.edit', $a) }}"
                                   style="padding:7px 14px;font-size:12px;font-weight:800;text-decoration:none;border-radius:10px;background:#FFFFFF;color:#131218;border:1.5px solid #131218;display:inline-flex;align-items:center;gap:5px;transition:all .18s;"
                                   onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';" title="Edit Arsip & Dokumentasi">
                                    @include('components.icon',['name'=>'edit','size'=>13]) Edit
                                </a>
                                <form action="{{ route('admin.arsip.destroy', $a) }}" method="POST" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="fccConfirmDelete(this, 'Hapus Arsip Kegiatan Permanen', 'Apakah Anda yakin ingin menghapus arsip kegiatan {{ addslashes($a->judul ?? '') }}? Seluruh data arsip, berita acara, dokumentasi foto, dan riwayat pendaftaran terkait akan dihapus secara permanen.')"
                                            style="background:#FEF2F2;border:1px solid #FCA5A5;color:#EF4444;padding:7px 12px;border-radius:10px;font-size:12px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:4px;transition:all .18s;" title="Hapus Arsip Kegiatan Permanen"
                                            onmouseover="this.style.background='#EF4444';this.style.color='#FFFFFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';">
                                        @include('components.icon',['name'=>'trash','size'=>13]) Hapus
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:56px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F8FAFC;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'archive','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Arsip Kegiatan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Arsip kegiatan akan secara otomatis dibuat dari kegiatan yang telah selesai dilaksanakan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Mobile Cards List View (< 640px) --}}
        <div class="fcc-arsip-mobile-list">
            @forelse($arsip as $a)
            @php $fotoCount = count($a->dokumentasi ?? []); @endphp
            <div style="padding:16px;border-top:1px solid #F1F5F9;background:#FFFFFF;">
                {{-- Badges row: Tanggal & Foto --}}
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:8px;flex-wrap:wrap;">
                    <span style="font-size:11px;color:#64748B;font-weight:700;display:inline-flex;align-items:center;gap:4px;">
                        @include('components.icon',['name'=>'calendar','size'=>12,'style'=>'color:#94A3B8'])
                        Dibuat: {{ $a->created_at->format('d M Y') }}
                    </span>
                    <div>
                        @if($fotoCount > 0)
                        <span style="font-size:11px;font-weight:800;padding:3px 10px;border-radius:20px;background:#EEF2FF;color:#4F46E5;border:1px solid #C7D2FE;display:inline-flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'camera','size'=>12]) {{ $fotoCount }} Foto
                        </span>
                        @else
                        <span style="font-size:10.5px;color:#94A3B8;font-weight:600;">Belum ada foto</span>
                        @endif
                    </div>
                </div>

                {{-- Judul Arsip --}}
                <h4 style="font-size:14.5px;font-weight:900;color:#131218;margin:0 0 4px;line-height:1.35;word-break:break-word;">
                    {{ $a->judul ?? '-' }}
                </h4>

                {{-- Nama Kegiatan Asal --}}
                <p style="font-size:12px;color:#475569;font-weight:600;margin:0 0 12px;display:flex;align-items:center;gap:5px;word-break:break-word;">
                    @include('components.icon',['name'=>'layers','size'=>13,'style'=>'color:#94A3B8;flex-shrink:0'])
                    <span>{{ $a->kegiatan->judul ?? '-' }}</span>
                </p>

                {{-- Actions & PDF --}}
                <div class="fcc-arsip-mobile-actions" style="display:flex;align-items:center;justify-content:flex-end;gap:8px;padding-top:8px;border-top:1px dashed #E2E8F0;">
                    @if($a->berita_acara)
                    <a href="{{ asset('storage/'.$a->berita_acara) }}" target="_blank"
                       style="padding:6px 14px;font-size:12px;font-weight:800;text-decoration:none;border-radius:18px;background:#FFFFFF;color:#131218;border:1.5px solid #131218;display:inline-flex;align-items:center;gap:5px;">
                        @include('components.icon',['name'=>'file-text','size'=>13])
                        <span>PDF</span>
                    </a>
                    @endif
                    <a href="{{ route('admin.arsip.edit', $a) }}"
                       style="padding:6px 14px;font-size:12px;font-weight:800;text-decoration:none;border-radius:18px;background:#FFC81A;color:#131218;border:1.5px solid #131218;display:inline-flex;align-items:center;gap:5px;">
                        @include('components.icon',['name'=>'edit','size'=>13])
                        <span>Edit</span>
                    </a>
                    <form action="{{ route('admin.arsip.destroy', $a) }}" method="POST" style="margin:0;display:inline-flex;">
                        @csrf @method('DELETE')
                        <button type="button" onclick="fccConfirmDelete(this, 'Hapus Arsip Kegiatan Permanen', 'Apakah Anda yakin ingin menghapus arsip kegiatan {{ addslashes($a->judul ?? '') }}? Seluruh data arsip, berita acara, dokumentasi foto, dan riwayat pendaftaran terkait akan dihapus secara permanen.')"
                                style="padding:6px 14px;font-size:12px;font-weight:800;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:18px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'trash','size'=>13])
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div style="padding:40px 20px;text-align:center;color:#94A3B8;">
                <div style="width:52px;height:52px;border-radius:16px;background:#F8FAFC;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                    @include('components.icon',['name'=>'archive','size'=>24,'style'=>'color:#9CA3B0'])
                </div>
                <p style="font-size:14.5px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Arsip Kegiatan</p>
                <p style="font-size:12.5px;color:#64748B;margin:0;">Arsip kegiatan akan secara otomatis dibuat dari kegiatan yang telah selesai dilaksanakan.</p>
            </div>
            @endforelse
        </div>

        <div class="fcc-arsip-pagination-bar" style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:10px;">
                <form method="GET" action="{{ url()->current() }}" style="margin:0;"><select name="per_page" onchange="this.form.submit()" class="fcc-input" style="width:auto;font-size:12.5px;height:34px;padding:0 10px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:8px;font-weight:700;cursor:pointer;color:#131218;outline:none;" title="Jumlah data per halaman">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / hal</option>
                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 / hal</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 / hal</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / hal</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / hal</option>
                </select>
                </form>
                <span style="font-size:12px;color:#64748B;font-weight:600;">
                    Menampilkan {{ $arsip->firstItem() ?? 0 }} &ndash; {{ $arsip->lastItem() ?? 0 }} dari {{ $arsip->total() }} data
                </span>
            </div>
            <div>
                {{ $arsip->withQueryString()->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>

</div>
@endsection

