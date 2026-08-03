@extends('layouts.peserta')
@section('title','Jelajahi Kegiatan')
@section('page-title','Jelajahi Kegiatan')
@section('page-content')
<div style="padding:24px;">
    {{-- Search + Filter --}}
    <form method="GET" action="{{ route('peserta.jelajahi') }}" style="display:flex;gap:10px;margin-bottom:22px;align-items:center;flex-wrap:wrap;">
        <div style="flex:1;min-width:200px;position:relative;">
            <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#A0A3AD;pointer-events:none;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kegiatan..." class="fcc-input" style="padding-left:36px;"
                   onkeydown="if(event.key==='Enter')this.form.submit()">
        </div>
        <div style="display:inline-flex;gap:4px;background:#F7F8FA;padding:4px;border-radius:10px;border:1px solid #E2E4EB;">
            @foreach([['semua','Semua'],['pelatihan','Pelatihan'],['sertifikasi','Sertifikasi']] as [$v,$l])
            <button type="submit" name="jenis" value="{{ $v }}"
                style="padding:6px 14px;border-radius:8px;border:none;font-size:13px;font-weight:700;cursor:pointer;transition:all .2s;
                       background:{{ (request('jenis')===$v || (!request('jenis')&&$v==='semua')) ? 'linear-gradient(135deg,#FFC81A,#FFD84D)' : 'transparent' }};
                       color:{{ (request('jenis')===$v || (!request('jenis')&&$v==='semua')) ? '#111' : '#6B7280' }};">
                {{ $l }}
            </button>
            @endforeach
        </div>
    </form>
    {{-- Desktop Table View & Mobile Cards --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:14px;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;text-align:left;">
                <thead>
                    <tr style="background:#F8F9FB;border-bottom:2px solid #E2E4EB;">
                        <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;letter-spacing:.7px;">Kegiatan</th>
                        <th style="padding:14px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;text-align:center;">Jenis</th>
                        <th style="padding:14px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Jadwal Pelaksanaan</th>
                        <th style="padding:14px 14px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;text-align:center;">Kuota</th>
                        <th style="padding:14px 20px;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;text-align:center;width:170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan as $k)
                    @php $sudah=in_array($k->id,$sudahDaftar); $isPel=$k->jenis_kegiatan==='pelatihan'; @endphp
                    <tr style="border-top:1px solid #F0F1F3;transition:background .2s;" onmouseover="this.style.background='#FAFBFD'" onmouseout="this.style.background='transparent'">
                        <td style="padding:16px 20px;">
                            <div style="display:flex;align-items:center;gap:14px;">
                                <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#131218,#1A1920);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    @include('components.icon',['name'=>$isPel?'book-open':'award','size'=>20,'style'=>'color:#FFC81A'])
                                </div>
                                <div>
                                    <p style="font-size:14px;font-weight:800;color:#0F0F14;margin:0 0 2px;line-height:1.35;">{{ $k->judul }}</p>
                                    <p style="font-size:11.5px;color:#9CA3B0;margin:0;">
                                        Status Biaya: <span style="color:#10B981;font-weight:700;">{{ $k->biaya->isNotEmpty() ? 'Berbayar' : 'Gratis' }}</span>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;">
                            <span style="font-size:11px;font-weight:800;padding:4px 10px;border-radius:6px;background:{{ $isPel?'rgba(255,200,26,.15)':'rgba(139,92,246,.12)' }};color:{{ $isPel?'#B38F00':'#7C3AED' }};text-transform:uppercase;">
                                {{ ucfirst($k->jenis_kegiatan) }}
                            </span>
                        </td>
                        <td style="padding:16px 14px;vertical-align:middle;font-size:13px;color:#4B5563;font-weight:600;">
                            <div style="display:flex;align-items:center;gap:6px;">
                                @include('components.icon',['name'=>'calendar','size'=>14,'style'=>'color:#9CA3B0'])
                                {{ $k->jadwal?->tgl_pelaksanaan?->format('d M Y') ?? 'Jadwal Menyusul' }}
                            </div>
                        </td>
                        <td style="padding:16px 14px;text-align:center;vertical-align:middle;font-size:13px;color:#374151;font-weight:700;">
                            <span style="background:#F3F4F6;padding:4px 10px;border-radius:8px;font-size:12px;">
                                {{ $k->terisi }} / {{ $k->kuota }}
                            </span>
                        </td>
                        <td style="padding:16px 20px;text-align:center;vertical-align:middle;">
                            @if($sudah)
                            <a href="{{ route('peserta.pendaftaran') }}" style="display:inline-flex;align-items:center;justify-content:center;padding:8px 14px;border-radius:9px;border:1.5px solid #10B981;color:#10B981;font-size:12.5px;font-weight:700;text-decoration:none;">&#10003; Terdaftar</a>
                            @elseif($k->isFull())
                            <button disabled style="width:100%;padding:8px 14px;border-radius:9px;border:1px solid #E2E4EB;background:rgba(100,100,100,.08);color:#A0A3AD;font-size:12.5px;font-weight:700;cursor:not-allowed;">Kuota Penuh</button>
                            @else
                            <button onclick="showDaftarModal('{{ $k->hashid }}', '{{ addslashes($k->judul) }}', {{ $k->biaya->toJson() }})"
                                class="fcc-btn-gold" style="width:100%;justify-content:center;padding:8px 14px;font-size:12.5px;">Daftar</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:48px;text-align:center;color:#A0A3AD;font-size:14px;">Tidak ada kegiatan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($kegiatan->hasPages())
    <div style="margin-top:24px;">{{ $kegiatan->withQueryString()->links() }}</div>
    @endif
</div>

{{-- Modal Daftar --}}
<div id="daftar-modal" style="display:none;position:fixed;inset:0;z-index:2000;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);display:none;align-items:center;justify-content:center;padding:16px;">
    <div style="background:#FFF;border-radius:18px;max-width:420px;width:100%;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,.2);">
        <div style="background:linear-gradient(135deg,#131218,#1A1920);padding:22px 24px;display:flex;justify-content:space-between;align-items:center;">
            <div>
                <p style="margin:0;color:#FFF;font-weight:800;font-size:16px;">Konfirmasi Pendaftaran</p>
                <p style="margin:4px 0 0;color:rgba(255,255,255,.5);font-size:12px;" id="modal-judul"></p>
            </div>
            <button onclick="closeDaftarModal()" style="background:rgba(255,255,255,.1);border:none;border-radius:8px;color:rgba(255,255,255,.7);padding:6px 8px;cursor:pointer;display:flex;">
                @include('components.icon',['name'=>'x','size'=>16])
            </button>
        </div>
        <form id="daftar-form" method="POST" style="padding:22px 24px;">
            @csrf
            <div id="biaya-section"></div>
            <button type="submit" class="fcc-btn-gold" style="width:100%;justify-content:center;padding:12px;font-size:15px;">
                @include('components.icon',['name'=>'check','size'=>16]) Konfirmasi Pendaftaran
            </button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
@vite('resources/js/pages/landing-jelajahi.js')
@endpush
