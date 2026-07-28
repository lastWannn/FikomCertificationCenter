@extends('layouts.admin')
@section('title','Detail Sertifikasi')
@section('page-title','Detail Sertifikasi')
@section('page-content')
<div style="padding:20px 24px;">
  <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;flex-wrap:wrap;gap:12px;">
    <div>
      <a href="{{ route('admin.sertifikasi.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#9CA3B0;font-size:13px;text-decoration:none;margin-bottom:8px;">
        @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
      </a>
      <h1 style="font-size:20px;font-weight:900;color:#131218;margin:0 0 4px;">{{ $sertifikasi->judul }}</h1>
      <p style="color:#FFC81A;font-size:13px;font-weight:700;margin:0;font-family:monospace;">{{ $sertifikasi->kode }}</p>
    </div>
    <div style="display:flex;gap:8px;">
      <a href="{{ route('admin.sertifikasi.materi.index', ['sertifikasi_id' => $sertifikasi->id]) }}" style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:10px;border:1.5px solid #E2E4EB;background:#F7F8FA;font-size:13px;font-weight:700;color:#131218;text-decoration:none;transition:all .18s;cursor:pointer;"
         onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
        @include('components.icon',['name'=>'book-open','size'=>13]) Kelola Materi
      </a>
      <a href="{{ route('admin.jadwal-sertifikasi.create', $sertifikasi) }}" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'calendar','size'=>13]) Tambah Jadwal
      </a>
      <a href="{{ route('admin.sertifikasi.edit', $sertifikasi) }}" class="fcc-btn-dark" style="padding:9px 14px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'edit','size'=>13,'style'=>'color:#FFC81A'])
      </a>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
    {{-- Kiri: Jadwal --}}
    <div>
      <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
          <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">Jadwal ({{ $sertifikasi->jadwal->count() }})</p>
          <a href="{{ route('admin.jadwal-sertifikasi.create', $sertifikasi) }}" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;">+ Tambah Jadwal</a>
        </div>
        @forelse($sertifikasi->jadwal as $j)
        @php $ks = $j->kegiatanSertifikasi; @endphp
        <div style="padding:12px 18px;border-top:1px solid #F0F1F5;">
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <div>
              @if($j->nama_kegiatan)
              <p style="margin:0 0 3px;font-size:13.5px;font-weight:800;color:#131218;">{{ $j->nama_kegiatan }}</p>
              <p style="margin:0;font-size:11.5px;color:#9CA3B0;">{{ $j->tgl_pelaksanaan->format('d M Y') }} &bull; {{ substr($j->jam_mulai, 0, 5) }} – {{ substr($j->jam_selesai, 0, 5) }} &bull; Kuota: {{ $j->kuota_peserta }}</p>
              @else
              <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $j->tgl_pelaksanaan->format('d M Y') }}</p>
              <p style="margin:2px 0 0;font-size:11px;color:#9CA3B0;">{{ substr($j->jam_mulai, 0, 5) }} – {{ substr($j->jam_selesai, 0, 5) }} &bull; Kuota: {{ $j->kuota_peserta }}</p>
              @endif
              
              @if(!empty($j->biaya_setup) && is_array($j->biaya_setup))
              <div style="margin-top:6px;display:flex;gap:4px;flex-wrap:wrap;">
                @foreach($j->biaya_setup as $b)
                <span style="font-size:10px;font-weight:700;background:#F8F9FB;border:1px solid #E2E4EB;color:#6B7280;padding:2px 8px;border-radius:12px;">{{ $b['nama'] }}: Rp{{ number_format($b['nominal'],0,',','.') }}</span>
                @endforeach
              </div>
              @endif
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
              <div style="text-align:right;">
                @if($ks)
                <span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:rgba(16,185,129,.12);color:#10B981;">&#10003; Aktif</span>
                <br>
                <a href="{{ route('admin.kegiatan.show', $ks->kegiatan) }}" style="font-size:11px;color:#3B82F6;text-decoration:none;">Lihat Kegiatan</a>
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
        <div style="padding:18px;text-align:center;color:#9CA3B0;font-size:13px;">
          Belum ada jadwal. <a href="{{ route('admin.jadwal-sertifikasi.create', $sertifikasi) }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">Tambah jadwal &rarr;</a>
        </div>
        @endforelse
      </div>
    </div>

    {{-- Kanan: Info --}}
    <div>
      <div class="fcc-card" style="padding:20px;margin-bottom:14px;">
        <div style="display:flex;flex-direction:column;gap:12px;">
          @foreach([
            ['Kategori',     $sertifikasi->kategori->nama_kategori??'—'],
            ['Total Materi', $sertifikasi->materi->count().' Materi'],
            ['Dibuat',       $sertifikasi->created_at->format('d M Y')],
          ] as [$l,$v])
          <div>
            <p style="margin:0;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $l }}</p>
            <p style="margin:3px 0 0;font-size:14px;font-weight:600;color:#131218;">{{ $v }}</p>
          </div>
          @endforeach
          @if($sertifikasi->link_materi)
          <div>
            <p style="margin:0 0 3px;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">Link Materi</p>
            <a href="{{ $sertifikasi->link_materi }}" target="_blank" style="font-size:13px;color:#FFC81A;font-weight:700;text-decoration:none;">Buka Link &rarr;</a>
          </div>
          @endif
        </div>
      </div>
      <div class="fcc-card" style="padding:18px;">
        <p style="font-size:13px;font-weight:800;color:#131218;margin:0 0 10px;">Deskripsi</p>
        <p style="color:#6B7280;font-size:13px;line-height:1.75;margin:0;">{{ $sertifikasi->isi }}</p>
      </div>
    </div>
  </div>
</div>

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(19,18,24,.55);backdrop-filter:blur(4px);align-items:center;justify-content:center;">
    <div style="background:#FFF;border-radius:18px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 64px rgba(0,0,0,.18);text-align:center;position:relative;animation:modalIn .25s ease;">
        <div id="fcc-confirm-icon" style="width:56px;height:56px;border-radius:16px;background:#FEF2F2;border:1.5px solid #FEE2E2;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#0F0F14;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Jadwal?</h3>
        <p id="fcc-confirm-msg" style="color:#6B7280;font-size:14px;margin:0 0 28px;line-height:1.6;"></p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="closeConfirm()" style="padding:11px 28px;border-radius:12px;border:1px solid #E2E4EB;background:#F7F8FA;color:#6B7280;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='#F0F1F5'" onmouseout="this.style.background='#F7F8FA'">Batal</button>
            <form id="fcc-confirm-form" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" style="padding:11px 28px;border-radius:12px;border:none;background:#EF4444;color:#FFF;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 15px rgba(239,68,68,.3);transition:all .2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
</style>

<script>
function closeConfirm() {
    document.getElementById('fcc-confirm-modal').style.display = 'none';
}

function showModal(id) {
    const el = document.getElementById(id);
    el.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Close on backdrop click
document.getElementById('fcc-confirm-modal').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Watch overflow
[document.getElementById('fcc-confirm-modal')].forEach(el => {
    if(!el) return;
    const obs = new MutationObserver(() => {
        const visible = el.style.display !== 'none';
        document.body.style.overflow = visible ? 'hidden' : '';
    });
    obs.observe(el, { attributes: true, attributeFilter: ['style'] });
});
</script>
@endsection
