<div wire:poll.15s>
  {{-- Flash Message Notification --}}
  @if($message)
  @php $isSuccess = $messageType === 'success'; @endphp
  <div style="padding: 12px 18px; border-radius: 12px; background: {{ $isSuccess ? 'rgba(16, 185, 129, 0.12)' : 'rgba(239, 68, 68, 0.12)' }}; border: 1.5px solid {{ $isSuccess ? 'rgba(16, 185, 129, 0.3)' : 'rgba(239, 68, 68, 0.3)' }}; color: {{ $isSuccess ? '#059669' : '#DC2626' }}; font-weight: 800; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
    <span>{{ $message }}</span>
    <button type="button" wire:click="$set('message', null)" style="background: none; border: none; color: {{ $isSuccess ? '#059669' : '#DC2626' }}; cursor: pointer; font-size: 18px; font-weight: 900;">&times;</button>
  </div>
  @endif

  {{-- Summary Stats Cards (Neo-Brutalist) --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:16px;margin-bottom:24px;">
    {{-- Card 1: Total Peserta --}}
    <div wire:click="$set('status', '')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:44px;height:44px;border-radius:12px;background:#F1F5F9;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;color:#131218;flex-shrink:0;">
        @include('components.icon',['name'=>'users','size'=>20])
      </div>
      <div>
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Total Peserta</p>
        <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($stats['total']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Orang</span></p>
      </div>
    </div>

    {{-- Card 2: Terverifikasi --}}
    <div wire:click="$set('status', 'aktif')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:44px;height:44px;border-radius:12px;background:#ECFDF5;border:1.5px solid #10B981;display:flex;align-items:center;justify-content:center;color:#10B981;box-shadow:0 4px 10px rgba(16,185,129,0.2);flex-shrink:0;">
        @include('components.icon',['name'=>'check-circle','size'=>20])
      </div>
      <div>
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Terverifikasi</p>
        <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($stats['terverifikasi']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Akun</span></p>
      </div>
    </div>

    {{-- Card 3: Belum Verifikasi --}}
    <div wire:click="$set('status', '')" class="fcc-card" style="padding:18px 20px;border-radius:18px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 16px rgba(0,0,0,0.03);display:flex;align-items:center;gap:14px;cursor:pointer;transition:all .18s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
      <div style="width:44px;height:44px;border-radius:12px;background:#FEF3C7;border:1.5px solid #F59E0B;display:flex;align-items:center;justify-content:center;color:#D97706;box-shadow:0 4px 10px rgba(245,158,11,0.25);flex-shrink:0;">
        @include('components.icon',['name'=>'x-circle','size'=>20])
      </div>
      <div>
        <p style="margin:0;font-size:11px;font-weight:800;color:#64748B;text-transform:uppercase;letter-spacing:0.5px;">Belum Verifikasi OTP</p>
        <p style="margin:2px 0 0;font-size:22px;font-weight:900;color:#131218;">{{ number_format($stats['belum_verifikasi']) }} <span style="font-size:12px;font-weight:700;color:#94A3B8;">Akun</span></p>
      </div>
    </div>
  </div>

  {{-- Main Neo-Brutalist Table Card --}}
  <div class="fcc-card" style="padding:0;overflow:hidden;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);position:relative;">
    <div style="padding:18px 24px;border-bottom:2px solid #E5E7EB;background:#F8FAFC;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
      <h3 style="margin:0;font-size:16px;font-weight:900;color:#131218;">Daftar Akun Peserta</h3>
      
      <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        {{-- Search Input --}}
        <div style="position:relative;width:240px;">
          <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748B;display:flex;pointer-events:none;">
            @include('components.icon', ['name'=>'search', 'size'=>14])
          </span>
          <input type="text" wire:model.live.debounce.300ms="search"
                 placeholder="Cari nama, email, HP, instansi..."
                 class="fcc-input" style="padding-left:34px;font-size:12.5px;height:36px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;"
                 autocomplete="off">
        </div>

        {{-- Status Select --}}
        <select wire:model.live="status" class="fcc-input" style="width:auto;font-size:12.5px;height:36px;padding:0 12px;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;font-weight:700;cursor:pointer;">
          <option value="">Semua Status Akun</option>
          <option value="aktif">Aktif</option>
          <option value="nonaktif">Nonaktif</option>
        </select>

        @if($search || $status)
        <button type="button" wire:click="$set('search', ''); $set('status', '')" style="padding:6px 12px;font-size:12px;height:36px;cursor:pointer;display:inline-flex;align-items:center;gap:4px;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;transition:all .18s;" title="Reset Filter">
          ✕ Reset
        </button>
        @endif

        {{-- Export Button --}}
        <a href="{{ route('admin.export.peserta') }}" style="padding:6px 14px;font-size:12px;height:36px;font-weight:800;background:#FFFFFF;color:#131218;border-radius:10px;border:1.5px solid #131218;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .18s;" onmouseover="this.style.background='#131218';this.style.color='#FFC81A';" onmouseout="this.style.background='#FFFFFF';this.style.color='#131218';">
          @include('components.icon',['name'=>'download','size'=>14]) Export CSV
        </a>

        <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">{{ $peserta->total() }} Data</span>
      </div>
    </div>

    <div style="overflow-x:auto;">
      <table style="width:100%;border-collapse:collapse;">
        <thead>
          <tr style="background:#131218;color:#FFFFFF;">
            <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;">Peserta &amp; Instansi</th>
            <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;">No. WhatsApp</th>
            <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">Status</th>
            <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:110px;">Kegiatan</th>
            <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFFFFF;width:140px;">Terdaftar</th>
            <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:0.6px;color:#FFC81A;width:220px;">Aksi Akun</th>
          </tr>
        </thead>
        <tbody>
          @forelse($peserta as $p)
          @php 
            if (is_null($p->email_verified_at)) {
              $sc = ['#D97706', '#FEF3C7', '#FCD34D', 'Belum Verifikasi (OTP)'];
            } else if (($p->status_akun ?? 'aktif') === 'aktif') {
              $sc = ['#059669', '#ECFDF5', '#A7F3D0', 'Aktif'];
            } else {
              $sc = ['#DC2626', '#FEF2F2', '#FCA5A5', 'Nonaktif'];
            }
          @endphp
          <tr style="border-top:1px solid #F1F5F9;transition:background .15s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background=''">
            
            {{-- Peserta & Instansi --}}
            <td style="padding:14px 20px;vertical-align:middle;">
              <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:40px;height:40px;border-radius:10px;background:#131218;border:1.5px solid #131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                  @include('components.icon',['name'=>'user','size'=>18,'style'=>'color:#FFC81A'])
                </div>
                <div style="min-width:0;">
                  <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:240px;">{{ $p->nama }}</p>
                  <p style="margin:0;font-size:11.5px;color:#64748B;font-weight:500;">{{ $p->email }} &bull; <span style="color:#131218;font-weight:700;">{{ $p->instansi ?? 'Umum' }}</span></p>
                </div>
              </div>
            </td>

            {{-- No WhatsApp --}}
            <td style="padding:14px 16px;vertical-align:middle;">
              <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $p->no_hp)) }}" target="_blank" style="color:#059669;text-decoration:none;display:inline-flex;align-items:center;gap:5px;font-weight:800;font-size:13px;background:#ECFDF5;padding:4px 10px;border-radius:8px;border:1px solid #A7F3D0;" title="Hubungi via WhatsApp">
                @include('components.icon',['name'=>'phone','size'=>13]) {{ $p->no_hp }}
              </a>
            </td>

            {{-- Status --}}
            <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
              <span style="font-size:11px;font-weight:800;padding:3px 10px;border-radius:12px;background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[2] }};display:inline-block;">
                {{ $sc[3] }}
              </span>
            </td>

            {{-- Kegiatan Count --}}
            <td style="padding:14px 16px;text-align:center;vertical-align:middle;font-size:14px;font-weight:900;color:#131218;">
              <span style="background:#F1F5F9;padding:4px 10px;border-radius:8px;border:1px solid #CBD5E1;display:inline-block;">
                {{ $p->pendaftaran_count }}
              </span>
            </td>

            {{-- Terdaftar Date --}}
            <td style="padding:14px 16px;vertical-align:middle;font-size:12.5px;color:#64748B;font-weight:700;">
              📅 {{ $p->created_at->format('d M Y') }}
            </td>

            {{-- Aksi Akun --}}
            <td style="padding:14px 20px;text-align:center;vertical-align:middle;">
              <div style="display:flex;gap:6px;justify-content:center;align-items:center;">
                
                {{-- Detail Modal Button --}}
                <button type="button" onclick="loadPesertaDetail('{{ route('admin.pengguna.peserta.detail', $p) }}')" style="background:#FFFFFF;border:1.5px solid #131218;border-radius:8px;padding:6px 9px;cursor:pointer;color:#131218;display:inline-flex;align-items:center;transition:all .18s;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';" title="Lihat Detail Peserta">
                  @include('components.icon',['name'=>'eye','size'=>15])
                </button>

                {{-- Instant Livewire Status Toggle Buttons --}}
                @if($p->status_akun !== 'aktif')
                <button type="button" wire:click="toggleStatus({{ $p->id }}, 'aktif')" style="background:#ECFDF5;border:1px solid #A7F3D0;color:#059669;padding:6px 12px;border-radius:8px;font-size:11.5px;font-weight:800;cursor:pointer;transition:all .18s;" title="Aktifkan Akun">
                  Aktifkan
                </button>
                @else
                <button type="button" wire:click="toggleStatus({{ $p->id }}, 'nonaktif')" style="background:#FEF3C7;border:1px solid #FCD34D;color:#D97706;padding:6px 12px;border-radius:8px;font-size:11.5px;font-weight:800;cursor:pointer;transition:all .18s;" title="Nonaktifkan Akun">
                  Nonaktif
                </button>
                @endif

                {{-- Hapus Akun Button --}}
                <button type="button" wire:click="deletePeserta({{ $p->id }})" wire:confirm="Apakah Anda yakin ingin menghapus akun peserta '{{ $p->nama }}'?" style="background:#FEF2F2;border:1px solid #FCA5A5;color:#DC2626;padding:6px 10px;border-radius:8px;font-size:11.5px;font-weight:800;cursor:pointer;transition:all .18s;" title="Hapus Akun Peserta">
                  Hapus
                </button>

              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" style="padding:48px;text-align:center;color:#94A3B8;">
              <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                @include('components.icon',['name'=>'users','size'=>24,'style'=>'color:#9CA3B0'])
              </div>
              <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Peserta Ditemukan</p>
              <p style="font-size:12.5px;color:#64748B;margin:0;">Tidak ada data peserta yang cocok dengan kriteria pencarian.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($peserta->hasPages())
    <div style="padding:14px 20px;border-top:1px solid #E2E4EB;background:#F8FAFC;">
      {{ $peserta->links() }}
    </div>
    @endif
  </div>
</div>
