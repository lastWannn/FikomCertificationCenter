@extends('layouts.peserta')
@section('title','Detail Pembayaran')
@section('page-title','Detail Pembayaran')
@section('page-content')

@php
// Status mapping
$sc = match($pembayaran->status_pembayaran) {
    'terverifikasi'       => ['color'=>'#10B981','bg'=>'rgba(16,185,129,0.08)','border'=>'rgba(16,185,129,0.25)','label'=>'Terverifikasi',
                              'desc'=>'Pembayaran telah diverifikasi Admin. Anda resmi terdaftar!',
                              'icon'=>'check-circle'],
    'menunggu_verifikasi' => ['color'=>'#F59E0B','bg'=>'rgba(245,158,11,0.08)','border'=>'rgba(245,158,11,0.25)','label'=>'Menunggu Verifikasi',
                              'desc'=>'Bukti transfer sedang ditinjau oleh tim Admin FCC.',
                              'icon'=>'clock'],
    'ditolak'             => ['color'=>'#EF4444','bg'=>'rgba(239,68,68,0.08)','border'=>'rgba(239,68,68,0.25)','label'=>'Pembayaran Ditolak',
                              'desc'=>'Pembayaran tidak dapat diverifikasi. Lihat keterangan atau hubungi Admin.',
                              'icon'=>'x-circle'],
    'kadaluarsa'          => ['color'=>'#6B7280','bg'=>'rgba(107,114,128,0.08)','border'=>'rgba(107,114,128,0.25)','label'=>'Kadaluarsa',
                              'desc'=>'Batas waktu habis. Anda dapat mengajukan permintaan perpanjangan waktu bayar.',
                              'icon'=>'alert-circle'],
    default               => ['color'=>'#3B82F6','bg'=>'rgba(59,130,246,0.08)','border'=>'rgba(59,130,246,0.25)','label'=>'Menunggu Pembayaran',
                              'desc'=>'Transfer tepat nominal berikut sebelum batas waktu habis.',
                              'icon'=>'credit-card'],
};
$perpStatus = $pembayaran->status_perpanjangan;
@endphp

<style>
.pembayaran-wrapper {
    padding: 24px;
    max-width: 1120px;
    margin: 0 auto;
}
.pembayaran-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 20px;
    align-items: start;
}
.pembayaran-grid > div:last-child {
    position: sticky;
    top: 24px;
}
.form-grid-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.rekening-transfer-box {
    background: linear-gradient(135deg, #131218, #1C1B22);
    border-radius: 14px;
    padding: 20px 24px;
    color: #FFF;
    margin-bottom: 18px;
}
.nominal-calc-box {
    display: grid;
    grid-template-columns: 1fr auto 1fr auto 1.2fr;
    gap: 12px;
    align-items: center;
    background: #FFF;
    border: 1px solid #E2E4EB;
    border-radius: 10px;
    padding: 14px 16px;
}
@media (max-width: 1024px) {
    .pembayaran-grid {
        grid-template-columns: 1fr;
    }
}
@media (max-width: 640px) {
    .pembayaran-wrapper {
        padding: 16px 12px;
    }
    .form-grid-2col {
        grid-template-columns: 1fr;
    }
    .nominal-calc-box {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 8px;
    }
    .nominal-calc-box > div {
        text-align: center !important;
    }
}
</style>

<div class="pembayaran-wrapper" style="position:relative;background:#F6F8FB;min-height:100vh;padding:24px 28px;">

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
      #pembayaran-detail-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="pembayaran-detail-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      <div class="fcc-skeleton-box" style="width:180px;height:32px;border-radius:20px;margin-bottom:16px;"></div>
      <div class="fcc-skeleton-box" style="width:100%;height:80px;border-radius:18px;margin-bottom:20px;"></div>
      <div style="display:grid;grid-template-columns:1fr 380px;gap:20px;">
        <div class="fcc-skeleton-box" style="width:100%;height:320px;border-radius:20px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:320px;border-radius:20px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('pembayaran-detail-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- ── NAVIGASI KEMBALI ───────────────────────────────────── --}}
    <div style="margin-bottom:18px;">
        <a href="{{ route('peserta.pembayaran') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#131218;background:#FFFFFF;border:1.5px solid #131218;padding:6px 16px;border-radius:20px;font-size:12.5px;text-decoration:none;font-weight:900;transition:all 0.18s;box-shadow:0 2px 8px rgba(0,0,0,0.03);"
           onmouseover="this.style.background='#FFC81A';this.style.transform='translateX(-2px)'" onmouseout="this.style.background='#FFFFFF';this.style.transform='translateX(0)'">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) &larr; Kembali ke Pembayaran Saya
        </a>
    </div>

    @if(!($pembayaran->status_pembayaran === 'kadaluarsa' && $perpStatus === 'menunggu'))
    <div style="background:{{ $sc['bg'] }};border:2px solid {{ $sc['border'] }};
                border-radius:18px;padding:22px 26px;margin-bottom:22px;
                display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;box-shadow:0 4px 16px rgba(0,0,0,0.03);">
        <div style="display:flex;align-items:center;gap:16px;">
            <div style="width:52px;height:52px;border-radius:14px;background:#131218;border:1.5px solid #131218;
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(19,18,24,0.2);">
                @include('components.icon',['name'=>$sc['icon'],'size'=>24,'style'=>"color:#FFC81A"])
            </div>
            <div>
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:2px;">
                    <span style="font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;background:{{ $sc['color'] }};color:#FFFFFF;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Status</span>
                    <p style="margin:0;font-size:17px;font-weight:900;color:#131218;">{{ $sc['label'] }}</p>
                </div>
                <p style="margin:0;font-size:13px;color:#64748B;font-weight:600;line-height:1.4">{{ $sc['desc'] }}</p>
            </div>
        </div>
        @if(($pembayaran->status_pembayaran === 'kadaluarsa' || $pembayaran->minutes_left <= 0) && $pembayaran->bisaRequestPerpanjangan())
        <form action="{{ route('peserta.pembayaran.request-perpanjangan', $pembayaran) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="fcc-btn-gold"
               onclick="return fccConfirmAction(this, 'Ajukan Perpanjangan Waktu', 'Apakah Anda yakin ingin mengajukan perpanjangan waktu pembayaran ke Admin?', 'Ya, Ajukan', false)"
               style="padding:10px 18px;font-size:13px;border-radius:12px;font-weight:900;white-space:nowrap;display:inline-flex;align-items:center;gap:6px;cursor:pointer;box-shadow:0 4px 12px rgba(255,200,26,0.3);">
                @include('components.icon',['name'=>'clock','size'=>15]) Minta Perpanjangan Waktu
            </button>
        </form>
        @endif
    </div>
    @endif

    {{-- ── PERPANJANGAN BANNER ────────────────────────────────── --}}
    @if($perpStatus === 'menunggu')
    <div style="background:#FFFDF5;border:2px solid #F59E0B;
                border-radius:16px;padding:16px 20px;margin-bottom:22px;
                display:flex;align-items:center;gap:14px;box-shadow:0 4px 14px rgba(245,158,11,0.15);">
        <div style="width:40px;height:40px;border-radius:12px;background:#131218;border:1px solid #131218;
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @include('components.icon',['name'=>'clock','size'=>20,'style'=>'color:#FFC81A'])
        </div>
        <div>
            <p style="margin:0 0 2px;font-weight:900;color:#B45309;font-size:14.5px">
                Permintaan Perpanjangan Sedang Diproses Admin
            </p>
            <p style="margin:0;font-size:12.5px;color:#78350F;font-weight:600">
                Admin sedang meninjau permintaan Anda. Harap cek berkala halaman ini atau email Anda.
            </p>
        </div>
    </div>
    @elseif($perpStatus === 'ditolak')
    <div style="background:#FEF2F2;border:2px solid #EF4444;
                border-radius:16px;padding:16px 20px;margin-bottom:22px;">
        <p style="margin:0 0 4px;font-weight:900;color:#DC2626;font-size:14px">
            ✕ Permintaan Perpanjangan Ditolak
        </p>
        @if($pembayaran->catatan_perpanjangan)
        <p style="margin:0;font-size:12.5px;color:#991B1B;font-weight:600">
            Catatan Admin: {{ $pembayaran->catatan_perpanjangan }}
        </p>
        @endif
    </div>
    @elseif($perpStatus === 'disetujui' && $pembayaran->status_pembayaran === 'kadaluarsa')
    <div style="background:#ECFDF5;border:2px solid #10B981;
                border-radius:16px;padding:16px 20px;margin-bottom:22px;">
        <p style="margin:0 0 2px;font-weight:900;color:#059669;font-size:14px">
            ✓ Perpanjangan Disetujui — Batas Waktu Diperpanjang
        </p>
        <p style="margin:0;font-size:12.5px;color:#065F46;font-weight:600">
            Upload bukti transfer sebelum batas waktu baru habis.
        </p>
    </div>
    @endif

    {{-- ── GRID LAYOUT DESKTOP ─────────────────────────────────── --}}
    <div class="pembayaran-grid">

        {{-- ── KOLOM KIRI: Rekening Transfer Utama + Upload ──────── --}}
        <div>

            {{-- 1. UTAMA: KARTU REKENING TUJUAN TRANSFER & NOMINAL (PALING ATAS) --}}
            @if(in_array($pembayaran->status_pembayaran, ['menunggu_pembayaran','kadaluarsa']))
            <div class="fcc-card" style="padding:28px;margin-bottom:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
                    <div>
                        <h3 style="font-size:17px;font-weight:900;color:#131218;margin:0 0 3px;display:flex;align-items:center;gap:10px;">
                            @include('components.icon',['name'=>'credit-card','size'=>20,'style'=>'color:#131218'])
                            Instruksi Pembayaran Transfer
                        </h3>
                        <p style="font-size:12.5px;color:#64748B;margin:0;font-weight:500">Silakan transfer tepat nominal berikut ke rekening resmi FCC UMI</p>
                    </div>
                    @if($pembayaran->status_pembayaran === 'menunggu_pembayaran')
                    <div style="background:#FEF2F2;border:1.5px solid #FCA5A5;padding:8px 16px;border-radius:12px;text-align:right;">
                        <p style="font-size:10px;color:#991B1B;margin:0 0 2px;font-weight:900;text-transform:uppercase;letter-spacing:0.5px;">Batas Waktu Bayar:</p>
                        <p id="timer" style="font-size:22px;font-weight:900;color:#DC2626;font-family:monospace;margin:0;line-height:1">--:--:--</p>
                    </div>
                    @endif
                </div>

                {{-- BANNER REKENING --}}
                @if($rekening)
                <div style="background:#131218;border-radius:16px;padding:22px 26px;color:#FFF;margin-bottom:20px;border:1.5px solid #FFC81A;box-shadow:0 6px 20px rgba(19,18,24,0.18);">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;">
                        <div>
                            <p style="color:#FFC81A;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px;margin:0 0 6px">
                                Transfer Ke {{ $rekening->bank }}
                            </p>
                            <p style="color:#FFFFFF;font-size:26px;font-weight:900;font-family:monospace;letter-spacing:2px;margin:0 0 6px">
                                {{ $rekening->no_rekening }}
                            </p>
                            <p style="color:#CBD5E1;font-size:13px;font-weight:700;margin:0">
                                a.n. {{ $rekening->nama_pemilik }}
                            </p>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ $rekening->no_rekening }}').then(()=>fccToast('Nomor rekening berhasil disalin!','success'))"
                                class="fcc-btn-gold"
                                style="padding:10px 18px;font-size:12.5px;border-radius:10px;font-weight:900;display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 12px rgba(255,200,26,0.3);">
                            @include('components.icon',['name'=>'copy','size'=>15])
                            Salin No. Rekening
                        </button>
                    </div>
                </div>
                @endif

                {{-- RINCIAN NOMINAL TRANSFER --}}
                @if($pembayaran->kode_unik)
                <div style="background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:16px;padding:18px;margin-bottom:16px;">
                    <p style="font-size:11px;font-weight:900;color:#64748B;text-transform:uppercase;letter-spacing:1px;margin:0 0 14px;text-align:center">
                        Rincian Nominal Transfer (Wajib Tepat)
                    </p>
                    <div class="nominal-calc-box" style="background:#FFFFFF;border:1.5px solid #CBD5E1;border-radius:12px;padding:16px;">
                        <div>
                            <p style="font-size:11px;color:#64748B;margin:0 0 2px;font-weight:700">Nominal Biaya</p>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0;font-family:monospace">
                                {{ $pembayaran->jumlah_bayar_format }}
                            </p>
                        </div>
                        <div style="font-size:18px;color:#94A3B8;font-weight:800;text-align:center">+</div>
                        <div style="text-align:center">
                            <p style="font-size:11px;color:#64748B;margin:0 0 2px;font-weight:700">Kode Unik</p>
                            <span style="background:#131218;color:#FFC81A;font-weight:900;font-size:15px;font-family:monospace;padding:3px 10px;border-radius:6px;display:inline-block;letter-spacing:1.5px;border:1px solid #131218;">
                                {{ $pembayaran->kode_unik }}
                            </span>
                        </div>
                        <div style="font-size:18px;color:#94A3B8;font-weight:800;text-align:center">=</div>
                        <div style="text-align:right">
                            <p style="font-size:11px;color:#64748B;margin:0 0 2px;font-weight:700">Total Wajib Ditransfer</p>
                            <p style="font-size:20px;font-weight:900;color:#059669;margin:0;font-family:monospace">
                                {{ $pembayaran->nominal_transfer_format }}
                            </p>
                        </div>
                    </div>
                    <div style="background:#ECFDF5;border:1px solid #A7F3D0;
                                border-radius:10px;padding:10px 14px;margin-top:14px;
                                display:flex;align-items:center;gap:10px;">
                        @include('components.icon',['name'=>'info','size'=>16,'style'=>'color:#059669;flex-shrink:0'])
                        <p style="font-size:12px;color:#065F46;margin:0;font-weight:600">
                            Transfer <strong>tepat {{ $pembayaran->nominal_transfer_format }}</strong> agar pembayaran Anda terverifikasi secara otomatis oleh sistem/Admin.
                        </p>
                    </div>
                </div>
                @endif

                {{-- Status perpanjangan jika kadaluarsa --}}
                @if($pembayaran->status_pembayaran === 'kadaluarsa' || $pembayaran->minutes_left <= 0)
                    @if($perpStatus === 'menunggu')
                    <div style="text-align:center;padding:14px;background:#FFFDF5;border-radius:12px;
                                border:1.5px dashed #F59E0B;color:#B45309;font-size:13px;margin-top:14px;font-weight:700;">
                        @include('components.icon',['name'=>'clock','size'=>15,'style'=>'color:#D97706'])
                        Permintaan perpanjangan waktu sedang ditinjau oleh Admin...
                    </div>
                    @endif
                @endif
            </div>
            @endif

            {{-- 2. UPLOAD BUKTI TRANSFER --}}
            @if($pembayaran->bisaUploadBukti())
            <div class="fcc-card" style="padding:28px;margin-bottom:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <h3 style="font-size:17px;font-weight:900;color:#131218;margin:0 0 4px;display:flex;align-items:center;gap:10px;">
                    @include('components.icon',['name'=>'upload','size'=>20,'style'=>'color:#131218'])
                    Upload Foto Bukti Transfer
                </h3>
                <p style="font-size:12.5px;color:#64748B;margin:0 0 20px;font-weight:500">
                    Setelah melakukan transfer, silakan lengkapi formulir dan unggah bukti transfer di bawah ini:
                </p>

                <form action="{{ route('peserta.pembayaran.konfirmasi', $pembayaran) }}"
                      method="POST" enctype="multipart/form-data" onsubmit="return validateBuktiTransfer(event)">
                    @csrf

                    <div class="form-grid-2col" style="margin-bottom:16px;">
                        <div>
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Metode Transfer *
                            </label>
                            <input type="text" name="metode_pembayaran"
                                   placeholder="Transfer Bank / QRIS / m-Banking" required class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Nama Pengirim (sesuai rekening) *
                            </label>
                            <input type="text" name="nama_pengirim"
                                   placeholder="Nama di rekening asal" required class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Tanggal Transfer *
                            </label>
                            <input type="date" name="tgl_transfer" required class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                                Jam Transfer *
                            </label>
                            <input type="time" name="jam_transfer" required class="fcc-input" style="height:42px;border:1.5px solid #CBD5E1;border-radius:10px;font-size:13px;"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>
                    </div>

                    {{-- Upload Foto Bukti --}}
                    <div style="margin-bottom:22px;">
                        <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">
                            Foto Bukti Transfer *
                        </label>
                        <div id="upload-area" style="border:2px dashed #CBD5E1;border-radius:16px;
                             padding:28px;text-align:center;cursor:pointer;transition:all .2s;
                             background:#F8FAFC;position:relative;"
                             onclick="document.getElementById('bukti-input').click()"
                             ondragover="event.preventDefault();this.style.borderColor='#131218';this.style.background='#FFFDF5'"
                             ondragleave="this.style.borderColor='#CBD5E1';this.style.background='#F8FAFC'"
                             ondrop="handleDrop(event)">
                            <div id="upload-placeholder">
                                <div style="width:52px;height:52px;border-radius:14px;background:#131218;
                                            display:flex;align-items:center;justify-content:center;margin:0 auto 12px;box-shadow:0 4px 12px rgba(19,18,24,0.2);">
                                    @include('components.icon',['name'=>'image','size'=>24,'style'=>'color:#FFC81A'])
                                </div>
                                <p style="font-size:14px;font-weight:900;color:#131218;margin:0 0 4px">
                                    Klik atau seret foto bukti transfer ke sini
                                </p>
                                <p style="font-size:12px;color:#64748B;margin:0;font-weight:500">
                                    Format: JPG, JPEG, PNG, WebP — Maksimal 5 MB
                                </p>
                            </div>
                            <img id="preview-img" src="" alt="Preview"
                                 style="display:none;max-height:220px;max-width:100%;border-radius:12px;object-fit:contain;margin:0 auto;border:2px solid #131218;">
                            <input type="file" id="bukti-input" name="bukti_bayar"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   required style="display:none"
                                   onchange="previewImage(this)">
                        </div>
                        @error('bukti_bayar')
                        <p style="color:#DC2626;font-size:12px;margin:6px 0 0;font-weight:700;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="fcc-btn-gold"
                            style="width:100%;justify-content:center;padding:13px;font-size:14px;border-radius:12px;font-weight:900;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
                        @include('components.icon',['name'=>'send','size'=>16])
                        Kirim Bukti Pembayaran &rarr;
                    </button>
                </form>
            </div>

            @elseif($pembayaran->bukti_bayar)
            {{-- BUKTI TRANSFER SUDAH DIKIRIM --}}
            <div class="fcc-card" style="padding:28px;margin-bottom:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <h3 style="font-size:16px;font-weight:900;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:10px;">
                    @include('components.icon',['name'=>'image','size'=>18,'style'=>'color:#059669'])
                    Foto Bukti Transfer Terkirim
                </h3>
                <div style="background:#F8FAFC;border-radius:14px;padding:14px;text-align:center;border:1.5px solid #E2E8F0;margin-bottom:18px;">
                    <img src="{{ asset('storage/'.$pembayaran->bukti_bayar) }}"
                         style="max-width:100%;border-radius:10px;max-height:340px;object-fit:contain;border:1.5px solid #CBD5E1;"
                         alt="Bukti Transfer">
                </div>
                <div class="form-grid-2col">
                    @foreach([
                        ['Nama Pengirim',$pembayaran->nama_pengirim],
                        ['Tgl Transfer', optional($pembayaran->tgl_transfer)->format('d M Y').' '.$pembayaran->jam_transfer],
                        ['Metode Pembayaran',$pembayaran->metode_pembayaran],
                    ] as [$l,$v])
                    @if($v)
                    <div style="padding:10px;background:#F8FAFC;border-radius:10px;border:1px solid #E2E8F0;">
                        <p style="color:#64748B;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;margin:0 0 2px">{{ $l }}</p>
                        <p style="color:#131218;font-size:13.5px;font-weight:800;margin:0">{{ $v }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

        </div>{{-- end kolom kiri --}}

        {{-- ── KOLOM KANAN: Sidebar Ringkasan & Referensi Kode ──────── --}}
        <div>
            <div class="fcc-card" style="padding:26px;margin-bottom:22px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
                <h3 style="font-size:16px;font-weight:900;color:#131218;margin:0 0 18px;display:flex;align-items:center;gap:10px;">
                    @include('components.icon',['name'=>'file-text','size'=>18,'style'=>'color:#FFC81A'])
                    Ringkasan Transaksi
                </h3>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @foreach([
                        ['Kode Pembayaran', $pembayaran->kode_pembayaran],
                        ['Kegiatan',Str::limit($pembayaran->pendaftaran->kegiatan->judul, 40)],
                        ['Jenis Kegiatan', ucfirst($pembayaran->pendaftaran->kegiatan->jenis_kegiatan ?? '-')],
                        ['Jenis Biaya', $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Gratis'],
                        ['Nominal Biaya', $pembayaran->jumlah_bayar_format],
                        ['Kode Unik', $pembayaran->kode_unik ?? '-'],
                    ] as [$l,$v])
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;">
                        <span style="color:#64748B;font-size:11.5px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</span>
                        <span style="color:#131218;font-size:13px;font-weight:900;text-align:right;">{{ $v }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Total Transfer Highlight --}}
                @if($pembayaran->kode_unik)
                <div style="background:#131218;border-radius:14px;padding:18px;margin-top:16px;text-align:center;border:1.5px solid #FFC81A;box-shadow:0 4px 14px rgba(19,18,24,0.2);">
                    <p style="color:#CBD5E1;font-size:10.5px;font-weight:800;text-transform:uppercase;letter-spacing:1px;margin:0 0 4px">
                        Total Wajib Ditransfer
                    </p>
                    <p style="color:#FFC81A;font-size:24px;font-weight:900;font-family:monospace;letter-spacing:1px;margin:0">
                        {{ $pembayaran->nominal_transfer_format }}
                    </p>
                </div>
                @endif

                <div style="margin-top:18px;">
                    <a href="{{ route('peserta.pembayaran.invoice', $pembayaran) }}" target="_blank"
                       style="width:100%;justify-content:center;padding:11px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;border-radius:12px;font-weight:900;background:#131218;color:#FFFFFF;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(19,18,24,0.15);">
                        @include('components.icon',['name'=>'download','size'=>15,'style'=>'color:#FFC81A']) Unduh Invoice Resmi (PDF)
                    </a>
                </div>

            </div>
        </div>

    </div>{{-- end grid --}}
</div>

@endsection

@push('page-data')
<script>
window.PAGE_DATA = {!! json_encode([
    'expiry'  => $pembayaran->tgl_kadaluarsa?->toISOString(),
    'serverTime' => now()->toISOString(),
    'isAktif' => $pembayaran->isAktif(),
]) !!};
if (typeof window.initCountdown === 'function') {
    window.initCountdown();
}
</script>
@endpush
@push('scripts')
@vite('resources/js/pages/peserta-pembayaran.js')
<script>
function compressAndPreviewImage(file, inputElement) {
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        if (typeof window.fccToast === 'function') {
            fccToast('Hanya file gambar yang diizinkan (JPG, PNG, WebP)', 'error');
        } else {
            alert('Hanya file gambar yang diizinkan (JPG, PNG, WebP)');
        }
        if (inputElement) inputElement.value = '';
        return;
    }

    const area = document.getElementById('upload-area');
    if (area) {
        area.style.borderColor = '#10B981';
        area.style.background = 'rgba(16,185,129,.04)';
    }

    // Load FileReader & Canvas Compression
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = new Image();
        img.onload = function() {
            // Resize image if max dimension > 1600px
            const maxDim = 1600;
            let width = img.width;
            let height = img.height;

            if (width > maxDim || height > maxDim) {
                if (width > height) {
                    height = Math.round((height * maxDim) / width);
                    width = maxDim;
                } else {
                    width = Math.round((width * maxDim) / height);
                    height = maxDim;
                }
            }

            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, width, height);

            canvas.toBlob(function(blob) {
                if (!blob) return;

                // Create compressed File object (< 500KB)
                const compressedFile = new File([blob], file.name.replace(/\.[^/.]+$/, ".jpg"), {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });

                // Update inputElement.files using DataTransfer
                if (inputElement) {
                    const dt = new DataTransfer();
                    dt.items.add(compressedFile);
                    inputElement.files = dt.files;
                }

                // Show Preview Image
                const previewImg = document.getElementById('preview-img');
                const placeholder = document.getElementById('upload-placeholder');
                if (previewImg) {
                    previewImg.src = canvas.toDataURL('image/jpeg', 0.85);
                    previewImg.style.display = 'block';
                }
                if (placeholder) placeholder.style.display = 'none';

            }, 'image/jpeg', 0.85);
        };
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function validateBuktiTransfer(e) {
    const inp = document.getElementById('bukti-input');
    if (!inp || !inp.files || inp.files.length === 0) {
        if (e && e.preventDefault) e.preventDefault();
        
        // Show Warning Popup / Alert
        if (typeof window.fccConfirmAction === 'function') {
            window.fccConfirmAction(
                null,
                'Bukti Transfer Belum Diunggah',
                'Mohon pilih / unggah foto bukti struk transfer Anda terlebih dahulu sebelum mengonfirmasi pembayaran.',
                'Saya Mengerti',
                true
            );
        } else if (typeof window.fccToast === 'function') {
            window.fccToast('Mohon unggah foto bukti struk transfer Anda terlebih dahulu!', 'error', 'Bukti Transfer Belum Ada');
        } else {
            alert('Mohon unggah foto bukti struk transfer Anda terlebih dahulu!');
        }

        // Highlight upload box with red border
        const area = document.getElementById('upload-area');
        if (area) {
            area.style.borderColor = '#EF4444';
            area.style.background = 'rgba(239,68,68,.06)';
            area.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return false;
    }

    const file = inp.files[0];
    if (file && file.size > 5 * 1024 * 1024) {
        if (e && e.preventDefault) e.preventDefault();
        if (typeof window.fccToast === 'function') {
            window.fccToast('Ukuran foto bukti transfer terlalu besar (maksimal 5MB). Harap pilih foto lain yang lebih kecil.', 'error');
        } else {
            alert('Ukuran foto bukti transfer terlalu besar (maksimal 5MB). Harap pilih foto lain yang lebih kecil.');
        }
        return false;
    }

    return true;
}

function previewImage(input) {
    if (input && input.files && input.files[0]) {
        compressAndPreviewImage(input.files[0], input);
    }
}

function handleDrop(e) {
    e.preventDefault();
    const file = e.dataTransfer.files[0];
    if (!file) return;
    const inp = document.getElementById('bukti-input');
    compressAndPreviewImage(file, inp);
}
</script>
@endpush
