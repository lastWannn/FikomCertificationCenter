@extends('layouts.admin')

@section('page-content')
<div style="padding:24px;">
    {{-- HEADER --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div>
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
                <h1 style="font-size:24px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.5px;">Point Peserta Pelatihan</h1>
                <span style="background:#F7F8FA;color:#6B7280;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:700;">Studio Informatika</span>
            </div>
            <p style="color:#6B7280;margin:0;font-size:14px;display:flex;align-items:center;gap:6px;">
                <span style="font-weight:700;color:#131218;">Judul:</span> {{ $jadwal->pelatihan->judul ?? '-' }} 
                <span style="color:#E2E4EB;">|</span> 
                <span style="font-weight:700;color:#131218;">Pelaksanaan:</span> {{ \Carbon\Carbon::parse($jadwal->tgl_pelaksanaan)->translatedFormat('d-M-Y') }}
            </p>
        </div>
        <a href="{{ route('admin.pelatihan.point.index') }}" class="fcc-btn-gold" style="padding:10px 20px;font-size:12.5px;font-weight:800;border:none;border-radius:10px;cursor:pointer;display:inline-block;text-decoration:none;background:#EF4444;color:#FFF;box-shadow:0 4px 12px rgba(239,68,68,.2);">
            KEMBALI
        </a>
    </div>

    @if(session('success'))
    <div style="background:#ECFDF5;border:1px solid #10B981;padding:16px;border-radius:12px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
        @include('components.icon',['name'=>'check-circle','size'=>20,'style'=>'color:#10B981'])
        <p style="margin:0;color:#065F46;font-size:13.5px;font-weight:600;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- LIST PESERTA --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;background:#FFF;">
        <div style="padding:18px 24px;border-bottom:1px solid #F0F1F5;display:flex;justify-content:space-between;align-items:center;background:#FDFDFE;">
            <p style="margin:0;font-size:14px;font-weight:700;color:#6B7280;">Menampilkan {{ $pendaftaran->count() }} peserta</p>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:12px;font-weight:700;color:#9CA3B0;">Search:</span>
                <input type="text" placeholder="Cari nama..." class="fcc-input" style="padding:8px 12px;font-size:13px;border-radius:8px;width:200px;">
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13.5px;">
                <thead>
                    <tr style="background:#F7F8FA;border-bottom:1px solid #E2E4EB;">
                        <th style="text-align:left;padding:14px 24px;font-weight:800;color:#9CA3B0;width:5%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">No</th>
                        <th style="text-align:left;padding:14px 24px;font-weight:800;color:#9CA3B0;width:20%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Nomor Identitas</th>
                        <th style="text-align:left;padding:14px 24px;font-weight:800;color:#9CA3B0;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Nama Peserta</th>
                        <th style="text-align:center;padding:14px 24px;font-weight:800;color:#9CA3B0;width:15%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Point</th>
                        <th style="text-align:left;padding:14px 24px;font-weight:800;color:#9CA3B0;width:35%;text-transform:uppercase;font-size:11px;letter-spacing:0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $item)
                    @php
                        // Menghitung rata-rata nilai jika ada banyak materi
                        $avgPoint = $item->nilai->count() > 0 ? $item->nilai->avg('nilai') : null;
                    @endphp
                    <tr style="border-bottom:1px solid #F0F1F5;transition:background .2s;" onmouseover="this.style.background='#F8F9FB'" onmouseout="this.style.background='none'">
                        <td style="padding:16px 24px;color:#9CA3B0;font-weight:700;">{{ $index + 1 }}</td>
                        <td style="padding:16px 24px;font-weight:600;color:#6B7280;font-family:monospace;font-size:14px;">
                            {{ $item->peserta->no_hp ?? '-' }}
                        </td>
                        <td style="padding:16px 24px;font-weight:800;color:#131218;">
                            {{ $item->peserta->nama ?? 'Peserta Tidak Ditemukan' }}
                        </td>
                        <td style="padding:16px 24px;text-align:center;">
                            @if($avgPoint !== null)
                                <span style="font-weight:900;color:#10B981;font-size:15px;">{{ number_format($avgPoint, 0) }}</span>
                            @else
                                <span style="font-weight:700;color:#D1D5DB;font-size:13px;">Belum Dinilai</span>
                            @endif
                        </td>
                        <td style="padding:16px 24px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <button type="button" onclick="openNilaiModal('{{ $item->id }}', '{{ addslashes($item->peserta->nama ?? '') }}', {{ $item->nilai->toJson() }})" class="fcc-btn-gold" style="padding:8px 12px;font-size:11px;font-weight:800;border:none;border-radius:6px;cursor:pointer;background:#10B981;color:#FFF;box-shadow:0 2px 8px rgba(16,185,129,.2);">
                                    INPUT NILAI
                                </button>
                                <a href="{{ route('admin.cetak.penilaian', $item->hashid) }}" target="_blank" class="fcc-btn-gold" style="padding:8px 12px;font-size:11px;font-weight:800;border:none;border-radius:6px;cursor:pointer;background:#84CC16;color:#FFF;box-shadow:0 2px 8px rgba(132,204,22,.2);text-decoration:none;">
                                    CETAK LEMBAR PENILAIAN
                                </a>
                                @if($item->sertifikat)
                                    <a href="{{ route('admin.cetak.sertifikat', $item->sertifikat->hashid) }}" target="_blank" class="fcc-btn-gold" style="padding:8px 12px;font-size:11px;font-weight:800;border:none;border-radius:6px;cursor:pointer;text-decoration:none;">
                                        CETAK SERTIFIKAT
                                    </a>
                                @else
                                    <button type="button" onclick="alert('Sertifikat belum diterbitkan! Silakan terbitkan sertifikat melalui menu Kelola Sertifikat terlebih dahulu.')" class="fcc-btn-gold" style="padding:8px 12px;font-size:11px;font-weight:800;border:none;border-radius:6px;cursor:pointer;opacity:0.6;" title="Sertifikat Belum Diterbitkan">
                                        CETAK SERTIFIKAT
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:48px 24px;color:#9CA3B0;">
                            <div style="width:64px;height:64px;background:#F7F8FA;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                                @include('components.icon',['name'=>'users','size'=>28,'style'=>'color:#C0C4CF'])
                            </div>
                            <p style="font-weight:700;color:#6B7280;margin:0 0 4px;font-size:14px;">Belum Ada Peserta</p>
                            <p style="font-size:12.5px;margin:0;">Tidak ada peserta yang terdaftar pada jadwal pelatihan ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL INPUT NILAI --}}
<div id="nilai-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.55);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
    <div style="background:#FFF;border-radius:18px;padding:32px 28px;max-width:550px;width:90%;position:relative;box-shadow:0 24px 64px rgba(0,0,0,.18);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;">
        
        <button type="button" onclick="document.getElementById('nilai-modal').style.display='none'" style="position:absolute;top:18px;right:18px;width:28px;height:28px;border:none;background:none;cursor:pointer;color:#9CA3B0;font-size:20px;line-height:1;border-radius:8px;transition:background .15s;" onmouseover="this.style.background='#F7F8FA'" onmouseout="this.style.background='none'">&#215;</button>

        <div style="margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #F0F1F5;">
            <h2 style="font-size:18px;font-weight:900;color:#0F0F14;margin:0 0 4px;">Input Nilai Peserta</h2>
            <p style="color:#6B7280;font-size:13px;margin:0;">Masukkan nilai untuk <strong id="peserta-name" style="color:#131218;">-</strong></p>
        </div>

        <form id="nilai-form" method="POST" action="">
            @csrf
            
            @if($jadwal->pelatihan && $jadwal->pelatihan->materi && $jadwal->pelatihan->materi->count() > 0)
                <div style="background:#F7F8FA;padding:16px;border-radius:12px;margin-bottom:24px;">
                    @foreach($jadwal->pelatihan->materi as $index => $mat)
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:{{ $loop->last ? '0' : '12px' }};padding-bottom:{{ $loop->last ? '0' : '12px' }};border-bottom:{{ $loop->last ? 'none' : '1px solid #E2E4EB' }};">
                        <div style="flex:1;">
                            <p style="margin:0 0 4px;font-size:13px;font-weight:800;color:#131218;">{{ $mat->judul_materi }}</p>
                            <p style="margin:0;font-size:11.5px;font-weight:600;color:#9CA3B0;">{{ $mat->jam_pelajaran }} Jam Pelajaran</p>
                        </div>
                        <div style="width:100px;">
                            <input type="number" name="nilai[{{ $mat->id }}]" id="nilai-input-{{ $mat->id }}" min="0" max="100" placeholder="0 - 100" class="fcc-input" style="padding:10px 12px;font-size:14px;font-weight:800;text-align:center;width:100%;border-radius:8px;border:1px solid #E2E4EB;">
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div style="background:#FEF2F2;border:1px solid #FCA5A5;padding:16px;border-radius:12px;margin-bottom:24px;text-align:center;">
                    <p style="margin:0;color:#EF4444;font-size:13px;font-weight:600;">Pelatihan ini belum memiliki materi. Silakan tambahkan materi pelatihan terlebih dahulu.</p>
                </div>
            @endif

            <div style="display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="document.getElementById('nilai-modal').style.display='none'" style="padding:10px 20px;border-radius:10px;border:1px solid #E2E4EB;background:#FFF;color:#6B7280;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='#F7F8FA';this.style.color='#131218'" onmouseout="this.style.background='#FFF';this.style.color='#6B7280'">Batal</button>
                <button type="submit" class="fcc-btn-gold" style="padding:10px 24px;font-size:13px;font-weight:800;border:none;border-radius:10px;cursor:pointer;" {{ (!$jadwal->pelatihan || !$jadwal->pelatihan->materi || $jadwal->pelatihan->materi->count() == 0) ? 'disabled' : '' }}>Simpan Nilai</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openNilaiModal(pendaftaranId, namaPeserta, existingNilai) {
        document.getElementById('peserta-name').innerText = namaPeserta;
        
        // Atur URL form action
        const baseUrl = '{{ route('admin.pelatihan.point.index') }}';
        document.getElementById('nilai-form').action = baseUrl + '/{{ $jadwal->id }}/pendaftaran/' + pendaftaranId;
        
        // Reset input fields
        const inputs = document.querySelectorAll('input[name^="nilai["]');
        inputs.forEach(input => input.value = '');

        // Isi dengan nilai yang sudah ada (jika ada)
        if (existingNilai && existingNilai.length > 0) {
            existingNilai.forEach(n => {
                const input = document.getElementById('nilai-input-' + n.materi_pelatihan_id);
                if (input) {
                    input.value = Math.round(n.nilai);
                }
            });
        }
        
        document.getElementById('nilai-modal').style.display = 'flex';
    }
</script>
@endsection
