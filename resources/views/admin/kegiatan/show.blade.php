@extends('layouts.admin')
@section('title','Detail Kegiatan — ' . $kegiatan->judul)
@section('page-title','Detail Kegiatan')

@section('page-content')
<div style="padding:24px;max-width:1200px;margin:0 auto;width:100%;">
  @php
    $isPel = $kegiatan->jenis_kegiatan === 'pelatihan';
    $detail = $kegiatan->detail;
    $isArsiped = $kegiatan->arsip()->exists();
  @endphp

  {{-- ── 1. TOP HEADER BAR ────────────────────────────────────────────────────── --}}
  <div style="margin-bottom:24px;">
    <a href="{{ route('admin.kegiatan.index') }}"
       style="display:inline-flex;align-items:center;gap:6px;color:#64748B;font-size:12px;font-weight:700;text-decoration:none;margin-bottom:14px;background:#F1F5F9;padding:5px 12px;border-radius:20px;border:1px solid #CBD5E1;transition:all .18s;"
       onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
      @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Kegiatan Aktif
    </a>

    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;">
      {{-- Judul --}}
      <div style="flex:1;min-width:300px;">
        <h1 style="font-size:24px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;line-height:1.3;">{{ $kegiatan->judul }}</h1>
      </div>

      {{-- Action Buttons --}}
      <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
        <a href="{{ route('admin.presensi.show', $kegiatan) }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:9.5px 18px;border-radius:30px;border:1.5px solid #131218;background:#FFC81A;color:#131218;font-size:13px;font-weight:900;text-decoration:none;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
           onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
          @include('components.icon',['name'=>'clipboard-list','size'=>14]) Presensi Peserta
        </a>
        <a href="{{ route('admin.sertifikat.peserta', $kegiatan) }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:9.5px 16px;border-radius:30px;border:1.5px solid #131218;background:#131218;color:#FFC81A;font-size:13px;font-weight:800;text-decoration:none;transition:all .18s;">
          @include('components.icon',['name'=>'file-text','size'=>14,'style'=>'color:#FFC81A']) Sertifikat
        </a>
        <button type="button" onclick="document.getElementById('edit-kegiatan-modal-{{ $kegiatan->id }}').style.display='flex'"
                style="display:inline-flex;align-items:center;gap:8px;padding:9.5px 16px;border-radius:30px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:13px;font-weight:800;cursor:pointer;transition:all .18s;">
          @include('components.icon',['name'=>'edit','size'=>14]) Edit Kegiatan
        </button>
        @include('admin.kegiatan.partials.edit-modal', ['kegiatan' => $kegiatan])

        @if(!$isArsiped)
        <form action="{{ route('admin.kegiatan.arsipkan', $kegiatan) }}" method="POST" style="display:inline;">
          @csrf
          <button type="button" onclick="fccConfirmAction(this, 'Tandai Selesai & Arsipkan', 'Apakah Anda yakin ingin menandai kegiatan ini selesai dan memindahkannya ke Arsip Kegiatan?', 'Ya, Arsipkan', false)"
                  style="display:inline-flex;align-items:center;gap:8px;padding:9.5px 18px;border-radius:30px;border:1.5px solid #131218;background:#10B981;color:#FFFFFF;font-size:13px;font-weight:900;cursor:pointer;box-shadow:0 4px 14px rgba(16,185,129,0.3);transition:all .18s;">
            @include('components.icon',['name'=>'archive','size'=>14]) Tandai Selesai / Arsipkan
          </button>
        </form>
        @else
        <span style="font-size:12px;font-weight:900;padding:8px 16px;border-radius:30px;background:#ECFDF5;color:#10B981;border:1.5px solid #10B981;display:inline-flex;align-items:center;gap:6px;">
          ✓ Sudah Diarsipkan
        </span>
        @endif
      </div>
    </div>
  </div>

  {{-- Warning Alert jika lewat tanggal --}}
  @if($kegiatan->isPassed() && !$kegiatan->arsip)
  <div style="background:#FFFDF5;border:2px solid #FFC81A;border-radius:20px;padding:18px 22px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;box-shadow:0 4px 16px rgba(255,200,26,0.15);">
    <div style="display:flex;align-items:center;gap:14px;">
      <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;font-size:20px;font-weight:900;flex-shrink:0;">
        ⚠
      </div>
      <div>
        <h4 style="margin:0;font-weight:900;color:#131218;font-size:15px;">Kegiatan Ini Telah Melewati Tanggal Pelaksanaan</h4>
        <p style="margin:2px 0 0;font-size:13px;color:#64748B;font-weight:500;">
          Anda dapat menandai kegiatan ini sebagai selesai dan memindahkannya ke Arsip Kegiatan.
        </p>
      </div>
    </div>
    <div>
      <form action="{{ route('admin.kegiatan.arsipkan', $kegiatan) }}" method="POST" style="display:inline;">
        @csrf
        <button type="button" onclick="fccConfirmAction(this, 'Tandai Selesai & Arsipkan', 'Apakah Anda yakin ingin menandai kegiatan ini selesai dan memindahkannya ke Arsip Kegiatan?', 'Ya, Arsipkan', false)"
                style="padding:9px 20px;font-size:13px;background:#10B981;color:#FFF;border:1.5px solid #131218;border-radius:30px;font-weight:900;display:inline-flex;align-items:center;gap:8px;cursor:pointer;box-shadow:0 4px 12px rgba(16,185,129,0.25);">
          @include('components.icon',['name'=>'archive','size'=>14]) Tandai Selesai / Arsipkan
        </button>
      </form>
    </div>
  </div>
  @endif

  {{-- ── 2. STAT CARDS HORIZONTAL BAR (SUBTLE ACCENT COLORS) ─────────────────── --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
    @foreach([
      ['Terdaftar', $kegiatan->pendaftaran->where('status_pendaftaran','terdaftar')->count(), 'check', '#ECFDF5', '#10B981'],
      ['Menunggu Verifikasi', $kegiatan->pendaftaran->where('status_pendaftaran','menunggu_verifikasi')->count(), 'clock', '#FFFDF5', '#D97706'],
      ['Pembayaran Masuk', 'Rp '.number_format($kegiatan->pendaftaran->sum(fn($p)=>$p->pembayaran?->jumlah_bayar??0),0,',','.'), 'credit-card', '#EFF6FF', '#2563EB'],
      ['Peserta Hadir', $kegiatan->pendaftaran->where('status_kehadiran','hadir')->count(), 'users', '#FFC81A', '#131218'],
    ] as [$l, $v, $ic, $bg, $c])
    <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
      <div style="width:46px;height:46px;border-radius:12px;background:{{ $bg }};border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:{{ $c }};flex-shrink:0;">
        @include('components.icon',['name'=>$ic,'size'=>22])
      </div>
      <div>
        <p style="margin:0;font-size:20px;font-weight:900;color:#131218;">{{ $v }}</p>
        <p style="margin:2px 0 0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">{{ $l }}</p>
      </div>
    </div>
    @endforeach
  </div>

  {{-- ── 3. INFORMASI UTAMA KEGIATAN (3x2 GRID WITH SUBTLE ICON COLORS) ───────── --}}
  <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);margin-bottom:24px;">
    <div style="padding:16px 22px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
      <div style="display:flex;align-items:center;gap:8px;">
        <span style="background:#131218;color:#FFC81A;font-size:10px;font-weight:900;padding:3px 8px;border-radius:6px;text-transform:uppercase;">RINGKASAN</span>
        <h3 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Informasi &amp; Jadwal Pelaksanaan</h3>
      </div>
    </div>

    <div style="padding:20px 22px;">
      <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:16px;">
        @foreach([
          ['Pelaksanaan', $kegiatan->jadwal?->tgl_pelaksanaan?->translatedFormat('d F Y') ?? '—', 'calendar', '#EFF6FF', '#2563EB'],
          ['Waktu', ($kegiatan->jadwal?->jam_mulai ? substr($kegiatan->jadwal->jam_mulai, 0, 5) : '—').' – '.($kegiatan->jadwal?->jam_selesai ? substr($kegiatan->jadwal->jam_selesai, 0, 5) : '—'), 'clock', '#FFFDF5', '#D97706'],
          ['Batas Daftar', $kegiatan->jadwal?->tgl_batas_daftar?->translatedFormat('d M Y') ?? '—', 'alert-circle', '#FEF2F2', '#EF4444'],
          ['Kategori', $isPel ? ($kegiatan->kegiatanPelatihan?->jadwalPelatihan?->pelatihan?->kategori?->nama_kategori ?? '—') : ($kegiatan->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi?->kategori?->nama_kategori ?? '—'), 'tag', '#F3E8FF', '#9333EA'],
          ['Kuota Peserta', ($kegiatan->jadwal?->kuota_peserta ?? 0) . ' Peserta', 'users', '#ECFDF5', '#10B981'],
          ['Jenis Program', ucfirst($kegiatan->jenis_kegiatan), 'layers', '#FFFDF5', '#131218'],
        ] as [$l, $v, $ic, $bg, $c])
        <div style="background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:12px;">
          <div style="width:38px;height:38px;border-radius:10px;background:{{ $bg }};border:1px solid #CBD5E1;display:flex;align-items:center;justify-content:center;color:{{ $c }};flex-shrink:0;">
            @include('components.icon',['name'=>$ic,'size'=>18])
          </div>
          <div style="min-width:0;flex:1;">
            <p style="margin:0;font-size:10.5px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:.5px;">{{ $l }}</p>
            <p style="margin:2px 0 0;font-size:13px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $v }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- ── 4. TWO EQUAL HEIGHT SIDE-BY-SIDE CARDS: MATERI & BIAYA ───────────────── --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(360px, 1fr));align-items:stretch;gap:20px;margin-bottom:24px;">
    
    {{-- Card 1: Materi & Modul --}}
    @php
      $materiList = collect();
      $storeMateriRoute = null;
      $targetId = null;

      if ($isPel) {
          $pelatihan = $kegiatan->kegiatanPelatihan?->jadwalPelatihan?->pelatihan;
          if ($pelatihan) {
              $materiList = $pelatihan->materi;
              $targetId = $pelatihan->id;
              $storeMateriRoute = route('admin.materi-pelatihan.store', $pelatihan->id);
          }
      } else {
          $sertifikasi = $kegiatan->kegiatanSertifikasi?->jadwalSertifikasi?->sertifikasi;
          if ($sertifikasi) {
              $materiList = $sertifikasi->materi;
              $targetId = $sertifikasi->id;
              $storeMateriRoute = route('admin.materi-sertifikasi.store', $sertifikasi->id);
          }
      }
    @endphp

    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);height:100%;display:flex;flex-direction:column;">
      <div style="padding:16px 22px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;flex-shrink:0;">
        <h3 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Materi / Modul ({{ $materiList->count() }})</h3>
        <div style="display:flex;align-items:center;gap:8px;">
          @if($storeMateriRoute)
          <button type="button" onclick="document.getElementById('tambah-materi-modal').style.display='flex'" style="font-size:12px;color:#131218;background:#FFC81A;padding:4px 14px;border-radius:20px;border:1px solid #131218;font-weight:800;cursor:pointer;">
            + Tambah Materi
          </button>
          @endif
        </div>
      </div>
      
      <div style="padding:0;flex:1;display:flex;flex-direction:column;justify-content:center;">
        @forelse($materiList as $m)
        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 22px;border-bottom:1px solid #F1F5F9;">
          <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;">
            <div style="width:28px;height:28px;border-radius:8px;background:#131218;border:1px solid #131218;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;color:#FFC81A;flex-shrink:0;">
              {{ $m->urutan }}
            </div>
            <div style="flex:1;min-width:0;">
              <p style="margin:0;font-size:13.5px;font-weight:900;color:#131218;">{{ $m->judul_materi }}</p>
              <p style="margin:2px 0 0;font-size:11.5px;color:#64748B;font-weight:600;">
                @if(isset($m->jam_pelajaran)) {{ $m->jam_pelajaran }} JP @endif
                @if(isset($m->jam_pelajaran) && $m->file_materi) &bull; @endif
                @if($m->file_materi)
                  <a href="{{ \Illuminate\Support\Str::startsWith($m->file_materi, ['http://', 'https://']) ? $m->file_materi : asset('storage/'.$m->file_materi) }}" target="_blank" style="color:#2563EB;font-weight:800;text-decoration:none;">📄 Lihat Berkas Modul</a>
                @endif
              </p>
            </div>
          </div>

          @php
            $deleteMateriRoute = $isPel && $targetId
              ? route('admin.materi-pelatihan.destroy', [$targetId, $m->id]) 
              : ($targetId ? route('admin.materi-sertifikasi.destroy', [$targetId, $m->id]) : '#');
          @endphp
          @if($deleteMateriRoute !== '#')
          <form action="{{ $deleteMateriRoute }}" method="POST" style="margin:0;">
            @csrf @method('DELETE')
            <button type="button" onclick="fccConfirmDelete(this, 'Hapus Materi / Modul', 'Apakah Anda yakin ingin menghapus materi {{ addslashes($m->judul_materi) }}?')"
                    style="background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:9px;cursor:pointer;color:#EF4444;display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;padding:0;transition:all .18s;" title="Hapus Materi"
                    onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';">
              @include('components.icon',['name'=>'trash','size'=>14])
            </button>
          </form>
          @endif
        </div>
        @empty
        <div style="padding:28px 22px;text-align:center;color:#94A3B8;font-size:13px;font-weight:600;flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;">
          <p style="margin:0 0 6px;color:#64748B;font-size:13px;font-weight:600;">Belum ada materi untuk kegiatan ini.</p>
          @if($storeMateriRoute)
          <button type="button" onclick="document.getElementById('tambah-materi-modal').style.display='flex'" style="color:#131218;font-weight:900;text-decoration:underline;background:none;border:none;cursor:pointer;padding:0;">
            + Tambah Materi Baru Sekarang &rarr;
          </button>
          @endif
        </div>
        @endforelse
      </div>
    </div>

    {{-- Card 2: Biaya Kegiatan --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);height:100%;display:flex;flex-direction:column;">
      <div style="padding:16px 22px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-shrink:0;">
        <h3 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Biaya Kegiatan</h3>
        <button type="button" onclick="document.getElementById('tambah-biaya-modal').style.display='flex'" style="font-size:12px;color:#131218;background:#FFC81A;padding:4px 14px;border-radius:20px;border:1px solid #131218;font-weight:800;cursor:pointer;">+ Tambah Biaya</button>
      </div>
      
      <div style="padding:0 22px;flex:1;display:flex;flex-direction:column;justify-content:center;">
        @forelse($kegiatan->biaya as $b)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid #F1F5F9;">
          <span style="font-size:13.5px;color:#131218;font-weight:800;">{{ $b->nama_jenis }}</span>
          <div style="display:flex;align-items:center;gap:12px;">
            <span style="font-size:14px;font-weight:900;color:#131218;">{{ $b->nominal_format }}</span>
            <form action="{{ route('admin.biaya.destroy', $b) }}" method="POST" style="margin:0;">
              @csrf @method('DELETE')
              <button type="button" onclick="fccConfirmDelete(this, 'Hapus Biaya Kegiatan', 'Apakah Anda yakin ingin menghapus rincian biaya {{ addslashes($b->nama_jenis) }} ({{ $b->nominal_format }})?')"
                      style="background:#FEF2F2;border:1.5px solid #FCA5A5;border-radius:9px;cursor:pointer;color:#EF4444;display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;padding:0;transition:all .18s;" title="Hapus Biaya"
                      onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                @include('components.icon',['name'=>'trash','size'=>14])
              </button>
            </form>
          </div>
        </div>
        @empty
        <div style="padding:24px 0;text-align:center;flex:1;display:flex;align-items:center;justify-content:center;">
          <p style="color:#64748B;font-size:13px;margin:0;font-weight:600;">Tidak ada rincian biaya — kegiatan ini <strong style="color:#10B981;font-weight:900;">GRATIS</strong>.</p>
        </div>
        @endforelse
      </div>
    </div>

  </div>

  {{-- ── 5. FULL WIDTH BOTTOM SECTION: DAFTAR PESERTA ────────────────────────── --}}
  <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
    <div style="padding:16px 22px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
      <h3 style="margin:0;font-size:15px;font-weight:900;color:#131218;">Daftar Peserta Terdaftar ({{ $kegiatan->pendaftaran->count() }})</h3>
      <a href="{{ route('admin.presensi.export', $kegiatan) }}" style="font-size:12px;color:#131218;background:#FFFFFF;border:1.5px solid #131218;padding:4px 14px;border-radius:20px;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
        @include('components.icon',['name'=>'download','size'=>13]) Export CSV
      </a>
    </div>
    <div style="overflow-x:auto;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="background:#131218;color:#FFFFFF;">
            <th style="padding:12px 18px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFC81A;text-align:left;">Nama Peserta</th>
            <th style="padding:12px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:center;">Status Daftar</th>
            <th style="padding:12px 14px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:center;">Pembayaran</th>
            <th style="padding:12px 18px;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:.6px;color:#FFFFFF;text-align:center;">Kehadiran</th>
          </tr>
        </thead>
        <tbody>
          @forelse($kegiatan->pendaftaran as $pd)
          @php
            $dS=match($pd->status_pendaftaran){
              'terdaftar'=>['#ECFDF5','#10B981','Terdaftar'],
              'menunggu_verifikasi'=>['#FFFDF5','#D97706','Menunggu Verifikasi'],
              'ditolak'=>['#FEF2F2','#EF4444','Ditolak'],
              default=>['#F8FAFC','#64748B','Belum Bayar']
            };
            $hS=match($pd->status_kehadiran){
              'hadir'=>['#ECFDF5','#10B981','Hadir'],
              'tidak_hadir'=>['#FEF2F2','#EF4444','Tidak Hadir'],
              default=>['#F8FAFC','#64748B','Belum Presensi']
            };
          @endphp
          <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
            <td style="padding:12px 18px;">
              <p style="margin:0;font-size:13.5px;font-weight:800;color:#131218;">{{ $pd->peserta->nama }}</p>
              <p style="margin:1px 0 0;font-size:11px;color:#64748B;font-weight:500;">{{ $pd->peserta->email }}</p>
            </td>
            <td style="padding:12px 14px;text-align:center;">
              <span style="font-size:10.5px;font-weight:800;padding:3px 10px;border-radius:12px;background:{{ $dS[0] }};color:{{ $dS[1] }};border:1px solid {{ $dS[1] }}40;display:inline-block;white-space:nowrap;">
                {{ $dS[2] }}
              </span>
            </td>
            <td style="padding:12px 14px;text-align:center;font-size:12.5px;color:#131218;font-weight:800;">
              {{ $pd->pembayaran?->jumlah_bayar_format ?? 'Gratis' }}
            </td>
            <td style="padding:12px 18px;text-align:center;">
              <span style="font-size:10.5px;font-weight:800;padding:3px 10px;border-radius:12px;background:{{ $hS[0] }};color:{{ $hS[1] }};border:1px solid {{ $hS[1] }}40;display:inline-block;white-space:nowrap;">
                {{ $hS[2] }}
              </span>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" style="padding:32px 20px;text-align:center;color:#94A3B8;font-size:13px;font-weight:600;">
              Belum ada peserta yang mendaftar pada kegiatan ini.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- ── TAMBAH BIAYA MODAL (Neo-Brutalist) ────────────────────────────── --}}
<div id="tambah-biaya-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:16px;" onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:480px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);display:flex;flex-direction:column;text-align:left;" onclick="event.stopPropagation()">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('tambah-biaya-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;">BIAYA KEGIATAN</span>
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Tambah Biaya Kegiatan</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Tentukan jenis dan nominal biaya pendaftaran baru untuk {{ $kegiatan->judul }}.</p>
        </div>

        <form action="{{ route('admin.biaya.store') }}" method="POST">
            @csrf
            <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Nama Jenis Biaya <span style="color:#EF4444;">*</span></label>
                <input type="text" name="nama_jenis" value="{{ old('nama_jenis') }}" placeholder="Contoh: Umum, Mahasiswa UMI, Alumni" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                @error('nama_jenis')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:18px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Nominal (Rp) <span style="color:#EF4444;">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:900;color:#64748B;">Rp</span>
                    <input type="number" name="nominal" value="{{ old('nominal') }}" placeholder="0" min="0" required class="fcc-input" style="padding:9.5px 14px 9.5px 40px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;" onfocus="this.select()">
                </div>
                <p style="font-size:11px;color:#64748B;margin:5px 0 0;font-weight:500;">Isi 0 jika pendaftaran tidak dipungut biaya.</p>
                @error('nominal')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- ACTION BUTTONS --}}
            <div style="display:flex;gap:12px;justify-content:flex-end;align-items:center;border-top:1.5px solid #E5E7EB;padding-top:18px;">
                <button type="button" onclick="document.getElementById('tambah-biaya-modal').style.display='none'"
                        style="padding:10px 22px;font-size:13px;font-weight:800;border-radius:30px;border:1.5px solid #CBD5E1;background:#F8FAFC;color:#64748B;cursor:pointer;">
                    Batal
                </button>
                <button type="submit"
                        style="padding:10px 26px;font-size:13.5px;font-weight:900;border-radius:30px;border:1.5px solid #131218;background:#FFC81A;color:#131218;cursor:pointer;box-shadow:0 4px 14px rgba(255,200,26,0.35);display:inline-flex;align-items:center;gap:6px;">
                    @include('components.icon',['name'=>'check','size'=>15]) Simpan Biaya
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── TAMBAH MATERI / MODUL MODAL (Neo-Brutalist) ────────────────────────────── --}}
@if($storeMateriRoute)
<div id="tambah-materi-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:16px;" onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:520px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);display:flex;flex-direction:column;text-align:left;" onclick="event.stopPropagation()">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('tambah-materi-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;">MATERI &amp; MODUL</span>
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Tambah Materi / Modul</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Tambahkan berkas modul atau tautan materi baru untuk {{ $kegiatan->judul }}.</p>
        </div>

        <form action="{{ $storeMateriRoute }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Judul Materi / Modul <span style="color:#EF4444;">*</span></label>
                <input type="text" name="judul_materi" value="{{ old('judul_materi') }}" placeholder="Contoh: Modul 1: Dasar Pemrograman" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                @error('judul_materi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            @if($isPel)
            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Jam Pelajaran (JP) <span style="color:#EF4444;">*</span></label>
                <input type="number" name="jam_pelajaran" value="{{ old('jam_pelajaran', 1) }}" min="1" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;" onfocus="this.select()">
                @error('jam_pelajaran')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>
            @endif

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Unggah Berkas Modul (Opsional)</label>
                <input type="file" name="file_materi" accept=".pdf,.ppt,.pptx,.doc,.docx,.zip" class="fcc-input" style="padding:8px 12px;font-size:12.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;background:#F8FAFC;">
                <p style="font-size:11px;color:#64748B;margin:4px 0 0;">Format: PDF, PPT, DOC, ZIP (Maks. 20MB)</p>
                @error('file_materi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:18px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Atau Tautan Modul / Video (Opsional)</label>
                <input type="url" name="link_materi" value="{{ old('link_materi') }}" placeholder="https://drive.google.com/..." class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                @error('link_materi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- ACTION BUTTONS --}}
            <div style="display:flex;gap:12px;justify-content:flex-end;align-items:center;border-top:1.5px solid #E5E7EB;padding-top:18px;">
                <button type="button" onclick="document.getElementById('tambah-materi-modal').style.display='none'"
                        style="padding:10px 22px;font-size:13px;font-weight:800;border-radius:30px;border:1.5px solid #CBD5E1;background:#F8FAFC;color:#64748B;cursor:pointer;">
                    Batal
                </button>
                <button type="submit"
                        style="padding:10px 26px;font-size:13.5px;font-weight:900;border-radius:30px;border:1.5px solid #131218;background:#FFC81A;color:#131218;cursor:pointer;box-shadow:0 4px 14px rgba(255,200,26,0.35);display:inline-flex;align-items:center;gap:6px;">
                    @include('components.icon',['name'=>'check','size'=>15]) Simpan Materi
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
