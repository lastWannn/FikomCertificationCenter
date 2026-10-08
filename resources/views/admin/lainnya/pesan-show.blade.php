@extends('layouts.admin')
@section('title','Detail Pesan Masuk')
@section('page-title','Detail Pesan Masuk')
@section('page-breadcrumb','Konten / Pesan Masuk / Detail')

@section('page-content')
<style>
  .fcc-pesan-show-container {
    padding: 24px 28px;
    background: #F6F8FB;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    position: relative;
    box-sizing: border-box;
  }
  .fcc-pesan-show-card {
    max-width: 840px;
    padding: 32px;
    border-radius: 24px;
    background: #FFFFFF;
    border: 2px solid #E5E7EB;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    box-sizing: border-box;
  }
  .fcc-pesan-show-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
    border-bottom: 1.5px solid #F1F5F9;
    padding-bottom: 20px;
    flex-wrap: wrap;
    gap: 16px;
  }
  @media (max-width: 767px) {
    .fcc-pesan-show-container {
      padding: 14px 12px;
    }
    .fcc-pesan-show-card {
      padding: 18px 14px;
      border-radius: 16px;
    }
    .fcc-pesan-show-header {
      flex-direction: column;
      align-items: stretch;
      gap: 14px;
    }
    .fcc-pesan-show-header-right {
      text-align: left !important;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .fcc-pesan-show-header-right a {
      width: 100%;
      justify-content: center;
      min-height: 42px;
    }
    .fcc-pesan-show-foot {
      flex-direction: column;
      align-items: stretch !important;
      gap: 14px !important;
    }
    .fcc-pesan-show-foot a,
    .fcc-pesan-show-foot form,
    .fcc-pesan-show-foot button {
      width: 100%;
      justify-content: center;
      text-align: center;
    }
  }
</style>

<div class="fcc-pesan-show-container">

    {{-- Back Button --}}
    <div style="margin-bottom:20px;">
        <a href="{{ route('admin.pesan.index') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:900;color:#131218;text-decoration:none;background:#FFFFFF;border:1.5px solid #131218;padding:8px 16px;border-radius:30px;box-shadow:0 4px 12px rgba(0,0,0,0.06);transition:all .18s;"
           onmouseover="this.style.background='#FFC81A'" onmouseout="this.style.background='#FFFFFF'">
            &larr; Kembali ke Pesan Masuk
        </a>
    </div>

    {{-- Detail Card --}}
    <div class="fcc-card fcc-pesan-show-card">
        
        <div class="fcc-pesan-show-header">
            <div>
                <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;display:inline-block;margin-bottom:8px;">
                    Informasi Pengirim
                </span>
                <h2 style="font-size:22px;font-weight:900;color:#131218;margin:0 0 6px;font-family:'Outfit',sans-serif;word-break:break-word;">{{ $pesan->nama }}</h2>
                <p style="font-size:13.5px;color:#64748B;margin:0;font-weight:600;word-break:break-all;">
                    Email: <a href="mailto:{{ $pesan->email }}?subject=Re:%20Pesan%20dari%20FIKOM%20Certification%20Center" style="color:#2563EB;text-decoration:none;font-weight:800;">{{ $pesan->email }}</a>
                </p>
            </div>
            <div class="fcc-pesan-show-header-right" style="text-align:right;">
                <span style="font-size:12px;color:#64748B;font-weight:700;display:block;margin-bottom:8px;">
                    Diterima: {{ $pesan->created_at?->format('d M Y, H:i') ?? '—' }} WITA
                </span>
                <a href="mailto:{{ $pesan->email }}?subject=Re:%20Pesan%20dari%20FIKOM%20Certification%20Center" class="fcc-btn-gold" style="padding:9px 20px;font-size:13px;border-radius:12px;font-weight:900;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
                    @include('components.icon',['name'=>'mail','size'=>16,'style'=>'color:#131218']) Balas via Email &rarr;
                </a>
            </div>
        </div>

        {{-- Isi Pesan --}}
        <div>
            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:10px;text-transform:uppercase;letter-spacing:0.5px;">
                Isi Pesan / Pertanyaan:
            </label>
            <div style="background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:16px;padding:22px;font-size:14.5px;color:#1E293B;line-height:1.7;white-space:pre-wrap;font-weight:500;box-shadow:inset 0 2px 4px rgba(0,0,0,0.02);word-break:break-word;">
{{ $pesan->pesan }}
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="fcc-pesan-show-foot" style="display:flex;justify-content:space-between;align-items:center;margin-top:28px;border-top:1.5px solid #F1F5F9;padding-top:20px;flex-wrap:wrap;gap:12px;">
            <a href="mailto:{{ $pesan->email }}?subject=Re:%20Tanggapan%20FCC%20-[{{ $pesan->nama }}]"
               style="font-size:13px;font-weight:800;color:#2563EB;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                ✉️ Kirim Email Balasan Langsung
            </a>

            <form action="{{ route('admin.pesan.destroy', $pesan) }}" method="POST"
                  onsubmit="return fccConfirmDelete(event, this, 'Hapus Pesan Masuk', 'Apakah Anda yakin ingin menghapus pesan dari {{ addslashes($pesan->nama) }}? Data yang dihapus tidak dapat dikembalikan.')">
                @csrf @method('DELETE')
                <button type="submit" style="padding:10px 20px;font-size:13px;font-weight:800;background:#FEF2F2;color:#DC2626;border:1.5px solid #EF4444;border-radius:12px;cursor:pointer;transition:all .18s;"
                        onmouseover="this.style.background='#DC2626';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#DC2626';">
                    Hapus Pesan Ini
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
