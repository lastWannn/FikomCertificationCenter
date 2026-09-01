@extends('layouts.peserta')
@section('title','Pendaftaran Saya')
@section('page-title','Pendaftaran Saya')
@section('page-content')
<div class="fcc-pendaftaran-page-wrap" style="padding:24px 28px;background:#F6F8FB;min-height:100vh;font-family:'Inter',sans-serif;position:relative;">

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
      #pendaftaran-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }

      .fcc-mobile-pendaftaran-card-list {
        display: none;
      }
      .fcc-desktop-pendaftaran-table {
        display: block;
      }

      @media (max-width: 640px) {
        .fcc-pendaftaran-page-wrap {
          padding: 14px 12px 32px !important;
        }
        #pendaftaran-skeleton-overlay {
          padding: 14px 12px 32px !important;
        }
        .fcc-pendaftaran-header-bar {
          flex-direction: column !important;
          align-items: stretch !important;
          gap: 12px !important;
          margin-bottom: 16px !important;
        }
        .fcc-pendaftaran-header-bar h1 {
          font-size: 19px !important;
        }
        .fcc-pendaftaran-header-bar a {
          width: 100% !important;
          justify-content: center !important;
          padding: 9px 14px !important;
          box-sizing: border-box !important;
        }
        .fcc-desktop-pendaftaran-table {
          display: none !important;
        }
        .fcc-mobile-pendaftaran-card-list {
          display: block !important;
        }
        .fcc-card {
          border-radius: 16px !important;
        }
      }
    </style>

    <div id="pendaftaran-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="margin-bottom:20px;">
        <div class="fcc-skeleton-box" style="width:130px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
        <div class="fcc-skeleton-box" style="width:60%;height:24px;margin-bottom:6px;"></div>
        <div class="fcc-skeleton-box" style="width:85%;height:13px;"></div>
      </div>
      {{-- Card List Skeleton --}}
      <div style="border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;overflow:hidden;">
        @for($s=0;$s<3;$s++)
        <div style="padding:14px 16px;border-bottom:1px solid #F1F5F9;display:flex;flex-direction:column;gap:10px;">
          <div style="display:flex;align-items:flex-start;gap:10px;">
            <div class="fcc-skeleton-box" style="width:36px;height:36px;border-radius:10px;flex-shrink:0;"></div>
            <div style="flex:1;">
              <div class="fcc-skeleton-box" style="width:75%;height:16px;margin-bottom:6px;"></div>
              <div class="fcc-skeleton-box" style="width:45%;height:11px;"></div>
            </div>
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;padding-top:2px;">
            <div style="display:flex;align-items:center;gap:6px;">
              <div class="fcc-skeleton-box" style="width:70px;height:18px;border-radius:6px;"></div>
              <div class="fcc-skeleton-box" style="width:60px;height:12px;"></div>
            </div>
            <div class="fcc-skeleton-box" style="width:60px;height:24px;border-radius:6px;"></div>
          </div>
        </div>
        @endfor
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('pendaftaran-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div class="fcc-pendaftaran-header-bar" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Histori &amp; Status</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Pendaftaran Saya</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola dan pantau status pendaftaran kegiatan pelatihan serta sertifikasi kompetensi Anda.</p>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        {{-- Desktop Table View --}}
        <div class="fcc-desktop-pendaftaran-table" style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;text-align:left;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFC81A;">Kegiatan</th>
                        <th style="padding:14px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:center;">Jenis</th>
                        <th style="padding:14px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;">Tanggal Daftar</th>
                        <th style="padding:14px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:center;">Status Pendaftaran</th>
                        <th style="padding:14px 20px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:right;width:170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $pd)
                    @php
                    $isPel = $pd->kegiatan->jenis_kegiatan === 'pelatihan';
                    $sc = match($pd->status_pendaftaran){
                        'terdaftar'           => ['#ECFDF5','#059669','#10B981','Terdaftar'],
                        'menunggu_verifikasi' => ['#FFFDF5','#D97706','#F59E0B','Menunggu Verifikasi'],
                        'ditolak'             => ['#FEF2F2','#DC2626','#EF4444','Ditolak'],
                        default               => ['#F1F5F9','#4B5563','#CBD5E1','Menunggu Bayar'],
                    };
                    @endphp
                    <tr style="border-bottom:1px solid #F1F5F9;transition:background .18s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                        <td style="padding:16px 20px;">
                            <div style="display:flex;align-items:center;gap:14px;">
                                <div style="width:42px;height:42px;border-radius:12px;background:{{ $isPel?'#FFFDF5':'#EEF2FF' }};border:1.5px solid {{ $isPel?'#FFC81A':'#6366F1' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>20,'style'=>"color:".($isPel?'#131218':'#6366F1')])
                                </div>
                                <div>
                                    <p style="font-size:14px;font-weight:900;color:#131218;margin:0 0 3px;">{{ Str::limit($pd->kegiatan->judul,45) }}</p>
                                    <p style="font-size:11.5px;color:#64748B;margin:0;font-weight:600;">Paket: {{ $pd->biaya?->nama_jenis ?? 'Gratis' }}</p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
                            <span style="font-size:10.5px;font-weight:900;padding:4px 10px;border-radius:6px;background:{{ $isPel?'#FFC81A':'#3B82F6' }};color:{{ $isPel?'#131218':'#FFFFFF' }};border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">
                                {{ ucfirst($pd->kegiatan->jenis_kegiatan) }}
                            </span>
                        </td>
                        <td style="padding:16px 14px;vertical-align:middle;font-size:13px;color:#334155;font-weight:700;">
                            {{ $pd->tgl_daftar->format('d M Y') }}
                        </td>
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
                            <span style="font-size:10.5px;font-weight:900;padding:4px 10px;border-radius:6px;background:{{ $sc[0] }};color:{{ $sc[1] }};border:1px solid {{ $sc[2] }};text-transform:uppercase;letter-spacing:0.5px;">
                                {{ $sc[3] }}
                            </span>
                        </td>
                        <td style="padding:16px 20px;text-align:right;vertical-align:middle;">
                            @if($pd->pembayaran && $pd->status_pendaftaran==='menunggu_pembayaran')
                            <a href="{{ route('peserta.pembayaran.show',$pd->pembayaran->id) }}" style="font-size:12px;font-weight:900;color:#131218;text-decoration:none;padding:6px 14px;background:#FFC81A;border-radius:8px;border:1px solid #131218;box-shadow:0 2px 8px rgba(255,200,26,0.3);display:inline-block;">
                                Bayar Sekarang
                            </a>
                            @else
                            <button type="button" onclick="openPendaftaranModal('{{ $pd->hashid }}', '{{ addslashes($pd->kegiatan->judul) }}', '{{ ucfirst($pd->kegiatan->jenis_kegiatan) }}', '{{ addslashes($pd->biaya?->nama_jenis ?? 'Gratis') }}', '{{ $pd->tgl_daftar->format('d F Y - H:i WIB') }}', '{{ $pd->status_pendaftaran }}', '{{ addslashes($sc[3]) }}', '{{ $sc[0] }}', '{{ $sc[1] }}', '{{ $sc[2] }}', '{{ $pd->pembayaran ? route('peserta.pembayaran.show', $pd->pembayaran->id) : '' }}', '{{ $pd->pembayaran ? route('peserta.pembayaran.invoice', $pd->pembayaran->id) : '' }}')" style="font-size:12px;font-weight:800;color:#131218;cursor:pointer;padding:6px 14px;background:#F1F5F9;border-radius:8px;border:1px solid #CBD5E1;display:inline-block;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.borderColor='#CBD5E1';">
                                Detail &rarr;
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#94A3B8;font-size:14px;font-weight:600;">
                            Belum ada pendaftaran kegiatan. <a href="{{ route('peserta.jelajahi') }}" style="color:#131218;font-weight:900;text-decoration:underline;">Jelajahi kegiatan &rarr;</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List View --}}
        <div class="fcc-mobile-pendaftaran-card-list">
            @forelse($pendaftaran as $pd)
            @php
            $isPel = $pd->kegiatan->jenis_kegiatan === 'pelatihan';
            $sc = match($pd->status_pendaftaran){
                'terdaftar'           => ['#ECFDF5','#059669','#10B981','Terdaftar'],
                'menunggu_verifikasi' => ['#FFFDF5','#D97706','#F59E0B','Menunggu Verifikasi'],
                'ditolak'             => ['#FEF2F2','#DC2626','#EF4444','Ditolak'],
                default               => ['#F1F5F9','#4B5563','#CBD5E1','Menunggu Bayar'],
            };
            @endphp
            <div style="padding:14px 16px;border-bottom:1px solid #F1F5F9;display:flex;flex-direction:column;gap:10px;">
                <div style="display:flex;align-items:flex-start;gap:12px;">
                    <div style="width:38px;height:38px;border-radius:10px;background:{{ $isPel?'#FFFDF5':'#EEF2FF' }};border:1.5px solid {{ $isPel?'#FFC81A':'#6366F1' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>18,'style'=>"color:".($isPel?'#131218':'#6366F1')])
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="display:flex;align-items:center;gap:6px;margin-bottom:3px;flex-wrap:wrap;">
                            <span style="font-size:9.5px;font-weight:900;padding:2px 7px;border-radius:6px;background:{{ $isPel?'#FFC81A':'#3B82F6' }};color:{{ $isPel?'#131218':'#FFFFFF' }};border:1px solid #131218;text-transform:uppercase;">
                                {{ ucfirst($pd->kegiatan->jenis_kegiatan) }}
                            </span>
                            <span style="font-size:10.5px;color:#64748B;font-weight:600;">Paket: {{ $pd->biaya?->nama_jenis ?? 'Gratis' }}</span>
                        </div>
                        <p style="font-size:13.5px;font-weight:900;color:#131218;margin:0;line-height:1.35;">{{ $pd->kegiatan->judul }}</p>
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;padding-top:6px;border-top:1px dashed #F1F5F9;">
                    <div style="display:flex;align-items:center;gap:6px;">
                        <span style="font-size:9.5px;font-weight:900;padding:3px 8px;border-radius:6px;background:{{ $sc[0] }};color:{{ $sc[1] }};border:1px solid {{ $sc[2] }};text-transform:uppercase;">
                            {{ $sc[3] }}
                        </span>
                        <span style="font-size:10.5px;color:#64748B;font-weight:600;">{{ $pd->tgl_daftar->format('d M Y') }}</span>
                    </div>
                    <div>
                        @if($pd->pembayaran && $pd->status_pendaftaran==='menunggu_pembayaran')
                        <a href="{{ route('peserta.pembayaran.show',$pd->pembayaran->id) }}" style="font-size:11.5px;font-weight:900;color:#131218;text-decoration:none;padding:5px 12px;background:#FFC81A;border-radius:6px;border:1px solid #131218;box-shadow:0 2px 8px rgba(255,200,26,0.3);display:inline-block;">
                            Bayar Sekarang
                        </a>
                        @else
                        <button type="button" onclick="openPendaftaranModal('{{ $pd->hashid }}', '{{ addslashes($pd->kegiatan->judul) }}', '{{ ucfirst($pd->kegiatan->jenis_kegiatan) }}', '{{ addslashes($pd->biaya?->nama_jenis ?? 'Gratis') }}', '{{ $pd->tgl_daftar->format('d F Y - H:i WIB') }}', '{{ $pd->status_pendaftaran }}', '{{ addslashes($sc[3]) }}', '{{ $sc[0] }}', '{{ $sc[1] }}', '{{ $sc[2] }}', '{{ $pd->pembayaran ? route('peserta.pembayaran.show', $pd->pembayaran->id) : '' }}', '{{ $pd->pembayaran ? route('peserta.pembayaran.invoice', $pd->pembayaran->id) : '' }}')" style="font-size:11.5px;font-weight:800;color:#131218;cursor:pointer;padding:5px 12px;background:#F1F5F9;border-radius:6px;border:1px solid #CBD5E1;display:inline-block;">
                            Detail &rarr;
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div style="padding:32px 20px;text-align:center;color:#94A3B8;font-size:13px;font-weight:600;">
                Belum ada pendaftaran kegiatan. <a href="{{ route('peserta.jelajahi') }}" style="color:#131218;font-weight:900;text-decoration:underline;">Jelajahi kegiatan &rarr;</a>
            </div>
            @endforelse
        </div>
        @if($pendaftaran->hasPages())
        <div style="padding:16px 24px;border-top:1.5px solid #E2E8F0;background:#F8FAFC;">{{ $pendaftaran->links() }}</div>
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
