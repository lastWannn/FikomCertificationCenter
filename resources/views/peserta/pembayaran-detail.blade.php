@extends('layouts.peserta')
@section('title','Detail Pembayaran')
@section('page-title','Detail Pembayaran')
@section('page-content')

@php
// Status mapping
$sc = match($pembayaran->status_pembayaran) {
    'terverifikasi'       => ['color'=>'#10B981','label'=>'Terverifikasi',
                              'desc'=>'Pembayaran telah diverifikasi Admin. Anda resmi terdaftar!',
                              'icon'=>'check-circle'],
    'menunggu_verifikasi' => ['color'=>'#F59E0B','label'=>'Menunggu Verifikasi',
                              'desc'=>'Bukti transfer sedang ditinjau oleh tim Admin FCC.',
                              'icon'=>'clock'],
    'ditolak'             => ['color'=>'#EF4444','label'=>'Pembayaran Ditolak',
                              'desc'=>'Pembayaran tidak dapat diverifikasi. Lihat keterangan atau hubungi Admin.',
                              'icon'=>'x-circle'],
    'kadaluarsa'          => ['color'=>'#6B7280','label'=>'Kadaluarsa',
                              'desc'=>'Batas waktu habis. Anda dapat meminta perpanjangan atau mengaktifkan kode baru.',
                              'icon'=>'alert-circle'],
    default               => ['color'=>'#3B82F6','label'=>'Menunggu Pembayaran',
                              'desc'=>'Transfer tepat nominal berikut sebelum batas waktu habis.',
                              'icon'=>'credit-card'],
};
$perpStatus = $pembayaran->status_perpanjangan;
@endphp

<div style="padding:24px;max-width:820px;">

    {{-- ── STATUS BANNER ──────────────────────────────────────── --}}
    <div style="background:{{ $sc['color'] }}10;border:1.5px solid {{ $sc['color'] }}35;
                border-radius:14px;padding:18px 22px;margin-bottom:18px;
                display:flex;align-items:center;gap:14px;">
        <div style="width:46px;height:46px;border-radius:13px;background:{{ $sc['color'] }}18;
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @include('components.icon',['name'=>$sc['icon'],'size'=>22,'style'=>"color:{$sc['color']}"])
        </div>
        <div style="flex:1">
            <p style="margin:0 0 3px;font-size:15px;font-weight:800;color:{{ $sc['color'] }}">{{ $sc['label'] }}</p>
            <p style="margin:0;font-size:13px;color:#6B7280">{{ $sc['desc'] }}</p>
        </div>
    </div>

    {{-- ── PERPANJANGAN STATUS BANNER ─────────────────────────── --}}
    @if($perpStatus === 'menunggu')
    <div style="background:rgba(245,158,11,.08);border:1.5px solid rgba(245,158,11,.3);
                border-radius:12px;padding:14px 18px;margin-bottom:16px;
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
                border-radius:12px;padding:14px 18px;margin-bottom:16px;">
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
                border-radius:12px;padding:14px 18px;margin-bottom:16px;">
        <p style="margin:0 0 2px;font-weight:800;color:#059669;font-size:13px">
            ✓ Perpanjangan Disetujui — Batas Waktu Diperpanjang
        </p>
        <p style="margin:0;font-size:12px;color:#065F46">
            Upload bukti transfer sebelum batas waktu baru habis.
        </p>
    </div>
    @endif

    <div style="display:grid;grid-template-columns:3fr 2fr;gap:16px;">

        {{-- ── KOLOM KIRI: Kode + Aksi ─────────────────────────── --}}
        <div>

        {{-- ── PANEL KODE UNIK + COUNTDOWN ────────────────────── --}}
        @if(in_array($pembayaran->status_pembayaran, ['menunggu_pembayaran','kadaluarsa']))
        <div class="fcc-card" style="padding:24px;margin-bottom:14px;">

            {{-- Kode Pembayaran --}}
            <p style="font-size:11px;font-weight:700;color:#9CA3B0;text-align:center;
                       text-transform:uppercase;letter-spacing:1px;margin:0 0 10px">
                Kode Pembayaran
            </p>
            <div style="background:#131218;border-radius:12px;padding:14px 20px;
                        text-align:center;margin-bottom:16px;">
                <p style="color:#FFC81A;font-size:24px;font-weight:900;font-family:monospace;
                           letter-spacing:3px;margin:0">
                    {{ $pembayaran->kode_pembayaran }}
                </p>
            </div>

            {{-- Nominal Transfer dengan Kode Unik --}}
            @if($pembayaran->kode_unik)
            <div style="background:#F7F8FA;border:1px solid #E2E4EB;border-radius:12px;
                        padding:16px 18px;margin-bottom:16px;">
                <p style="font-size:11px;font-weight:700;color:#9CA3B0;text-transform:uppercase;
                           letter-spacing:1px;margin:0 0 12px;text-align:center">
                    Nominal Transfer (Wajib Tepat)
                </p>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap;">
                    <div>
                        <p style="font-size:11px;color:#9CA3B0;margin:0 0 2px">Nominal biaya</p>
                        <p style="font-size:16px;font-weight:700;color:#131218;margin:0;font-family:monospace">
                            {{ $pembayaran->jumlah_bayar_format }}
                        </p>
                    </div>
                    <div style="font-size:20px;color:#C0C4CF;font-weight:300">+</div>
                    <div style="text-align:center">
                        <p style="font-size:11px;color:#9CA3B0;margin:0 0 2px">Kode unik</p>
                        <div style="background:#131218;border-radius:8px;padding:6px 14px;display:inline-block;">
                            <p style="font-size:20px;font-weight:900;color:#FFC81A;
                                       font-family:monospace;letter-spacing:3px;margin:0">
                                {{ $pembayaran->kode_unik }}
                            </p>
                        </div>
                        <p style="font-size:9px;color:#9CA3B0;margin:2px 0 0;text-align:center">
                            @if(str_starts_with($pembayaran->kode_unik,'1'))
                                1 = Pelatihan
                            @else
                                2 = Sertifikasi
                            @endif
                        </p>
                    </div>
                    <div style="font-size:20px;color:#C0C4CF;font-weight:300">=</div>
                    <div style="text-align:right">
                        <p style="font-size:11px;color:#9CA3B0;margin:0 0 2px">Total transfer</p>
                        <p style="font-size:22px;font-weight:900;color:#10B981;margin:0;font-family:monospace">
                            {{ $pembayaran->nominal_transfer_format }}
                        </p>
                    </div>
                </div>
                <div style="background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);
                            border-radius:8px;padding:9px 12px;margin-top:12px;
                            display:flex;align-items:center;gap:8px;">
                    @include('components.icon',['name'=>'info','size'=>13,'style'=>'color:#10B981;flex-shrink:0'])
                    <p style="font-size:12px;color:#059669;margin:0;font-weight:600">
                        Transfer <strong>tepat</strong> {{ $pembayaran->nominal_transfer_format }}
                        agar transaksi dapat diidentifikasi Admin.
                    </p>
                </div>
            </div>
            @endif

            {{-- Countdown Timer --}}
            @if($pembayaran->status_pembayaran === 'menunggu_pembayaran')
            <div style="text-align:center;margin-bottom:16px;">
                <p style="font-size:12px;color:#9CA3B0;margin:0 0 4px">Batas waktu transfer:</p>
                <p id="timer" style="font-size:28px;font-weight:900;color:#EF4444;
                               font-family:monospace;margin:0 0 4px;letter-spacing:2px">--:--:--</p>
                <p style="font-size:11px;color:#9CA3B0;margin:0">
                    {{ $pembayaran->tgl_kadaluarsa?->format('d M Y H:i') }} WITA
                </p>
            </div>
            @endif

            {{-- Tombol aksi: aktifkan / request perpanjangan --}}
            @if($pembayaran->status_pembayaran === 'kadaluarsa' || $pembayaran->minutes_left <= 0)

                @if($pembayaran->bisaRequestPerpanjangan())
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:4px;">
                    {{-- Aktifkan kode baru --}}
                    <form action="{{ route('peserta.pembayaran.aktifkan', $pembayaran) }}" method="POST">
                        @csrf
                        <button type="submit" class="fcc-btn-dark"
                                style="width:100%;justify-content:center;padding:10px;font-size:13px;">
                            @include('components.icon',['name'=>'refresh-cw','size'=>13])
                            Aktifkan Kode Baru
                        </button>
                    </form>
                    {{-- Minta perpanjangan --}}
                    <button onclick="document.getElementById('form-perpanjangan').style.display='block';this.style.display='none'"
                            class="fcc-btn-outline-dark"
                            style="width:100%;justify-content:center;padding:10px;font-size:13px;">
                        @include('components.icon',['name'=>'clock','size'=>13])
                        Minta Perpanjangan
                    </button>
                </div>

                {{-- Form minta perpanjangan (tersembunyi) --}}
                <div id="form-perpanjangan" style="display:none;margin-top:12px;
                     background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;padding:16px;">
                    <p style="font-size:13px;font-weight:700;color:#131218;margin:0 0 10px">
                        Alasan Permintaan Perpanjangan
                    </p>
                    <form action="{{ route('peserta.pembayaran.request-perpanjangan', $pembayaran) }}" method="POST">
                        @csrf
                        <textarea name="alasan" rows="3" placeholder="Tuliskan alasan perpanjangan (opsional)..."
                                  class="fcc-input" style="resize:none;margin-bottom:10px;font-size:13px;"></textarea>
                        <div style="display:flex;gap:8px;">
                            <button type="submit" class="fcc-btn-gold" style="flex:1;justify-content:center;padding:9px;font-size:13px;">
                                @include('components.icon',['name'=>'send','size'=>13]) Kirim Permintaan
                            </button>
                            <button type="button" onclick="document.getElementById('form-perpanjangan').style.display='none'"
                                    class="fcc-btn-outline-dark" style="padding:9px 14px;font-size:13px;">
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

        {{-- ── UPLOAD BUKTI TRANSFER (gambar only) ─────────────── --}}
        @if($pembayaran->bisaUploadBukti())
        <div class="fcc-card" style="padding:24px;margin-bottom:14px;">
            <h3 style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px">
                @include('components.icon',['name'=>'upload','size'=>16,'style'=>'color:#FFC81A'])
                Upload Foto Bukti Transfer
            </h3>
            <p style="font-size:12px;color:#9CA3B0;margin:0 0 16px">
                Pastikan transfer tepat <strong style="color:#131218">{{ $pembayaran->nominal_transfer_format }}</strong>
            </p>

            <form action="{{ route('peserta.pembayaran.konfirmasi', $pembayaran) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf

                @foreach([
                    ['metode_pembayaran','Metode Transfer *','text','Transfer Bank / QRIS / m-Banking'],
                    ['nama_pengirim','Nama Pengirim (sesuai rekening) *','text','Nama di rekening asal'],
                    ['tgl_transfer','Tanggal Transfer *','date',''],
                    ['jam_transfer','Jam Transfer *','time',''],
                ] as [$name,$label,$type,$placeholder])
                <div style="margin-bottom:12px;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;
                                  margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">
                        {{ $label }}
                    </label>
                    <input type="{{ $type }}" name="{{ $name }}"
                           placeholder="{{ $placeholder }}" required class="fcc-input"
                           onkeydown="if(event.key==='Enter')event.preventDefault();">
                </div>
                @endforeach

                {{-- Upload gambar --}}
                <div style="margin-bottom:18px;">
                    <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;
                                  margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">
                        Foto Bukti Transfer *
                    </label>
                    <div id="upload-area" style="border:2px dashed #E2E4EB;border-radius:10px;
                         padding:20px;text-align:center;cursor:pointer;transition:border-color .2s;
                         background:#FAFAFA;position:relative;"
                         onclick="document.getElementById('bukti-input').click()"
                         ondragover="event.preventDefault();this.style.borderColor='#FFC81A'"
                         ondragleave="this.style.borderColor='#E2E4EB'"
                         ondrop="handleDrop(event)">
                        <div id="upload-placeholder">
                            <div style="width:44px;height:44px;border-radius:12px;background:#F0F1F5;
                                        display:flex;align-items:center;justify-content:center;margin:0 auto 10px;">
                                @include('components.icon',['name'=>'image','size'=>22,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:13px;font-weight:700;color:#131218;margin:0 0 4px">
                                Klik atau seret foto di sini
                            </p>
                            <p style="font-size:11px;color:#9CA3B0;margin:0">
                                JPG, JPEG, PNG, WebP — Maks. 5 MB
                            </p>
                        </div>
                        <img id="preview-img" src="" alt="Preview"
                             style="display:none;max-height:200px;max-width:100%;border-radius:8px;object-fit:contain;">
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
                        style="width:100%;justify-content:center;padding:12px;font-size:14px;">
                    @include('components.icon',['name'=>'send','size'=>15])
                    Kirim Bukti Pembayaran
                </button>
            </form>
        </div>

        @elseif($pembayaran->bukti_bayar)
        {{-- Bukti sudah dikirim --}}
        <div class="fcc-card" style="padding:22px;margin-bottom:14px;">
            <h3 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 12px">
                @include('components.icon',['name'=>'image','size'=>15,'style'=>'color:#10B981'])
                Foto Bukti Transfer
            </h3>
            <img src="{{ asset('storage/'.$pembayaran->bukti_bayar) }}"
                 style="width:100%;border-radius:10px;max-height:300px;object-fit:contain;
                        border:1px solid #E2E4EB;"
                 alt="Bukti Transfer">
            <div style="margin-top:12px;display:flex;flex-direction:column;gap:6px;">
                @foreach([
                    ['Pengirim',$pembayaran->nama_pengirim],
                    ['Tgl Transfer', optional($pembayaran->tgl_transfer)->format('d M Y').' '.$pembayaran->jam_transfer],
                    ['Metode',$pembayaran->metode_pembayaran],
                ] as [$l,$v])
                @if($v)
                <div style="display:flex;justify-content:space-between;padding:7px 0;
                            border-top:1px solid #F0F1F5;font-size:12px;">
                    <span style="color:#9CA3B0;font-weight:700;text-transform:uppercase;letter-spacing:.5px">{{ $l }}</span>
                    <span style="color:#131218;font-weight:600">{{ $v }}</span>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif

        </div>{{-- end kolom kiri --}}

        {{-- ── KOLOM KANAN: Ringkasan + Rekening ──────────────── --}}
        <div>
            <div class="fcc-card" style="padding:22px;margin-bottom:14px;">
                <h3 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 14px">Ringkasan</h3>
                @foreach([
                    ['Kegiatan',Str::limit($pembayaran->pendaftaran->kegiatan->judul, 36)],
                    ['Jenis', ucfirst($pembayaran->pendaftaran->kegiatan->jenis_kegiatan ?? '-')],
                    ['Jenis Biaya', $pembayaran->pendaftaran->biaya?->nama_jenis ?? 'Gratis'],
                    ['Nominal Biaya', $pembayaran->jumlah_bayar_format],
                    ['Kode Unik', $pembayaran->kode_unik ?? '-'],
                ] as [$l,$v])
                <div style="display:flex;justify-content:space-between;align-items:flex-start;
                            padding:9px 0;border-top:1px solid #F0F1F5;gap:8px;">
                    <span style="color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;
                                 letter-spacing:.5px;flex-shrink:0;min-width:90px">{{ $l }}</span>
                    <span style="color:#131218;font-size:13px;font-weight:700;text-align:right">{{ $v }}</span>
                </div>
                @endforeach

                {{-- Total transfer diperjelas --}}
                @if($pembayaran->kode_unik)
                <div style="background:linear-gradient(135deg,#131218,#1C1B22);border-radius:10px;
                            padding:14px 16px;margin-top:12px;text-align:center;">
                    <p style="color:rgba(255,255,255,.55);font-size:10px;font-weight:700;
                               text-transform:uppercase;letter-spacing:1px;margin:0 0 4px">
                        Total Harus Ditransfer
                    </p>
                    <p style="color:#FFC81A;font-size:22px;font-weight:900;font-family:monospace;
                               letter-spacing:1px;margin:0">
                        {{ $pembayaran->nominal_transfer_format }}
                    </p>
                </div>
                @endif
            </div>

            @if($rekening && $pembayaran->bisaUploadBukti())
            <div class="fcc-card" style="padding:22px;background:rgba(255,200,26,.03);
                                          border-color:rgba(255,200,26,.2);">
                <h3 style="font-size:14px;font-weight:800;color:#131218;margin:0 0 14px">Transfer ke</h3>
                <p style="color:#FFC81A;font-size:20px;font-weight:900;font-family:monospace;
                           letter-spacing:2px;margin:0 0 4px">{{ $rekening->no_rekening }}</p>
                <p style="color:#131218;font-size:14px;font-weight:700;margin:0 0 2px">{{ $rekening->bank }}</p>
                <p style="color:#6B7280;font-size:12px;margin:0 0 14px">a.n. {{ $rekening->nama_pemilik }}</p>
                <button onclick="navigator.clipboard.writeText('{{ $rekening->no_rekening }}').then(()=>fccToast('Nomor rekening disalin!','success'))"
                        class="fcc-btn-outline-dark"
                        style="width:100%;justify-content:center;padding:9px;font-size:13px;">
                    @include('components.icon',['name'=>'copy','size'=>13])
                    Salin Nomor Rekening
                </button>
            </div>
            @endif
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
