@extends('layouts.admin')
@section('title','Kata Mereka (Testimoni)')
@section('page-title', 'Kata Mereka')
@section('page-content')

{{-- ── Custom Confirm Modal ─────────────────────────────────────── --}}
<div id="fcc-confirm-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(19,18,24,0.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;">
    <div style="background:#FFFFFF;border:2.5px solid #131218;border-radius:24px;padding:32px;max-width:420px;width:90%;box-shadow:0 24px 60px rgba(0,0,0,0.35);text-align:center;position:relative;animation:modalIn .25s ease;">
        <div id="fcc-confirm-icon" style="width:56px;height:56px;border-radius:16px;background:#FEF2F2;border:1.5px solid #FCA5A5;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;color:#EF4444;">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
        <h3 id="fcc-confirm-title" style="color:#131218;font-size:18px;font-weight:900;margin:0 0 8px;">Hapus Testimoni?</h3>
        <p id="fcc-confirm-msg" style="color:#64748B;font-size:13.5px;margin:0 0 28px;line-height:1.6;font-weight:500;"></p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button onclick="closeConfirm()" style="padding:11px 24px;border-radius:12px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:13.5px;font-weight:800;cursor:pointer;transition:all .2s;">Batal</button>
            <form id="fcc-confirm-form" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" style="padding:11px 24px;border-radius:12px;border:1px solid #131218;background:#DC2626;color:#FFF;font-size:13.5px;font-weight:800;cursor:pointer;box-shadow:0 4px 15px rgba(220,38,38,.3);transition:all .2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- ── Form Modal (Create/Edit) ─────────────────────────────────── --}}
<div id="testimoni-modal" style="display:none;position:fixed;inset:0;z-index:9998;background:rgba(19,18,24,.65);backdrop-filter:blur(6px);align-items:center;justify-content:center;overflow-y:auto;padding:24px 0;">
    <div style="background:#FFFFFF;border:2.5px solid #131218;border-radius:24px;padding:32px;max-width:580px;width:90%;box-shadow:0 24px 64px rgba(0,0,0,.35);animation:modalIn .25s ease;margin:auto;position:relative;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;border-bottom:2px solid #E5E7EB;padding-bottom:16px;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                    <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Ulasan &amp; Testimoni</span>
                </div>
                <h2 id="modal-title" style="color:#131218;font-size:19px;font-weight:900;margin:0;">Tambah Testimoni Baru</h2>
            </div>
            <button onclick="closeTestimoniModal()" style="width:36px;height:36px;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:20px;line-height:1;font-weight:900;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">&times;</button>
        </div>

        <form id="testimoni-form" method="POST" enctype="multipart/form-data" style="margin:0;">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div style="display:grid;grid-template-columns:1fr;gap:16px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Nama Lengkap *</label>
                    <input type="text" name="nama" id="f-nama" required placeholder="Contoh: Budi Santoso" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:600;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Keterangan / Status *</label>
                    <input type="text" name="keterangan" id="f-keterangan" required placeholder="Contoh: Mahasiswa Teknik, Mitra Perusahaan" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:600;outline:none;box-sizing:border-box;">
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Rating (Bintang) *</label>
                    <select name="rating" id="f-rating" required class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:700;outline:none;box-sizing:border-box;cursor:pointer;">
                        <option value="5">⭐⭐⭐⭐⭐ (5) Sangat Puas</option>
                        <option value="4">⭐⭐⭐⭐ (4) Puas</option>
                        <option value="3">⭐⭐⭐ (3) Cukup</option>
                        <option value="2">⭐⭐ (2) Kurang</option>
                        <option value="1">⭐ (1) Sangat Kurang</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Status Publikasi *</label>
                    <select name="status" id="f-status" required class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:700;outline:none;box-sizing:border-box;cursor:pointer;">
                        <option value="dipublikasikan">✓ Dipublikasikan (Tampil di Landing)</option>
                        <option value="pending">⌛ Pending (Sembunyikan)</option>
                        <option value="ditolak">✕ Ditolak</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Kata (Ulasan) *</label>
                    <textarea name="kata" id="f-kata" required rows="4" placeholder="Tulis testimoni/ulasan..." class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:10px 14px;color:#131218;font-size:13.5px;font-weight:600;outline:none;box-sizing:border-box;resize:vertical;"></textarea>
                </div>
                <div>
                    <label style="display:block;font-size:11px;font-weight:800;color:#64748B;margin-bottom:6px;text-transform:uppercase;letter-spacing:.8px;">Upload Foto Profil</label>
                    <input type="file" name="foto" id="f-foto" accept="image/jpeg,image/png,image/jpg" class="fcc-input" style="width:100%;background:#FFF;border:1.5px solid #CBD5E1;border-radius:10px;padding:8px 14px;color:#131218;font-size:13px;outline:none;box-sizing:border-box;cursor:pointer;" onchange="
                        if(this.files[0]){
                            const file = this.files[0];
                            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                            if(!allowedTypes.includes(file.type)){
                                if(typeof fccShowFileAlert === 'function') fccShowFileAlert('Hanya file JPG dan PNG yang diperbolehkan!');
                                else alert('Hanya file JPG dan PNG yang diperbolehkan!');
                                this.value='';
                                return;
                            }
                            if(file.size > 2 * 1024 * 1024){
                                if(typeof fccShowFileAlert === 'function') fccShowFileAlert('Ukuran foto maksimal 2MB!');
                                else alert('Ukuran foto maksimal 2MB!');
                                this.value='';
                                return;
                            }
                        }
                    ">
                    <p id="f-foto-hint" style="font-size:11px;color:#94A3B8;margin:5px 0 0;font-weight:500;">Format: JPG/PNG, maks 2MB.</p>
                    <div id="f-foto-preview" style="margin-top:10px;display:none;">
                        <img id="f-foto-img" src="" alt="Foto Saat Ini" style="width:48px;height:48px;object-fit:cover;border-radius:50%;border:2px solid #FFC81A;">
                    </div>
                </div>
            </div>

            <div style="border-top:1.5px solid #E2E4EB;padding-top:20px;display:flex;justify-content:flex-end;gap:12px;">
                <button type="button" onclick="closeTestimoniModal()" style="padding:10px 18px;font-size:13px;font-weight:800;background:#FFFFFF;color:#131218;border:1.5px solid #131218;border-radius:10px;cursor:pointer;">Batal</button>
                <button type="submit" style="padding:10px 22px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border:1.5px solid #131218;border-radius:10px;cursor:pointer;transition:all .18s;" onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">Simpan Testimoni</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Main Content ─────────────────────────────────────────────── --}}
<style>
@keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
.testimoni-card-admin { background:#FFFFFF; border:2px solid #E5E7EB; border-radius:20px; padding:20px; transition:all .18s; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 4px 16px rgba(0,0,0,0.03); }
.testimoni-card-admin:hover { border-color:#131218; box-shadow:0 6px 24px rgba(0,0,0,0.06); transform:translateY(-3px); }
input[type="file"]::file-selector-button { cursor: pointer; }
</style>

<div style="padding:24px;">

    {{-- Header & Action Bar --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;flex-wrap:wrap;gap:16px;">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                <span style="background:#FFC81A;color:#131218;font-size:11px;font-weight:900;padding:3px 10px;border-radius:20px;border:1px solid #131218;text-transform:uppercase;letter-spacing:0.5px;">Ulasan &amp; Testimoni</span>
                <h1 style="font-size:22px;font-weight:900;color:#131218;margin:0;letter-spacing:-0.02em;">Kata Mereka (Testimoni)</h1>
            </div>
            <p style="color:#64748B;font-size:13px;margin:0;font-weight:500;">Kelola ulasan/testimoni dari peserta yang tampil di Landing Page.</p>
        </div>
        <button onclick="openTestimoniModal()"
                style="padding:10px 18px;font-size:13px;font-weight:800;background:#131218;color:#FFC81A;border-radius:30px;border:1.5px solid #131218;box-shadow:0 4px 12px rgba(0,0,0,0.1);cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:all .18s;"
                onmouseover="this.style.background='#FFC81A';this.style.color='#131218';" onmouseout="this.style.background='#131218';this.style.color='#FFC81A';">
            @include('components.icon',['name'=>'plus','size'=>15]) Tambah Testimoni Baru
        </button>
    </div>

    {{-- Testimonial Cards Grid --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(310px, 1fr));gap:20px;">
        @forelse($testimonis as $t)
        <div class="testimoni-card-admin">
            <div>
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;gap:8px;">
                    <div style="display:flex;gap:6px;flex-wrap:wrap;">
                        <span style="font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;
                                     {{ $t->status==='dipublikasikan' ? 'background:#ECFDF5;color:#059669;border:1px solid #10B981;' : 'background:#FFFDF5;color:#D97706;border:1px solid #F59E0B;' }}">
                            {{ $t->status==='dipublikasikan' ? '✓ Dipublikasikan' : '⌛ Pending / Sembunyi' }}
                        </span>
                        @if($t->peserta_id)
                        <span style="font-size:10.5px;font-weight:900;padding:3px 10px;border-radius:20px;background:#EEF2FF;color:#4F46E5;border:1px solid #6366F1;">
                            Peserta Terdaftar
                        </span>
                        @endif
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                    <div style="width:46px;height:46px;border-radius:50%;background:#131218;border:2px solid #FFC81A;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
                        @if($t->foto)
                            <img src="{{ asset('storage/'.$t->foto) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <span style="color:#FFC81A;font-weight:900;font-size:16px;">{{ Str::upper(Str::substr($t->nama, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <h3 style="font-size:14.5px;font-weight:900;color:#131218;margin:0 0 2px;">{{ $t->nama }}</h3>
                        <div style="display:flex;gap:2px;margin-bottom:3px;">
                            @for($i=0;$i<5;$i++)
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="{{ $i < $t->rating ? '#FFC81A' : '#CBD5E1' }}"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            @endfor
                        </div>
                        <p style="font-size:11.5px;color:#64748B;margin:0;font-weight:700;">{{ $t->keterangan }}</p>
                    </div>
                </div>
                
                <div style="background:#FFFDF5;border:1.5px solid #FFC81A;border-radius:12px;padding:12px;margin-bottom:16px;position:relative;">
                    <p style="font-size:12.5px;color:#131218;margin:0;line-height:1.5;font-weight:600;font-style:italic;">
                        "{{ Str::limit($t->kata, 120) }}"
                    </p>
                </div>
            </div>
            
            {{-- Actions --}}
            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                <form action="{{ route('admin.testimoni.toggle-status', $t->id) }}" method="POST" style="margin:0;flex:1;">
                    @csrf
                    <button type="submit"
                            style="width:100%;padding:8px 0;border-radius:10px;border:1.5px solid #131218;background:{{ $t->status==='dipublikasikan' ? '#FFF' : '#FFC81A' }};color:#131218;font-size:11.5px;font-weight:800;cursor:pointer;transition:all .18s;display:flex;align-items:center;justify-content:center;gap:4px;">
                        @include('components.icon',['name'=>$t->status==='dipublikasikan'?'eye-off':'eye','size'=>13])
                        {{ $t->status==='dipublikasikan' ? 'Sembunyikan' : 'Tayangkan' }}
                    </button>
                </form>
                <button type="button" onclick="openEditTestimoniModal({{ json_encode($t) }}, '{{ $t->foto ? asset('storage/'.$t->foto) : '' }}')"
                        style="padding:8px 14px;border-radius:10px;border:1.5px solid #131218;background:#FFFFFF;color:#131218;font-size:12px;font-weight:800;cursor:pointer;transition:all .18s;display:flex;align-items:center;justify-content:center;gap:4px;"
                        onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">
                    @include('components.icon',['name'=>'edit','size'=>13]) Edit
                </button>
                <button type="button" onclick="confirmTestimoniDelete('{{ route('admin.testimoni.destroy', $t) }}', {{ json_encode($t->nama) }})"
                        style="padding:8px 12px;border-radius:10px;border:1px solid #FCA5A5;background:#FEF2F2;color:#EF4444;font-size:12px;cursor:pointer;transition:all .18s;display:flex;align-items:center;"
                        onmouseover="this.style.background='#EF4444';this.style.color='#FFF';" onmouseout="this.style.background='#FEF2F2';this.style.color='#EF4444';">
                    @include('components.icon',['name'=>'trash','size'=>13])
                </button>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;padding:56px;text-align:center;color:#94A3B8;border-radius:20px;border:2px solid #E5E7EB;background:#FFFFFF;" class="fcc-card">
            <div style="width:52px;height:52px;border-radius:16px;background:#F7F8FA;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                @include('components.icon',['name'=>'message-square','size'=>24,'style'=>'color:#9CA3B0'])
            </div>
            <p style="font-size:15px;font-weight:800;color:#131218;margin:0 0 4px;">Belum Ada Data Ulasan (Testimoni)</p>
            <p style="font-size:12.5px;color:#64748B;margin:0;">Klik "Tambah Testimoni Baru" untuk memulai.</p>
        </div>
        @endforelse
    </div>

    @if($testimonis->hasPages())
    <div style="margin-top:24px;padding:14px 20px;background:#FFFFFF;border-radius:16px;border:2px solid #E5E7EB;">
        {{ $testimonis->links() }}
    </div>
    @endif
</div>

<script>
const STORE_URL = '{{ route('admin.testimoni.store') }}';
const UPDATE_URLS = @json($testimonis->getCollection()->mapWithKeys(fn($t) => [$t->id => route('admin.testimoni.update', $t->id)]));

function openTestimoniModal() {
    document.getElementById('modal-title').innerText = 'Tambah Testimoni Baru';
    document.getElementById('testimoni-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    document.getElementById('f-nama').value = '';
    document.getElementById('f-keterangan').value = '';
    document.getElementById('f-rating').value = '5';
    document.getElementById('f-status').value = 'dipublikasikan';
    document.getElementById('f-kata').value = '';
    document.getElementById('f-foto').value = '';
    document.getElementById('f-foto-preview').style.display = 'none';
    document.getElementById('f-foto-hint').innerText = 'Format: JPG/PNG, maks 2MB.';
    showModal('testimoni-modal');
}

function openEditTestimoniModal(testimoni, fotoAssetUrl) {
    document.getElementById('modal-title').innerText = 'Edit Testimoni';
    document.getElementById('testimoni-form').action = UPDATE_URLS[testimoni.id] || `/admin/testimoni/${testimoni.id}`;
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('f-nama').value = testimoni.nama || '';
    document.getElementById('f-keterangan').value = testimoni.keterangan || '';
    document.getElementById('f-rating').value = testimoni.rating || '5';
    document.getElementById('f-status').value = testimoni.status || 'dipublikasikan';
    document.getElementById('f-kata').value = testimoni.kata || '';
    document.getElementById('f-foto').value = '';
    
    const preview = document.getElementById('f-foto-preview');
    if (fotoAssetUrl) {
        document.getElementById('f-foto-img').src = fotoAssetUrl;
        preview.style.display = 'block';
        document.getElementById('f-foto-hint').innerText = 'Biarkan kosong jika tidak ingin mengubah foto.';
    } else {
        preview.style.display = 'none';
        document.getElementById('f-foto-hint').innerText = 'Format: JPG/PNG, maks 2MB. Opsional.';
    }
    showModal('testimoni-modal');
}

function closeTestimoniModal() {
    const modal = document.getElementById('testimoni-modal');
    if(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function confirmTestimoniDelete(url, name) {
    document.getElementById('fcc-confirm-title').innerText = 'Hapus Testimoni?';
    document.getElementById('fcc-confirm-msg').innerText = `Ulasan dari "${name}" akan dihapus secara permanen.`;
    document.getElementById('fcc-confirm-form').action = url;
    showModal('fcc-confirm-modal');
}

function closeConfirm() {
    const modal = document.getElementById('fcc-confirm-modal');
    if(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function showModal(id) {
    const el = document.getElementById(id);
    if(el) {
        el.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

// Close on backdrop click
document.getElementById('testimoni-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeTestimoniModal();
});
document.getElementById('fcc-confirm-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
});

// Re-open modal on validation error
document.addEventListener('DOMContentLoaded', () => {
    @if($errors->any())
        openTestimoniModal();
    @endif
});

// Watch overflow
[document.getElementById('testimoni-modal'), document.getElementById('fcc-confirm-modal')].forEach(el => {
    if(!el) return;
    const obs = new MutationObserver(() => {
        const visible = document.getElementById('testimoni-modal').style.display !== 'none' ||
                        document.getElementById('fcc-confirm-modal').style.display !== 'none';
        document.body.style.overflow = visible ? 'hidden' : '';
    });
    obs.observe(el, { attributes: true, attributeFilter: ['style'] });
});
</script>
@endsection

