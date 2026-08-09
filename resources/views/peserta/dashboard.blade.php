@extends('layouts.peserta')
@section('title','Dashboard Peserta')
@section('page-title','Dashboard Peserta')
@section('page-content')
<div style="padding:24px 28px;background:#F6F8FB;min-height:100vh;font-family:'Inter',sans-serif;position:relative;">

  {{-- ═══ PESERTA DASHBOARD SKELETON OVERLAY ════════════════════════ --}}
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
    #peserta-dashboard-skeleton-overlay {
      transition: opacity 0.35s ease, visibility 0.35s ease;
    }
  </style>

  <div id="peserta-dashboard-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
    {{-- Banner Skeleton --}}
    <div style="padding:30px 34px;border-radius:22px;background:#131218;margin-bottom:24px;">
      <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:12px;background:#24232C;"></div>
      <div class="fcc-skeleton-box" style="width:320px;height:28px;margin-bottom:8px;background:#24232C;"></div>
      <div class="fcc-skeleton-box" style="width:480px;height:14px;background:#24232C;"></div>
    </div>
    {{-- 3 Stat Cards Skeleton --}}
    <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:18px;margin-bottom:24px;">
      @for($s=0;$s<3;$s++)
      <div style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:16px;">
        <div class="fcc-skeleton-box" style="width:50px;height:50px;border-radius:14px;flex-shrink:0;"></div>
        <div style="flex:1;">
          <div class="fcc-skeleton-box" style="width:60%;height:12px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:40%;height:24px;"></div>
        </div>
      </div>
      @endfor
    </div>
    {{-- Single Column Skeleton --}}
    <div style="display:flex;flex-direction:column;gap:24px;">
      <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:40%;height:20px;margin-bottom:20px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>
  </div>

  <script>
    (function() {
      setTimeout(function() {
        var sk = document.getElementById('peserta-dashboard-skeleton-overlay');
        if (sk) {
          sk.style.opacity = '0';
          sk.style.visibility = 'hidden';
          setTimeout(function() { sk.style.display = 'none'; }, 350);
        }
      }, 450);
    })();
  </script>

  {{-- ═══ HERO WELCOME BANNER (NEO-BRUTALIST) ═════════════════════ --}}
  <div style="background:linear-gradient(135deg, #131218 0%, #1F1D2B 100%);border-radius:22px;padding:30px 34px;margin-bottom:24px;position:relative;overflow:hidden;border:2px solid #FFC81A;box-shadow:0 12px 36px rgba(19,18,24,0.18);">
    <div style="position:absolute;top:-40px;right:-30px;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle, rgba(255,200,26,0.15) 0%, transparent 70%);pointer-events:none;"></div>
    <div style="position:relative;z-index:2;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:20px;">
      <div>
        <div style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,200,26,0.15);border:1px solid #FFC81A;padding:4px 12px;border-radius:20px;margin-bottom:12px;">
          <span style="width:6px;height:6px;border-radius:50%;background:#FFC81A;"></span>
          <span style="font-size:11px;font-weight:900;color:#FFC81A;text-transform:uppercase;letter-spacing:0.8px;">Portal Peserta FCC UMI</span>
        </div>
        <h1 style="color:#FFFFFF;font-size:24px;font-weight:900;margin:0 0 6px;letter-spacing:-0.02em;">
          Selamat Datang Kembali, {{ $peserta->nama }} &#128075;
        </h1>
        <p style="color:#94A3B8;font-size:13px;margin:0;font-weight:500;max-width:560px;">
          Pantau status pendaftaran kegiatan, selesaikan administrasi pembayaran, dan unduh sertifikat digital kompetensi Anda.
        </p>
      </div>
      <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <a href="{{ route('peserta.jelajahi') }}" class="fcc-btn-gold" style="padding:10px 22px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;border-radius:30px;font-weight:900;box-shadow:0 6px 18px rgba(255,200,26,0.35);">
          @include('components.icon',['name'=>'compass','size'=>16]) Jelajahi Kegiatan
        </a>
        <a href="{{ route('peserta.sertifikat') }}" style="padding:10px 20px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;border-radius:30px;font-weight:800;background:#24232C;color:#FFF;border:1.5px solid #363442;transition:all .18s;" onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#363442'">
          @include('components.icon',['name'=>'award','size'=>16,'style'=>'color:#FFC81A']) Sertifikat Saya
        </a>
      </div>
    </div>
  </div>

  {{-- ═══ 3 STAT CARDS SUMMARY GRID ═══════════════════════════════ --}}
  <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:18px;margin-bottom:24px;">
    {{-- Card 1: Terdaftar Aktif --}}
    <div class="fcc-card" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);display:flex;align-items:center;gap:16px;transition:all .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:50px;height:50px;border-radius:14px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;box-shadow:0 6px 14px rgba(16,185,129,0.2);">
        @include('components.icon',['name'=>'check-circle','size'=>22])
      </div>
      <div>
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Terdaftar Aktif</p>
        <p style="margin:2px 0 0;font-size:24px;font-weight:900;color:#131218;letter-spacing:-0.02em;">{{ $stats['terdaftar'] }} <span style="font-size:13px;font-weight:700;color:#94A3B8;">Kegiatan</span></p>
      </div>
    </div>

    {{-- Card 2: Menunggu Verifikasi --}}
    <div class="fcc-card" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);display:flex;align-items:center;gap:16px;transition:all .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:50px;height:50px;border-radius:14px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;box-shadow:0 6px 14px rgba(255,200,26,0.3);">
        @include('components.icon',['name'=>'clock','size'=>22])
      </div>
      <div>
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Menunggu Verifikasi</p>
        <p style="margin:2px 0 0;font-size:24px;font-weight:900;color:#131218;letter-spacing:-0.02em;">{{ $stats['menunggu'] }} <span style="font-size:13px;font-weight:700;color:#94A3B8;">Pendaftaran</span></p>
      </div>
    </div>

    {{-- Card 3: Sertifikat Diterima --}}
    <div class="fcc-card" style="padding:20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.04);display:flex;align-items:center;gap:16px;transition:all .2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:50px;height:50px;border-radius:14px;background:#131218;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#FFC81A;flex-shrink:0;box-shadow:0 6px 14px rgba(19,18,24,0.25);">
        @include('components.icon',['name'=>'award','size'=>22])
      </div>
      <div>
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Sertifikat Diterima</p>
        <p style="margin:2px 0 0;font-size:24px;font-weight:900;color:#131218;letter-spacing:-0.02em;">{{ $stats['sertifikat'] }} <span style="font-size:13px;font-weight:700;color:#94A3B8;">Berkas</span></p>
      </div>
    </div>
  </div>

  {{-- ═══ SINGLE COLUMN CONTENT LAYOUT ══════════════════════════════ --}}
  <div style="display:flex;flex-direction:column;gap:24px;">

    {{-- Table Card: Pendaftaran Terakhir --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
      <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
        <div>
          <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Pendaftaran Terakhir</h3>
          <p style="margin:2px 0 0;font-size:11px;color:#64748B;">Histori pendaftaran kegiatan Anda di FCC UMI</p>
        </div>
        <a href="{{ route('peserta.pendaftaran') }}" style="font-size:12.5px;color:#131218;font-weight:800;text-decoration:none;padding:6px 14px;background:#FFC81A;border-radius:20px;border:1px solid #131218;box-shadow:0 2px 8px rgba(255,200,26,0.3);transition:all .18s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
          Lihat Semua &rarr;
        </a>
      </div>

      <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;text-align:left;">
          <thead>
            <tr style="background:#131218;color:#FFFFFF;">
              <th style="padding:12px 18px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFC81A;">Kegiatan</th>
              <th style="padding:12px 16px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;">Tgl Daftar</th>
              <th style="padding:12px 16px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;">Status</th>
              <th style="padding:12px 18px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:right;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pendaftaranTerbaru as $pd)
            @php
              $stInfo = match($pd->status_pendaftaran) {
                  'terdaftar'           => ['#ECFDF5','#059669','#10B981','Terdaftar'],
                  'menunggu_verifikasi' => ['#FFFDF5','#D97706','#F59E0B','Menunggu Verifikasi'],
                  'ditolak'             => ['#FEF2F2','#DC2626','#EF4444','Ditolak'],
                  default               => ['#F3F4F6','#4B5563','#9CA3B0','Menunggu Bayar'],
              };
            @endphp
            <tr style="border-bottom:1px solid #F1F5F9;transition:background .18s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
              <td style="padding:14px 18px;">
                <div style="display:flex;align-items:center;gap:12px;">
                  <div style="width:38px;height:38px;border-radius:12px;flex-shrink:0;background:{{ $pd->kegiatan->jenis_kegiatan==='pelatihan' ? '#FFFDF5' : '#EEF2FF' }};border:1.5px solid {{ $pd->kegiatan->jenis_kegiatan==='pelatihan' ? '#FFC81A' : '#6366F1' }};display:flex;align-items:center;justify-content:center;">
                    @include('components.icon',['name'=>$pd->kegiatan->jenis_kegiatan==='pelatihan'?'book-open':'award','size'=>18,'style'=>"color:".($pd->kegiatan->jenis_kegiatan==='pelatihan'?'#131218':'#6366F1')])
                  </div>
                  <div>
                    <p style="margin:0;font-size:13.5px;font-weight:800;color:#131218;">{{ Str::limit($pd->kegiatan->judul, 60) }}</p>
                    <p style="margin:2px 0 0;font-size:11px;color:#64748B;font-weight:600;">{{ ucfirst($pd->kegiatan->jenis_kegiatan) }} &bull; {{ $pd->biaya?->nama_jenis ?? 'Gratis' }}</p>
                  </div>
                </div>
              </td>
              <td style="padding:14px 16px;font-size:12.5px;font-weight:700;color:#334155;">
                {{ $pd->tgl_daftar->format('d M Y') }}
              </td>
              <td style="padding:14px 16px;">
                <span style="font-size:10.5px;font-weight:900;padding:4px 10px;border-radius:6px;background:{{ $stInfo[0] }};color:{{ $stInfo[1] }};border:1px solid {{ $stInfo[2] }};text-transform:uppercase;letter-spacing:0.5px;display:inline-flex;align-items:center;gap:4px;">
                  {{ $stInfo[3] }}
                </span>
              </td>
              <td style="padding:14px 18px;text-align:right;">
                <button type="button" onclick="openPendaftaranModal('{{ $pd->hashid }}', '{{ addslashes($pd->kegiatan->judul) }}', '{{ ucfirst($pd->kegiatan->jenis_kegiatan) }}', '{{ addslashes($pd->biaya?->nama_jenis ?? 'Gratis') }}', '{{ $pd->tgl_daftar->format('d F Y - H:i WIB') }}', '{{ $pd->status_pendaftaran }}', '{{ addslashes($stInfo[3]) }}', '{{ $stInfo[0] }}', '{{ $stInfo[1] }}', '{{ $stInfo[2] }}', '{{ $pd->pembayaran ? route('peserta.pembayaran.show', $pd->pembayaran->id) : '' }}', '{{ $pd->pembayaran ? route('peserta.pembayaran.invoice', $pd->pembayaran->id) : '' }}')" style="font-size:12px;font-weight:800;color:#131218;cursor:pointer;padding:5px 12px;background:#F1F5F9;border-radius:8px;border:1px solid #CBD5E1;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.borderColor='#CBD5E1';">
                  Detail &rarr;
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" style="padding:32px;text-align:center;color:#94A3B8;font-size:13.5px;">
                Belum ada pendaftaran kegiatan. <a href="{{ route('peserta.jelajahi') }}" style="color:#131218;font-weight:900;text-decoration:underline;">Jelajahi Katalog Kegiatan &rarr;</a>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- Card 2: Rekomendasi Kegiatan Terbaru --}}
    @if(isset($kegiatan) && $kegiatan->count() > 0)
    <div class="fcc-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
        <div>
          <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Rekomendasi Kegiatan Terbaru</h3>
          <p style="margin:2px 0 0;font-size:11px;color:#64748B;">Program pelatihan &amp; sertifikasi kompetensi terbaru di FCC UMI</p>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:18px;">
        @foreach($kegiatan as $k)
        <div style="padding:18px;border-radius:14px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;flex-direction:column;justify-content:space-between;">
          <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
              <span style="font-size:10px;font-weight:900;padding:2px 8px;border-radius:12px;background:{{ $k->jenis_kegiatan==='pelatihan'?'#FFC81A':'#3B82F6' }};color:{{ $k->jenis_kegiatan==='pelatihan'?'#131218':'#FFF' }};border:1px solid #131218;text-transform:uppercase;">
                {{ $k->jenis_kegiatan }}
              </span>
              @php $minNominal = $k->biaya->min('nominal') ?? 0; @endphp
              <span style="font-size:11.5px;font-weight:800;color:#64748B;">
                {{ $minNominal > 0 ? 'Rp '.number_format($minNominal,0,',','.') : 'Gratis' }}
              </span>
            </div>
            <h4 style="margin:0 0 6px;font-size:14px;font-weight:900;color:#131218;line-height:1.3;">{{ Str::limit($k->judul, 50) }}</h4>
          </div>
          <div style="margin-top:14px;padding-top:10px;border-top:1px solid #E2E8F0;display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:11px;color:#64748B;font-weight:600;">Kuota: {{ $k->terisi }}/{{ $k->jadwal?->kuota_peserta ?? '-' }}</span>
            <a href="{{ route('landing.show', $k) }}" style="font-size:11.5px;font-weight:900;color:#131218;text-decoration:none;padding:5px 12px;background:#FFC81A;border-radius:6px;border:1px solid #131218;">
              Daftar &rarr;
            </a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

  </div>

  {{-- ═══ POPUP MODAL DETAIL PENDAFTARAN ══════════════════════════ --}}
  <div id="pendaftaran-detail-modal" onclick="if(event.target===this)closePendaftaranModal()" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.6);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:20px;box-sizing:border-box;">
    <div style="background:#FFFFFF;border-radius:24px;border:2px solid #E5E7EB;max-width:560px;width:100%;box-shadow:0 24px 60px rgba(0,0,0,0.25);overflow:hidden;position:relative;animation:modalPop 0.25s ease-out;">
      {{-- Modal Header --}}
      <div style="background:#131218;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;">
        <div style="display:flex;align-items:center;gap:10px;">
          <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;text-transform:uppercase;letter-spacing:0.5px;">Rincian Pendaftaran</span>
        </div>
        <button type="button" onclick="closePendaftaranModal()" style="background:rgba(255,255,255,0.1);border:none;color:#FFFFFF;width:32px;height:32px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:900;transition:all .18s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">&times;</button>
      </div>

      {{-- Modal Body --}}
      <div style="padding:26px 28px;">
        <h2 id="modal-judul" style="font-size:18px;font-weight:900;color:#131218;margin:0 0 20px;line-height:1.35;"></h2>

        <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:20px;">
          <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
            <span style="color:#64748B;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Jenis Kegiatan</span>
            <span id="modal-jenis" style="color:#131218;font-size:13px;font-weight:800;"></span>
          </div>
          <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
            <span style="color:#64748B;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Paket Biaya</span>
            <span id="modal-biaya" style="color:#131218;font-size:13px;font-weight:800;"></span>
          </div>
          <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:12px;">
            <span style="color:#64748B;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">Tanggal Daftar</span>
            <span id="modal-tgl" style="color:#131218;font-size:13px;font-weight:800;"></span>
          </div>
        </div>

        {{-- Status Box --}}
        <div id="modal-status-box" style="border-radius:12px;padding:14px;text-align:center;margin-bottom:20px;">
          <p id="modal-status-text" style="font-size:14px;font-weight:900;margin:0;letter-spacing:0.3px;"></p>
        </div>

        {{-- Action Buttons --}}
        <div id="modal-action-box" style="display:flex;flex-direction:column;gap:10px;"></div>
      </div>
    </div>
  </div>

  <style>
    @keyframes modalPop {
      0% { opacity: 0; transform: scale(0.92) translateY(12px); }
      100% { opacity: 1; transform: scale(1) translateY(0); }
    }
  </style>

  <script>
    function openPendaftaranModal(hashid, judul, jenis, biaya, tgl, status, statusText, statusBg, statusColor, statusBorder, bayarUrl, invoiceUrl) {
      document.getElementById('modal-judul').innerText = judul;
      document.getElementById('modal-jenis').innerText = jenis;
      document.getElementById('modal-biaya').innerText = biaya;
      document.getElementById('modal-tgl').innerText = tgl;

      var statusBox = document.getElementById('modal-status-box');
      statusBox.style.background = statusBg;
      statusBox.style.border = '1.5px solid ' + statusBorder;
      var statusTextEl = document.getElementById('modal-status-text');
      statusTextEl.style.color = statusColor;
      statusTextEl.innerText = 'STATUS: ' + statusText.toUpperCase();

      var actionBox = document.getElementById('modal-action-box');
      actionBox.innerHTML = '';
      if (bayarUrl) {
        actionBox.innerHTML += '<a href="' + bayarUrl + '" class="fcc-btn-gold" style="display:flex;text-align:center;text-decoration:none;padding:12px;justify-content:center;font-size:13.5px;align-items:center;gap:8px;border-radius:12px;font-weight:900;box-shadow:0 4px 12px rgba(255,200,26,0.3);">Lihat Detail Pembayaran</a>';
      }
      if (invoiceUrl) {
        actionBox.innerHTML += '<a href="' + invoiceUrl + '" target="_blank" style="display:flex;text-align:center;text-decoration:none;padding:11px;justify-content:center;font-size:13px;align-items:center;gap:8px;border-radius:12px;font-weight:800;background:#131218;color:#FFF;border:1.5px solid #131218;">Unduh Invoice Resmi (PDF)</a>';
      }

      var modal = document.getElementById('pendaftaran-detail-modal');
      modal.style.display = 'flex';
    }

    function closePendaftaranModal() {
      var modal = document.getElementById('pendaftaran-detail-modal');
      modal.style.display = 'none';
    }
  </script>
</div>
@endsection

