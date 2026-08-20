@extends('layouts.admin')
@section('title','Pesan Masuk')
@section('page-title','Pesan Masuk')

@section('page-content')
<div style="padding:24px 28px;background:#F6F8FB;min-height:100vh;font-family:'Inter',sans-serif;position:relative;">

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
      #pesan-skeleton-overlay {
        transition: opacity 0.35s ease, visibility 0.35s ease;
      }
    </style>

    <div id="pesan-skeleton-overlay" class="no-print" style="opacity:1;visibility:visible;position:absolute;top:0;left:0;right:0;bottom:0;z-index:99;background:#F6F8FB;padding:24px 28px;box-sizing:border-box;pointer-events:none;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div style="width:40%;">
          <div class="fcc-skeleton-box" style="width:140px;height:18px;margin-bottom:8px;border-radius:20px;"></div>
          <div class="fcc-skeleton-box" style="width:260px;height:24px;margin-bottom:6px;"></div>
          <div class="fcc-skeleton-box" style="width:220px;height:12px;"></div>
        </div>
      </div>
      <div style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;">
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;margin-bottom:14px;border-radius:10px;"></div>
        <div class="fcc-skeleton-box" style="width:100%;height:44px;border-radius:10px;"></div>
      </div>
    </div>

    <script>
      (function() {
        setTimeout(function() {
          var sk = document.getElementById('pesan-skeleton-overlay');
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
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Kotak Masuk</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Pesan Masuk</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Daftar pesan dan pertanyaan yang dikirimkan pengunjung dari halaman Hubungi Kami.</p>
        </div>
        @if($unreadCount > 0)
        <div style="background:#131218;color:#FFC81A;padding:8px 16px;border-radius:20px;border:1.5px solid #FFC81A;font-size:12.5px;font-weight:900;display:inline-flex;align-items:center;gap:8px;box-shadow:0 4px 12px rgba(0,0,0,0.15);">
            @include('components.icon',['name'=>'mail','size'=>16,'style'=>'color:#FFC81A'])
            <span>{{ $unreadCount }} Pesan Belum Dibaca</span>
        </div>
        @endif
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
    <div style="background:#ECFDF5;border:2px solid #10B981;border-radius:14px;padding:14px 20px;margin-bottom:22px;display:flex;align-items:center;gap:12px;box-shadow:0 4px 14px rgba(16,185,129,0.12);">
        @include('components.icon',['name'=>'check','size'=>20,'style'=>'color:#059669;flex-shrink:0'])
        <p style="margin:0;font-size:13.5px;font-weight:800;color:#065F46;">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Filter Toolbar & Table Card --}}
    <div class="fcc-card" style="padding:24px;border-radius:20px;background:#FFFFFF;border:2px solid #E5E7EB;box-shadow:0 4px 20px rgba(0,0,0,0.04);">
        
        <form method="GET" action="{{ route('admin.pesan.index') }}" style="display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:20px;flex-wrap:wrap;">
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div style="position:relative;">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, atau isi pesan..." class="fcc-input" style="width:280px;height:38px;border-radius:10px;border:1.5px solid #CBD5E1;font-size:13px;">
                </div>
                <select name="status" onchange="this.form.submit()" class="fcc-input" style="width:auto;height:38px;border-radius:10px;border:1.5px solid #CBD5E1;font-size:13px;font-weight:700;">
                    <option value="">Semua Status</option>
                    <option value="belum_dibaca" {{ request('status')==='belum_dibaca'?'selected':'' }}>Belum Dibaca</option>
                    <option value="dibaca" {{ request('status')==='dibaca'?'selected':'' }}>Sudah Dibaca</option>
                </select>
                <button type="submit" class="fcc-btn-gold" style="height:38px;padding:0 18px;border-radius:10px;font-size:13px;font-weight:900;">
                    Cari &rarr;
                </button>
                @if(request('q') || request('status'))
                <a href="{{ route('admin.pesan.index') }}" style="padding:8px 14px;font-size:12px;height:38px;box-sizing:border-box;display:inline-flex;align-items:center;background:#FEF2F2;border:1.5px solid #FCA5A5;color:#EF4444;border-radius:10px;font-weight:800;text-decoration:none;" title="Reset Filter">
                    ✕ Reset
                </a>
                @endif
            </div>
            <span style="font-size:11.5px;font-weight:800;color:#131218;background:#FFC81A;padding:4px 12px;border-radius:20px;border:1px solid #131218;">
                {{ $pesanList->total() }} Total Pesan
            </span>
        </form>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#131218;color:#FFFFFF;">
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;letter-spacing:0.5px;border-top-left-radius:12px;color:#FFC81A;width:50px;">NO</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;letter-spacing:0.5px;">PENGIRIM</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;letter-spacing:0.5px;">PESAN / PERTANYAAN</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;letter-spacing:0.5px;">STATUS</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:900;letter-spacing:0.5px;">WAKTU DIKIRIM</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:900;letter-spacing:0.5px;border-top-right-radius:12px;width:140px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanList as $index => $p)
                    @php
                        $pesanJson = json_encode([
                            'id' => $p->id,
                            'nama' => $p->nama,
                            'email' => $p->email,
                            'pesan' => $p->pesan,
                            'status' => $p->status,
                            'waktu_format' => $p->created_at?->format('d M Y, H:i') . ' WITA',
                        ]);
                    @endphp
                    <tr id="pesan-row-{{ $p->id }}"
                        style="border-bottom:1px solid #E2E8F0;background:{{ $p->status==='belum_dibaca'?'#FFFDF5':($index%2==0?'#FFFFFF':'#F8FAFC') }};transition:all .18s;cursor:pointer;"
                        onclick='openPesanModal({{ $pesanJson }})'
                        onmouseover="this.style.background='#F1F5F9'"
                        onmouseout="this.style.background='{{ $p->status==='belum_dibaca'?'#FFFDF5':($index%2==0?'#FFFFFF':'#F8FAFC') }}'">
                        <td style="padding:14px 16px;font-size:13px;font-weight:800;color:#131218;vertical-align:middle;">
                            {{ $pesanList->firstItem() + $index }}
                        </td>
                        <td style="padding:14px 16px;vertical-align:middle;">
                            <p style="margin:0 0 2px;font-size:13.5px;font-weight:900;color:#131218;">{{ $p->nama }}</p>
                            <p style="margin:0;font-size:12px;color:#64748B;font-weight:600;">{{ $p->email }}</p>
                        </td>
                        <td style="padding:14px 16px;max-width:320px;vertical-align:middle;">
                            <p style="margin:0;font-size:13px;color:#334155;font-weight:{{ $p->status==='belum_dibaca'?'800':'500' }};white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ Str::limit($p->pesan, 80) }}
                            </p>
                        </td>
                        <td style="padding:14px 16px;text-align:center;vertical-align:middle;">
                            @if($p->status === 'belum_dibaca')
                            <span id="status-badge-{{ $p->id }}" style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:4px 12px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;white-space:nowrap;">
                                Belum Dibaca
                            </span>
                            @else
                            <span id="status-badge-{{ $p->id }}" style="background:#E2E8F0;color:#64748B;font-size:10.5px;font-weight:800;padding:4px 12px;border-radius:20px;border:1px solid #CBD5E1;text-transform:uppercase;white-space:nowrap;">
                                Sudah Dibaca
                            </span>
                            @endif
                        </td>
                        <td style="padding:14px 16px;font-size:12px;color:#64748B;font-weight:600;white-space:nowrap;vertical-align:middle;">
                            {{ $p->created_at?->format('d M Y, H:i') ?? '—' }} WITA
                        </td>
                        <td style="padding:14px 16px;text-align:center;white-space:nowrap;vertical-align:middle;" onclick="event.stopPropagation()">
                            <div style="display:inline-flex;gap:6px;align-items:center;">
                                <button type="button" onclick='openPesanModal({{ $pesanJson }})' class="fcc-btn-gold" style="padding:6px 14px;font-size:12px;border-radius:8px;font-weight:900;cursor:pointer;border:none;">
                                    Detail &rarr;
                                </button>
                                <form action="{{ route('admin.pesan.destroy', $p) }}" method="POST"
                                      onsubmit="return fccConfirmDelete(event, this, 'Hapus Pesan Masuk', 'Apakah Anda yakin ingin menghapus pesan dari {{ addslashes($p->nama) }}? Data yang dihapus tidak dapat dikembalikan.')"
                                      style="margin:0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="padding:6px 10px;font-size:12px;border-radius:8px;font-weight:800;background:#FEF2F2;color:#DC2626;border:1px solid #EF4444;cursor:pointer;transition:all .15s;"
                                            onmouseover="this.style.background='#DC2626';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#DC2626';">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:48px;text-align:center;color:#94A3B8;">
                            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                @include('components.icon',['name'=>'mail','size'=>24,'style'=>'color:#9CA3B0'])
                            </div>
                            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Tidak Ada Pesan Masuk Ditemukan</p>
                            <p style="font-size:12.5px;color:#64748B;margin:0;">Belum ada pesan yang sesuai dengan kriteria pencarian atau filter Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pesanList->hasPages())
        <div style="padding:16px 0 0;margin-top:16px;border-top:1px solid #E2E8F0;">
            {{ $pesanList->links() }}
        </div>
        @endif
    </div>

</div>

{{-- ═══ POPUP MODAL DETAIL PESAN MASUK ═════════════════════════════════ --}}
<div id="pesan-detail-modal" onclick="closePesanModal()" role="dialog" aria-modal="true"
     style="display:none;position:fixed;inset:0;z-index:9999999 !important;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:20px;">
    <div onclick="event.stopPropagation()"
         style="background:#FFFFFF;border-radius:24px;padding:32px;max-width:680px;width:100%;position:relative;box-shadow:0 24px 64px rgba(0,0,0,.25);border:2px solid #E5E7EB;box-sizing:border-box;">
        
        {{-- Close Button X --}}
        <button type="button" onclick="closePesanModal()" aria-label="Tutup" style="
            position:absolute;top:20px;right:20px;width:32px;height:32px;
            border:none;background:#F1F5F9;cursor:pointer;color:#64748B;
            font-size:20px;line-height:1;border-radius:10px;transition:all .15s;display:flex;align-items:center;justify-content:center;font-weight:800;"
            onmouseover="this.style.background='#131218';this.style.color='#FFC81A';"
            onmouseout="this.style.background='#F1F5F9';this.style.color='#64748B';">&#215;</button>

        {{-- Modal Header --}}
        <div style="margin-bottom:20px;border-bottom:1.5px solid #F1F5F9;padding-bottom:18px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                <span style="background:#FFC81A;color:#131218;font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;">
                    Informasi Pengirim
                </span>
                <span id="modal-pesan-waktu" style="font-size:12px;color:#64748B;font-weight:700;"></span>
            </div>
            <h2 id="modal-pesan-nama" style="font-size:22px;font-weight:900;color:#131218;margin:0 0 4px;"></h2>
            <p style="font-size:13.5px;color:#64748B;margin:0;font-weight:600;">
                Email: <a id="modal-pesan-email" href="#" target="_blank" style="color:#2563EB;text-decoration:none;font-weight:800;"></a>
            </p>
        </div>

        {{-- Modal Message Content --}}
        <div style="margin-bottom:24px;">
            <label style="font-size:11px;font-weight:900;color:#131218;display:block;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px;">
                Isi Pesan / Pertanyaan:
            </label>
            <div id="modal-pesan-isi" style="background:#F8FAFC;border:1.5px solid #E2E8F0;border-radius:16px;padding:20px;font-size:14px;color:#1E293B;line-height:1.7;white-space:pre-wrap;font-weight:500;max-height:300px;overflow-y:auto;box-shadow:inset 0 2px 4px rgba(0,0,0,0.02);">
            </div>
        </div>

        {{-- Modal Actions Footer --}}
        <div style="display:flex;justify-content:space-between;align-items:center;border-top:1.5px solid #F1F5F9;padding-top:18px;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                <a id="modal-pesan-gmail-btn" href="#" target="_blank" class="fcc-btn-gold" style="padding:10px 18px;font-size:12.5px;border-radius:12px;font-weight:900;text-decoration:none;display:inline-flex;align-items:center;gap:6px;box-shadow:0 4px 14px rgba(255,200,26,0.35);">
                    @include('components.icon',['name'=>'mail','size'=>15,'style'=>'color:#131218']) Balas via Gmail Web &rarr;
                </a>

                <a id="modal-pesan-mailto-btn" href="#" style="padding:10px 14px;font-size:12px;border-radius:12px;font-weight:800;text-decoration:none;display:inline-flex;align-items:center;gap:6px;background:#F1F5F9;color:#334155;border:1.5px solid #CBD5E1;transition:all .18s;" title="Buka aplikasi email default komputer (Outlook/Mail)">
                    💻 Aplikasi Email (Mailto)
                </a>

                <button type="button" onclick="copyModalEmail()" style="padding:10px 14px;font-size:12px;border-radius:12px;font-weight:800;background:#F8FAFC;color:#475569;border:1.5px solid #CBD5E1;cursor:pointer;display:inline-flex;align-items:center;gap:6px;" title="Salin alamat email pengirim">
                    📋 Salin Email
                </button>
            </div>

            <div style="display:flex;gap:10px;align-items:center;">
                <form id="modal-pesan-delete-form" action="" method="POST"
                      onsubmit="return fccConfirmDelete(event, this, 'Hapus Pesan Masuk', 'Apakah Anda yakin ingin menghapus pesan ini? Data yang dihapus tidak dapat dikembalikan.')"
                      style="margin:0;">
                    @csrf @method('DELETE')
                    <button type="submit" style="padding:10px 18px;font-size:13px;font-weight:800;background:#FEF2F2;color:#DC2626;border:1.5px solid #EF4444;border-radius:12px;cursor:pointer;transition:all .18s;"
                            onmouseover="this.style.background='#DC2626';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#DC2626';">
                        Hapus Pesan
                    </button>
                </form>

                <button type="button" onclick="closePesanModal()" class="fcc-btn-outline-dark" style="padding:10px 18px;font-size:13px;font-weight:800;border-radius:12px;cursor:pointer;">
                    Tutup
                </button>
            </div>
        </div>

    </div>
</div>

<script>
let currentModalEmail = '';

function openPesanModal(pesan) {
    currentModalEmail = pesan.email;
    document.getElementById('modal-pesan-nama').textContent = pesan.nama;
    
    const mailLink = document.getElementById('modal-pesan-email');
    mailLink.textContent = pesan.email;
    
    const subject = encodeURIComponent('Re: Pesan dari FIKOM Certification Center');
    
    // Format Balasan Rapi: Space kosong di atas untuk mengetik jawaban admin + Kutipan ringkas di bawah
    const quoteMsg = pesan.pesan.length > 250 ? pesan.pesan.substring(0, 250) + '...' : pesan.pesan;
    const bodyStr  = "\n\n--------------------------------------------------\n" +
                     "Membalas Pesan Dari: " + pesan.nama + " (" + pesan.email + ")\n" +
                     "\"" + quoteMsg + "\"";
    const body = encodeURIComponent(bodyStr);
    
    // Gmail Web Direct Link & Mailto Link
    const gmailUrl  = 'https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=' + encodeURIComponent(pesan.email) + '&su=' + subject + '&body=' + body;
    const mailtoUrl = 'mailto:' + encodeURIComponent(pesan.email) + '?subject=' + subject + '&body=' + body;
    
    mailLink.href = gmailUrl;
    document.getElementById('modal-pesan-gmail-btn').href = gmailUrl;
    document.getElementById('modal-pesan-mailto-btn').href = mailtoUrl;
    
    document.getElementById('modal-pesan-waktu').textContent = 'Diterima pada: ' + pesan.waktu_format;
    document.getElementById('modal-pesan-isi').textContent = pesan.pesan;
    document.getElementById('modal-pesan-delete-form').action = '{{ url("admin/pesan") }}/' + pesan.id;
    
    const overlay = document.getElementById('pesan-detail-modal');
    overlay.style.display = 'flex';

    // Auto mark as read via AJAX if status was 'belum_dibaca'
    if (pesan.status === 'belum_dibaca') {
        fetch('{{ url("admin/pesan") }}/' + pesan.id + '/read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        }).then(r => r.json()).then(data => {
            if (data.success) {
                pesan.status = 'dibaca';
                const badge = document.getElementById('status-badge-' + pesan.id);
                if (badge) {
                    badge.style.background = '#E2E8F0';
                    badge.style.color = '#64748B';
                    badge.style.borderColor = '#CBD5E1';
                    badge.textContent = 'Sudah Dibaca';
                }
                const row = document.getElementById('pesan-row-' + pesan.id);
                if (row) {
                    row.style.background = '#FFFFFF';
                }
            }
        }).catch(err => console.error(err));
    }
}

function copyModalEmail() {
    if (!currentModalEmail) return;
    navigator.clipboard.writeText(currentModalEmail).then(() => {
        if (typeof window.fccToast === 'function') {
            window.fccToast('Alamat email ' + currentModalEmail + ' berhasil disalin!', 'success');
        } else {
            alert('Alamat email ' + currentModalEmail + ' berhasil disalin!');
        }
    }).catch(err => {
        console.error('Gagal menyalin email: ', err);
    });
}

function closePesanModal() {
    document.getElementById('pesan-detail-modal').style.display = 'none';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePesanModal();
});
</script>
@endsection
