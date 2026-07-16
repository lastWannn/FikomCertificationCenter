@extends('layouts.admin')
@section('title','Detail Pembayaran')
@section('page-content')
<div style="padding:24px;">

    {{-- ── HEADER + AKSI ─────────────────────────────────────── --}}
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
                    <input type="text" name="no_kwitansi" placeholder="No. Kwitansi (opsional)"
                           class="fcc-input" style="width:190px;font-size:13px;">
                    <button type="submit" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;"
                            onclick="return fccConfirm({title:'Verifikasi Pembayaran?',msg:'Pembayaran akan ditandai terverifikasi dan peserta diberitahu via email.',action:'{{ route('admin.pembayaran.verifikasi', $pembayaran) }}',btnText:'Ya, Verifikasi',danger:false})||true">
                        @include('components.icon',['name'=>'check','size'=>14]) Verifikasi
                    </button>
                </form>
                {{-- Tolak --}}
                <button onclick="document.getElementById('form-tolak').style.display='block'"
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
                <textarea name="alasan" rows="3" placeholder="Misal: foto tidak terbaca, nominal tidak sesuai..."
                          class="fcc-input" style="resize:none;font-size:13px;"></textarea>
            </div>
            <div style="display:flex;gap:8px;">
                <button type="submit" style="padding:9px 18px;border-radius:10px;border:none;
                        background:#EF4444;color:#FFF;font-size:13px;font-weight:700;cursor:pointer;">
                    Konfirmasi Tolak
                </button>
                <button type="button" onclick="document.getElementById('form-tolak').style.display='none'"
                        class="fcc-btn-outline-dark" style="padding:9px 14px;font-size:13px;">
                    Batal
                </button>
            </div>
        </form>
    </div>

    {{-- ── PANEL PERPANJANGAN (jika ada request pending) ────────── --}}
    @if($pembayaran->status_perpanjangan === 'menunggu')
    <div style="background:rgba(245,158,11,.06);border:1.5px solid rgba(245,158,11,.25);
                border-radius:14px;padding:22px;margin-bottom:18px;">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
            <div style="width:38px;height:38px;border-radius:10px;background:rgba(245,158,11,.12);
                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                @include('components.icon',['name'=>'clock','size'=>18,'style'=>'color:#F59E0B'])
            </div>
            <div>
                <p style="font-size:14px;font-weight:800;color:#B45309;margin:0">
                    Permintaan Perpanjangan Waktu Bayar
                </p>
                <p style="font-size:12px;color:#92400E;margin:0">
                    Diterima {{ $pembayaran->request_perpanjangan_at?->diffForHumans() }}
                    ({{ $pembayaran->request_perpanjangan_at?->format('d M Y H:i') }})
                </p>
            </div>
        </div>

        @if($pembayaran->alasan_perpanjangan)
        <div style="background:#FFF;border:1px solid rgba(245,158,11,.2);border-radius:8px;
                    padding:12px 14px;margin-bottom:16px;">
            <p style="font-size:11px;font-weight:700;color:#9CA3B0;text-transform:uppercase;
                       letter-spacing:.7px;margin:0 0 4px">Alasan dari Peserta</p>
            <p style="font-size:13px;color:#131218;margin:0">{{ $pembayaran->alasan_perpanjangan }}</p>
        </div>
        @endif

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
            {{-- Approve --}}
            <div style="background:#FFF;border:1px solid rgba(16,185,129,.2);border-radius:12px;padding:18px;">
                <p style="font-size:13px;font-weight:800;color:#059669;margin:0 0 12px;">
                    ✓ Setujui Perpanjangan
                </p>
                <form action="{{ route('admin.pembayaran.approve-perpanjangan', $pembayaran) }}" method="POST">
                    @csrf
                    <div style="margin-bottom:10px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px">
                            Tambah Waktu *
                        </label>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <input type="number" name="jam_tambah" value="2" min="1" max="72"
                                   class="fcc-input" style="width:80px;text-align:center;">
                            <span style="font-size:13px;color:#6B7280;font-weight:600">jam</span>
                        </div>
                    </div>
                    <div style="margin-bottom:12px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px">
                            Catatan (opsional)
                        </label>
                        <input type="text" name="catatan" placeholder="Pesan untuk peserta..."
                               class="fcc-input" style="font-size:13px;">
                    </div>
                    <button type="submit"
                            style="width:100%;padding:9px;border-radius:9px;border:none;
                                   background:#10B981;color:#FFF;font-size:13px;font-weight:700;cursor:pointer;
                                   display:flex;align-items:center;justify-content:center;gap:6px;">
                        @include('components.icon',['name'=>'check','size'=>14]) Setujui
                    </button>
                </form>
            </div>

            {{-- Tolak Perpanjangan --}}
            <div style="background:#FFF;border:1px solid rgba(239,68,68,.2);border-radius:12px;padding:18px;">
                <p style="font-size:13px;font-weight:800;color:#DC2626;margin:0 0 12px;">
                    ✕ Tolak Perpanjangan
                </p>
                <form action="{{ route('admin.pembayaran.tolak-perpanjangan', $pembayaran) }}" method="POST">
                    @csrf
                    <div style="margin-bottom:12px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px">
                            Alasan Penolakan
                        </label>
                        <textarea name="catatan" rows="3" placeholder="Alasan penolakan..."
                                  class="fcc-input" style="resize:none;font-size:13px;"></textarea>
                    </div>
                    <button type="submit"
                            style="width:100%;padding:9px;border-radius:9px;border:none;
                                   background:#EF4444;color:#FFF;font-size:13px;font-weight:700;cursor:pointer;
                                   display:flex;align-items:center;justify-content:center;gap:6px;">
                        @include('components.icon',['name'=>'x','size'=>14]) Tolak
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- ── KONTEN UTAMA ─────────────────────────────────────────── --}}
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:18px;">

        {{-- Kiri: Info peserta + Bukti --}}
        <div>
            <div class="fcc-card" style="padding:24px;margin-bottom:16px;">
                <h3 style="font-size:15px;font-weight:800;color:#131218;margin:0 0 16px">
                    Informasi Peserta & Kegiatan
                </h3>
                @foreach([
                    ['Nama Peserta',  $pembayaran->pendaftaran->peserta->nama],
                    ['Email',         $pembayaran->pendaftaran->peserta->email],
                    ['No. HP',        $pembayaran->pendaftaran->peserta->no_hp],
                    ['Kegiatan',      Str::limit($pembayaran->pendaftaran->kegiatan->judul, 50)],
                    ['Jenis Kegiatan',ucfirst($pembayaran->pendaftaran->kegiatan->jenis_kegiatan ?? '-')],
                    ['Jenis Biaya',   $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Gratis'],
                ] as [$l,$v])
                <div style="display:flex;gap:14px;padding:9px 0;border-top:1px solid #F0F1F5;">
                    <span style="min-width:130px;color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;flex-shrink:0">{{ $l }}</span>
                    <span style="color:#131218;font-size:13px;font-weight:600">{{ $v }}</span>
                </div>
                @endforeach
            </div>

            @if($pembayaran->bukti_bayar)
            <div class="fcc-card" style="padding:24px;">
                <h3 style="font-size:15px;font-weight:800;color:#131218;margin:0 0 14px">
                    @include('components.icon',['name'=>'image','size'=>15,'style'=>'color:#FFC81A'])
                    Foto Bukti Transfer
                </h3>
                <img src="{{ asset('storage/'.$pembayaran->bukti_bayar) }}"
                     style="max-width:100%;border-radius:10px;border:1px solid #E2E4EB;
                            max-height:380px;object-fit:contain;"
                     alt="Bukti Transfer">
                <div style="margin-top:14px;">
                    @foreach([
                        ['Nama Pengirim', $pembayaran->nama_pengirim],
                        ['Tgl Transfer',  optional($pembayaran->tgl_transfer)->format('d M Y').' '.$pembayaran->jam_transfer],
                        ['Metode',        $pembayaran->metode_pembayaran],
                    ] as [$l,$v])
                    @if($v)
                    <div style="display:flex;justify-content:space-between;padding:8px 0;
                                border-top:1px solid #F0F1F5;font-size:13px;">
                        <span style="color:#9CA3B0;font-weight:700;text-transform:uppercase;font-size:11px;letter-spacing:.5px">{{ $l }}</span>
                        <span style="color:#131218;font-weight:600">{{ $v }}</span>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Kanan: Ringkasan keuangan --}}
        <div>
            <div class="fcc-card" style="padding:22px;margin-bottom:14px;">
                <h3 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 16px">
                    Ringkasan Pembayaran
                </h3>

                @foreach([
                    ['Nominal Biaya',   $pembayaran->jumlah_bayar_format],
                    ['Kode Unik',       $pembayaran->kode_unik ?? '-'],
                    ['Total Transfer',  $pembayaran->nominal_transfer_format],
                    ['Metode',          $pembayaran->metode_pembayaran ?? '-'],
                    ['Batas Bayar',     $pembayaran->tgl_kadaluarsa?->format('d M Y H:i')],
                ] as [$l,$v])
                <div style="display:flex;justify-content:space-between;align-items:center;
                            padding:9px 0;border-top:1px solid #F0F1F5;">
                    <span style="color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">{{ $l }}</span>
                    <span style="color:#131218;font-size:13px;font-weight:700;">{{ $v }}</span>
                </div>
                @endforeach

                {{-- Keterangan kode unik --}}
                @if($pembayaran->kode_unik)
                <div style="background:#F7F8FA;border:1px solid #E2E4EB;border-radius:9px;
                            padding:10px 12px;margin-top:12px;font-size:11px;color:#6B7280;line-height:1.6">
                    <strong style="color:#131218">Kode Unik: {{ $pembayaran->kode_unik }}</strong><br>
                    Digit 1:
                    @if(str_starts_with($pembayaran->kode_unik,'1'))
                        <span style="color:#FFC81A;font-weight:700">1 = Pelatihan</span>
                    @else
                        <span style="color:#3B82F6;font-weight:700">2 = Sertifikasi</span>
                    @endif
                    <br>Digit 2–3: acak ({{ substr($pembayaran->kode_unik,1) }})
                </div>
                @endif

                {{-- Status badge --}}
                @php
                $sc = match($pembayaran->status_pembayaran) {
                    'terverifikasi'       => ['#10B981','Terverifikasi'],
                    'menunggu_verifikasi' => ['#F59E0B','Menunggu Verifikasi'],
                    'ditolak'             => ['#EF4444','Ditolak'],
                    'kadaluarsa'          => ['#6B7280','Kadaluarsa'],
                    default               => ['#3B82F6','Menunggu Bayar'],
                };
                @endphp
                <div style="margin-top:14px;background:{{ $sc[0] }}12;border:1px solid {{ $sc[0] }}30;
                            border-radius:10px;padding:12px;text-align:center;">
                    <p style="color:{{ $sc[0] }};font-size:14px;font-weight:800;margin:0">
                        {{ $sc[1] }}
                    </p>
                    @if($pembayaran->status_perpanjangan === 'menunggu')
                    <p style="color:#F59E0B;font-size:11px;font-weight:700;margin:4px 0 0">
                        + Request Perpanjangan Pending
                    </p>
                    @endif
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
@endsection
