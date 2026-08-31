@extends('layouts.peserta')
@section('title','Jelajahi Kegiatan')
@section('page-title','Jelajahi Kegiatan')
@section('page-content')
<style>
.fcc-jelajahi-wrap {
    padding: 24px 28px;
    background: #F6F8FB;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    position: relative;
    box-sizing: border-box;
}
.fcc-jelajahi-table-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.fcc-jelajahi-table {
    width: 100%;
    min-width: 600px;
    border-collapse: collapse;
    text-align: left;
}

/* ── Mobile Card View ── */
@media (max-width: 639px) {
    .fcc-jelajahi-wrap {
        padding: 14px 12px 32px;
    }
    .fcc-jelajahi-search-form {
        flex-direction: column !important;
        gap: 10px !important;
    }
    .fcc-jelajahi-search-form > div:first-child {
        min-width: 0 !important;
    }
    .fcc-jenis-filter {
        width: 100%;
        justify-content: space-between !important;
    }
    .fcc-jenis-filter button {
        flex: 1;
        text-align: center;
    }
    /* Hide desktop table, show card list */
    .fcc-jelajahi-table-wrap { display: none !important; }
    .fcc-mobile-card-list  { display: flex !important; }
}
.fcc-mobile-card-list {
    display: none;
    flex-direction: column;
    gap: 12px;
}
.fcc-mobile-card {
    background: #FFF;
    border: 1.5px solid #E5E7EB;
    border-radius: 16px;
    padding: 14px 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: box-shadow .18s;
}
.fcc-mobile-card:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.08); }
.fcc-mobile-card-top {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 12px;
}
.fcc-mobile-card-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.fcc-mobile-card-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    flex-wrap: wrap;
}
.fcc-mobile-card-footer {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 8px;
    align-items: center;
    padding-top: 10px;
    border-top: 1px solid #F1F5F9;
}
</style>

<div class="fcc-jelajahi-wrap">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
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
      #jelajahi-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="jelajahi-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:280px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
      </div>
      <div style="padding:14px 18px;margin-bottom:22px;border-radius:16px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;gap:12px;align-items:center;">
        <div class="fcc-skeleton-box" style="flex:1;height:38px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:200px;height:38px;border-radius:10px;"></div>
      </div>
      <div style="padding:28px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('jelajahi-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;flex-wrap:wrap;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Katalog &amp; Pendaftaran</span>
                <h1 style="font-size:clamp(18px,4vw,22px);font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Jelajahi Kegiatan</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Daftarkan diri Anda pada program pelatihan dan sertifikasi kompetensi terbaru dari FCC UMI.</p>
        </div>
    </div>

    {{-- Search + Filter Card --}}
    <div class="fcc-card" style="padding:12px 14px;margin-bottom:18px;border-radius:16px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);">
        <form method="GET" action="{{ route('peserta.jelajahi') }}" class="fcc-jelajahi-search-form" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
            <div style="flex:1;min-width:180px;position:relative;">
                <svg style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#64748B;pointer-events:none;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul kegiatan..." class="fcc-input" style="padding-left:40px;height:40px;font-size:13px;border:1.5px solid #CBD5E1;border-radius:10px;background:#FFF;width:100%;box-sizing:border-box;"
                       onkeydown="if(event.key==='Enter')this.form.submit()">
            </div>
            <div class="fcc-jenis-filter" style="display:inline-flex;gap:4px;background:#F8FAFC;padding:4px;border-radius:12px;border:1.5px solid #E2E8F0;">
                @foreach([['semua','Semua'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
                <button type="submit" name="jenis" value="{{ $v }}"
                    style="padding:7px 13px;border-radius:9px;border:{{ (request('jenis')===$v || (!request('jenis')&&$v==='semua')) ? '1px solid #131218' : 'none' }};font-size:12px;font-weight:900;cursor:pointer;transition:all .18s;white-space:nowrap;
                           background:{{ (request('jenis')===$v || (!request('jenis')&&$v==='semua')) ? '#FFC81A' : 'transparent' }};
                           color:{{ (request('jenis')===$v || (!request('jenis')&&$v==='semua')) ? '#131218' : '#64748B' }};">
                    {{ $l }}
                </button>
                @endforeach
            </div>
        </form>
    </div>

    {{-- ══ DESKTOP TABLE ══ --}}
    <div class="fcc-card fcc-jelajahi-table-wrap" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div style="overflow-x:auto;">
            <table class="fcc-jelajahi-table">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFC81A;">Kegiatan</th>
                        <th style="padding:14px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:center;">Jenis</th>
                        <th style="padding:14px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;">Jadwal Pelaksanaan</th>
                        <th style="padding:14px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:center;">Kuota</th>
                        <th style="padding:14px 20px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:center;width:150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan as $k)
                    @php $sudah=$sudah??[]; $sudahD=in_array($k->id,$sudahDaftar??[]); $isPel=$k->jenis_kegiatan==='pelatihan'; @endphp
                    <tr style="border-bottom:1px solid #F1F5F9;transition:background .18s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                        <td style="padding:16px 20px;">
                            <div style="display:flex;align-items:center;gap:14px;">
                                <div style="width:44px;height:44px;border-radius:12px;background:{{ $isPel?'#FFFDF5':'#EEF2FF' }};border:1.5px solid {{ $isPel?'#FFC81A':'#6366F1' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>20,'style'=>"color:".($isPel?'#131218':'#6366F1')])
                                </div>
                                <div>
                                    <p style="font-size:14px;font-weight:900;color:#131218;margin:0 0 3px;line-height:1.35;">{{ $k->judul }}</p>
                                    <p style="font-size:11.5px;color:#64748B;margin:0;font-weight:600;">
                                        Biaya: <span style="color:{{ $k->biaya->isNotEmpty() ? '#059669' : '#64748B' }};font-weight:800;">{{ $k->biaya->isNotEmpty() ? ('Rp '.number_format($k->biaya->min('nominal'),0,',','.')) : 'Gratis' }}</span>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
                            <span style="font-size:10.5px;font-weight:900;padding:4px 10px;border-radius:6px;background:{{ $isPel?'#FFC81A':'#3B82F6' }};color:{{ $isPel?'#131218':'#FFFFFF' }};border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">
                                {{ ucfirst($k->jenis_kegiatan) }}
                            </span>
                        </td>
                        <td style="padding:16px 14px;vertical-align:middle;font-size:13px;color:#334155;font-weight:700;">
                            <div style="display:flex;align-items:center;gap:6px;">
                                @include('components.icon',['name'=>'calendar','size'=>15,'style'=>'color:#64748B'])
                                {{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul' }}
                            </div>
                        </td>
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;font-size:13px;color:#131218;font-weight:800;">
                            <span style="background:#F1F5F9;border:1px solid #CBD5E1;padding:4px 12px;border-radius:20px;font-size:12px;">
                                {{ $k->terisi }} / {{ $k->kuota }}
                            </span>
                        </td>
                        <td style="padding:16px 20px;text-align:center;vertical-align:middle;">
                            @if($k->isDraf())
                            <button disabled style="width:100%;padding:8px 14px;border-radius:10px;border:1.5px solid #CBD5E1;background:#F1F5F9;color:#94A3B8;font-size:12.5px;font-weight:800;cursor:not-allowed;">Draft / Belum Dibuka</button>
                            @elseif($k->isComingSoon())
                            <button disabled style="width:100%;padding:8px 14px;border-radius:10px;border:1.5px solid #FCD34D;background:#FEF3C7;color:#D97706;font-size:12.5px;font-weight:800;cursor:not-allowed;">Segera Hadir</button>
                            @elseif($sudahD)
                            <a href="{{ route('peserta.pendaftaran') }}" style="display:inline-flex;align-items:center;justify-content:center;padding:8px 14px;border-radius:10px;border:1.5px solid #10B981;background:#ECFDF5;color:#059669;font-size:12.5px;font-weight:900;text-decoration:none;">&#10003; Terdaftar</a>
                            @elseif($k->isRegistrationClosed())
                            <button disabled style="width:100%;padding:8px 14px;border-radius:10px;border:1.5px solid #CBD5E1;background:#F1F5F9;color:#94A3B8;font-size:12.5px;font-weight:800;cursor:not-allowed;">Tutup</button>
                            @elseif($k->isFull())
                            <button disabled style="width:100%;padding:8px 14px;border-radius:10px;border:1.5px solid #CBD5E1;background:#F1F5F9;color:#94A3B8;font-size:12.5px;font-weight:800;cursor:not-allowed;">Kuota Penuh</button>
                            @else
                            <button onclick="showDaftarModal('{{ $k->hashid }}', '{{ addslashes($k->judul) }}', {{ $k->biaya->toJson() }})"
                                class="fcc-btn-gold" style="width:100%;justify-content:center;padding:8px 14px;font-size:12.5px;font-weight:900;border-radius:10px;">Daftar &rarr;</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#94A3B8;font-size:14px;font-weight:600;">Tidak ada kegiatan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ══ MOBILE CARD LIST ══ --}}
    <div class="fcc-mobile-card-list">
        @forelse($kegiatan as $k)
        @php $sudahD=in_array($k->id,$sudahDaftar??[]); $isPel=$k->jenis_kegiatan==='pelatihan'; @endphp
        <div class="fcc-mobile-card">
            <div class="fcc-mobile-card-top">
                <div class="fcc-mobile-card-icon" style="background:{{ $isPel?'#FFFDF5':'#EEF2FF' }};border:1.5px solid {{ $isPel?'#FFC81A':'#6366F1' }};">
                    @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>20,'style'=>"color:".($isPel?'#131218':'#6366F1')])
                </div>
                <div style="flex:1;min-width:0;">
                    <p style="font-size:13.5px;font-weight:900;color:#131218;margin:0 0 4px;line-height:1.3;">{{ $k->judul }}</p>
                    <div class="fcc-mobile-card-meta">
                        <span style="font-size:10px;font-weight:900;padding:2px 8px;border-radius:6px;background:{{ $isPel?'#FFC81A':'#3B82F6' }};color:{{ $isPel?'#131218':'#FFF' }};border:1px solid #131218;text-transform:uppercase;">{{ ucfirst($k->jenis_kegiatan) }}</span>
                        <span style="font-size:11px;color:#059669;font-weight:800;">{{ $k->biaya->isNotEmpty() ? ('Rp '.number_format($k->biaya->min('nominal'),0,',','.')) : 'Gratis' }}</span>
                    </div>
                </div>
            </div>
            <div class="fcc-mobile-card-footer">
                <div style="display:flex;flex-direction:column;gap:4px;">
                    <div style="display:flex;align-items:center;gap:5px;font-size:12px;color:#334155;font-weight:700;">
                        @include('components.icon',['name'=>'calendar','size'=>13,'style'=>'color:#64748B'])
                        {{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul' }}
                    </div>
                    <div style="font-size:11.5px;color:#64748B;font-weight:600;">Kuota: <strong style="color:#131218;">{{ $k->terisi }}/{{ $k->kuota }}</strong></div>
                </div>
                <div>
                    @if($k->isDraf())
                    <button disabled style="padding:7px 14px;border-radius:10px;border:1.5px solid #CBD5E1;background:#F1F5F9;color:#94A3B8;font-size:12px;font-weight:800;cursor:not-allowed;white-space:nowrap;">Belum Dibuka</button>
                    @elseif($k->isComingSoon())
                    <button disabled style="padding:7px 14px;border-radius:10px;border:1.5px solid #FCD34D;background:#FEF3C7;color:#D97706;font-size:12px;font-weight:800;cursor:not-allowed;white-space:nowrap;">Segera Hadir</button>
                    @elseif($sudahD)
                    <a href="{{ route('peserta.pendaftaran') }}" style="display:inline-flex;align-items:center;justify-content:center;padding:7px 14px;border-radius:10px;border:1.5px solid #10B981;background:#ECFDF5;color:#059669;font-size:12px;font-weight:900;text-decoration:none;white-space:nowrap;">&#10003; Terdaftar</a>
                    @elseif($k->isRegistrationClosed())
                    <button disabled style="padding:7px 14px;border-radius:10px;border:1.5px solid #CBD5E1;background:#F1F5F9;color:#94A3B8;font-size:12px;font-weight:800;cursor:not-allowed;white-space:nowrap;">Tutup</button>
                    @elseif($k->isFull())
                    <button disabled style="padding:7px 14px;border-radius:10px;border:1.5px solid #CBD5E1;background:#F1F5F9;color:#94A3B8;font-size:12px;font-weight:800;cursor:not-allowed;white-space:nowrap;">Kuota Penuh</button>
                    @else
                    <button onclick="showDaftarModal('{{ $k->hashid }}', '{{ addslashes($k->judul) }}', {{ $k->biaya->toJson() }})"
                        class="fcc-btn-gold" style="justify-content:center;padding:7px 16px;font-size:12px;font-weight:900;border-radius:10px;white-space:nowrap;">Daftar &rarr;</button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="padding:40px;text-align:center;color:#94A3B8;font-size:14px;font-weight:600;background:#FFF;border-radius:16px;border:1.5px solid #E5E7EB;">Tidak ada kegiatan ditemukan.</div>
        @endforelse
    </div>

    @if($kegiatan->hasPages())
    <div style="margin-top:24px;">{{ $kegiatan->withQueryString()->links() }}</div>
    @endif
</div>


{{-- Modal Daftar --}}
<div id="daftar-modal" style="display:none;position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);display:none;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#FFF;border-radius:18px;max-width:420px;width:100%;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.2);">
        <div style="background:linear-gradient(135deg,#131218,#1A1920);padding:22px 24px;display:flex;justify-content:space-between;align-items:center;">
            <div>
                <p style="margin:0;color:#FFF;font-weight:800;font-size:16px;">Konfirmasi Pendaftaran</p>
                <p style="margin:4px 0 0;color:rgba(255,255,255,.5);font-size:12px;" id="modal-judul"></p>
            </div>
            <button onclick="closeDaftarModal()" style="background:rgba(255,255,255,.1);border:none;border-radius:8px;color:rgba(255,255,255,.7);padding:6px 8px;cursor:pointer;display:flex;">
                @include('components.icon',['name'=>'x','size'=>16])
            </button>
        </div>
        <form id="daftar-form" method="POST" style="padding:22px 24px;">
            @csrf
            <div id="biaya-section"></div>
            <button type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:15px;">
                @include('components.icon',['name'=>'check','size'=>16]) Konfirmasi Pendaftaran
            </button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
@vite('resources/js/pages/landing-jelajahi.js')
@endpush
