<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Penilaian - {{ $pendaftaran->peserta->nama ?? '-' }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #131218;
            margin: 0;
            padding: 30px;
            font-size: 14px;
            line-height: 1.5;
        }
        .logo-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .logo-header img {
            width: 80px;
        }
        .title-section {
            margin-bottom: 20px;
        }
        .title-section h3 {
            margin: 0 0 5px 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .title-section p {
            margin: 0;
            font-size: 12px;
        }
        .participant-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .score-table th, .score-table td {
            border-bottom: 1px solid #131218;
            padding: 8px 10px;
            text-align: left;
        }
        .score-table th {
            font-weight: bold;
            font-size: 13px;
        }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .footer-sig {
            width: 250px;
            text-align: left;
        }
        .footer-sig p { margin: 0 0 60px; font-size:12px; }
        .footer-sig .name { font-weight: bold; }
    </style>
</head>
<body>

    <div class="logo-header">
        <!-- Logo Image Placeholder -->
        <div style="width:180px;height:60px;background:url('{{ asset('images/logo.png') }}') no-repeat center left;background-size:contain;">
            @if(!file_exists(public_path('images/logo.png')))
                <h2 style="margin:0;color:#FFC81A;">STUDIO <br><span style="font-size:12px;color:#131218">INFORMATIKA</span></h2>
            @endif
        </div>
    </div>

    @php
        $jadwal = $pendaftaran->kegiatan->kegiatanPelatihan->jadwalPelatihan ?? null;
        $pelatihan = $jadwal->pelatihan ?? null;
    @endphp

    <div class="title-section">
        <h3>POINT PESERTA PELATIHAN <span style="font-weight:normal;color:#6B7280;font-size:14px;text-transform:none;">Studio Informatika</span></h3>
        <p>Judul: {{ $pelatihan->judul ?? '-' }} | Pelaksanaan: {{ $jadwal ? \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d-M-Y') : '-' }}</p>
    </div>

    <div class="participant-name">
        NAMA PESERTA: {{ $pendaftaran->peserta->nama ?? '-' }}
    </div>

    <table class="score-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th>Materi Pelatihan</th>
                <th class="text-center" style="width: 20%;">Point</th>
            </tr>
        </thead>
        <tbody>
            @if($pelatihan && $pelatihan->materi && $pelatihan->materi->count() > 0)
                @foreach($pelatihan->materi as $index => $mat)
                    @php
                        $nilaiObj = $pendaftaran->nilai->where('materi_pelatihan_id', $mat->id)->first();
                        $nilai = $nilaiObj ? $nilaiObj->nilai : null;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mat->judul_materi }}</td>
                        <td class="text-center">{{ $nilai !== null ? round($nilai) : '' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center">Belum ada materi pelatihan.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-sig">
            <p>Makassar, {{ \Carbon\Carbon::now()->translatedFormat('d-M-Y') }}<br>Kepala Studio Informatika</p>
            <div class="name">[Nama Kepala Studio, S.Kom., M.Kom]</div>
        </div>
        <div class="footer-sig">
            <p><br>Instruktur</p>
            <div class="name">[Nama Instruktur]</div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
