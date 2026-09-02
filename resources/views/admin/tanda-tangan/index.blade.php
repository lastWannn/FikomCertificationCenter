@extends('layouts.admin')

@section('title', 'Kelola Tanda Tangan Digital')
@section('page-title', 'Pengaturan Tanda Tangan Digital')
@section('page-breadcrumb', 'Konten / Kelola Tanda Tangan')

@section('page-content')
<div style="padding: 24px; max-width: 1300px; margin: 0 auto;">

  {{-- ═══ FORM UPLOAD TANDA TANGAN ═══════════════════════════════ --}}
  <form action="{{ route('admin.tanda-tangan.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- ═══ HEADER BANNER ═════════════════════════════════════════ --}}
    <div style="background: linear-gradient(135deg, #131218 0%, #24222E 100%); border: 2.5px solid #131218; border-radius: 16px; padding: 24px 28px; margin-bottom: 24px; color: #FFF; box-shadow: 4px 4px 0px #131218; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
      <div>
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
          <span style="background: #FFC81A; color: #131218; font-weight: 900; font-size: 11px; padding: 3px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; border: 1.5px solid #131218;">
            Dokumen Resmi
          </span>
          <h1 style="margin: 0; font-size: 22px; font-weight: 900; font-family: 'Outfit', sans-serif;">Pengaturan Tanda Tangan Digital</h1>
        </div>
        <p style="margin: 0; font-size: 13px; color: rgba(255,255,255,0.7); max-width: 680px;">
          Upload file tanda tangan (foto/scan kertas putih atau PNG/WebP) dan sesuaikan nama penandatangan. <strong>Sistem secara otomatis menghapus background putih</strong> agar tanda tangan menyatu sempurna pada Sertifikat dan Invoice.
        </p>
      </div>

      <button type="submit" style="background: #FFC81A; color: #131218; border: 2px solid #131218; border-radius: 12px; padding: 12px 24px; font-size: 13.5px; font-weight: 900; cursor: pointer; box-shadow: 3px 3px 0px #FFF; transition: all .15s; white-space: nowrap;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
        💾 Simpan Pengaturan
      </button>
    </div>

    {{-- ═══ FLASH MESSAGES ═════════════════════════════════════════ --}}
    @if(session('success'))
      <div style="background: #DEF7EC; border: 2px solid #0E9F6E; color: #03543F; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; justify-content: space-between; box-shadow: 3px 3px 0px #0E9F6E;">
        <div style="display: flex; align-items: center; gap: 10px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span>{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; cursor: pointer; color: #03543F;">&times;</button>
      </div>
    @endif

    @if(session('error'))
      <div style="background: #FDE8E8; border: 2px solid #E02424; color: #9B1C1C; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; font-weight: 700; font-size: 13.5px; display: flex; align-items: center; justify-content: space-between; box-shadow: 3px 3px 0px #E02424;">
        <div style="display: flex; align-items: center; gap: 10px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span>{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 16px; cursor: pointer; color: #9B1C1C;">&times;</button>
      </div>
    @endif

    @if($errors->any())
      <div style="background: #FEF08A; border: 2px solid #CA8A04; color: #854D0E; border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; font-weight: 700; font-size: 13px;">
        <ul style="margin: 0; padding-left: 20px;">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 24px; margin-bottom: 28px;">

      {{-- 🎓 CARD 1: DEKAN --}}
      <div style="background: #FFF; border: 2.5px solid #131218; border-radius: 16px; padding: 22px; box-shadow: 5px 5px 0px #131218; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
          <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #F1F5F9; padding-bottom: 14px; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <div style="width: 36px; height: 36px; background: #FEF3C7; border: 1.5px solid #F59E0B; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #B45309;">
                1
              </div>
              <div>
                <h3 style="margin: 0; font-size: 16px; font-weight: 900; color: #131218;">Dekan (Sertifikat Kiri)</h3>
                <span style="font-size: 11.5px; color: #64748B; font-weight: 600;">Digunakan pada Sertifikat</span>
              </div>
            </div>
            <span style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">Sertifikat</span>
          </div>

          <div style="margin-bottom: 14px;">
            <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px;">Nama Lengkap & Gelar</label>
            <input type="text" name="dekan_nama" value="{{ old('dekan_nama', $ttd->dekan_nama) }}" required style="width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 10px; font-size: 13.5px; font-weight: 700; color: #0F172A; outline: none;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='#CBD5E1'">
          </div>

          <div style="margin-bottom: 14px;">
            <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px;">Jabatan Utama</label>
            <input type="text" name="dekan_jabatan" value="{{ old('dekan_jabatan', $ttd->dekan_jabatan) }}" required style="width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 10px; font-size: 13.5px; font-weight: 700; color: #0F172A; outline: none;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='#CBD5E1'">
          </div>

          <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px;">NIP / NIDN (Opsional)</label>
            <input type="text" name="dekan_nip" value="{{ old('dekan_nip', $ttd->dekan_nip) }}" placeholder="Contoh: NIP. 19820..." style="width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 10px; font-size: 13.5px; font-weight: 600; color: #0F172A; outline: none;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='#CBD5E1'">
          </div>

          {{-- Preview & Upload --}}
          <div style="margin-bottom: 10px;">
            <label style="display: flex; align-items: center; justify-content: space-between; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 8px;">
              <span>Upload Tanda Tangan Transparan</span>
              <span style="font-size: 10.5px; font-weight: 700; color: #B45309; background: #FEF3C7; padding: 2px 8px; border-radius: 10px;">PNG / WebP Transparan</span>
            </label>

            <div class="fcc-dropzone" id="dropzone-dekan" style="position: relative; background: #F8FAFC; border: 2.5px dashed #CBD5E1; border-radius: 14px; padding: 20px 16px; text-align: center; cursor: pointer; transition: all 0.2s ease-in-out; overflow: hidden;">
              <input type="file" name="dekan_ttd" accept="image/png,image/webp,image/jpeg,image/svg+xml" id="input-dekan" onchange="handleFileSelect(this, 'dekan')" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">

              <div id="dropzone-content-dekan">
                @if($ttd->dekan_ttd)
                  <div style="margin-bottom: 12px; background: repeating-conic-gradient(#E2E8F0 0% 25%, #FFF 0% 50%) 50% / 16px 16px; border-radius: 10px; padding: 14px; border: 1.5px solid #CBD5E1; display: inline-flex; align-items: center; justify-content: center; min-width: 160px; max-width: 100%; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                    <img src="{{ asset('storage/' . $ttd->dekan_ttd) }}" id="preview-img-dekan" style="max-height: 80px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                  </div>
                  <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <div style="font-size: 12px; font-weight: 800; color: #059669; background: #D1FAE5; border: 1px solid #A7F3D0; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                      <span>TTD Dekan Terpasang</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Drag & drop file baru ke sini atau <u>klik untuk mengganti</u></span>
                  </div>
                @else
                  <div style="padding: 12px 8px;">
                    <div class="drop-icon" style="width: 48px; height: 48px; background: #FEF3C7; border: 2px solid #F59E0B; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto; color: #B45309; transition: transform 0.2s;">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                    <div style="font-size: 13px; font-weight: 800; color: #1E293B;">Drag & Drop file TTD di sini</div>
                    <div style="font-size: 11.5px; color: #64748B; margin-top: 4px; font-weight: 600;">atau <span style="color: #B45309; text-decoration: underline; font-weight: 800;">klik untuk memilih file</span></div>
                    <div style="font-size: 10.5px; color: #94A3B8; margin-top: 8px; font-weight: 700;">Format: PNG, WebP, JPG (Max 2MB)</div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        @if($ttd->dekan_ttd)
          <div style="margin-top: 14px; text-align: right;">
            <button type="button" onclick="confirmDelete('{{ route('admin.tanda-tangan.destroy', 'dekan') }}', 'TTD Dekan')" style="background: #FEE2E2; color: #DC2626; border: 1.5px solid #FCA5A5; font-size: 11.5px; font-weight: 800; padding: 6px 12px; border-radius: 8px; cursor: pointer;">
              Hapus Gambar TTD
            </button>
          </div>
        @endif
      </div>

      {{-- 📜 CARD 2: KETUA UNIT --}}
      <div style="background: #FFF; border: 2.5px solid #131218; border-radius: 16px; padding: 22px; box-shadow: 5px 5px 0px #131218; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
          <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #F1F5F9; padding-bottom: 14px; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <div style="width: 36px; height: 36px; background: #DBEAFE; border: 1.5px solid #2563EB; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #1D4ED8;">
                2
              </div>
              <div>
                <h3 style="margin: 0; font-size: 16px; font-weight: 900; color: #131218;">Ketua Unit (Sertifikat Kanan)</h3>
                <span style="font-size: 11.5px; color: #64748B; font-weight: 600;">Digunakan pada Sertifikat</span>
              </div>
            </div>
            <span style="background: #F1F5F9; border: 1px solid #CBD5E1; color: #475569; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">Sertifikat</span>
          </div>

          <div style="margin-bottom: 14px;">
            <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px;">Nama Lengkap & Gelar</label>
            <input type="text" name="ketua_nama" value="{{ old('ketua_nama', $ttd->ketua_nama) }}" required style="width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 10px; font-size: 13.5px; font-weight: 700; color: #0F172A; outline: none;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='#CBD5E1'">
          </div>

          <div style="margin-bottom: 14px;">
            <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px;">Jabatan Utama</label>
            <input type="text" name="ketua_jabatan" value="{{ old('ketua_jabatan', $ttd->ketua_jabatan) }}" required style="width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 10px; font-size: 13.5px; font-weight: 700; color: #0F172A; outline: none;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='#CBD5E1'">
          </div>

          <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px;">NIP / NIDN (Opsional)</label>
            <input type="text" name="ketua_nip" value="{{ old('ketua_nip', $ttd->ketua_nip) }}" placeholder="Contoh: NIP. 19850..." style="width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 10px; font-size: 13.5px; font-weight: 600; color: #0F172A; outline: none;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='#CBD5E1'">
          </div>

          {{-- Preview & Upload --}}
          <div style="margin-bottom: 10px;">
            <label style="display: flex; align-items: center; justify-content: space-between; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 8px;">
              <span>Upload Tanda Tangan Transparan</span>
              <span style="font-size: 10.5px; font-weight: 700; color: #1D4ED8; background: #DBEAFE; padding: 2px 8px; border-radius: 10px;">PNG / WebP Transparan</span>
            </label>

            <div class="fcc-dropzone" id="dropzone-ketua" style="position: relative; background: #F8FAFC; border: 2.5px dashed #CBD5E1; border-radius: 14px; padding: 20px 16px; text-align: center; cursor: pointer; transition: all 0.2s ease-in-out; overflow: hidden;">
              <input type="file" name="ketua_ttd" accept="image/png,image/webp,image/jpeg,image/svg+xml" id="input-ketua" onchange="handleFileSelect(this, 'ketua')" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">

              <div id="dropzone-content-ketua">
                @if($ttd->ketua_ttd)
                  <div style="margin-bottom: 12px; background: repeating-conic-gradient(#E2E8F0 0% 25%, #FFF 0% 50%) 50% / 16px 16px; border-radius: 10px; padding: 14px; border: 1.5px solid #CBD5E1; display: inline-flex; align-items: center; justify-content: center; min-width: 160px; max-width: 100%; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                    <img src="{{ asset('storage/' . $ttd->ketua_ttd) }}" id="preview-img-ketua" style="max-height: 80px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                  </div>
                  <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <div style="font-size: 12px; font-weight: 800; color: #059669; background: #D1FAE5; border: 1px solid #A7F3D0; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                      <span>TTD Ketua Terpasang</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Drag & drop file baru ke sini atau <u>klik untuk mengganti</u></span>
                  </div>
                @else
                  <div style="padding: 12px 8px;">
                    <div class="drop-icon" style="width: 48px; height: 48px; background: #DBEAFE; border: 2px solid #2563EB; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto; color: #1D4ED8; transition: transform 0.2s;">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                    <div style="font-size: 13px; font-weight: 800; color: #1E293B;">Drag & Drop file TTD di sini</div>
                    <div style="font-size: 11.5px; color: #64748B; margin-top: 4px; font-weight: 600;">atau <span style="color: #2563EB; text-decoration: underline; font-weight: 800;">klik untuk memilih file</span></div>
                    <div style="font-size: 10.5px; color: #94A3B8; margin-top: 8px; font-weight: 700;">Format: PNG, WebP, JPG (Max 2MB)</div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        @if($ttd->ketua_ttd)
          <div style="margin-top: 14px; text-align: right;">
            <button type="button" onclick="confirmDelete('{{ route('admin.tanda-tangan.destroy', 'ketua') }}', 'TTD Ketua Unit')" style="background: #FEE2E2; color: #DC2626; border: 1.5px solid #FCA5A5; font-size: 11.5px; font-weight: 800; padding: 6px 12px; border-radius: 8px; cursor: pointer;">
              Hapus Gambar TTD
            </button>
          </div>
        @endif
      </div>

      {{-- 🧾 CARD 3: BENDAHARA / INVOICE --}}
      <div style="background: #FFF; border: 2.5px solid #131218; border-radius: 16px; padding: 22px; box-shadow: 5px 5px 0px #131218; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
          <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #F1F5F9; padding-bottom: 14px; margin-bottom: 16px;">
            <div style="display: flex; align-items: center; gap: 10px;">
              <div style="width: 36px; height: 36px; background: #D1FAE5; border: 1.5px solid #059669; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #047857;">
                3
              </div>
              <div>
                <h3 style="margin: 0; font-size: 16px; font-weight: 900; color: #131218;">Bendahara (Invoice & Kwitansi)</h3>
                <span style="font-size: 11.5px; color: #64748B; font-weight: 600;">Digunakan pada Invoice Pembayaran</span>
              </div>
            </div>
            <span style="background: #ECFDF5; border: 1px solid #A7F3D0; color: #047857; font-size: 11px; font-weight: 800; padding: 3px 8px; border-radius: 6px;">Invoice & Bukti</span>
          </div>

          <div style="margin-bottom: 14px;">
            <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px;">Nama Penandatangan Invoice</label>
            <input type="text" name="bendahara_nama" value="{{ old('bendahara_nama', $ttd->bendahara_nama) }}" required style="width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 10px; font-size: 13.5px; font-weight: 700; color: #0F172A; outline: none;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='#CBD5E1'">
          </div>

          <div style="margin-bottom: 14px;">
            <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px;">Jabatan Utama</label>
            <input type="text" name="bendahara_jabatan" value="{{ old('bendahara_jabatan', $ttd->bendahara_jabatan) }}" required style="width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 10px; font-size: 13.5px; font-weight: 700; color: #0F172A; outline: none;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='#CBD5E1'">
          </div>

          <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 6px;">NIP / Kode Verifikasi (Opsional)</label>
            <input type="text" name="bendahara_nip" value="{{ old('bendahara_nip', $ttd->bendahara_nip) }}" placeholder="Contoh: FCC-ADM-01" style="width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 10px; font-size: 13.5px; font-weight: 600; color: #0F172A; outline: none;" onfocus="this.style.borderColor='#FFC81A'" onblur="this.style.borderColor='#CBD5E1'">
          </div>

          {{-- Preview & Upload --}}
          <div style="margin-bottom: 10px;">
            <label style="display: flex; align-items: center; justify-content: space-between; font-size: 12px; font-weight: 800; color: #334155; margin-bottom: 8px;">
              <span>Upload TTD / Stempel Keuangan Transparan</span>
              <span style="font-size: 10.5px; font-weight: 700; color: #047857; background: #D1FAE5; padding: 2px 8px; border-radius: 10px;">PNG / WebP Transparan</span>
            </label>

            <div class="fcc-dropzone" id="dropzone-bendahara" style="position: relative; background: #F8FAFC; border: 2.5px dashed #CBD5E1; border-radius: 14px; padding: 20px 16px; text-align: center; cursor: pointer; transition: all 0.2s ease-in-out; overflow: hidden;">
              <input type="file" name="bendahara_ttd" accept="image/png,image/webp,image/jpeg,image/svg+xml" id="input-bendahara" onchange="handleFileSelect(this, 'bendahara')" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">

              <div id="dropzone-content-bendahara">
                @if($ttd->bendahara_ttd)
                  <div style="margin-bottom: 12px; background: repeating-conic-gradient(#E2E8F0 0% 25%, #FFF 0% 50%) 50% / 16px 16px; border-radius: 10px; padding: 14px; border: 1.5px solid #CBD5E1; display: inline-flex; align-items: center; justify-content: center; min-width: 160px; max-width: 100%; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                    <img src="{{ asset('storage/' . $ttd->bendahara_ttd) }}" id="preview-img-bendahara" style="max-height: 80px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                  </div>
                  <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
                    <div style="font-size: 12px; font-weight: 800; color: #059669; background: #D1FAE5; border: 1px solid #A7F3D0; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                      <span>TTD/Stempel Invoice Terpasang</span>
                    </div>
                    <span style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Drag & drop file baru ke sini atau <u>klik untuk mengganti</u></span>
                  </div>
                @else
                  <div style="padding: 12px 8px;">
                    <div class="drop-icon" style="width: 48px; height: 48px; background: #D1FAE5; border: 2px solid #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto; color: #047857; transition: transform 0.2s;">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    </div>
                    <div style="font-size: 13px; font-weight: 800; color: #1E293B;">Drag & Drop file TTD di sini</div>
                    <div style="font-size: 11.5px; color: #64748B; margin-top: 4px; font-weight: 600;">atau <span style="color: #059669; text-decoration: underline; font-weight: 800;">klik untuk memilih file</span></div>
                    <div style="font-size: 10.5px; color: #94A3B8; margin-top: 8px; font-weight: 700;">Format: PNG, WebP, JPG (Max 2MB)</div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        @if($ttd->bendahara_ttd)
          <div style="margin-top: 14px; text-align: right;">
            <button type="button" onclick="confirmDelete('{{ route('admin.tanda-tangan.destroy', 'bendahara') }}', 'TTD/Stempel Bendahara')" style="background: #FEE2E2; color: #DC2626; border: 1.5px solid #FCA5A5; font-size: 11.5px; font-weight: 800; padding: 6px 12px; border-radius: 8px; cursor: pointer;">
              Hapus Gambar TTD
            </button>
          </div>
        @endif
      </div>

    </div>
  </form>
</div>

{{-- FORM DELETE HIDDEN --}}
<form id="delete-ttd-form" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>

<script>
function handleFileSelect(input, key) {
  if (input.files && input.files[0]) {
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
      const contentBox = document.getElementById('dropzone-content-' + key);
      if (contentBox) {
        contentBox.innerHTML = `
          <div style="margin-bottom: 12px; background: repeating-conic-gradient(#E2E8F0 0% 25%, #FFF 0% 50%) 50% / 16px 16px; border-radius: 10px; padding: 14px; border: 2px solid #FFC81A; display: inline-flex; align-items: center; justify-content: center; min-width: 160px; max-width: 100%; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);">
            <img src="${e.target.result}" style="max-height: 80px; max-width: 100%; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));">
          </div>
          <div style="display: flex; flex-direction: column; align-items: center; gap: 4px;">
            <div style="font-size: 12px; font-weight: 800; color: #B45309; background: #FEF3C7; border: 1px solid #FDE68A; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
              <span>${escapeHtml(file.name)} (${(file.size / 1024).toFixed(1)} KB)</span>
            </div>
            <span style="font-size: 11px; font-weight: 700; color: #64748B; margin-top: 4px;">Klik "Simpan Pengaturan" di atas untuk menyimpan</span>
          </div>
        `;
      }
    };
    reader.readAsDataURL(file);
  }
}

function escapeHtml(text) {
  return text.replace(/[&<>"']/g, function(m) {
    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
  });
}

function confirmDelete(url, title) {
  const form = document.getElementById('delete-ttd-form');
  if (!form) return;
  form.action = url;

  if (typeof window.fccConfirm === 'function') {
    window.fccConfirm({
      title: 'Hapus ' + title + '?',
      msg: 'Gambar ' + title + ' akan dihapus secara permanen. Tanda tangan pada dokumen sertifikat/invoice yang belum diterbitkan akan dikosongkan.',
      danger: true,
      btnText: 'Ya, Hapus Gambar',
      onConfirm: function() {
        HTMLFormElement.prototype.submit.call(form);
      }
    });
  } else {
    if (confirm('Apakah Anda yakin ingin menghapus ' + title + '?')) {
      HTMLFormElement.prototype.submit.call(form);
    }
  }
}

// Drag & Drop event handlers
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.fcc-dropzone').forEach(dropzone => {
    const input = dropzone.querySelector('input[type="file"]');
    if (!input) return;

    ['dragenter', 'dragover'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.style.borderColor = '#F59E0B';
        dropzone.style.background = '#FFFBEB';
        dropzone.style.transform = 'scale(1.01)';
        const icon = dropzone.querySelector('.drop-icon');
        if (icon) icon.style.transform = 'scale(1.15) rotate(-6deg)';
      }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropzone.style.borderColor = '#CBD5E1';
        dropzone.style.background = '#F8FAFC';
        dropzone.style.transform = 'scale(1)';
        const icon = dropzone.querySelector('.drop-icon');
        if (icon) icon.style.transform = 'scale(1) rotate(0deg)';
      }, false);
    });
  });
});
</script>
@endsection
