@extends('layouts.admin')
@section('title','Tambah Sertifikasi')
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
      #create-sertifikasi-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="create-sertifikasi-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px;box-sizing:border-box;pointer-events:none;">
      <div style="margin-bottom:20px;">
        <div class="fcc-skeleton-box" style="width:80px;height:14px;margin-bottom:10px;"></div>
        <div class="fcc-skeleton-box" style="width:240px;height:24px;margin-bottom:6px;"></div>
      </div>
      <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
        <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:18px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:40px;margin-bottom:14px;border-radius:8px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:40px;margin-bottom:14px;border-radius:8px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:120px;border-radius:8px;"></div>
        </div>
        <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
          <div class="fcc-skeleton-box" style="width:120px;height:18px;margin-bottom:18px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:40px;margin-bottom:14px;border-radius:8px;"></div>
          <div class="fcc-skeleton-box" style="width:100%;height:40px;border-radius:8px;"></div>
        </div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('create-sertifikasi-skeleton-overlay');
          if (sk) {
            sk.style.opacity = '0';
            sk.style.visibility = 'hidden';
            setTimeout(function() { sk.style.display = 'none'; }, 350);
          }
        }, 400);
      })();
    </script>
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.sertifikasi.index') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6B7280;font-size:13px;text-decoration:none;margin-bottom:10px;">
            @include('components.icon',['name'=>'chevron-left','size'=>14]) Kembali
        </a>
        <h1 style="font-size:21px;font-weight:900;color:#0F0F14;margin:0 0 3px;">Tambah Program Sertifikasi</h1>
    </div>
    
    @php $edit = isset($sertifikasi); @endphp
    <form action="{{ $edit ? route('admin.sertifikasi.update', $sertifikasi) : route('admin.sertifikasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf @if($edit) @method('PUT') @endif
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">
            <div>
                <div class="fcc-card" style="padding:24px;margin-bottom:16px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 18px;">Informasi Sertifikasi</h3>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kode *</label>
                        <input type="text" name="kode" value="{{ old('kode',$sertifikasi->kode??'') }}" placeholder="CERT-001" required class="fcc-input" {{ $edit?'readonly':'' }}>
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Judul *</label>
                        <input type="text" name="judul" value="{{ old('judul',$sertifikasi->judul??'') }}" placeholder="Judul program sertifikasi" required class="fcc-input">
                    </div>
                    <div style="margin-bottom:14px;">
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Deskripsi *</label>
                        <textarea name="isi" rows="4" placeholder="Deskripsi program sertifikasi..." required class="fcc-input" style="resize:vertical;">{{ old('isi',$sertifikasi->isi??'') }}</textarea>
                    </div>
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Fasilitas &amp; Benefit Keikutsertaan <span style="font-weight:500;color:#64748B;">(Opsional)</span></label>
                        <textarea name="fasilitas_input" rows="3" placeholder="Contoh:&#10;- E-Book & Modul Digital&#10;- Ruang Lab AC & Wi-Fi&#10;- Ujian Ulang 1x Gratis" class="fcc-input" style="padding:9.5px 14px;font-size:13.5px;width:100%;border:1.5px solid #CBD5E1;border-radius:10px;resize:vertical;">{{ old('fasilitas_input') }}</textarea>
                        <p style="color:#64748B;font-size:11px;margin:4px 0 0;font-weight:500;">Tuliskan setiap fasilitas tambahan di baris baru untuk ditampilkan secara otomatis di halaman kegiatan.</p>
                    </div>
                </div>
            </div>
            <div>
                <div class="fcc-card" style="padding:24px;margin-bottom:16px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 18px;">Pengaturan</h3>
                    <div>
                        <label style="font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px;">Kategori *</label>
                        <select name="kategori_id" required class="fcc-input">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id',$sertifikasi->kategori_id??'')==$k->id?'selected':'' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="fcc-card" style="padding:24px;">
                    <h3 style="font-size:15px;font-weight:800;color:#0F0F14;margin:0 0 14px;">Gambar / Poster</h3>
                    @if($edit && isset($sertifikasi->gambar) && $sertifikasi->gambar)
                    <img src="{{ asset('storage/'.$sertifikasi->gambar) }}" style="width:100%;border-radius:10px;margin-bottom:12px;max-height:160px;object-fit:cover;">
                    @endif
                    <label style="display:flex;flex-direction:column;align-items:center;border:2px dashed #E2E4EB;border-radius:10px;padding:20px;cursor:pointer;gap:6px;transition:border-color .2s;"
                           onmouseover="this.style.borderColor='#FFC81A'" onmouseout="this.style.borderColor='#E2E4EB'">
                        @include('components.icon',['name'=>'image','size'=>24,'style'=>'color:#A0A3AD'])
                        <span style="font-size:12px;color:#6B7280;">Upload Gambar</span>
                        <input type="file" name="gambar" accept="image/*" style="display:none;">
                    </label>
                </div>
            </div>
        </div>
        <div style="display:flex;gap:10px;margin-top:18px;">
            <button type="submit" class="fcc-btn-gold" style="padding:11px 28px;font-size:14px;">
                @include('components.icon',['name'=>'check','size'=>15]) {{ $edit ? 'Perbarui' : 'Simpan' }}
            </button>
            <a href="{{ route('admin.sertifikasi.index') }}" style="padding:11px 20px;font-size:14px;font-weight:700;color:#6B7280;text-decoration:none;background:#F7F8FA;border:1px solid #E2E4EB;border-radius:10px;">Batal</a>
        </div>
    </form>

</div>
@endsection
