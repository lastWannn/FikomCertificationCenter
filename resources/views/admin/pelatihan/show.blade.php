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
      <button onclick="openMateriModal()" style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:10px;border:1.5px solid #E2E4EB;background:#F7F8FA;font-size:13px;font-weight:700;color:#131218;text-decoration:none;transition:all .18s;cursor:pointer;"
         onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
        @include('components.icon',['name'=>'plus','size'=>13]) Tambah Materi
      </button>
      <a href="{{ route('admin.jadwal-pelatihan.create', $pelatihan) }}" class="fcc-btn-gold" style="padding:9px 16px;font-size:13px;text-decoration:none;">
        @include('components.icon',['name'=>'calendar','size'=>13]) Tambah Jadwal
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
          <button onclick="openMateriModal()" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;background:none;border:none;cursor:pointer;padding:0;">+ Tambah</button>
        </div>
        @forelse($pelatihan->materi as $m)
        <div style="display:flex;align-items:center;gap:12px;padding:12px 18px;border-top:1px solid #F0F1F5;" class="tbl-row">
          <div style="width:28px;height:28px;border-radius:8px;background:#131218;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:900;color:#FFC81A;flex-shrink:0;">{{ $m->urutan }}</div>
          <div style="flex:1;min-width:0;">
            <p style="margin:0;font-size:13px;font-weight:700;color:#131218;">{{ $m->judul_materi }}</p>
            <p style="margin:0;font-size:11px;color:#9CA3B0;">{{ $m->jam_pelajaran }} JP
              @if($m->file_materi)&bull; <a href="{{ \Illuminate\Support\Str::startsWith($m->file_materi, ['http://', 'https://']) ? $m->file_materi : asset('storage/'.$m->file_materi) }}" target="_blank" style="color:#FFC81A;font-weight:600;text-decoration:none;">Lihat Materi</a>@endif
            </p>
          </div>
          <div style="display:flex;gap:8px;flex-shrink:0;">
            <button onclick="openEditMateriModal({{ $m->id }}, '{{ addslashes($m->judul_materi) }}', {{ $m->jam_pelajaran }}, {{ $m->urutan }})" style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;transition:color .18s;"
               onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#9CA3B0'">
              @include('components.icon',['name'=>'edit','size'=>14])
            </button>
            <button onclick="confirmMateriDelete('{{ route('admin.materi-pelatihan.destroy',[$pelatihan->id,$m->id]) }}', '{{ addslashes($m->judul_materi) }}')" style="background:none;border:none;cursor:pointer;color:#9CA3B0;display:flex;padding:4px;transition:color .18s;"
                    onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3B0'">
              @include('components.icon',['name'=>'trash','size'=>14])
            </button>
          </div>
        </div>
        @empty
        <div style="padding:22px 18px;text-align:center;color:#9CA3B0;font-size:13px;">
          Belum ada materi. <button onclick="openMateriModal()" style="color:#FFC81A;font-weight:700;text-decoration:none;background:none;border:none;cursor:pointer;padding:0;font-size:13px;">Tambah sekarang &rarr;</button>
        </div>
        @endforelse
      </div>

      {{-- Jadwal --}}
      <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
          <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">Jadwal ({{ $pelatihan->jadwal->count() }})</p>
          <a href="{{ route('admin.jadwal-pelatihan.create', $pelatihan) }}" style="font-size:12px;color:#FFC81A;font-weight:700;text-decoration:none;">+ Tambah Jadwal</a>
        </div>
        @forelse($pelatihan->jadwal as $j)
        @php $kp = $j->kegiatanPelatihan; @endphp
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
                @if($kp)
                <span style="font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;background:rgba(16,185,129,.12);color:#10B981;">&#10003; Aktif</span>
                <br>
                <a href="{{ route('admin.kegiatan.show',$kp->kegiatan_id) }}" style="font-size:11px;color:#3B82F6;text-decoration:none;">Lihat Kegiatan</a>
                @else
                <form action="{{ route('admin.jadwal-pelatihan.aktifkan', $j) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" style="background:#131218;border:none;color:#FFC81A;font-size:11px;font-weight:700;padding:4px 10px;border-radius:7px;cursor:pointer;" onclick="return confirm('Aktifkan jadwal ini?')">+ Aktifkan</button>
                </form>
                @endif
              </div>
              <div style="display:flex;gap:6px;">
                <a href="{{ route('admin.jadwal-pelatihan.edit',$j->id) }}" title="Edit" style="color:#9CA3B0;display:flex;padding:4px;transition:color .18s;"
                   onmouseover="this.style.color='#FFC81A'" onmouseout="this.style.color='#9CA3B0'">
                  @include('components.icon',['name'=>'edit','size'=>14])
                </a>
                <form action="{{ route('admin.jadwal-pelatihan.destroy',$j->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
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
          Belum ada jadwal. <a href="{{ route('admin.jadwal-pelatihan.create', $pelatihan) }}" style="color:#FFC81A;font-weight:700;text-decoration:none;">Tambah jadwal &rarr;</a>
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
</div>

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.5);text-align:center;position:relative;animation:modalIn .25s ease;">
        <div id="fcc-confirm-icon" style="width:56px;height:56px;border-radius:16px;background:rgba(239,68,68,.15);border:1.5px solid rgba(239,68,68,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 18px;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Materi?</h3>
        <p id="fcc-confirm-msg" style="color:rgba(255,255,255,.55);font-size:14px;margin:0 0 28px;line-height:1.6;"></p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="closeConfirm()" style="padding:11px 28px;border-radius:12px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">Batal</button>
            <form id="fcc-confirm-form" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" style="padding:11px 28px;border-radius:12px;border:none;background:linear-gradient(135deg,#EF4444,#DC2626);color:#FFF;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 15px rgba(239,68,68,.3);transition:all .2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- ── Form Modal Materi ────────────────────────────────────────── --}}
<div id="materi-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(0,0,0,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;overflow-y:auto;padding:24px 0;">
    <div style="background:#1C1B22;border:1px solid rgba(255,255,255,.1);border-radius:20px;padding:32px;max-width:550px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,.5);animation:modalIn .25s ease;margin:auto;position:relative;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
            <div>
                <h2 id="modal-title" style="color:#FFF;font-size:18px;font-weight:900;margin:0 0 4px;">Tambah Materi</h2>
                <p style="color:rgba(255,255,255,.4);font-size:13px;margin:0;">Masukkan detail modul/materi pelatihan.</p>
            </div>
            <button onclick="closeMateriModal()" style="width:36px;height:36px;border-radius:10px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.6);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;line-height:1;" onmouseover="this.style.background='rgba(255,255,255,.1)'" onmouseout="this.style.background='rgba(255,255,255,.05)'">&times;</button>
        </div>

        <form id="materi-form" method="POST" enctype="multipart/form-data" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div style="display:grid;gap:20px;margin-bottom:24px;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Judul Materi <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="judul_materi" id="f-judul" required placeholder="Contoh: Pengenalan Dasar" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Jam Pelajaran (JP) <span style="color:#EF4444;">*</span></label>
                        <input type="number" name="jam_pelajaran" id="f-jp" min="1" required placeholder="1" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Urutan Ke- <span style="color:#EF4444;">*</span></label>
                        <input type="number" name="urutan" id="f-urutan" min="1" required placeholder="1" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;color:#FFF;font-size:14px;outline:none;transition:border-color .2s;box-sizing:border-box;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='rgba(255,255,255,.1)'">
                    </div>
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:rgba(255,255,255,.5);margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Upload File Materi (Opsional)</label>
                    <input type="file" name="file_materi" id="f-file" accept=".pdf,.doc,.docx,.ppt,.pptx" style="width:100%;background:rgba(255,255,255,.05);border:1.5px solid rgba(255,255,255,.1);border-radius:10px;padding:8px 14px;color:rgba(255,255,255,.6);font-size:13px;outline:none;box-sizing:border-box;cursor:pointer;" onchange="
                        if(this.files[0]){
                            const file = this.files[0];
                            const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
                            if(!allowedTypes.includes(file.type) && !file.name.match(/\.(pdf|doc|docx|ppt|pptx)$/i)){
                                if(typeof fccShowFileAlert === 'function') fccShowFileAlert('Hanya file PDF, Word, atau PPT yang diperbolehkan!');
                                else alert('Hanya file PDF, Word, atau PPT yang diperbolehkan!');
                                this.value='';
                                return;
                            }
                            if(file.size > 2 * 1024 * 1024){
                                if(typeof fccShowFileAlert === 'function') fccShowFileAlert('Ukuran file maksimal 2MB!');
                                else alert('Ukuran file maksimal 2MB!');
                                this.value='';
                                return;
                            }
                        }
                    ">
                    <p style="font-size:11px;color:rgba(255,255,255,.3);margin:5px 0 0;">Format: PDF, Word, PPT. Maks 2MB.</p>
                </div>
            </div>

            <div style="border-top:1px solid rgba(255,255,255,.08);padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="closeMateriModal()" style="padding:11px 24px;border-radius:12px;border:1.5px solid rgba(255,255,255,.12);background:rgba(255,255,255,.05);color:rgba(255,255,255,.7);font-size:14px;font-weight:700;cursor:pointer;">Batal</button>
                <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
</style>

<script>
const STORE_URL = '{{ route('admin.materi-pelatihan.store', $pelatihan->id) }}';
const UPDATE_URL_BASE = '{{ url("admin/materi-pelatihan/{$pelatihan->id}") }}'; // e.g., admin/materi-pelatihan/1/...

function openMateriModal() {
    document.getElementById('modal-title').innerText = 'Tambah Materi Baru';
    document.getElementById('materi-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    document.getElementById('f-judul').value = '';
    document.getElementById('f-jp').value = '1';
    document.getElementById('f-urutan').value = '{{ $pelatihan->materi->max("urutan") + 1 }}';
    document.getElementById('f-file').value = '';
    showModal('materi-modal');
}

function openEditMateriModal(id, judul, jp, urutan) {
    document.getElementById('modal-title').innerText = 'Edit Materi';
    document.getElementById('materi-form').action = `${UPDATE_URL_BASE}/${id}`;
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('f-judul').value = judul;
    document.getElementById('f-jp').value = jp;
    document.getElementById('f-urutan').value = urutan;
    document.getElementById('f-file').value = '';
    showModal('materi-modal');
}

function closeMateriModal() {
    document.getElementById('materi-modal').style.display = 'none';
}

function confirmMateriDelete(url, name) {
    document.getElementById('fcc-confirm-title').innerText = 'Hapus Materi?';
    document.getElementById('fcc-confirm-msg').innerText = `Materi "${name}" akan dihapus permanen dari sistem.`;
    document.getElementById('fcc-confirm-form').action = url;
    showModal('fcc-confirm-modal');
}

function closeConfirm() {
    document.getElementById('fcc-confirm-modal').style.display = 'none';
}

function showModal(id) {
    const el = document.getElementById(id);
    el.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Close on backdrop click
document.getElementById('materi-modal').addEventListener('click', function(e) {
    if (e.target === this) closeMateriModal();
});
document.getElementById('fcc-confirm-modal').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Watch overflow
[document.getElementById('materi-modal'), document.getElementById('fcc-confirm-modal')].forEach(el => {
    const obs = new MutationObserver(() => {
        const visible = document.getElementById('materi-modal').style.display !== 'none' ||
                        document.getElementById('fcc-confirm-modal').style.display !== 'none';
        document.body.style.overflow = visible ? 'hidden' : '';
    });
    obs.observe(el, { attributes: true, attributeFilter: ['style'] });
});
</script>
@endsection
