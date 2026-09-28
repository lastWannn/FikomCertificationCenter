@extends('layouts.admin')
@section('title','Detail Pembayaran - ' . $pembayaran->kode_pembayaran)

@section('page-content')
<style>
  .admin-detail-pembayaran-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 375px;
    gap: 20px;
    align-items: start;
  }
  @media (max-width: 1024px) {
    .admin-detail-pembayaran-grid {
      grid-template-columns: 1fr;
    }
  }

  /* Split layout pada card bukti bayar: Kiri Gambar, Kanan Informasi Pengirim */
  .proof-split-grid {
    display: grid;
    grid-template-columns: 310px 1fr;
    gap: 24px;
    align-items: stretch;
  }
  @media (max-width: 820px) {
    .proof-split-grid {
      grid-template-columns: 1fr;
    }
  }

  /* Frame Foto Bukti Transfer: Bersih, Rapi & Proporsional */
  .proof-photo-box {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    background: #F8FAFC;
    cursor: zoom-in;
    width: 100%;
    max-width: 310px;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  }
  .proof-photo-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.09);
    border-color: #CBD5E1;
  }
  .proof-img-natural {
    width: 100%;
    height: auto;
    display: block;
    object-fit: contain;
  }

  /* Panel Informasi Pengirim Transfer (Kanan) */
  .sender-info-panel {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 16px 18px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    box-sizing: border-box;
  }
  .sender-field-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-top: 1px solid #EEF2F6;
    font-size: 13px;
  }
  .sender-field-row:first-of-type {
    border-top: none;
    padding-top: 2px;
  }
  .sender-field-label {
    color: #64748B;
    font-weight: 700;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .sender-field-val {
    color: #0F172A;
    font-weight: 700;
    text-align: right;
  }

  /* Lightbox Modal Minimalis */
  .fcc-lightbox-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 999999;
    background: rgba(10, 11, 16, 0.94);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    flex-direction: column;
    padding: 16px;
    box-sizing: border-box;
    overflow: hidden;
  }
  .lightbox-topbar {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    color: #FFFFFF;
    flex-shrink: 0;
  }
  .lb-ctrl-btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
    height: 34px;
    padding: 0 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.15s;
  }
  .lb-ctrl-btn:hover {
    background: rgba(255, 200, 26, 0.2);
    border-color: #FFC81A;
    color: #FFC81A;
  }
  .lb-close-btn {
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.4);
    color: #EF4444;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    font-size: 17px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    transition: all 0.15s;
  }
  .lb-close-btn:hover {
    background: #EF4444;
    color: #FFFFFF;
    border-color: #EF4444;
  }
  .lightbox-viewport {
    flex: 1;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: auto;
    position: relative;
    user-select: none;
  }
  .lightbox-image-target {
    max-width: 90vw;
    max-height: 85vh;
    border-radius: 10px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.9), 0 0 30px rgba(255, 200, 26, 0.15);
    object-fit: contain;
  }
</style>

<div style="padding:24px;">

    {{-- ── 1. HEADER + AKSI ─────────────────────────────────────── --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.pembayaran.index') }}"
           style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:14px;">
            <div>
                <h1 style="font-size:20px;font-weight:900;color:#131218;margin:0 0 4px">Detail Pembayaran</h1>
                <p style="color:#FFC81A;font-size:14px;font-weight:700;font-family:monospace;margin:0">
                    {{ $pembayaran->kode_pembayaran }}
                </p>
            </div>

            {{-- AKSI berdasarkan status --}}
            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">

                @if($pembayaran->status_pembayaran === 'menunggu_verifikasi')
                {{-- Verifikasi --}}
                <form action="{{ route('admin.pembayaran.verifikasi', $pembayaran) }}"
                      method="POST" style="display:flex;gap:8px;align-items:center;">
                    @csrf
                    <input type="text" name="no_kwitansi" placeholder="No. Kwitansi (Auto Generate)"
                           class="fcc-input" style="width:210px;font-size:12.5px;">
                    <button type="button" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;"
                            onclick="fccConfirmAction(this, 'Verifikasi Pembayaran?', 'Pembayaran akan ditandai terverifikasi dan peserta diberitahu via email.', 'Ya, Verifikasi', false)">
                        @include('components.icon',['name'=>'check','size'=>14]) Verifikasi
                    </button>
                </form>
                {{-- Tolak --}}
                <button type="button" onclick="document.getElementById('form-tolak').style.display='block'"
                        style="padding:9px 16px;border-radius:10px;border:1.5px solid rgba(239,68,68,.3);
                               background:rgba(239,68,68,.07);color:#EF4444;font-size:13px;
                               font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
                    @include('components.icon',['name'=>'x','size'=>14]) Tolak
                </button>

                @elseif($pembayaran->status_perpanjangan === 'menunggu')
                {{-- Badge permintaan perpanjangan pending --}}
                <div style="background:rgba(245,158,11,.1);border:1.5px solid rgba(245,158,11,.3);
                            border-radius:10px;padding:8px 14px;display:flex;align-items:center;gap:8px;">
                    @include('components.icon',['name'=>'clock','size'=>15,'style'=>'color:#F59E0B'])
                    <span style="font-size:13px;font-weight:700;color:#B45309">
                        Ada Permintaan Perpanjangan
                    </span>
                </div>

                @elseif($pembayaran->status_pembayaran === 'kadaluarsa')
                <form action="{{ route('admin.pembayaran.perpanjang', $pembayaran) }}" method="POST">
                    @csrf
                    <button type="submit" style="padding:9px 16px;border-radius:10px;border:1.5px solid rgba(255,200,26,.3);
                                                background:rgba(255,200,26,.08);color:#B38F00;font-size:13px;
                                                font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;">
                        @include('components.icon',['name'=>'refresh-cw','size'=>13]) Perpanjang +2 Jam
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    {{-- ── FORM TOLAK PEMBAYARAN (tersembunyi) ─────────────────── --}}
    <div id="form-tolak" style="display:none;background:#FFF8F8;border:1.5px solid rgba(239,68,68,.2);
                                border-radius:12px;padding:20px 22px;margin-bottom:18px;">
        <p style="font-size:14px;font-weight:800;color:#DC2626;margin:0 0 12px">Tolak Pembayaran</p>
        <form action="{{ route('admin.pembayaran.tolak', $pembayaran) }}" method="POST">
            @csrf
            <div style="margin-bottom:12px;">
                <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px">
                    Alasan Penolakan (opsional)
                </label>
                <textarea name="alasan" rows="2" placeholder="Jelaskan alasan penolakan (misal: bukti tidak jelas, nominal tidak sesuai)..."
                          class="fcc-input" style="resize:none;font-size:13px;width:100%"></textarea>
            </div>
            <div style="display:flex;gap:8px">
                <button type="submit" style="padding:8px 18px;border-radius:8px;border:none;background:#EF4444;color:#FFF;font-size:13px;font-weight:700;cursor:pointer">
                    Konfirmasi Tolak
                </button>
                <button type="button" onclick="document.getElementById('form-tolak').style.display='none'"
                        class="fcc-btn-outline-dark" style="padding:8px 16px;font-size:13px">
                    Batal
                </button>
            </div>
        </form>
    </div>

    {{-- ── PANEL PERPANJANGAN WAKTU (jika ada request) ─────────── --}}
    @if($pembayaran->status_perpanjangan === 'menunggu')
    <div style="background:#FFFDF5;border:1.5px solid #FCD34D;border-radius:14px;padding:18px 22px;margin-bottom:20px;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:14px;">
            <div>
                <div style="display:flex;align-items:center;gap:8px;">
                    @include('components.icon',['name'=>'clock','size'=>18,'style'=>'color:#D97706'])
                    <span style="font-size:15px;font-weight:900;color:#92400E">Permintaan Perpanjangan Waktu (+2 Jam)</span>
                </div>
                <p style="font-size:12.5px;color:#78350F;margin:4px 0 0 26px">
                    Diajukan pada: <strong>{{ $pembayaran->request_perpanjangan_at?->format('d M Y H:i') }}</strong>
                    ({{ $pembayaran->request_perpanjangan_at?->diffForHumans() }})
                </p>
            </div>
        </div>

        <div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:10px;padding:12px 16px;margin-bottom:14px;">
            <span style="font-size:11px;font-weight:700;color:#B45309;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:3px">Alasan Peserta:</span>
            <p style="font-size:13.5px;color:#1E293B;margin:0;font-weight:600">
                "{{ $pembayaran->alasan_perpanjangan ?: 'Tidak ada alasan khusus.' }}"
            </p>
        </div>

        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            {{-- Setujui form --}}
            <form action="{{ route('admin.pembayaran.approve-perpanjangan', $pembayaran) }}" method="POST">
                @csrf
                <input type="hidden" name="jam_tambah" value="2">
                <button type="submit" style="background:#10B981;color:#FFF;border:none;padding:8px 20px;font-size:13px;font-weight:800;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                    ✓ Setujui (+2 Jam)
                </button>
            </form>

            {{-- Tolak Inline Form --}}
            <form action="{{ route('admin.pembayaran.tolak-perpanjangan', $pembayaran) }}" method="POST" style="background:#FFF;border:1px solid #FCA5A5;border-radius:12px;padding:10px 14px;display:flex;align-items:center;gap:8px;">
                @csrf
                <input type="text" name="catatan" placeholder="Alasan penolakan..." class="fcc-input" required style="flex:1;padding:6px 10px;font-size:12px;min-width:0;">
                <button type="submit" style="background:#EF4444;color:#FFF;border:none;padding:7px 16px;font-size:12px;font-weight:800;border-radius:8px;cursor:pointer;white-space:nowrap;flex-shrink:0;display:inline-flex;align-items:center;gap:4px;">
                    ✕ Tolak
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- ── 2. KONTEN UTAMA (GRID 2 KOLOM SESUAI GAMBAR) ────────────── --}}
    <div class="admin-detail-pembayaran-grid">

        {{-- ── KOLOM KIRI (LEBAR: FOTO BUKTI & INFORMASI PENGIRIM) ── --}}
        <div>

            {{-- Card 2: Foto Bukti Transfer (Dua Section: Kiri Gambar/Bukti & Kanan Informasi Pengirim) --}}
            @if($pembayaran->bukti_bayar)
            <div class="fcc-card" style="padding:22px 24px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <h3 style="font-size:15px;font-weight:800;color:#131218;margin:0;display:flex;align-items:center;gap:6px;">
                        @include('components.icon',['name'=>'image','size'=>15,'style'=>'color:#FFC81A'])
                        Foto Bukti &amp; Data Pengirim Transfer
                    </h3>
                    <div style="display:flex;gap:6px;">
                        <button type="button" onclick="openPaymentLightbox('{{ asset('storage/'.$pembayaran->bukti_bayar) }}')"
                                style="background:#F7F8FA;border:1px solid #E2E4EB;color:#334155;padding:5px 12px;font-size:12px;font-weight:700;border-radius:6px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'eye','size'=>12]) Perbesar
                        </button>
                        <a href="{{ asset('storage/'.$pembayaran->bukti_bayar) }}" target="_blank"
                           style="background:#F7F8FA;border:1px solid #E2E4EB;color:#334155;padding:5px 12px;font-size:12px;font-weight:700;border-radius:6px;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
                            @include('components.icon',['name'=>'download','size'=>12]) Tab Baru
                        </a>
                    </div>
                </div>

                {{-- Dua Section: Kiri Gambar Bukti, Kanan Informasi Pengirim --}}
                <div class="proof-split-grid">
                    {{-- Section Kiri: Gambar Bukti Bayar --}}
                    <div style="display:flex;flex-direction:column;align-items:center;">
                        <div class="proof-photo-box" onclick="openPaymentLightbox('{{ asset('storage/'.$pembayaran->bukti_bayar) }}')" title="Klik untuk membuka ukuran penuh">
                            <img src="{{ asset('storage/'.$pembayaran->bukti_bayar) }}"
                                 alt="Bukti Transfer {{ $pembayaran->kode_pembayaran }}"
                                 class="proof-img-natural">
                        </div>
                        <span style="font-size:11px;color:#94A3B8;margin-top:8px;font-weight:600;display:flex;align-items:center;gap:4px;">
                            @include('components.icon',['name'=>'check-circle','size'=>12,'style'=>'color:#10B981'])
                            Struk Asli &bull; Resolusi Penuh di Lightbox
                        </span>
                    </div>

                    {{-- Section Kanan: Panel Informasi Pengirim Transfer --}}
                    <div class="sender-info-panel">
                        <div>
                            <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:10px;margin-bottom:6px;border-bottom:1px solid #E2E8F0;">
                                <span style="font-size:11.5px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;display:flex;align-items:center;gap:6px;">
                                    @include('components.icon',['name'=>'user-check','size'=>13,'style'=>'color:#FFC81A'])
                                    Informasi Pengirim
                                </span>
                                <span style="font-size:10.5px;font-weight:800;color:#059669;background:#ECFDF5;padding:2px 8px;border-radius:6px;border:1px solid #A7F3D0;">
                                    Sesuai Struk
                                </span>
                            </div>

                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'user','size'=>12]) Nama Pengirim
                                </span>
                                <span class="sender-field-val" style="font-size:13.5px;color:#0F172A;">
                                    {{ $pembayaran->nama_pengirim ?: '-' }}
                                </span>
                            </div>

                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'calendar','size'=>12]) Waktu Transfer
                                </span>
                                <span class="sender-field-val">
                                    {{ optional($pembayaran->tgl_transfer)->format('d M Y') ?: '-' }}
                                    @if($pembayaran->jam_transfer)
                                        <span style="color:#64748B;font-weight:600;font-size:12px;margin-left:3px;">({{ $pembayaran->jam_transfer }})</span>
                                    @endif
                                </span>
                            </div>

                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'credit-card','size'=>12]) Jenis Pembayaran
                                </span>
                                <span class="sender-field-val">
                                    <span style="background:rgba(255,200,26,0.18);border:1px solid rgba(255,200,26,0.5);color:#92400E;padding:2px 9px;border-radius:6px;font-size:11px;font-weight:800;text-transform:uppercase;">
                                        {{ $pembayaran->metode_pembayaran ?: '-' }}
                                    </span>
                                </span>
                            </div>

                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'building','size'=>12]) Layanan / Bank
                                </span>
                                <span class="sender-field-val">
                                    {{ $pembayaran->nama_layanan_bank ?: '-' }}
                                </span>
                            </div>

                            @if($pembayaran->no_referensi)
                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'tag','size'=>12]) No. Referensi
                                </span>
                                <span class="sender-field-val" style="font-family:'SF Mono', Monaco, monospace;font-size:12px;">
                                    {{ $pembayaran->no_referensi }}
                                </span>
                            </div>
                            @endif

                            @if($pembayaran->berita_transaksi)
                            <div class="sender-field-row">
                                <span class="sender-field-label">
                                    @include('components.icon',['name'=>'file-text','size'=>12]) Catatan / Berita
                                </span>
                                <span class="sender-field-val" style="font-size:12px;color:#475569;font-weight:600;">
                                    {{ $pembayaran->berita_transaksi }}
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Box kecocokan nominal untuk menyeimbangkan tinggi kolom kanan dengan foto di kiri --}}
                        <div style="background:#FFFFFF;border:1px solid #E2E8F0;border-radius:10px;padding:11px 13px;margin-top:14px;box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
                                <span style="font-size:10.5px;font-weight:700;color:#64748B;text-transform:uppercase;letter-spacing:0.4px;">Total Ditagihkan:</span>
                                <span style="font-size:13.5px;font-weight:900;color:#B45309;font-family:'SF Mono',Monaco,monospace;">
                                    {{ $pembayaran->nominal_transfer_format }}
                                </span>
                            </div>
                            <p style="margin:0;font-size:11px;color:#64748B;line-height:1.4;">
                                Pastikan nominal pada foto struk di sebelah kiri cocok dengan mutasi bank Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="fcc-card" style="padding:28px;text-align:center;color:#9CA3B0;">
                @include('components.icon',['name'=>'image','size'=>32])
                <p style="margin:8px 0 0;font-size:13px;font-weight:600">Belum ada bukti transfer yang diunggah.</p>
            </div>
            @endif
        </div>

        {{-- ── KOLOM KANAN (SIDEBAR: INFORMASI PESERTA & RINGKASAN PEMBAYARAN) ── --}}
        <div>
            {{-- Card 1: Informasi Peserta & Kegiatan --}}
            <div class="fcc-card" style="padding:22px;margin-bottom:14px;">
                <h3 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                    @include('components.icon',['name'=>'user-check','size'=>15,'style'=>'color:#FFC81A'])
                    Informasi Peserta &amp; Kegiatan
                </h3>

                @foreach([
                    ['Nama Peserta',  $pembayaran->pendaftaran->peserta->nama],
                    ['Email',         $pembayaran->pendaftaran->peserta->email],
                    ['No. HP',        $pembayaran->pendaftaran->peserta->no_hp ?: '-'],
                    ['Kegiatan',      Str::limit($pembayaran->pendaftaran->kegiatan->judul, 35)],
                    ['Jenis Kegiatan',ucfirst($pembayaran->pendaftaran->kegiatan->jenis_kegiatan ?? '-')],
                    ['Jenis Biaya',   $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Gratis'],
                ] as [$l,$v])
                <div style="display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-top:1px solid #F0F1F5;">
                    <span style="color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;flex-shrink:0;">{{ $l }}</span>
                    <span style="color:#131218;font-size:13px;font-weight:700;text-align:right;max-width:65%;word-break:break-word;" title="{{ $l === 'Kegiatan' ? $pembayaran->pendaftaran->kegiatan->judul : '' }}">{{ $v }}</span>
                </div>
                @endforeach
            </div>

            {{-- Card 2: Ringkasan Pembayaran --}}
            <div class="fcc-card" style="padding:22px;margin-bottom:14px;">
                <h3 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 16px;display:flex;align-items:center;gap:6px;">
                    @include('components.icon',['name'=>'credit-card','size'=>15,'style'=>'color:#FFC81A'])
                    Ringkasan Pembayaran
                </h3>

                @foreach([
                    ['Nominal Biaya',     $pembayaran->jumlah_bayar_format],
                    ['Kode Unik',         $pembayaran->kode_unik ?? '-'],
                    ['Total Transfer',    $pembayaran->nominal_transfer_format],
                    ['Jenis Pembayaran',  $pembayaran->metode_pembayaran ?? '-'],
                    ['Layanan / Bank',    $pembayaran->nama_layanan_bank ?? '-'],
                    ['Batas Bayar',       $pembayaran->tgl_kadaluarsa?->format('d M Y H:i')],
                ] as [$l,$v])
                <div style="display:flex;justify-content:space-between;align-items:center;
                            padding:9px 0;border-top:1px solid #F0F1F5;">
                    <span style="color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;flex-shrink:0;">{{ $l }}</span>
                    <span style="color:#131218;font-size:13px;font-weight:700;text-align:right;">{{ $v }}</span>
                </div>
                @endforeach

                {{-- Status badge --}}
                @php
                $sc = match(true) {
                    $pembayaran->status_perpanjangan === 'menunggu' => ['#D97706', 'Req. Perpanjangan'],
                    $pembayaran->status_pembayaran === 'terverifikasi'       => ['#10B981','Terverifikasi'],
                    $pembayaran->status_pembayaran === 'menunggu_verifikasi' => ['#F59E0B','Menunggu Verifikasi'],
                    $pembayaran->status_pembayaran === 'ditolak'             => ['#EF4444','Ditolak'],
                    $pembayaran->status_pembayaran === 'kadaluarsa'          => ['#6B7280','Kadaluarsa'],
                    default               => ['#3B82F6','Menunggu Bayar'],
                };
                @endphp
                <div style="margin-top:14px;background:{{ $sc[0] }}12;border:1px solid {{ $sc[0] }}30;
                            border-radius:10px;padding:12px;text-align:center;">
                    <p style="color:{{ $sc[0] }};font-size:14px;font-weight:800;margin:0">
                        {{ $sc[1] }}
                    </p>
                </div>
            </div>

            {{-- Cetak PDF --}}
            <a href="{{ route('admin.cetak.invoice', $pembayaran) }}" target="_blank"
               style="display:flex;align-items:center;justify-content:center;gap:6px;
                      padding:10px;border-radius:10px;border:1.5px solid #E2E4EB;
                      background:#F7F8FA;color:#6B7280;font-size:13px;font-weight:700;
                      text-decoration:none;margin-bottom:8px;transition:all .18s;"
               onmouseover="this.style.borderColor='#FFC81A';this.style.color='#131218'"
               onmouseout="this.style.borderColor='#E2E4EB';this.style.color='#6B7280'">
                @include('components.icon',['name'=>'printer','size'=>13]) Cetak Invoice
            </a>
            @if($pembayaran->status_pembayaran === 'terverifikasi')
            <a href="{{ route('admin.cetak.bukti', $pembayaran) }}" target="_blank"
               class="fcc-btn-gold"
               style="display:flex;align-items:center;justify-content:center;gap:6px;
                      padding:10px;font-size:13px;text-decoration:none;">
                @include('components.icon',['name'=>'file-check','size'=>13]) Cetak Bukti Lunas
            </a>
            @endif
        </div>
    </div>
</div>

{{-- ── 3. LIGHTBOX MODAL MINIMALIS ─────────────────────────────── --}}
<div id="fcc-payment-lightbox" class="fcc-lightbox-modal" onclick="handleLightboxBackdropClick(event)">
    <div class="lightbox-topbar" onclick="event.stopPropagation()">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:30px;height:30px;border-radius:7px;background:rgba(255,200,26,0.15);border:1px solid rgba(255,200,26,0.4);display:flex;align-items:center;justify-content:center;color:#FFC81A;">
                @include('components.icon',['name'=>'image','size'=>14])
            </div>
            <div>
                <h4 style="font-size:13.5px;font-weight:800;margin:0;color:#FFFFFF;">Foto Bukti Transfer</h4>
                <p style="font-size:11px;color:#94A3B8;margin:0;">{{ $pembayaran->kode_pembayaran }} &bull; {{ $pembayaran->nama_pengirim ?: $pembayaran->pendaftaran->peserta->nama }}</p>
            </div>
        </div>

        <div style="display:flex;align-items:center;gap:8px;">
            <a id="lightbox-tab-link" href="#" target="_blank" class="lb-ctrl-btn" title="Buka di Tab Baru">
                @include('components.icon',['name'=>'download','size'=>12]) Buka Ukuran Asli
            </a>
            <button type="button" class="lb-close-btn" onclick="closePaymentLightbox()" title="Tutup (ESC)">
                &times;
            </button>
        </div>
    </div>

    <div class="lightbox-viewport" id="lb-viewport">
        <img id="lightbox-preview-img" src="" class="lightbox-image-target" alt="Bukti Transfer Perbesar" onclick="event.stopPropagation()">
    </div>
</div>

<script>
  /* Lightbox Logic */
  function openPaymentLightbox(src) {
    const modal = document.getElementById('fcc-payment-lightbox');
    const img = document.getElementById('lightbox-preview-img');
    const tabLink = document.getElementById('lightbox-tab-link');
    if (!modal || !img) return;

    img.src = src;
    if (tabLink) tabLink.href = src;

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function closePaymentLightbox() {
    const modal = document.getElementById('fcc-payment-lightbox');
    if (!modal) return;
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }

  function handleLightboxBackdropClick(e) {
    if (e.target.id === 'fcc-payment-lightbox' || e.target.id === 'lb-viewport') {
      closePaymentLightbox();
    }
  }

  // Keyboard shortcut: ESC to close
  document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('fcc-payment-lightbox');
    if (!modal || modal.style.display !== 'flex') return;

    if (e.key === 'Escape') {
      closePaymentLightbox();
    }
  });
</script>
@endsection
