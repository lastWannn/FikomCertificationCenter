@extends('layouts.admin')
@section('title','Detail Sertifikasi')
@section('page-content')
<div style="padding:24px;">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <a href="{{ route('admin.sertifikasi.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:8px;">
                @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
            </a>
            <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0;">{{ $sertifikasi->judul }}</h1>
            <p style="color:#3B82F6;font-size:13px;font-weight:700;margin:4px 0 0;font-family:monospace;">{{ $sertifikasi->kode }}</p>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('admin.materi-sertifikasi.create', $sertifikasi) }}" style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:10px;border:1.5px solid #E2E4EB;background:#F7F8FA;font-size:13px;font-weight:700;color:#131218;text-decoration:none;transition:all .18s;"
               onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                @include('components.icon',['name'=>'plus','size'=>13]) Tambah Materi
            </a>
            <a href="{{ route('admin.jadwal-sertifikasi.create', $sertifikasi) }}" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;text-decoration:none;">
                @include('components.icon',['name'=>'calendar','size'=>13]) Tambah Jadwal
            </a>
            <a href="{{ route('admin.sertifikasi.edit', $sertifikasi) }}" class="fcc-btn-dark" style="padding:9px 14px;font-size:13px;text-decoration:none;">
                @include('components.icon',['name'=>'edit','size'=>13,'style'=>'color:#FFC81A'])
            </a>
        </div>
    </div>
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:18px;">
        <div class="fcc-card" style="padding:24px;">
            <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 14px;">Deskripsi</h3>
            <div style="color:#6B7280;font-size:14px;line-height:1.85;">{!! nl2br(e($sertifikasi->isi)) !!}</div>
        </div>
        <div>
            <div class="fcc-card" style="padding:20px;margin-bottom:14px;">
                <p style="margin:0 0 4px;font-size:11px;font-weight:700;color:#A0A3AD;text-transform:uppercase;">Kategori</p>
                <p style="margin:0;font-size:14px;color:#0F0F14;font-weight:700;">{{ $sertifikasi->kategori->nama_kategori ?? '-' }}</p>
            </div>
            <div class="fcc-card" style="padding:20px;margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <h4 style="font-size:13px;font-weight:800;color:#0F0F14;margin:0;">Materi ({{ $sertifikasi->materi->count() }})</h4>
                    <a href="{{ route('admin.materi-sertifikasi.create', $sertifikasi) }}" style="font-size:11px;color:#FFC81A;font-weight:700;text-decoration:none;">+ Tambah</a>
                </div>
                @forelse($sertifikasi->materi as $m)
                <div style="display:flex;align-items:center;gap:12px;padding:8px 0;border-top:1px solid #F0F1F3;" class="tbl-row">
                    <div style="width:24px;height:24px;border-radius:6px;background:#131218;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:900;color:#FFC81A;flex-shrink:0;">{{ $m->urutan }}</div>
                    <div style="flex:1;min-width:0;">
                        <p style="margin:0;font-size:13px;font-weight:700;color:#0F0F14;">{{ $m->judul_materi }}</p>
                        @if($m->file_materi)
                        <p style="margin:2px 0 0;font-size:11px;color:#9CA3B0;">
                            <a href="{{ \Illuminate\Support\Str::startsWith($m->file_materi, ['http://', 'https://']) ? $m->file_materi : asset('storage/'.$m->file_materi) }}" target="_blank" style="color:#FFC81A;font-weight:600;text-decoration:none;">Lihat Materi</a>
                        </p>
                        @endif
                    </div>
                    <div style="display:flex;gap:6px;flex-shrink:0;">
                        <a href="{{ route('admin.materi-sertifikasi.edit',[$sertifikasi->id,$m->id]) }}" title="Edit" style="color:#9CA3B0;display:flex;padding:4px;transition:color .18s;"
                           onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#9CA3B0'">
                            @include('components.icon',['name'=>'edit','size'=>14])
                        </a>
                        <form action="{{ route('admin.materi-sertifikasi.destroy',[$sertifikasi->id,$m->id]) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;transition:color .18s;"
                                    onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3B0'">
                                @include('components.icon',['name'=>'trash','size'=>14])
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="color:#A0A3AD;font-size:13px;margin:0;">Belum ada materi.</p>
                @endforelse
            </div>
            
            {{-- Jadwal Card --}}
            <div class="fcc-card" style="padding:0;overflow:hidden;">
                <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
                    <p style="margin:0;font-size:13px;font-weight:800;color:#0F0F14;">Jadwal ({{ $sertifikasi->jadwal->count() }})</p>
                    <a href="{{ route('admin.jadwal-sertifikasi.create', $sertifikasi) }}" style="font-size:11px;color:#FFC81A;font-weight:700;text-decoration:none;">+ Tambah Jadwal</a>
                </div>
                @forelse($sertifikasi->jadwal as $j)
                @php $ks = $j->kegiatanSertifikasi; @endphp
                <div style="padding:12px 18px;border-top:1px solid #F0F1F3;">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            @if($j->nama_kegiatan)
                            <p style="margin:0 0 3px;font-size:13.5px;font-weight:800;color:#0F0F14;">{{ $j->nama_kegiatan }}</p>
                            <p style="margin:0;font-size:11.5px;color:#6B7280;">{{ $j->tgl_pelaksanaan->format('d M Y') }} &bull; {{ substr($j->jam_mulai, 0, 5) }} – {{ substr($j->jam_selesai, 0, 5) }} &bull; Kuota: {{ $j->kuota_peserta }}</p>
                            @else
                            <p style="margin:0;font-size:13px;font-weight:700;color:#0F0F14;">{{ $j->tgl_pelaksanaan->format('d M Y') }}</p>
                            <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">{{ substr($j->jam_mulai, 0, 5) }} – {{ substr($j->jam_selesai, 0, 5) }} &bull; Kuota: {{ $j->kuota_peserta }}</p>
                            @endif
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="text-align:right;">
                                @if($ks)
                                <span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:rgba(16,185,129,.12);color:#10B981;">&#10003; Aktif</span>
                                <br>
                                <a href="{{ route('admin.kegiatan.show',$ks->kegiatan_id) }}" style="font-size:11px;color:#3B82F6;text-decoration:none;">Lihat Kegiatan</a>
                                @else
                                <form action="{{ route('admin.jadwal-sertifikasi.aktifkan', $j) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" style="background:#131218;border:none;color:#FFC81A;font-size:11px;font-weight:700;padding:4px 10px;border-radius:7px;cursor:pointer;" onclick="return confirm('Aktifkan jadwal ini?')">+ Aktifkan</button>
                                </form>
                                @endif
                            </div>
                            <div style="display:flex;gap:6px;">
                                <a href="{{ route('admin.jadwal-sertifikasi.edit',$j->id) }}" title="Edit" style="color:#9CA3B0;display:flex;padding:4px;transition:color .18s;"
                                   onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#9CA3B0'">
                                    @include('components.icon',['name'=>'edit','size'=>14])
                                </a>
                                <form action="{{ route('admin.jadwal-sertifikasi.destroy',$j->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;transition:color .18s;"
                                            onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3B0'">
                                        @include('components.icon',['name'=>'trash','size'=>14])
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div style="padding:18px;text-align:center;color:#A0A3AD;font-size:13px;">
                    Belum ada jadwal. <a href="{{ route('admin.jadwal-sertifikasi.create', $sertifikasi) }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">Tambah jadwal &rarr;</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
