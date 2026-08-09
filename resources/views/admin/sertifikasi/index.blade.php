@extends('layouts.admin')
@section('title', 'Program Sertifikasi')

@section('page-content')
<div style="padding:24px;position:relative;">

    {{-- ═══ SKELETON LOADING OVERLAY ═════════════════════════════════ --}}
    <style>
      @keyframes skeletonShimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
      }
      .fcc-skeleton-box {
        background: linear-gradient(90deg, #E2E8F0 25%, #F1F5F9 50%, #E2E8F0 75%);
        background-size: 200% 100%;
        animation: skeletonShimmer 1.4s infinite ease-in-out;
        border-radius: 12px;
      }
      #sertifikasi-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="sertifikasi-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      {{-- Header Skeleton --}}
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:110px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:200px;height:12px;"></div>
        </div>
        <div class="fcc-skeleton-box" style="width:180px;height:40px;border-radius:30px;"></div>
      </div>
      {{-- 2 Stat Cards Skeleton --}}
      <div style="display:grid;grid-template-columns:repeat(2, 1fr);gap:16px;margin-bottom:24px;">
        @for($sc=0;$sc<2;$sc++)
        <div style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;display:flex;align-items:center;gap:14px;">
          <div class="fcc-skeleton-box" style="width:44px;height:44px;border-radius:12px;flex-shrink:0;"></div>
          <div style="flex:1;">
            <div class="fcc-skeleton-box" style="width:65%;height:12px;margin-bottom:6px;"></div>
            <div class="fcc-skeleton-box" style="width:40%;height:20px;"></div>
          </div>
        </div>
        @endfor
      </div>
      {{-- Table Skeleton --}}
      <div style="padding:28px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('sertifikasi-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Katalog Master</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Program Sertifikasi</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola master data program sertifikasi, modul materi, dan biaya pendaftaran.</p>
        </div>
        <button type="button" onclick="document.getElementById('create-modal').style.display='flex'"
                style="padding:10px 22px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 14px rgba(255,200,26,0.35);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            @include('components.icon',['name'=>'plus','size'=>16]) Tambah Sertifikasi Baru
        </button>
    </div>

    {{-- Stat Cards Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#FFC81A;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;box-shadow:0 4px 10px rgba(255,200,26,0.25);flex-shrink:0;">
                @include('components.icon',['name'=>'award','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Sertifikasi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $sertifikasi->total() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Program</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#EEF2FF;border:1.5px solid #6366F1;display:flex;align-items:center;justify-content:center;color:#6366F1;flex-shrink:0;">
                @include('components.icon',['name'=>'tag','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Kategori Sertifikasi</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ $kategori->count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Kategori</span></p>
            </div>
        </div>

        <div class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;">
            <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;flex-shrink:0;">
                @include('components.icon',['name'=>'calendar','size'=>20])
            </div>
            <div>
                <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Jadwal Terdaftar</p>
                <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ \App\Models\JadwalSertifikasi::count() }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Batch</span></p>
            </div>
        </div>
    </div>

    {{-- Main Neo-Brutalist Table Card --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;">
            <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Master Sertifikasi</h3>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $sertifikasi->total() }} Data</span>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Kode</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Program Sertifikasi</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Kategori</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">Status Modul &amp; Jadwal</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sertifikasi as $s)
                    <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
                        {{-- Kode --}}
                        <td style="padding:14px 20px;vertical-align:middle;">
                            <span style="font-size:12px;font-weight:900;color:#FFC81A;background:#131218;padding:4px 10px;border-radius:8px;font-family:monospace;letter-spacing:0.5px;border:1px solid #131218;display:inline-block;">
                                {{ $s->kode }}
                            </span>
                        </td>

                        {{-- Judul --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <div style="display:flex;align-items:center;gap:12px;">
                                @if($s->gambar_url || $s->gambar)
                                    <img src="{{ $s->gambar_url ?? asset('storage/'.$s->gambar) }}" alt="{{ $s->judul }}" style="width:42px;height:42px;border-radius:10px;object-fit:cover;border:1.5px solid #131218;flex-shrink:0;">
                                @else
                                    <div style="width:42px;height:42px;border-radius:10px;background:#F1F5F9;border:1.5px solid #CBD5E1;display:flex;align-items:center;justify-content:center;color:#94A3B8;flex-shrink:0;">
                                        @include('components.icon',['name'=>'award','size'=>18])
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.sertifikasi.show', $s) }}" style="font-size:14px;font-weight:900;color:#131218;text-decoration:none;margin:0;display:block;transition:color .15s;" onmouseover="this.style.color='#3B82F6'" onmouseout="this.style.color='#131218'">
                                        {{ $s->judul }}
                                    </a>
                                    <span style="font-size:11px;color:#64748B;font-weight:600;">Dibuat: {{ $s->created_at?->translatedFormat('d M Y') ?? '—' }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td style="padding:14px 16px;vertical-align:middle;white-space:nowrap;">
                            <span style="font-size:11.5px;font-weight:800;color:#475569;background:#F1F5F9;padding:4px 12px;border-radius:20px;border:1px solid #E2E8F0;display:inline-block;white-space:nowrap;">
                                {{ $s->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </td>

                        {{-- Modul & Jadwal Stats --}}
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <span style="font-size:11px;font-weight:800;color:#131218;background:#FFFDF5;border:1px solid #FFC81A;padding:3px 9px;border-radius:8px;">
                                    📅 {{ $s->jadwal()->count() }} Jadwal
                                </span>
                                <span style="font-size:11px;font-weight:800;color:#3B82F6;background:#EFF6FF;border:1px solid #93C5FD;padding:3px 9px;border-radius:8px;">
                                    📚 {{ $s->materi()->count() }} Materi
                                </span>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
                            <div style="display:inline-flex;gap:6px;align-items:center;">
                                {{-- Detail Button --}}
                                <a href="{{ route('admin.sertifikasi.show', $s) }}" title="Detail Sertifikasi"
                                   style="width:32px;height:32px;border-radius:9px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;text-decoration:none;transition:all .18s;"
                                   onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                                    @include('components.icon',['name'=>'eye','size'=>15])
                                </a>

                                {{-- Edit Button (Modal Trigger) --}}
                                <button type="button" onclick="document.getElementById('edit-modal-{{ $s->id }}').style.display='flex'" title="Edit Sertifikasi"
                                        style="width:32px;height:32px;border-radius:9px;background:#F8FAFC;border:1.5px solid #E2E8F0;display:flex;align-items:center;justify-content:center;color:#131218;cursor:pointer;transition:all .18s;padding:0;"
                                        onmouseover="this.style.background='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F8FAFC';this.style.borderColor='#E2E8F0';">
                                    @include('components.icon',['name'=>'edit','size'=>15])
                                </button>

                                {{-- Hapus Button --}}
                                <form action="{{ route('admin.sertifikasi.destroy', $s) }}" method="POST" style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="fccConfirmDelete(this, 'Hapus Sertifikasi', 'Apakah Anda yakin ingin menghapus sertifikasi {{ addslashes($s->judul) }}?')" title="Hapus Sertifikasi"
                                            style="width:32px;height:32px;border-radius:9px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;color:#EF4444;cursor:pointer;transition:all .18s;padding:0;"
                                            onmouseover="this.style.background='#EF4444';this.style.color='#FFFFFF';this.style.borderColor='#131218';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';this.style.borderColor='#FCA5A5';">
                                        @include('components.icon',['name'=>'trash','size'=>15])
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:48px 24px;color:#94A3B8;">
                            <div style="width:52px;height:52px;background:#F7F8FA;border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'award','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-weight:900;color:#131218;margin:0 0 4px;font-size:14px;">Belum Ada Data Sertifikasi</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Silakan tambahkan program sertifikasi pertama dengan mengklik tombol Tambah Sertifikasi Baru di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sertifikasi->hasPages())
        <div style="padding:16px 24px;border-top:1px solid #F1F5F9;">
            {{ $sertifikasi->links() }}
        </div>
        @endif
    </div>
</div>

{{-- ── TAMBAH SERTIFIKASI MODAL (Neo-Brutalist Glassmorphism) ───────────────────────────────────── --}}
<div id="create-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,0.65);backdrop-filter:blur(8px);align-items:center;justify-content:center;" onclick="if(event.target===this) this.style.display='none'">
    <div style="background:#FFFFFF;border:2px solid #131218;border-radius:24px;padding:32px;max-width:680px;width:92%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.3);max-height:90vh;overflow-y:auto;display:flex;flex-direction:column;" onclick="event.stopPropagation()">
        
        {{-- Close button --}}
        <button type="button" onclick="document.getElementById('create-modal').style.display='none'" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:1.5px solid #131218;background:#FFC81A;cursor:pointer;color:#131218;
            font-size:18px;font-weight:900;line-height:1;border-radius:10px;transition:all .18s;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.transform='rotate(90deg)'"
            onmouseout="this.style.transform='rotate(0deg)'">&#215;</button>

        <div style="margin-bottom:20px;border-bottom:2px solid #E5E7EB;padding-bottom:14px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                <span style="background:#131218;color:#FFC81A;font-size:10.5px;font-weight:900;padding:2px 8px;border-radius:6px;">MASTER DATA</span>
                <h2 style="font-size:19px;font-weight:900;color:#131218;margin:0;">Tambah Program Sertifikasi</h2>
            </div>
            <p style="color:#64748B;font-size:12.5px;margin:0;font-weight:500;">Isi informasi program sertifikasi baru.</p>
        </div>

        <form action="{{ route('admin.sertifikasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:14px;">
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Kode Sertifikasi <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="kode" value="{{ old('kode') }}" placeholder="CERT-001" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                    @error('kode')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Kategori Program <span style="color:#EF4444;">*</span></label>
                    <select name="kategori_id" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;background:#FFF;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id')==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Judul Sertifikasi <span style="color:#EF4444;">*</span></label>
                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Judul program sertifikasi" required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;">
                @error('judul')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Deskripsi Program <span style="color:#EF4444;">*</span></label>
                <textarea name="isi" rows="4" placeholder="Deskripsi program sertifikasi..." required class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;resize:vertical;">{{ old('isi') }}</textarea>
                @error('isi')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:11px;font-weight:800;color:#131218;display:block;margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px;">Gambar / Poster Sampul</label>
                <label style="display:flex;align-items:center;gap:10px;border:1.5px dashed #CBD5E1;border-radius:12px;padding:12px 16px;cursor:pointer;transition:all .18s;background:#F8FAFC;"
                       onmouseover="this.style.borderColor='#131218';this.style.background='#FFFDF5';" onmouseout="this.style.borderColor='#CBD5E1';this.style.background='#F8FAFC';">
                    @include('components.icon',['name'=>'image','size'=>18,'style'=>'color:#131218'])
                    <span style="font-size:13px;color:#131218;font-weight:700;">Klik untuk Upload Gambar Sampul</span>
                    <input type="file" name="gambar" accept="image/*" style="display:none;" onchange="previewGambar(this, 'gambar-preview')">
                </label>
                @error('gambar')<p style="color:#EF4444;font-size:11px;margin:4px 0 0;">{{ $message }}</p>@enderror
            </div>

            {{-- Actions --}}
            <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:14px;">
                <button type="button" onclick="document.getElementById('create-modal').style.display='none'"
                        style="padding:11px 22px;font-size:13px;font-weight:800;color:#64748B;background:#F1F5F9;border:1.5px solid #CBD5E1;border-radius:30px;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#131218';this.style.color='#FFC81A';this.style.borderColor='#131218';" onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';this.style.borderColor='#CBD5E1';">
                    Batal
                </button>
                <button type="submit"
                        style="padding:11px 26px;font-size:13.5px;font-weight:900;background:#FFC81A;color:#131218;border:1.5px solid #131218;border-radius:30px;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(255,200,26,0.35);transition:all .18s;"
                        onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';">
                    @include('components.icon',['name'=>'check','size'=>16]) Simpan Sertifikasi
                </button>
            </div>
        </form>
    </div>
</div>

@include('admin.sertifikasi.edit-modal')
@endsection

@push('scripts')
<script>
function previewGambar(input, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        preview.src = e.target.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(file);
}
</script>

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('create-modal').style.display = 'flex';
});
</script>
@endif
@endpush
