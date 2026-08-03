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
                              'desc'=>'Batas waktu habis. Anda dapat meminta perpanjangan atau mengaktifkan kode baru.',
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
    grid-template-columns: 1fr 340px;
    gap: 20px;
    align-items: start;
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

<div class="pembayaran-wrapper">

    {{-- ── NAVIGASI KEMBALI ───────────────────────────────────── --}}
    <div style="margin-bottom:14px;">
        <a href="{{ route('peserta.pembayaran') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;font-weight:600;transition:color 0.2s;"
           onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#6B7280'">
            @include('components.icon',['name'=>'chevron-left','size'=>15]) Kembali ke Daftar Pembayaran
        </a>
    </div>

    {{-- ── STATUS BANNER ──────────────────────────────────────── --}}
    <div style="background:{{ $sc['bg'] }};border:1.5px solid {{ $sc['border'] }};
                border-radius:14px;padding:20px 24px;margin-bottom:20px;
                display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:48px;height:48px;border-radius:12px;background:{{ $sc['color'] }}18;
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                @include('components.icon',['name'=>$sc['icon'],'size'=>24,'style'=>"color:{$sc['color']}"])
            </div>
            <div>
                <p style="margin:0 0 3px;font-size:16px;font-weight:800;color:{{ $sc['color'] }}">{{ $sc['label'] }}</p>
                <p style="margin:0;font-size:13px;color:#6B7280;line-height:1.4">{{ $sc['desc'] }}</p>
            </div>
        </div>
        <a href="{{ route('peserta.pembayaran.invoice', $pembayaran) }}" target="_blank" class="fcc-btn-outline-dark"
           style="padding:9px 16px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;border-radius:10px;font-weight:700;white-space:nowrap;">
            @include('components.icon',['name'=>'download','size'=>14]) Unduh Invoice (PDF)
        </a>
    </div>

    {{-- ── PERPANJANGAN BANNER ────────────────────────────────── --}}
    @if($perpStatus === 'menunggu')
    <div style="background:rgba(245,158,11,.08);border:1.5px solid rgba(245,158,11,.3);
                border-radius:12px;padding:14px 18px;margin-bottom:20px;
                display:flex;align-items:center;gap:12px;">
        <div style="width:36px;height:36px;border-radius:10px;background:rgba(245,158,11,.12);
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @include('components.icon',['name'=>'clock','size'=>18,'style'=>'color:#F59E0B'])
        </div>
        <div>
            <p style="margin:0 0 2px;font-weight:800;color:#B45309;font-size:14px">
                Permintaan Perpanjangan Sedang Diproses
            </p>
            <p style="margin:0;font-size:12px;color:#92400E">
                Admin sedang meninjau permintaan Anda. Harap tunggu konfirmasi melalui email.
            </p>
        </div>
    </div>
    @elseif($perpStatus === 'ditolak')
    <div style="background:rgba(239,68,68,.07);border:1.5px solid rgba(239,68,68,.25);
                border-radius:12px;padding:14px 18px;margin-bottom:20px;">
        <p style="margin:0 0 4px;font-weight:800;color:#DC2626;font-size:13px">
            ✕ Permintaan Perpanjangan Ditolak
        </p>
        @if($pembayaran->catatan_perpanjangan)
        <p style="margin:0;font-size:12px;color:#991B1B">
            Catatan Admin: {{ $pembayaran->catatan_perpanjangan }}
        </p>
        @endif
    </div>
    @elseif($perpStatus === 'disetujui')
    <div style="background:rgba(16,185,129,.08);border:1.5px solid rgba(16,185,129,.25);
                border-radius:12px;padding:14px 18px;margin-bottom:20px;">
        <p style="margin:0 0 2px;font-weight:800;color:#059669;font-size:13px">
            ✓ Perpanjangan Disetujui — Batas Waktu Diperpanjang
        </p>
        <p style="margin:0;font-size:12px;color:#065F46">
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
            <div class="fcc-card" style="padding:24px;margin-bottom:18px;">

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:10px;">
                    <div>
                        <h3 style="font-size:16px;font-weight:900;color:#131218;margin:0 0 2px;display:flex;align-items:center;gap:8px;">
                            @include('components.icon',['name'=>'credit-card','size'=>18,'style'=>'color:#FFC81A'])
                            Instruksi Pembayaran Transfer
                        </h3>
                        <p style="font-size:12px;color:#6B7280;margin:0">Silakan transfer tepat nominal berikut ke rekening resmi FCC</p>
                    </div>
                    @if($pembayaran->status_pembayaran === 'menunggu_pembayaran')
                    <div style="background:#FFF8F8;border:1px solid rgba(239,68,68,0.2);padding:8px 14px;border-radius:10px;text-align:right;">
                        <p style="font-size:10px;color:#9CA3B0;margin:0 0 2px;font-weight:700;text-transform:uppercase;">Batas Waktu Bayar:</p>
                        <p id="timer" style="font-size:22px;font-weight:900;color:#EF4444;font-family:monospace;margin:0;line-height:1">--:--:--</p>
                    </div>
                    @endif
                </div>

                {{-- BANNER REKENING --}}
                @if($rekening)
                <div class="rekening-transfer-box">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;">
                        <div>
                            <p style="color:rgba(255,255,255,0.6);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin:0 0 4px">
                                Transfer Ke {{ $rekening->bank }}
                            </p>
                            <p style="color:#FFC81A;font-size:24px;font-weight:900;font-family:monospace;letter-spacing:2px;margin:0 0 4px">
                                {{ $rekening->no_rekening }}
                            </p>
                            <p style="color:#FFF;font-size:13px;font-weight:700;margin:0">
                                a.n. {{ $rekening->nama_pemilik }}
                            </p>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ $rekening->no_rekening }}').then(()=>fccToast('Nomor rekening disalin!','success'))"
                                class="fcc-btn-gold"
                                style="padding:10px 18px;font-size:13px;border-radius:10px;font-weight:800;display:inline-flex;align-items:center;gap:6px;">
                            @include('components.icon',['name'=>'copy','size'=>15])
                            Salin No. Rekening
                        </button>
                    </div>
                </div>
                @endif

                {{-- RINCIAN NOMINAL TRANSFER --}}
                @if($pembayaran->kode_unik)
                <div style="background:#F7F8FA;border:1px solid #E2E4EB;border-radius:12px;padding:16px;margin-bottom:16px;">
                    <p style="font-size:11px;font-weight:800;color:#9CA3B0;text-transform:uppercase;letter-spacing:1px;margin:0 0 12px;text-align:center">
                        Rincian Nominal Transfer (Wajib Tepat)
                    </p>
                    <div class="nominal-calc-box">
                        <div>
                            <p style="font-size:11px;color:#9CA3B0;margin:0 0 2px;font-weight:600">Nominal Biaya</p>
                            <p style="font-size:15px;font-weight:700;color:#131218;margin:0;font-family:monospace">
                                {{ $pembayaran->jumlah_bayar_format }}
                            </p>
                        </div>
                        <div style="font-size:18px;color:#9CA3B0;font-weight:600;text-align:center">+</div>
                        <div style="text-align:center">
                            <p style="font-size:11px;color:#9CA3B0;margin:0 0 2px;font-weight:600">Kode Unik</p>
                            <span style="background:#131218;color:#FFC81A;font-weight:900;font-size:15px;font-family:monospace;padding:3px 10px;border-radius:6px;display:inline-block;letter-spacing:1.5px">
                                {{ $pembayaran->kode_unik }}
                            </span>
                            <p style="font-size:9px;color:#9CA3B0;margin:2px 0 0">
                                {{ str_starts_with($pembayaran->kode_unik,'1') ? '1=Pelatihan' : '2=Sertifikasi' }}
                            </p>
                        </div>
                        <div style="font-size:18px;color:#9CA3B0;font-weight:600;text-align:center">=</div>
                        <div style="text-align:right">
                            <p style="font-size:11px;color:#9CA3B0;margin:0 0 2px;font-weight:600">Total Wajib Ditransfer</p>
                            <p style="font-size:20px;font-weight:900;color:#10B981;margin:0;font-family:monospace">
                                {{ $pembayaran->nominal_transfer_format }}
                            </p>
                        </div>
                    </div>
                    <div style="background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);
                                border-radius:8px;padding:9px 12px;margin-top:12px;
                                display:flex;align-items:center;gap:8px;">
                        @include('components.icon',['name'=>'info','size'=>14,'style'=>'color:#10B981;flex-shrink:0'])
                        <p style="font-size:12px;color:#059669;margin:0;font-weight:600">
                            Transfer <strong>tepat {{ $pembayaran->nominal_transfer_format }}</strong> agar pembayaran Anda terdeteksi secara otomatis oleh Admin.
                        </p>
                    </div>
                </div>
                @endif

                {{-- Tombol aksi jika kadaluarsa --}}
                @if($pembayaran->status_pembayaran === 'kadaluarsa' || $pembayaran->minutes_left <= 0)
                    @if($pembayaran->bisaRequestPerpanjangan())
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:8px;">
                        <form action="{{ route('peserta.pembayaran.aktifkan', $pembayaran) }}" method="POST">
                            @csrf
                            <button type="submit" class="fcc-btn-dark"
                                    style="width:100%;justify-content:center;padding:11px;font-size:13px;border-radius:10px;">
                                @include('components.icon',['name'=>'refresh-cw','size'=>14])
                                Aktifkan Kode Baru
                            </button>
                        </form>
                        <button onclick="document.getElementById('form-perpanjangan').style.display='block';this.style.display='none'"
                                class="fcc-btn-outline-dark"
                                style="width:100%;justify-content:center;padding:11px;font-size:13px;border-radius:10px;">
                            @include('components.icon',['name'=>'clock','size'=>14])
                            Minta Perpanjangan
                        </button>
                    </div>

                    {{-- Form perpanjangan --}}
                    <div id="form-perpanjangan" style="display:none;margin-top:14px;
                         background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;padding:16px;">
                        <p style="font-size:13px;font-weight:700;color:#131218;margin:0 0 10px">
                            Alasan Permintaan Perpanjangan Waktu
                        </p>
                        <form action="{{ route('peserta.pembayaran.request-perpanjangan', $pembayaran) }}" method="POST">
                            @csrf
                            <textarea name="alasan" rows="3" placeholder="Tuliskan alasan perpanjangan (opsional)..."
                                      class="fcc-input" style="resize:none;margin-bottom:12px;font-size:13px;"></textarea>
                            <div style="display:flex;gap:10px;">
                                <button type="submit" class="fcc-btn-gold" style="flex:1;justify-content:center;padding:10px;font-size:13px;border-radius:8px;">
                                    @include('components.icon',['name'=>'send','size'=>14]) Kirim Permintaan
                                </button>
                                <button type="button" onclick="document.getElementById('form-perpanjangan').style.display='none'"
                                        class="fcc-btn-outline-dark" style="padding:10px 16px;font-size:13px;border-radius:8px;">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                    @elseif($perpStatus === 'menunggu')
                    <div style="text-align:center;padding:12px;background:#F7F8FA;border-radius:10px;
                                border:1px dashed #E2E4EB;color:#9CA3B0;font-size:13px;">
                        @include('components.icon',['name'=>'clock','size'=>14,'style'=>'color:#F59E0B'])
                        Permintaan perpanjangan sedang ditinjau Admin...
                    </div>
                    @endif
                @endif
            </div>
            @endif

            {{-- 2. UPLOAD BUKTI TRANSFER --}}
            @if($pembayaran->bisaUploadBukti())
            <div class="fcc-card" style="padding:24px;margin-bottom:18px;">
                <h3 style="font-size:16px;font-weight:800;color:#131218;margin:0 0 4px;display:flex;align-items:center;gap:8px;">
                    @include('components.icon',['name'=>'upload','size'=>18,'style'=>'color:#FFC81A'])
                    Upload Foto Bukti Transfer
                </h3>
                <p style="font-size:12px;color:#9CA3B0;margin:0 0 18px">
                    Setelah melakukan transfer, upload foto struk/bukti transfer di bawah ini:
                </p>

                <form action="{{ route('peserta.pembayaran.konfirmasi', $pembayaran) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid-2col" style="margin-bottom:14px;">
                        <div>
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Metode Transfer *
                            </label>
                            <input type="text" name="metode_pembayaran"
                                   placeholder="Transfer Bank / QRIS / m-Banking" required class="fcc-input"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Nama Pengirim (sesuai rekening) *
                            </label>
                            <input type="text" name="nama_pengirim"
                                   placeholder="Nama di rekening asal" required class="fcc-input"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Tanggal Transfer *
                            </label>
                            <input type="date" name="tgl_transfer" required class="fcc-input"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>

                        <div>
                            <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                                Jam Transfer *
                            </label>
                            <input type="time" name="jam_transfer" required class="fcc-input"
                                   onkeydown="if(event.key==='Enter')event.preventDefault();">
                        </div>
                    </div>

                    {{-- Upload Foto Bukti --}}
                    <div style="margin-bottom:20px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.7px;">
                            Foto Bukti Transfer *
                        </label>
                        <div id="upload-area" style="border:2px dashed #E2E4EB;border-radius:12px;
                             padding:24px;text-align:center;cursor:pointer;transition:border-color .2s, background .2s;
                             background:#FAFAFA;position:relative;"
                             onclick="document.getElementById('bukti-input').click()"
                             ondragover="event.preventDefault();this.style.borderColor='#FFC81A';this.style.background='rgba(255,200,26,.02)'"
                             ondragleave="this.style.borderColor='#E2E4EB';this.style.background='#FAFAFA'"
                             ondrop="handleDrop(event)">
                            <div id="upload-placeholder">
                                <div style="width:48px;height:48px;border-radius:12px;background:#F0F1F5;
                                            display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                                    @include('components.icon',['name'=>'image','size'=>24,'style'=>'color:#9CA3B0'])
                                </div>
                                <p style="font-size:14px;font-weight:700;color:#131218;margin:0 0 4px">
                                    Klik atau seret foto bukti di sini
                                </p>
                                <p style="font-size:12px;color:#9CA3B0;margin:0">
                                    Format: JPG, JPEG, PNG, WebP — Maksimal 5 MB
                                </p>
                            </div>
                            <img id="preview-img" src="" alt="Preview"
                                 style="display:none;max-height:220px;max-width:100%;border-radius:8px;object-fit:contain;margin:0 auto;">
                            <input type="file" id="bukti-input" name="bukti_bayar"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   required style="display:none"
                                   onchange="previewImage(this)">
                        </div>
                        @error('bukti_bayar')
                        <p style="color:#EF4444;font-size:12px;margin:6px 0 0">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="fcc-btn-gold"
                            style="width:100%;justify-content:center;padding:13px;font-size:15px;border-radius:10px;font-weight:800;">
                        @include('components.icon',['name'=>'send','size'=>16])
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>

            @elseif($pembayaran->bukti_bayar)
            {{-- BUKTI TRANSFER SUDAH DIKIRIM --}}
            <div class="fcc-card" style="padding:24px;margin-bottom:18px;">
                <h3 style="font-size:15px;font-weight:800;color:#131218;margin:0 0 14px;display:flex;align-items:center;gap:8px;">
                    @include('components.icon',['name'=>'image','size'=>16,'style'=>'color:#10B981'])
                    Foto Bukti Transfer Terkirim
                </h3>
                <div style="background:#F7F8FA;border-radius:12px;padding:12px;text-align:center;border:1px solid #E2E4EB;margin-bottom:14px;">
                    <img src="{{ asset('storage/'.$pembayaran->bukti_bayar) }}"
                         style="max-width:100%;border-radius:8px;max-height:340px;object-fit:contain;"
                         alt="Bukti Transfer">
                </div>
                <div class="form-grid-2col">
                    @foreach([
                        ['Nama Pengirim',$pembayaran->nama_pengirim],
                        ['Tgl Transfer', optional($pembayaran->tgl_transfer)->format('d M Y').' '.$pembayaran->jam_transfer],
                        ['Metode Pembayaran',$pembayaran->metode_pembayaran],
                    ] as [$l,$v])
                    @if($v)
                    <div style="padding:8px 0;border-top:1px solid #F0F1F5;">
                        <p style="color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin:0 0 2px">{{ $l }}</p>
                        <p style="color:#131218;font-size:13px;font-weight:700;margin:0">{{ $v }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

        </div>{{-- end kolom kiri --}}

        {{-- ── KOLOM KANAN: Sidebar Ringkasan & Referensi Kode ──────── --}}
        <div>
            <div class="fcc-card" style="padding:22px;margin-bottom:18px;">
                <h3 style="font-size:15px;font-weight:800;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:8px;">
                    @include('components.icon',['name'=>'file-text','size'=>16,'style'=>'color:#FFC81A'])
                    Ringkasan Transaksi
                </h3>
                @foreach([
                    ['Kode Pembayaran', $pembayaran->kode_pembayaran],
                    ['Kegiatan',Str::limit($pembayaran->pendaftaran->kegiatan->judul, 40)],
                    ['Jenis Kegiatan', ucfirst($pembayaran->pendaftaran->kegiatan->jenis_kegiatan ?? '-')],
                    ['Jenis Biaya', $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Gratis'],
                    ['Nominal Biaya', $pembayaran->jumlah_bayar_format],
                    ['Kode Unik', $pembayaran->kode_unik ?? '-'],
                ] as [$l,$v])
                <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:10px 0;border-top:1px solid #F0F1F5;gap:10px;">
                    <span style="color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;flex-shrink:0;">{{ $l }}</span>
                    <span style="color:#131218;font-size:13px;font-weight:700;text-align:right;">{{ $v }}</span>
                </div>
                @endforeach

                {{-- Total Transfer Highlight --}}
                @if($pembayaran->kode_unik)
                <div style="background:linear-gradient(135deg,#131218,#1C1B22);border-radius:12px;padding:16px;margin-top:14px;text-align:center;">
                    <p style="color:rgba(255,255,255,.55);font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin:0 0 4px">
                        Total Wajib Ditransfer
                    </p>
                    <p style="color:#FFC81A;font-size:22px;font-weight:900;font-family:monospace;letter-spacing:1px;margin:0">
                        {{ $pembayaran->nominal_transfer_format }}
                    </p>
                </div>
                @endif

                <div style="margin-top:16px;">
                    <a href="{{ route('peserta.pembayaran.invoice', $pembayaran) }}" target="_blank"
                       class="fcc-btn-outline-dark"
                       style="width:100%;justify-content:center;padding:11px;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:6px;border-radius:10px;font-weight:700;">
                        @include('components.icon',['name'=>'download','size'=>14]) Unduh Invoice (PDF)
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
function previewImage(input) {
    const file = input.files[0];
    if (!file) return;
    if (!file.type.startsWith('image/')) {
        fccToast('Hanya file gambar yang diizinkan (JPG, PNG, WebP)', 'error');
        input.value = '';
        return;
    }
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('preview-img').style.display = 'block';
        document.getElementById('upload-placeholder').style.display = 'none';
    };
    reader.readAsDataURL(file);
}
function handleDrop(e) {
    e.preventDefault();
    document.getElementById('upload-area').style.borderColor = '#E2E4EB';
    const file = e.dataTransfer.files[0];
    if (!file) return;
    const inp = document.getElementById('bukti-input');
    const dt  = new DataTransfer();
    dt.items.add(file);
    inp.files = dt.files;
    previewImage(inp);
}
</script>
@endpush
