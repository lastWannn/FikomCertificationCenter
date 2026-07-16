@extends('layouts.admin')
@section('title','Detail Pelatihan')
@section('page-title','Detail Pelatihan')
@section('page-content')
<div style="padding:20px 24px;">
  <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;flex-wrap:wrap;gap:12px;">
    <div>
      <a href="{{ route('admin.pelatihan.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:8px;">
        @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
      </a>
      <h1 style="font-size:20px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $pelatihan->judul }}</h1>
      <p style="color:#FFC81A;font-size:13px;font-weight:700;margin:0;font-family:monospace;">{{ $pelatihan->kode }}</p>
    </div>
    <div style="display:flex;gap:8px;">
      <a href="{{ route('admin.materi-pelatihan.create', $pelatihan) }}" style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:10px;border:1.5px solid #E2E4EB;background:#F7F8FA;font-size:13px;font-weight:700;color:#131218;text-decoration:none;transition:all .18s;"
         onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
        @include('components.icon',['name'=>'plus','size'=>13]) Tambah Materi
      </a>
      <a href="{{ route('admin.jadwal-pelatihan.create', $pelatihan) }}" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'calendar','size'=>13]) Buat Jadwal
      </a>
      <a href="{{ route('admin.pelatihan.edit', $pelatihan) }}" class="fcc-btn-dark" style="padding:9px 14px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'edit','size'=>13,'style'=>'color:#FFC81A'])
      </a>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
    {{-- Kiri: Materi --}}
    <div>
      <div class="fcc-card" style="padding:0;overflow:hidden;margin-bottom:14px;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
          <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">
            Materi / Modul ({{ $pelatihan->materi->count() }})
          </p>
          <a href="{{ route('admin.materi-pelatihan.create', $pelatihan) }}" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;">+ Tambah</a>
        </div>
        @forelse($pelatihan->materi as $m)
        <div style="display:flex;align-items:center;gap:12px;padding:12px 18px;border-top:1px solid #F0F1F5;" class="tbl-row">
          <div style="width:28px;height:28px;border-radius:8px;background:#131218;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;color:#FFC81A;flex-shrink:0;">{{ $m->urutan }}</div>
          <div style="flex:1;min-width:0;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $m->judul_materi }}</p>
            <p style="margin:0;font-size:11px;color:#9CA3B0;">{{ $m->jam_pelajaran }} JP
              @if($m->file_materi)&bull; <a href="{{ asset('storage/'.$m->file_materi) }}" target="_blank" style="color:#FFC81A;font-weight:600;text-decoration:none;">Lihat File</a>@endif
            </p>
          </div>
          <div style="display:flex;gap:8px;flex-shrink:0;">
            <a href="{{ route('admin.materi-pelatihan.edit',[$pelatihan->id,$m->id]) }}" style="color:#9CA3B0;display:flex;padding:4px;transition:color .18s;"
               onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#9CA3B0'">
              @include('components.icon',['name'=>'edit','size'=>14])
            </a>
            <form action="{{ route('admin.materi-pelatihan.destroy',[$pelatihan->id,$m->id]) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
              @csrf @method('DELETE')
              <button type="submit" style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;transition:color .18s;"
                      onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3B0'">
                @include('components.icon',['name'=>'trash','size'=>14])
              </button>
            </form>
          </div>
        </div>
        @empty
        <div style="padding:22px 18px;text-align:center;color:#9CA3B0;font-size:13px;">
          Belum ada materi. <a href="{{ route('admin.materi-pelatihan.create', $pelatihan) }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">Tambah sekarang &rarr;</a>
        </div>
        @endforelse
      </div>

      {{-- Jadwal --}}
      <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
          <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">Jadwal ({{ $pelatihan->jadwal->count() }})</p>
          <a href="{{ route('admin.jadwal-pelatihan.create', $pelatihan) }}" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;">+ Buat Jadwal</a>
        </div>
        @forelse($pelatihan->jadwal as $j)
        @php $kp = $j->kegiatanPelatihan; @endphp
        <div style="padding:12px 18px;border-top:1px solid #F0F1F5;">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;">
            <div>
              <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $j->tgl_pelaksanaan->format('d M Y') }}</p>
              <p style="margin:2px 0 0;font-size:11px;color:#9CA3B0;">{{ $j->jam_mulai }} – {{ $j->jam_selesai }} &bull; Kuota: {{ $j->kuota_peserta }}</p>
            </div>
            <div style="text-align:right;">
              @if($kp)
              <span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:rgba(16,185,129,.12);color:#10B981;">&#10003; Aktif</span>
              <br>
              <a href="{{ route('admin.kegiatan.show',$kp->kegiatan_id) }}" style="font-size:11px;color:#3B82F6;text-decoration:none;">Lihat Kegiatan</a>
              @else
              <form action="{{ route('admin.jadwal-pelatihan.aktifkan', $j) }}" method="POST">
                @csrf
                <button type="submit" style="background:#131218;border:none;color:#FFC81A;font-size:11px;font-weight:700;padding:4px 10px;border-radius:7px;cursor:pointer;" onclick="return confirm('Aktifkan jadwal ini?')">+ Aktifkan</button>
              </form>
              @endif
            </div>
          </div>
        </div>
        @empty
        <div style="padding:18px;text-align:center;color:#9CA3B0;font-size:13px;">
          Belum ada jadwal. <a href="{{ route('admin.jadwal-pelatihan.create', $pelatihan) }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">Buat jadwal &rarr;</a>
        </div>
        @endforelse
      </div>
    </div>

    {{-- Kanan: Info --}}
    <div>
      <div class="fcc-card" style="padding:20px;margin-bottom:14px;">
        <div style="display:flex;flex-direction:column;gap:12px;">
          @foreach([
            ['Kategori',  $pelatihan->kategori->nama_kategori??'—'],
            ['Instruktur',$pelatihan->instruktur->nama??'—'],
            ['Total JP',  $pelatihan->materi->sum('jam_pelajaran').' JP'],
            ['Dibuat',    $pelatihan->created_at->format('d M Y')],
          ] as [$l,$v])
          <div>
            <p style="margin:0;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $l }}</p>
            <p style="margin:3px 0 0;font-size:14px;font-weight:600;color:#131218;">{{ $v }}</p>
          </div>
          @endforeach
          @if($pelatihan->link_materi)
          <div>
            <p style="margin:0 0 3px;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">Link Materi</p>
            <a href="{{ $pelatihan->link_materi }}" target="_blank" style="font-size:13px;color:#FFC81A;font-weight:700;text-decoration:none;">Buka Link &rarr;</a>
          </div>
          @endif
        </div>
      </div>
      <div class="fcc-card" style="padding:18px;">
        <p style="font-size:13px;font-weight:800;color:#131218;margin:0 0 10px;">Deskripsi</p>
        <p style="color:#6B7280;font-size:13px;line-height:1.75;margin:0;">{{ $pelatihan->isi }}</p>
      </div>
    </div>
  </div>
</div>
@endsection
