@extends('layouts.admin')
@section('title','Manajemen Peserta')
@section('page-title','Manajemen Peserta')
@section('page-content')
<div style="padding:20px 24px;">

  {{-- Stats --}}
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:18px;">
    @foreach([
      ['Total Peserta',$stats['total'],'users','#131218'],
      ['Aktif',$stats['aktif'],'check','#10B981'],
      ['Nonaktif',$stats['nonaktif'],'x','#F59E0B'],
      ['Ditangguhkan',$stats['ditangguhkan'],'alert-triangle','#EF4444'],
    ] as [$lbl,$val,$ic,$c])
    <div class="fcc-card" style="padding:16px 18px;border-left:4px solid {{ $c }};">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
        <p style="color:#9CA3B0;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin:0;">{{ $lbl }}</p>
        <div style="width:32px;height:32px;border-radius:9px;background:{{ $c }}18;display:flex;align-items:center;justify-content:center;">
          @include('components.icon',['name'=>$ic,'size'=>15,'style'=>"color:{$c}"])
        </div>
      </div>
      <p style="margin:0;font-size:24px;font-weight:900;color:#131218;">{{ $val }}</p>
    </div>
    @endforeach
  </div>

  {{-- Filter & Search --}}
  <form method="GET" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
    <div style="position:relative;flex:1;min-width:200px;">
      @include('components.icon',['name'=>'search','size'=>14,'style'=>'position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#C0C4CF;pointer-events:none;'])
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
             class="fcc-input" style="padding-left:38px;"
             onkeydown="if(event.key==='Enter')this.form.submit()">
    </div>
    <select name="status" class="fcc-input" style="width:auto;" onchange="this.form.submit()">
      <option value="">Semua Status</option>
      @foreach(['aktif'=>'Aktif','nonaktif'=>'Nonaktif','ditangguhkan'=>'Ditangguhkan'] as $v=>$l)
      <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
      @endforeach
    </select>
    <a href="{{ route('admin.export.peserta') }}" class="fcc-btn-dark" style="padding:9px 16px;font-size:13px;text-decoration:none;">
      @include('components.icon',['name'=>'download','size'=>13,'style'=>'color:#FFC81A']) Export
    </a>
  </form>

  <div class="fcc-card" style="padding:0;overflow:hidden;">
    <table class="admin-table">
      <thead>
        <tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
          @foreach(['Peserta','No. HP','Status Akun','Kegiatan','Terdaftar','Aksi'] as $h)
          <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $h }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse($peserta as $p)
        @php $sc=match($p->status_akun??'aktif'){'aktif'=>['#10B981','Aktif'],'nonaktif'=>['#F59E0B','Nonaktif'],default=>['#EF4444','Ditangguhkan']}; @endphp
        <tr class="tbl-row" style="border-top:1px solid #F0F1F5;">
          <td style="padding:12px 14px;">
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:36px;height:36px;border-radius:10px;background:#131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              </div>
              <div style="min-width:0;">
                <p style="margin:0;font-size:13px;font-weight:700;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px;">{{ $p->nama }}</p>
                <p style="margin:0;font-size:11px;color:#9CA3B0;">{{ $p->email }}</p>
              </div>
            </div>
          </td>
          <td style="padding:12px 14px;font-size:13px;color:#6B7280;">{{ $p->no_hp }}</td>
          <td style="padding:12px 14px;">
            <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">{{ $sc[1] }}</span>
          </td>
          <td style="padding:12px 14px;font-size:13px;font-weight:700;color:#131218;">{{ $p->pendaftaran_count }}</td>
          <td style="padding:12px 14px;font-size:12px;color:#9CA3B0;">{{ $p->created_at->format('d M Y') }}</td>
          <td style="padding:12px 14px;">
            <div style="display:flex;gap:6px;align-items:center;">
              <a href="{{ route('admin.pengguna.peserta.detail', $p) }}" style="color:#3B82F6;display:flex;padding:4px;" title="Detail">
                @include('components.icon',['name'=>'eye','size'=>14])
              </a>
              <div style="position:relative;" x-data="{ open:false }">
                <button onclick="toggleDropdown('drop-{{ $p->id }}')"
                    style="background:#F7F8FA;border:1.5px solid #E2E4EB;border-radius:7px;padding:4px 8px;cursor:pointer;display:flex;align-items:center;gap:4px;font-size:11px;color:#6B7280;font-weight:700;">
                  Ubah Status @include('components.icon',['name'=>'chevron-down','size'=>10])
                </button>
                <div id="drop-{{ $p->id }}" style="display:none;position:absolute;right:0;top:34px;background:#FFF;border:1px solid #E2E4EB;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.1);z-index:100;min-width:160px;overflow:hidden;">
                  @foreach(['aktif'=>'✓ Aktifkan','nonaktif'=>'— Nonaktifkan','ditangguhkan'=>'⊘ Tangguhkan'] as $sv=>$sl)
                  <form action="{{ route('admin.pengguna.peserta.toggle', $p) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="{{ $sv }}">
                    <button type="submit" style="width:100%;padding:9px 14px;background:none;border:none;text-align:left;font-size:13px;cursor:pointer;color:{{ $sv==='aktif'?'#10B981':($sv==='nonaktif'?'#F59E0B':'#EF4444') }};font-weight:600;"
                        onmouseover="this.style.background='#F7F8FA'" onmouseout="this.style.background='none'">
                      {{ $sl }}
                    </button>
                  </form>
                  @endforeach
                  <div style="border-top:1px solid #F0F1F5;"></div>
                  <form action="{{ route('admin.pengguna.peserta.reset-password', $p) }}" method="POST">
                    @csrf
                    <button type="submit" style="width:100%;padding:9px 14px;background:none;border:none;text-align:left;font-size:13px;cursor:pointer;color:#3B82F6;font-weight:600;" onclick="return confirm('Reset & kirim password baru ke email peserta?')"
                        onmouseover="this.style.background='#F7F8FA'" onmouseout="this.style.background='none'">
                      &#128273; Reset Password
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="padding:36px;text-align:center;color:#9CA3B0;font-size:14px;">Tidak ada peserta yang ditemukan.</td></tr>
        @endforelse
      </tbody>
    </table>
    @if($peserta->hasPages())<div style="padding:12px 16px;border-top:1px solid #E2E4EB;">{{ $peserta->withQueryString()->links() }}</div>@endif
  </div>
</div>
@endsection
@push('scripts')
@vite('resources/js/pages/admin-pengguna.js')
@endpush
