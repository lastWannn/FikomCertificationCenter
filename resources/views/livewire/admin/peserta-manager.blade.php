<div wire:poll.15s>
  {{-- Flash Message Notification --}}
  @if($message)
  <div style="padding: 12px 18px; border-radius: 12px; background: rgba(16, 185, 129, 0.12); border: 1.5px solid rgba(16, 185, 129, 0.3); color: #059669; font-weight: 700; font-size: 13px; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
    <span>{{ $message }}</span>
    <button type="button" wire:click="$set('message', null)" style="background: none; border: none; color: #059669; cursor: pointer; font-size: 16px; font-weight: 900;">&times;</button>
  </div>
  @endif

  {{-- Summary Stats Cards --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:14px;margin-bottom:20px;">
    @foreach([
      ['Total Peserta', $stats['total'], 'users', '#131218'],
      ['Aktif', $stats['aktif'], 'check', '#10B981'],
      ['Nonaktif', $stats['nonaktif'], 'x', '#F59E0B'],
      ['Ditangguhkan', $stats['ditangguhkan'], 'alert-triangle', '#EF4444'],
    ] as [$lbl, $val, $ic, $c])
    <div class="fcc-card" style="padding:16px 20px;border-left:4px solid {{ $c }};">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
        <p style="color:#9CA3B0;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.8px;margin:0;">{{ $lbl }}</p>
        <div style="width:32px;height:32px;border-radius:10px;background:{{ $c }}18;display:flex;align-items:center;justify-content:center;">
          @include('components.icon',['name'=>$ic,'size'=>16,'style'=>"color:{$c}"])
        </div>
      </div>
      <p style="margin:0;font-size:24px;font-weight:900;color:#131218;">{{ number_format($val) }}</p>
    </div>
    @endforeach
  </div>

  {{-- Search & Filter Controls --}}
  <div style="display:flex;gap:12px;margin-bottom:18px;flex-wrap:wrap;align-items:center;">
    {{-- Instant Search Input --}}
    <div style="position:relative;flex:1;min-width:240px;">
      @include('components.icon',['name'=>'search','size'=>15,'style'=>'position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9CA3B0;pointer-events:none;'])
      <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama, email, no HP, instansi..."
             class="fcc-input" style="padding-left:40px;background:#FFF;font-size:13.5px;border-radius:10px;">
    </div>

    {{-- Status Select --}}
    <select wire:model.live="status" class="fcc-input" style="width:auto;min-width:160px;background:#FFF;font-size:13px;font-weight:700;padding:9px 14px;border-radius:10px;cursor:pointer;">
      <option value="">Semua Status Akun</option>
      <option value="aktif">Aktif</option>
      <option value="nonaktif">Nonaktif</option>
      <option value="ditangguhkan">Ditangguhkan</option>
    </select>

    {{-- Reset Filter Button --}}
    @if($search || $status)
    <button type="button" wire:click="$set('search', ''); $set('status', '')" class="fcc-btn-dark" style="padding:9px 14px;font-size:12.5px;background:#E2E4EB;color:#131218;border:none;">
      Reset
    </button>
    @endif

    {{-- Export Button --}}
    <a href="{{ route('admin.export.peserta') }}" class="fcc-btn-dark" style="padding:9px 18px;font-size:13px;text-decoration:none;margin-left:auto;display:inline-flex;align-items:center;gap:6px;">
      @include('components.icon',['name'=>'download','size'=>14,'style'=>'color:#FFC81A']) Export CSV
    </a>
  </div>

  {{-- Table Container --}}
  <div class="fcc-card" style="padding:0;overflow:hidden;position:relative;">
    
    {{-- Loading overlay --}}
    <div wire:loading style="position:absolute;top:10px;right:20px;background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:4px 12px;border-radius:20px;z-index:20;">
      Updating...
    </div>

    <table class="admin-table" style="width:100%;border-collapse:collapse;">
      <thead>
        <tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
          <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Peserta & Instansi</th>
          <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">No. WhatsApp</th>
          <th style="padding:12px 16px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Status</th>
          <th style="padding:12px 16px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Kegiatan</th>
          <th style="padding:12px 16px;text-align:left;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;">Terdaftar</th>
          <th style="padding:12px 16px;text-align:center;font-size:11px;font-weight:800;color:#6B7280;text-transform:uppercase;width:200px;">Aksi Quick Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($peserta as $p)
        @php 
          $sc = match($p->status_akun ?? 'aktif') {
            'aktif' => ['#10B981', 'Aktif'],
            'nonaktif' => ['#F59E0B', 'Nonaktif'],
            default => ['#EF4444', 'Ditangguhkan']
          }; 
        @endphp
        <tr style="border-top:1px solid #F0F1F5;{{ $p->status_akun !== 'aktif' ? 'background:#FAFBFD;' : '' }}">
          <td style="padding:14px 16px;">
            <div style="display:flex;align-items:center;gap:12px;">
              <div style="width:38px;height:38px;border-radius:10px;background:#131218;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              </div>
              <div style="min-width:0;">
                <p style="margin:0;font-size:13.5px;font-weight:800;color:#131218;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:220px;">{{ $p->nama }}</p>
                <p style="margin:2px 0 0;font-size:11px;color:#6B7280;">{{ $p->email }} &bull; <span style="color:#9CA3B0;">{{ $p->instansi ?? 'Umum' }}</span></p>
              </div>
            </div>
          </td>
          <td style="padding:14px 16px;font-size:13px;color:#6B7280;">
            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $p->no_hp)) }}" target="_blank" style="color:#059669;text-decoration:none;display:inline-flex;align-items:center;gap:5px;font-weight:700;" title="Hubungi via WhatsApp">
              @include('components.icon',['name'=>'message-circle','size'=>14]) {{ $p->no_hp }}
            </a>
          </td>
          <td style="padding:14px 16px;text-align:center;">
            <span style="font-size:11px;font-weight:800;padding:4px 12px;border-radius:20px;background:{{ $sc[0] }}18;color:{{ $sc[0] }};">
              {{ $sc[1] }}
            </span>
          </td>
          <td style="padding:14px 16px;text-align:center;font-size:14px;font-weight:900;color:#131218;">
            {{ $p->pendaftaran_count }}
          </td>
          <td style="padding:14px 16px;font-size:12px;color:#6B7280;font-weight:600;">
            {{ $p->created_at->format('d M Y') }}
          </td>
          <td style="padding:14px 16px;text-align:center;">
            <div style="display:flex;gap:6px;justify-content:center;align-items:center;">
              
              {{-- Detail Modal Button --}}
              <button type="button" onclick="loadPesertaDetail('{{ route('admin.pengguna.peserta.detail', $p) }}')" style="background:#F3F4F6;border:1px solid #E5E7EB;border-radius:8px;padding:6px 9px;cursor:pointer;color:#3B82F6;display:inline-flex;align-items:center;" title="Lihat Detail">
                @include('components.icon',['name'=>'eye','size'=>15])
              </button>

              {{-- Instant Livewire Status Toggle Buttons --}}
              @if($p->status_akun !== 'aktif')
              <button type="button" wire:click="toggleStatus({{ $p->id }}, 'aktif')" style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);color:#059669;padding:5px 10px;border-radius:8px;font-size:11px;font-weight:800;cursor:pointer;" title="Aktifkan Akun">
                Aktifkan
              </button>
              @endif

              @if($p->status_akun !== 'nonaktif')
              <button type="button" wire:click="toggleStatus({{ $p->id }}, 'nonaktif')" style="background:rgba(245,158,11,0.12);border:1px solid rgba(245,158,11,0.3);color:#D97706;padding:5px 10px;border-radius:8px;font-size:11px;font-weight:800;cursor:pointer;" title="Nonaktifkan Akun">
                Nonaktif
              </button>
              @endif

              @if($p->status_akun !== 'ditangguhkan')
              <button type="button" wire:click="toggleStatus({{ $p->id }}, 'ditangguhkan')" style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);color:#DC2626;padding:5px 10px;border-radius:8px;font-size:11px;font-weight:800;cursor:pointer;" title="Tangguhkan Akun">
                Tangguhkan
              </button>
              @endif

            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="padding:48px 24px;text-align:center;">
            <div style="width:56px;height:56px;background:#F3F4F6;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
              @include('components.icon',['name'=>'users','size'=>26,'style'=>'color:#9CA3B0'])
            </div>
            <p style="font-size:15px;font-weight:900;color:#131218;margin:0 0 4px;">Tidak Ada Peserta</p>
            <p style="font-size:12.5px;color:#6B7280;margin:0;">Tidak ada data peserta yang cocok dengan kriteria pencarian.</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>

    @if($peserta->hasPages())
    <div style="padding:14px 20px;border-top:1px solid #E2E4EB;">
      {{ $peserta->links() }}
    </div>
    @endif
  </div>
</div>
