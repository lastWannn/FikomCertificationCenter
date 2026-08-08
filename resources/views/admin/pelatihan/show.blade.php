@extends('layouts.admin')
@section('title','Detail Pelatihan — ' . $pelatihan->judul)

@section('page-content')
<div style="padding:24px;">

  {{-- Header Bar --}}
  <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
    <div>
      <a href="{{ route('admin.pelatihan.index') }}"
         style="display:inline-flex;align-items:center;gap:6px;color:#64748B;font-size:12.5px;font-weight:700;text-decoration:none;margin-bottom:10px;background:#F1F5F9;padding:5px 12px;border-radius:20px;border:1px solid #CBD5E1;transition:all .18s;"
         onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
        @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Katalog Pelatihan
      </a>
      <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 12px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;">
          {{ $pelatihan->kode }}
        </span>
        <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">{{ $pelatihan->judul }}</h1>
      </div>
    </div>

    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <button type="button" onclick="openJadwalModal()" style="display:inline-flex;align-items:center;gap:8px;padding:9.5px 20px;border-radius:30px;border:1.5px solid #131218;background:#FFC81A;color:#131218;font-size:13px;font-weight:900;cursor:pointer;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
         onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
        @include('components.icon',['name'=>'calendar','size'=>14]) Tambah Batch Jadwal
      </button>
      <button type="button" onclick="document.getElementById('edit-modal-{{ $pelatihan->id }}').style.display='flex'" style="display:inline-flex;align-items:center;gap:8px;padding:9.5px 16px;border-radius:30px;border:1.5px solid #131218;background:#131218;color:#FFC81A;font-size:13px;font-weight:800;cursor:pointer;transition:all .18s;">
        @include('components.icon',['name'=>'edit','size'=>14,'style'=>'color:#FFC81A']) Edit Pelatihan
      </button>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
    {{-- Kiri: Jadwal --}}
    <div>
      <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
          <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">Jadwal ({{ $pelatihan->jadwal->count() }})</p>
          <button type="button" onclick="openJadwalModal()" style="font-size:12px;color:#FFC81A;font-weight:800;background:#131218;padding:4px 12px;border-radius:14px;border:none;cursor:pointer;">+ Tambah Jadwal</button>
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
            <div style="display:flex;align-items:center;gap:6px;flex-wrap:nowrap;">
              @if($kp)
                {{-- TOGGLE SWITCH ON (Publik/Aktif) --}}
                <form action="{{ route('admin.jadwal-pelatihan.nonaktifkan', $j) }}" method="POST" style="margin:0;display:inline-flex;align-items:center;">
                  @csrf
                  <button type="submit" title="Publik (Klik untuk Menonaktifkan)"
                          onclick="return fccConfirmAction(this, 'Nonaktifkan Kegiatan', 'Apakah Anda yakin ingin menonaktifkan kegiatan ini?', 'Ya, Nonaktifkan', true)"
                          style="display:inline-flex;align-items:center;gap:6px;background:#ECFDF5;border:1.5px solid #10B981;padding:3px 10px 3px 6px;border-radius:20px;cursor:pointer;transition:all .18s;text-decoration:none;">
                    <span style="width:26px;height:15px;background:#10B981;border-radius:10px;display:inline-flex;align-items:center;padding:1.5px;justify-content:flex-end;transition:all .18s;">
                      <span style="width:12px;height:12px;background:#FFFFFF;border-radius:50%;box-shadow:0 1px 3px rgba(0,0,0,0.25);"></span>
                    </span>
                    <span style="font-size:11px;font-weight:900;color:#10B981;white-space:nowrap;">Publik</span>
                  </button>
                </form>

                {{-- Lihat Halaman Publik Icon Button --}}
                <a href="{{ route('admin.kegiatan.show', $kp->kegiatan) }}" target="_blank" title="Lihat Halaman Publik Kegiatan"
                   style="width:32px;height:32px;border-radius:9px;background:#EFF6FF;border:1.5px solid #93C5FD;display:flex;align-items:center;justify-content:center;color:#3B82F6;text-decoration:none;transition:all .18s;"
                   onmouseover="this.style.background='#3B82F6';this.style.color='#FFFFFF';this.style.borderColor='#3B82F6';" onmouseout="this.style.background='#EFF6FF';this.style.color='#3B82F6';this.style.borderColor='#93C5FD';">
                  @include('components.icon',['name'=>'eye','size'=>15])
                </a>
              @else
                {{-- TOGGLE SWITCH OFF (Draft/Nonaktif) --}}
                <form action="{{ route('admin.jadwal-pelatihan.aktifkan', $j) }}" method="POST" style="margin:0;display:inline-flex;align-items:center;">
                  @csrf
                  <button type="submit" title="Draft (Klik untuk Mengaktifkan ke Publik)"
                          onclick="return fccConfirmAction(this, 'Aktifkan Jadwal', 'Aktifkan jadwal ini sebagai kegiatan publik?', 'Ya, Aktifkan', false)"
                          style="display:inline-flex;align-items:center;gap:6px;background:#F8FAFC;border:1.5px solid #CBD5E1;padding:3px 10px 3px 6px;border-radius:20px;cursor:pointer;transition:all .18s;text-decoration:none;"
                          onmouseover="this.style.borderColor='#131218';this.style.background='#FFFDF5';" onmouseout="this.style.borderColor='#CBD5E1';this.style.background='#F8FAFC';">
                    <span style="width:26px;height:15px;background:#CBD5E1;border-radius:10px;display:inline-flex;align-items:center;padding:1.5px;justify-content:flex-start;transition:all .18s;">
                      <span style="width:12px;height:12px;background:#FFFFFF;border-radius:50%;box-shadow:0 1px 3px rgba(0,0,0,0.25);"></span>
                    </span>
                    <span style="font-size:11px;font-weight:800;color:#64748B;white-space:nowrap;">Draft</span>
                  </button>
                </form>
              @endif

              {{-- Edit Button --}}
              <a href="{{ route('admin.jadwal-pelatihan.edit', $j) }}" title="Edit Jadwal"
                 style="width:32px;height:32px;border-radius:9px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;text-decoration:none;transition:all .18s;"
                 onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                @include('components.icon',['name'=>'edit','size'=>15])
              </a>

              {{-- Hapus Button --}}
              <form action="{{ route('admin.jadwal-pelatihan.destroy', $j) }}" method="POST" style="margin:0;" onsubmit="return fccConfirmDelete(event, this, 'Hapus Jadwal', 'Apakah Anda yakin ingin menghapus jadwal pelatihan ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="width:32px;height:32px;border-radius:9px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;color:#EF4444;cursor:pointer;transition:all .18s;padding:0;" title="Hapus Jadwal"
                        onmouseover="this.style.background='#EF4444';this.style.color='#FFFFFF';this.style.borderColor='#EF4444';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                  @include('components.icon',['name'=>'trash','size'=>15])
                </button>
              </form>
            </div>
          </div>
        </div>
        @empty
        <div style="padding:24px;text-align:center;color:#94A3B8;font-size:13px;font-weight:600;">
          Belum ada jadwal pelaksanaan. <button type="button" onclick="openJadwalModal()" style="color:#FFC81A;background:none;border:none;font-weight:800;cursor:pointer;padding:0;">Tambah batch jadwal &rarr;</button>
        </div>
        @endforelse
      </div>
    </div>

    {{-- Kanan: Info --}}
    <div>
      <div class="fcc-card" style="padding:20px;margin-bottom:14px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div style="display:flex;flex-direction:column;gap:14px;">
          @foreach([
            ['Kategori',  $pelatihan->kategori->nama_kategori??'—'],
            ['Total Jam Pelajaran',  $pelatihan->materi->sum('jam_pelajaran').' JP'],
            ['Tanggal Dibuat',    $pelatihan->created_at->format('d M Y')],
          ] as [$l,$v])
          <div>
            <p style="margin:0;font-size:10.5px;font-weight:900;color:#64748B;text-transform:uppercase;letter-spacing:.7px;">{{ $l }}</p>
            <p style="margin:3px 0 0;font-size:14px;font-weight:900;color:#131218;">{{ $v }}</p>
          </div>
          @endforeach
          @if($pelatihan->link_materi)
          <div>
            <p style="margin:0 0 3px;font-size:10.5px;font-weight:900;color:#64748B;text-transform:uppercase;letter-spacing:.7px;">Link Utama</p>
            <a href="{{ $pelatihan->link_materi }}" target="_blank" style="font-size:13px;color:#FFC81A;background:#131218;padding:4px 12px;border-radius:8px;font-weight:800;text-decoration:none;display:inline-block;">Buka Link &rarr;</a>
          </div>
          @endif
        </div>
      </div>

      <div class="fcc-card" style="padding:20px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <p style="font-size:14px;font-weight:900;color:#131218;margin:0 0 10px;">Deskripsi Program</p>
        <p style="color:#475569;font-size:13px;line-height:1.75;margin:0;font-weight:500;">{{ $pelatihan->isi }}</p>
      </div>
    </div>
  </div>
</div>

{{-- ── TAMBAH BATCH JADWAL MODAL (Neo-Brutalist Glassmorphism) ────────────────────────────────────── --}}
<div id="jadwal-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:640px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;">
        
        {{-- Close button --}}
        <button type="button" onclick="closeJadwalModal()" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;">BATCH JADWAL</span>
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Tambah Batch Jadwal Pelatihan</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Jadwalkan tanggal dan jam pelaksanaan untuk {{ $pelatihan->judul }}.</p>
        </div>

        <form action="{{ route('admin.jadwal-pelatihan.store', $pelatihan) }}" method="POST">
            @csrf
            
            {{-- NAMA KEGIATAN --}}
            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Nama / Label Batch <span style="font-weight:500;color:#64748B;">(Opsional)</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" placeholder="Contoh: {{ $pelatihan->judul }} - Batch {{ $pelatihan->jadwal->count() + 1 }}" class="fcc-input" style="padding:9px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                @error('nama_kegiatan')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- TANGGAL GRID --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Tanggal Pelaksanaan <span style="color:#EF4444;">*</span></label>
                    <input type="date" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan', date('Y-m-d', strtotime('+7 days'))) }}" required class="fcc-input" style="padding:9px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('tgl_pelaksanaan')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Batas Pendaftaran <span style="color:#EF4444;">*</span></label>
                    <input type="date" name="tgl_batas_daftar" value="{{ old('tgl_batas_daftar', date('Y-m-d', strtotime('+5 days'))) }}" required class="fcc-input" style="padding:9px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('tgl_batas_daftar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- JAM & KUOTA GRID --}}
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;margin-bottom:14px;">
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Jam Mulai <span style="color:#EF4444;">*</span></label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai', '08:00') }}" required class="fcc-input" style="padding:9px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('jam_mulai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Jam Selesai <span style="color:#EF4444;">*</span></label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai', '12:00') }}" required class="fcc-input" style="padding:9px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('jam_selesai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Kuota <span style="color:#EF4444;">*</span></label>
                    <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta', 30) }}" min="1" max="500" required class="fcc-input" style="padding:9px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('kuota_peserta')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Peserta <span style="color:#EF4444;">*</span></label>
                    <select name="untuk_peserta" required class="fcc-input" style="padding:9px 8px;font-size:12.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;background:#FFF;">
                        <option value="LP" {{ old('untuk_peserta') == 'LP' ? 'selected' : '' }}>Semua (L/P)</option>
                        <option value="L" {{ old('untuk_peserta') == 'L' ? 'selected' : '' }}>Laki-laki Only</option>
                        <option value="P" {{ old('untuk_peserta') == 'P' ? 'selected' : '' }}>Perempuan Only</option>
                    </select>
                    @error('untuk_peserta')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- PENGATURAN BIAYA --}}
            <div style="margin-bottom:14px;background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:14px;padding:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                    <label style="font-size:11px;font-weight:900;color:#131218;margin:0;text-transform:uppercase;letter-spacing:.5px;">Pengaturan Biaya Pendaftaran</label>
                    <button type="button" onclick="addJadwalBiayaRow()" style="font-size:11px;font-weight:800;color:#131218;background:#FFC81A;border:1px solid #131218;padding:3px 10px;border-radius:14px;cursor:pointer;">
                        + Baris Biaya
                    </button>
                </div>
                <div id="jadwal-biaya-container">
                    <div class="biaya-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;">
                        <input type="text" name="nama_jenis_biaya[]" value="Umum" placeholder="Jenis (contoh: Umum)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                        <input type="number" name="nominal_biaya[]" value="0" placeholder="Nominal (Rp)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                        <span style="width:24px;"></span>
                    </div>
                </div>
                <p style="font-size:11px;color:#64748B;margin:6px 0 0;font-weight:500;">Isi 0 untuk pendaftaran gratis.</p>
            </div>

            {{-- CHECKBOX LANGSUNG AKTIFKAN --}}
            <div style="margin-bottom:18px;background:#FFFDF5;border:1.5px solid #FFC81A;border-radius:12px;padding:12px 14px;display:flex;align-items:center;gap:10px;">
                <input type="checkbox" name="langsung_aktifkan" id="langsung_aktifkan_modal" value="1" style="width:18px;height:18px;accent-color:#131218;cursor:pointer;">
                <label for="langsung_aktifkan_modal" style="font-size:12.5px;font-weight:800;color:#131218;cursor:pointer;margin:0;">
                    Langsung Aktifkan Sebagai Kegiatan Publik
                    <span style="display:block;font-size:11px;font-weight:500;color:#64748B;">Jadwal akan langsung tampil di halaman depan untuk pendaftar.</span>
                </label>
            </div>

            {{-- Actions --}}
            <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:16px;">
                <button type="button" onclick="closeJadwalModal()"
                        style="padding:11px 22px;font-size:13px;font-weight:800;color:#64748B;background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:30px;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
                    Batal
                </button>
                <button type="submit"
                        style="padding:11px 26px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
                        onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                    @include('components.icon',['name'=>'check','size'=>16]) Simpan Batch Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openJadwalModal() {
    document.getElementById('jadwal-modal').style.display = 'flex';
}

function closeJadwalModal() {
    document.getElementById('jadwal-modal').style.display = 'none';
}

function addJadwalBiayaRow() {
    const container = document.getElementById('jadwal-biaya-container');
    const div = document.createElement('div');
    div.className = 'biaya-row';
    div.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;';
    div.innerHTML = `
        <input type="text" name="nama_jenis_biaya[]" placeholder="contoh: Mahasiswa UMI" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
        <input type="number" name="nominal_biaya[]" placeholder="Nominal (Rp)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
        <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;">✕</button>
    `;
    container.appendChild(div);
}

function handleImagePreview(input, previewId, labelId, statusId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        const label = document.getElementById(labelId);
        const status = document.getElementById(statusId);
        
        if (preview) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        if (label) {
            label.textContent = 'Ganti File Gambar (' + file.name + ')';
        }
        if (status) {
            status.innerHTML = '✨ <span style="color:#10B981;font-weight:900;">Foto Baru Terpilih:</span> ' + file.name;
        }
    };
    reader.readAsDataURL(file);
}
</script>

{{-- ── EDIT PELATIHAN MODAL ────────────────────────────────────── --}}
@include('admin.pelatihan.tambah.edit-modal')
@endsection
