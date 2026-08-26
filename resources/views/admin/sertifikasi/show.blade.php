@extends('layouts.admin')
@section('title','Detail Sertifikasi — ' . $sertifikasi->judul)

@section('page-content')
<div style="padding:24px;">

  {{-- Header Bar --}}
  <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
    <div>
      <a href="{{ route('admin.sertifikasi.index') }}"
         style="display:inline-flex;align-items:center;gap:6px;color:#64748B;font-size:12.5px;font-weight:700;text-decoration:none;margin-bottom:10px;background:#F1F5F9;padding:5px 12px;border-radius:20px;border:1px solid #CBD5E1;transition:all .18s;"
         onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
        @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali ke Katalog Sertifikasi
      </a>
      <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 12px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;">
          {{ $sertifikasi->kode }}
        </span>
        <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">{{ $sertifikasi->judul }}</h1>
      </div>
    </div>

    <div style="display:flex;gap:10px;flex-wrap:wrap;">
      <button type="button" onclick="openJadwalModal()" style="display:inline-flex;align-items:center;gap:8px;padding:9.5px 20px;border-radius:30px;border:1.5px solid #131218;background:#FFC81A;color:#131218;font-size:13px;font-weight:900;cursor:pointer;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
         onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
        @include('components.icon',['name'=>'calendar','size'=>14]) Tambah Batch Jadwal
      </button>
      <button type="button" onclick="document.getElementById('edit-modal-{{ $sertifikasi->id }}').style.display='flex'" style="display:inline-flex;align-items:center;gap:8px;padding:9.5px 16px;border-radius:30px;border:1.5px solid #131218;background:#131218;color:#FFC81A;font-size:13px;font-weight:800;cursor:pointer;transition:all .18s;">
        @include('components.icon',['name'=>'edit','size'=>14,'style'=>'color:#FFC81A']) Edit Sertifikasi
      </button>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
    {{-- Kiri: Jadwal --}}
    <div>
      <div class="fcc-card" style="padding:0;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid #E2E4EB;display:flex;justify-content:space-between;align-items:center;">
          <p style="margin:0;font-size:14px;font-weight:800;color:#131218;">Jadwal ({{ $sertifikasi->jadwal->count() }})</p>
          <button type="button" onclick="openJadwalModal()" style="font-size:12px;color:#FFC81A;font-weight:800;background:#131218;padding:4px 12px;border-radius:14px;border:none;cursor:pointer;">+ Tambah Jadwal</button>
        </div>
        @forelse($sertifikasi->jadwal as $j)
        @php $ks = $j->kegiatanSertifikasi; @endphp
        <div style="padding:12px 18px;border-top:1px solid #F0F1F5;">
          <div style="display:flex;justify-content:space-between;align-items:center;">
            <div>
              @php
                $isPassedSchedule = $j->tgl_pelaksanaan && $j->tgl_pelaksanaan->lte(now()->startOfDay());
                $isRegClosedSchedule = $j->tgl_batas_daftar && $j->tgl_batas_daftar->lt(now()->startOfDay());
              @endphp
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;flex-wrap:wrap;">
                @if($j->nama_kegiatan)
                  <span style="font-size:13.5px;font-weight:900;color:#131218;">{{ $j->nama_kegiatan }}</span>
                @else
                  <span style="font-size:13.5px;font-weight:900;color:#131218;">Batch {{ $j->tgl_pelaksanaan?->format('d M Y') }}</span>
                @endif

                {{-- Status Execution Badge --}}
                @if($isPassedSchedule)
                  <span style="background:#F1F5F9;color:#475569;border:1.5px solid #CBD5E1;font-size:10px;font-weight:900;padding:2px 8px;border-radius:12px;display:inline-flex;align-items:center;gap:4px;">
                    ✓ Telah Dilaksanakan
                  </span>
                @else
                  <span style="background:#FFFDF5;color:#131218;border:1.5px solid #FFC81A;font-size:10px;font-weight:900;padding:2px 8px;border-radius:12px;display:inline-flex;align-items:center;gap:4px;">
                    ⏱ Akan Datang
                  </span>
                @endif

                {{-- Status Registration Badge --}}
                @if($isRegClosedSchedule)
                  <span style="background:#FEF2F2;color:#EF4444;border:1px solid #FCA5A5;font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;">
                    Pendaftaran Ditutup
                  </span>
                @elseif($j->tgl_batas_daftar)
                  <span style="background:#ECFDF5;color:#10B981;border:1px solid #A7F3D0;font-size:10px;font-weight:800;padding:2px 8px;border-radius:12px;">
                    Buka s/d {{ $j->tgl_batas_daftar->format('d M Y') }}
                  </span>
                @endif
              </div>

              <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;">
                Pelaksanaan: <strong style="color:#131218;">{{ $j->tgl_pelaksanaan?->format('d M Y') }}</strong> &bull; {{ $j->jam_mulai ? substr($j->jam_mulai, 0, 5) : '08:00' }} – {{ $j->jam_selesai ? substr($j->jam_selesai, 0, 5) : '12:00' }} &bull; Kuota: <strong style="color:#131218;">{{ $j->kuota_peserta }}</strong>
              </p>
              
              @php
                $effectiveBiaya = $ks?->kegiatan?->biaya;
              @endphp
              @if($effectiveBiaya && $effectiveBiaya->isNotEmpty())
              <div style="margin-top:6px;display:flex;gap:4px;flex-wrap:wrap;">
                @foreach($effectiveBiaya as $b)
                <span style="font-size:10px;font-weight:700;background:#F8F9FB;border:1px solid #E2E4EB;color:#6B7280;padding:2px 8px;border-radius:12px;">{{ $b->nama_jenis }}: Rp{{ number_format($b->nominal,0,',','.') }}</span>
                @endforeach
              </div>
              @elseif(!empty($j->biaya_setup) && is_array($j->biaya_setup))
              <div style="margin-top:6px;display:flex;gap:4px;flex-wrap:wrap;">
                @foreach($j->biaya_setup as $b)
                <span style="font-size:10px;font-weight:700;background:#F8F9FB;border:1px solid #E2E4EB;color:#6B7280;padding:2px 8px;border-radius:12px;">{{ $b['nama'] }}: Rp{{ number_format($b['nominal'],0,',','.') }}</span>
                @endforeach
              </div>
              @endif
            </div>
            <div style="display:flex;align-items:center;gap:6px;flex-wrap:nowrap;">
              {{-- STATUS DROPDOWN SELECTOR --}}
              @php
                $st = $ks?->kegiatan?->status ?? 'draf';
              @endphp
              <form action="{{ route('admin.jadwal-sertifikasi.status', $j) }}" method="POST" style="margin:0;display:inline-block;">
                @csrf
                <select name="status" onchange="this.form.submit()" title="Ubah Status Publikasi Jadwal"
                        style="padding:6px 10px;font-size:11.5px;font-weight:800;border-radius:10px;border:1.5px solid #131218;cursor:pointer;outline:none;
                               background:{{ $st === 'public' ? '#ECFDF5' : ($st === 'comingsoon' ? '#FFFDF5' : '#F8FAFC') }};
                               color:{{ $st === 'public' ? '#059669' : ($st === 'comingsoon' ? '#D97706' : '#64748B') }};">
                  <option value="draf" {{ $st === 'draf' ? 'selected' : '' }}>Draft</option>
                  <option value="comingsoon" {{ $st === 'comingsoon' ? 'selected' : '' }}>Coming Soon</option>
                  <option value="public" {{ $st === 'public' ? 'selected' : '' }}>Publik</option>
                </select>
              </form>

              @if($ks)
                {{-- Lihat Halaman Detail Kegiatan Icon Button --}}
                <a href="{{ route('admin.kegiatan.show', $ks->kegiatan) }}" target="_blank" title="Lihat Detail Kegiatan"
                   style="width:32px;height:32px;border-radius:9px;background:#EFF6FF;border:1.5px solid #93C5FD;display:flex;align-items:center;justify-content:center;color:#3B82F6;text-decoration:none;transition:all .18s;"
                   onmouseover="this.style.background='#3B82F6';this.style.color='#FFFFFF';this.style.borderColor='#3B82F6';" onmouseout="this.style.background='#EFF6FF';this.style.color='#3B82F6';this.style.borderColor='#93C5FD';">
                  @include('components.icon',['name'=>'eye','size'=>15])
                </a>
              @endif

              {{-- Edit Button (Modal Trigger) --}}
              <button type="button" onclick="document.getElementById('edit-jadwal-modal-{{ $j->id }}').style.display='flex'" title="Edit Jadwal"
                 style="width:32px;height:32px;border-radius:9px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;cursor:pointer;transition:all .18s;padding:0;"
                 onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                @include('components.icon',['name'=>'edit','size'=>15])
              </button>

              {{-- Hapus Button --}}
              <form action="{{ route('admin.jadwal-sertifikasi.destroy', $j) }}" method="POST" style="margin:0;" onsubmit="return fccConfirmDelete(event, this, 'Hapus Jadwal', 'Apakah Anda yakin ingin menghapus jadwal sertifikasi ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="width:32px;height:32px;border-radius:9px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;color:#EF4444;cursor:pointer;transition:all .18s;padding:0;" title="Hapus Jadwal"
                        onmouseover="this.style.background='#EF4444';this.style.color='#FFFFFF';this.style.borderColor='#EF4444';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                  @include('components.icon',['name'=>'trash','size'=>15])
                </button>
              </form>
            </div>
          </div>
        </div>

        {{-- ── EDIT BATCH JADWAL MODAL (Neo-Brutalist) ────────────────────────────── --}}
        <div id="edit-jadwal-modal-{{ $j->id }}" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;padding:16px;" onclick="if(event.target===this) this.style.display='none'">
            <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:640px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;text-align:left;" onclick="event.stopPropagation()">
                
                {{-- Close button --}}
                <button type="button" onclick="document.getElementById('edit-jadwal-modal-{{ $j->id }}').style.display='none'" aria-label="Tutup" style="
                    position:absolute;top:20px;right:20px;width:32px;height:32px;
                    border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
                    font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
                    onmouseover="this.style.transform='rotate(90deg)'"
                    onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

                <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                        <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;">EDIT BATCH JADWAL</span>
                        <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Edit Jadwal Sertifikasi</h2>
                    </div>
                    <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Perbarui tanggal, waktu, kuota, dan rincian biaya pendaftaran.</p>
                </div>

                <form action="{{ route('admin.jadwal-sertifikasi.update', $j) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- NAMA KEGIATAN --}}
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Nama / Label Batch <span style="font-weight:500;color:#64748B;">(Opsional)</span></label>
                        <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $j->nama_kegiatan) }}" placeholder="Contoh: {{ $sertifikasi->judul }} - Batch" class="fcc-input" style="padding:9px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    </div>

                    {{-- TANGGAL GRID --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                        <div>
                            <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Batas Pendaftaran <span style="color:#EF4444;">*</span></label>
                            <input type="date" name="tgl_batas_daftar" value="{{ old('tgl_batas_daftar', $j->tgl_batas_daftar?->format('Y-m-d')) }}" required class="fcc-input" style="padding:9px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Tanggal Pelaksanaan <span style="color:#EF4444;">*</span></label>
                            <input type="date" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan', $j->tgl_pelaksanaan?->format('Y-m-d')) }}" required class="fcc-input" style="padding:9px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                        </div>
                    </div>

                    {{-- JAM & KUOTA GRID --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;margin-bottom:14px;">
                        <div>
                            <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Jam Mulai <span style="color:#EF4444;">*</span></label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $j->jam_mulai ? substr($j->jam_mulai,0,5) : '08:00') }}" required class="fcc-input" style="padding:9px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Jam Selesai <span style="color:#EF4444;">*</span></label>
                            <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $j->jam_selesai ? substr($j->jam_selesai,0,5) : '12:00') }}" required class="fcc-input" style="padding:9px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Kuota <span style="color:#EF4444;">*</span></label>
                            <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta', $j->kuota_peserta) }}" min="1" max="500" required class="fcc-input" style="padding:9px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                        </div>
                        <div>
                            <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Peserta <span style="color:#EF4444;">*</span></label>
                            <select name="untuk_peserta" required class="fcc-input" style="padding:9px 8px;font-size:12.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;background:#FFF;">
                                <option value="LP" {{ old('untuk_peserta', $j->untuk_peserta) == 'LP' ? 'selected' : '' }}>Semua (L/P)</option>
                                <option value="L" {{ old('untuk_peserta', $j->untuk_peserta) == 'L' ? 'selected' : '' }}>Laki-laki Only</option>
                                <option value="P" {{ old('untuk_peserta', $j->untuk_peserta) == 'P' ? 'selected' : '' }}>Perempuan Only</option>
                            </select>
                        </div>
                    </div>

                    {{-- PENGATURAN BIAYA --}}
                    <div style="margin-bottom:14px;background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:14px;padding:14px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                            <label style="font-size:11px;font-weight:900;color:#131218;margin:0;text-transform:uppercase;letter-spacing:.5px;">Pengaturan Biaya Pendaftaran</label>
                            <button type="button" onclick="addEditJadwalBiayaRow_{{ $j->id }}()" style="font-size:11px;font-weight:800;color:#131218;background:#FFC81A;border:1px solid #131218;padding:3px 10px;border-radius:14px;cursor:pointer;">
                                + Baris Biaya
                            </button>
                        </div>
                        <div id="edit-jadwal-biaya-container-{{ $j->id }}">
                            @php $biayas = !empty($j->biaya_setup) && is_array($j->biaya_setup) ? $j->biaya_setup : []; @endphp
                            @forelse($biayas as $index => $b)
                            <div class="biaya-row-edit-{{ $j->id }}" style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;">
                                <input type="text" name="nama_jenis_biaya[]" value="{{ $b['nama'] }}" placeholder="Jenis (contoh: Umum)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                                <input type="number" name="nominal_biaya[]" value="{{ $b['nominal'] }}" placeholder="Nominal (Rp)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                                <button type="button" onclick="this.closest('.biaya-row-edit-{{ $j->id }}').remove()" style="background:#FEF2F2;border:1px solid #FCA5A5;color:#EF4444;width:30px;height:30px;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;padding:0;" title="Hapus">
                                    @include('components.icon',['name'=>'trash','size'=>14])
                                </button>
                            </div>
                            @empty
                            <div class="biaya-row-edit-{{ $j->id }}" style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;">
                                <input type="text" name="nama_jenis_biaya[]" value="Umum" placeholder="Jenis (contoh: Umum)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                                <input type="number" name="nominal_biaya[]" value="0" placeholder="Nominal (Rp)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                                <span style="width:30px;"></span>
                            </div>
                            @endforelse
                        </div>
                        <p style="font-size:11px;color:#64748B;margin:6px 0 0;font-weight:500;">Isi 0 untuk pendaftaran gratis.</p>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div style="display:flex;gap:12px;justify-content:flex-end;align-items:center;border-top:1.5px solid #E5E7EB;padding-top:16px;">
                        <button type="button" onclick="document.getElementById('edit-jadwal-modal-{{ $j->id }}').style.display='none'" style="padding:9px 22px;font-size:13px;font-weight:800;border-radius:30px;border:1.5px solid #CBD5E1;background:#F8FAFC;color:#64748B;cursor:pointer;">
                            Batal
                        </button>
                        <button type="submit" style="padding:9px 24px;font-size:13px;font-weight:900;border-radius:30px;border:1.5px solid #131218;background:#FFC81A;color:#131218;cursor:pointer;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
        function addEditJadwalBiayaRow_{{ $j->id }}() {
            const container = document.getElementById('edit-jadwal-biaya-container-{{ $j->id }}');
            const div = document.createElement('div');
            div.className = 'biaya-row-edit-{{ $j->id }}';
            div.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;';
            div.innerHTML = `
                <input type="text" name="nama_jenis_biaya[]" placeholder="Jenis (contoh: Mahasiswa)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                <input type="number" name="nominal_biaya[]" placeholder="Nominal (Rp)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                <button type="button" onclick="this.closest('.biaya-row-edit-{{ $j->id }}').remove()" style="background:#FEF2F2;border:1px solid #FCA5A5;color:#EF4444;width:30px;height:30px;border-radius:8px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;padding:0;" title="Hapus">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path></svg>
                </button>
            `;
            container.appendChild(div);
        }
        </script>
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
            ['Kategori', $sertifikasi->kategori->nama_kategori??'—'],
            ['Total Modul Materi', $sertifikasi->materi->count().' Modul'],
            ['Tanggal Dibuat', $sertifikasi->created_at->translatedFormat('d M Y')],
          ] as [$l,$v])
          <div>
            <p style="margin:0;font-size:10.5px;font-weight:900;color:#64748B;text-transform:uppercase;letter-spacing:.7px;">{{ $l }}</p>
            <p style="margin:3px 0 0;font-size:14px;font-weight:900;color:#131218;">{{ $v }}</p>
          </div>
          @endforeach
          @if($sertifikasi->link_materi)
          <div>
            <p style="margin:0 0 3px;font-size:10.5px;font-weight:900;color:#64748B;text-transform:uppercase;letter-spacing:.7px;">Link Utama</p>
            <a href="{{ $sertifikasi->link_materi }}" target="_blank" style="font-size:13px;color:#FFC81A;background:#131218;padding:4px 12px;border-radius:8px;font-weight:800;text-decoration:none;display:inline-block;">Buka Link &rarr;</a>
          </div>
          @endif
        </div>
      </div>

      <div class="fcc-card" style="padding:20px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <p style="font-size:14px;font-weight:900;color:#131218;margin:0 0 10px;">Deskripsi Program</p>
        <p style="color:#475569;font-size:13px;line-height:1.75;margin:0;font-weight:500;">{{ $sertifikasi->isi }}</p>
      </div>
    </div>
  </div>
</div>

{{-- ── TAMBAH BATCH JADWAL MODAL (Neo-Brutalist Glassmorphism) ────────────────────────────────────── --}}
<div id="jadwal-modal" style="display:{{ $errors->any() ? 'flex' : 'none' }};position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;" onclick="if(event.target===this) closeJadwalModal()">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:640px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;" onclick="event.stopPropagation()">
        
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
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Tambah Batch Jadwal Sertifikasi</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Jadwalkan tanggal dan jam pelaksanaan untuk {{ $sertifikasi->judul }}.</p>
        </div>

        <form action="{{ route('admin.jadwal-sertifikasi.store', $sertifikasi) }}" method="POST" onsubmit="return validateJadwalTime(this)">
            @csrf
            
            {{-- NAMA KEGIATAN --}}
            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Nama / Label Batch <span style="font-weight:500;color:#64748B;">(Opsional)</span></label>
                <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" placeholder="Contoh: {{ $sertifikasi->judul }} - Batch {{ $sertifikasi->jadwal->count() + 1 }}" class="fcc-input" style="padding:9px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                @error('nama_kegiatan')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- TANGGAL GRID --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:14px;">
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Batas Pendaftaran <span style="color:#EF4444;">*</span></label>
                    <input type="date" name="tgl_batas_daftar" value="{{ old('tgl_batas_daftar') }}" required class="fcc-input" style="padding:9px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('tgl_batas_daftar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Tanggal Pelaksanaan <span style="color:#EF4444;">*</span></label>
                    <input type="date" name="tgl_pelaksanaan" value="{{ old('tgl_pelaksanaan') }}" required class="fcc-input" style="padding:9px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('tgl_pelaksanaan')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- JAM & KUOTA GRID --}}
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:12px;margin-bottom:14px;">
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Jam Mulai <span style="color:#EF4444;">*</span></label>
                    <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}" required class="fcc-input" style="padding:9px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('jam_mulai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Jam Selesai <span style="color:#EF4444;">*</span></label>
                    <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}" required class="fcc-input" style="padding:9px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('jam_selesai')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.5px;">Kuota <span style="color:#EF4444;">*</span></label>
                    <input type="number" name="kuota_peserta" value="{{ old('kuota_peserta') }}" placeholder="30" min="1" max="500" required class="fcc-input" style="padding:9px 10px;font-size:13px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
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
                        <input type="text" name="nama_jenis_biaya[]" value="{{ old('nama_jenis_biaya.0') }}" placeholder="Jenis (contoh: Umum)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                        <input type="number" name="nominal_biaya[]" value="{{ old('nominal_biaya.0') }}" placeholder="Nominal (Rp)" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
                        <span style="width:24px;"></span>
                    </div>
                </div>
                <p style="font-size:11px;color:#64748B;margin:6px 0 0;font-weight:500;">Isi 0 untuk pendaftaran gratis.</p>
            </div>

            {{-- STATUS PUBLIKASI --}}
            <div style="margin-bottom:18px;background:#FFFDF5;border:1.5px solid #FFC81A;border-radius:12px;padding:12px 14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Status Publikasi Kegiatan</label>
                <select name="status" class="fcc-input" style="padding:9px 12px;font-size:13px;width:100%;border:1.5px solid #131218;border-radius:10px;background:#FFF;font-weight:800;">
                    <option value="public" {{ old('status') == 'public' ? 'selected' : '' }}>Publik (Terbuka untuk Pendaftaran)</option>
                    <option value="comingsoon" {{ old('status') == 'comingsoon' ? 'selected' : '' }}>Coming Soon (Segera Hadir di Katalog)</option>
                    <option value="draf" {{ old('status') == 'draf' ? 'selected' : '' }}>Draft (Konsep Internal Admin)</option>
                </select>
                <p style="margin:6px 0 0;font-size:11px;color:#64748B;font-weight:500;">Pilih 'Coming Soon' jika ingin kegiatan sudah tampil bagi pengguna namun pendaftaran belum dibuka.</p>
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

function validateJadwalTime(form) {
    const jamMulai = form.querySelector('input[name="jam_mulai"]');
    const jamSelesai = form.querySelector('input[name="jam_selesai"]');
    const tglDaftar = form.querySelector('input[name="tgl_batas_daftar"]');
    const tglPelaksanaan = form.querySelector('input[name="tgl_pelaksanaan"]');
    
    if (tglDaftar && tglDaftar.value) {
        const todayStr = new Date().toISOString().split('T')[0];
        if (tglDaftar.value < todayStr) {
            const msg = 'Tanggal batas pendaftaran tidak boleh tanggal yang sudah lewat!';
            if (typeof window.fccToast === 'function') {
                window.fccToast(msg, 'error', 'Validasi Tanggal Gagal');
            } else {
                alert(msg);
            }
            tglDaftar.focus();
            return false;
        }
    }

    if (tglDaftar && tglPelaksanaan && tglDaftar.value && tglPelaksanaan.value) {
        if (tglPelaksanaan.value < tglDaftar.value) {
            const msg = 'Tanggal pelaksanaan tidak boleh sebelum tanggal batas pendaftaran!';
            if (typeof window.fccToast === 'function') {
                window.fccToast(msg, 'error', 'Validasi Tanggal Gagal');
            } else {
                alert(msg);
            }
            tglPelaksanaan.focus();
            return false;
        }
    }

    if (jamMulai && jamSelesai && jamMulai.value && jamSelesai.value) {
        if (jamSelesai.value <= jamMulai.value) {
            const msg = 'Jam selesai (' + jamSelesai.value + ') harus setelah jam mulai (' + jamMulai.value + ')!';
            if (typeof window.fccToast === 'function') {
                window.fccToast(msg, 'error', 'Validasi Waktu Gagal');
            } else if (typeof window.fccConfirmAction === 'function') {
                window.fccConfirmAction(null, 'Waktu Tidak Valid', msg, 'Saya Mengerti', true);
            } else {
                alert(msg);
            }
            jamSelesai.focus();
            return false;
        }
    }

    return true;
}

function addJadwalBiayaRow() {
    const container = document.getElementById('jadwal-biaya-container');
    const div = document.createElement('div');
    div.className = 'biaya-row';
    div.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:10px;margin-bottom:8px;align-items:center;';
    div.innerHTML = `
        <input type="text" name="nama_jenis_biaya[]" placeholder="contoh: Mahasiswa UMI" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;">
        <input type="number" name="nominal_biaya[]" placeholder="0" class="fcc-input" style="padding:8px 12px;font-size:12.5px;border:1px solid #CBD5E1;border-radius:8px;background:#FFF;" onfocus="this.select()">
        <button type="button" onclick="this.closest('.biaya-row').remove()" style="color:#EF4444;background:none;border:none;cursor:pointer;padding:4px;display:flex;align-items:center;justify-content:center;">✕</button>
    `;
    container.appendChild(div);
}
</script>
@include('admin.sertifikasi.edit-modal')
@endsection
