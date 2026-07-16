<div>

{{-- Livewire toast bridge — kirim ke sistem modal FCC --}}
<script>
document.addEventListener('livewire:initialized', () => {
    Livewire.on('fcc-toast', (events) => {
        const ev = Array.isArray(events) ? events[0] : events;
        if (window.fccToast) window.fccToast(ev.message, ev.type || 'success');
    });
});
</script>

<div style="padding:20px 24px;">

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <div>
            <h2 style="font-size:18px;font-weight:900;color:#131218;margin:0 0 3px;">Manajemen Instruktur</h2>
            <p style="font-size:13px;color:#9CA3B0;margin:0;">
                {{ $instrukturs->count() }} instruktur terdaftar
            </p>
        </div>
        @if(!$showForm)
        <button wire:click="createNew" class="fcc-btn-gold" style="padding:9px 18px;font-size:13px;border:none;cursor:pointer;">
            @include('components.icon',['name'=>'plus','size'=>14])
            Tambah Instruktur
        </button>
        @endif
    </div>

    {{-- ── FORM (inline, tanpa reload) ────────────────────────── --}}
    @if($showForm)
    <div class="fcc-card" style="padding:24px;margin-bottom:20px;border-left:4px solid #FFC81A;"
         wire:transition.in.scale.origin.top>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="font-size:16px;font-weight:800;color:#131218;margin:0;">
                {{ $editingHashid ? 'Edit Instruktur' : 'Tambah Instruktur Baru' }}
            </h3>
            <button wire:click="cancel"
                    style="background:none;border:none;cursor:pointer;color:#9CA3B0;font-size:20px;line-height:1;"
                    title="Tutup">&times;</button>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">

            {{-- No. Identitas --}}
            <div>
                <label class="form-label-fcc">No. Identitas *</label>
                <input type="text" wire:model="no_identitas" placeholder="KTP / NIK / No. Dosen"
                       class="fcc-input" onkeydown="if(event.key==='Enter')event.preventDefault();">
                @error('no_identitas')<p class="form-error-fcc">{{ $message }}</p>@enderror
            </div>

            {{-- Nama --}}
            <div>
                <label class="form-label-fcc">Nama Lengkap *</label>
                <input type="text" wire:model="nama" placeholder="Nama instruktur"
                       class="fcc-input" onkeydown="if(event.key==='Enter')event.preventDefault();">
                @error('nama')<p class="form-error-fcc">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="form-label-fcc">Email *</label>
                <input type="email" wire:model.live.debounce.500ms="email"
                       placeholder="email@domain.com" class="fcc-input"
                       onkeydown="if(event.key==='Enter')event.preventDefault();">
                @error('email')<p class="form-error-fcc">{{ $message }}</p>@enderror
            </div>

            {{-- No HP --}}
            <div>
                <label class="form-label-fcc">No. HP *</label>
                <input type="text" wire:model="no_hp" placeholder="08xxxxxxxxxx"
                       class="fcc-input" onkeydown="if(event.key==='Enter')event.preventDefault();">
                @error('no_hp')<p class="form-error-fcc">{{ $message }}</p>@enderror
            </div>

            {{-- Kelamin --}}
            <div>
                <label class="form-label-fcc">Jenis Kelamin *</label>
                <select wire:model="kelamin" class="fcc-input">
                    <option value="">Pilih...</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                @error('kelamin')<p class="form-error-fcc">{{ $message }}</p>@enderror
            </div>

            {{-- Keahlian --}}
            <div>
                <label class="form-label-fcc">Keahlian *</label>
                <input type="text" wire:model="keahlian" placeholder="Mis: Web Development, Data Science"
                       class="fcc-input" onkeydown="if(event.key==='Enter')event.preventDefault();">
                @error('keahlian')<p class="form-error-fcc">{{ $message }}</p>@enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="form-label-fcc">
                    Password {{ $editingHashid ? '(kosongkan jika tidak diubah)' : '*' }}
                </label>
                <input type="password" wire:model="password"
                       placeholder="{{ $editingHashid ? '••••••••' : 'Min. 8 karakter' }}"
                       class="fcc-input" onkeydown="if(event.key==='Enter')event.preventDefault();">
                @error('password')<p class="form-error-fcc">{{ $message }}</p>@enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="form-label-fcc">Ulangi Password</label>
                <input type="password" wire:model="password_confirmation"
                       placeholder="Ulangi password" class="fcc-input"
                       onkeydown="if(event.key==='Enter')event.preventDefault();">
            </div>

            {{-- Alamat (full width) --}}
            <div style="grid-column:span 2;">
                <label class="form-label-fcc">Alamat</label>
                <textarea wire:model="alamat" rows="2" placeholder="Alamat instruktur (opsional)"
                          class="fcc-input" style="resize:none;"></textarea>
            </div>

            {{-- Tombol --}}
            <div style="grid-column:span 2;display:flex;justify-content:flex-end;gap:10px;padding-top:4px;">
                <button type="button" wire:click="cancel"
                        class="fcc-btn-outline-dark" style="padding:9px 20px;font-size:13px;border:none;cursor:pointer;">
                    Batal
                </button>
                <button type="button" wire:click="save"
                        wire:loading.attr="disabled"
                        class="fcc-btn-gold" style="padding:9px 20px;font-size:13px;border:none;cursor:pointer;">
                    <span wire:loading.remove>
                        @include('components.icon',['name'=>'save','size'=>14])
                        {{ $editingHashid ? 'Perbarui' : 'Simpan' }}
                    </span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>

        </div>
    </div>
    @endif

    {{-- ── TABEL INSTRUKTUR ────────────────────────────────────── --}}
    <div class="fcc-card" style="padding:0;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F7F8FA;border-bottom:1.5px solid #E2E4EB;">
                    @foreach(['No. Identitas','Nama','Email','No. HP','Keahlian','Program','Aksi'] as $h)
                    <th style="padding:10px 14px;text-align:left;font-size:10px;font-weight:700;
                               color:#9CA3B0;text-transform:uppercase;letter-spacing:.7px;">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($instrukturs as $ins)
                <tr wire:key="instruktur-{{ $ins->hashid }}"
                    style="border-top:1px solid #F0F1F5;transition:background .15s;"
                    onmouseover="this.style.background='#FAFAFA'"
                    onmouseout="this.style.background=''">
                    <td style="padding:12px 14px;font-size:13px;color:#6B7280;font-family:monospace;">
                        {{ $ins->no_identitas }}
                    </td>
                    <td style="padding:12px 14px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;border-radius:9px;background:#131218;
                                        display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#FFC81A" stroke-width="2.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:13px;font-weight:700;color:#131218;margin:0;">{{ $ins->nama }}</p>
                                <p style="font-size:11px;color:#9CA3B0;margin:0;">
                                    {{ $ins->kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td style="padding:12px 14px;font-size:13px;color:#5A6275;">{{ $ins->email }}</td>
                    <td style="padding:12px 14px;font-size:13px;color:#5A6275;">{{ $ins->no_hp }}</td>
                    <td style="padding:12px 14px;font-size:12px;color:#5A6275;">
                        <span style="background:#F7F8FA;border:1px solid #E2E4EB;border-radius:6px;padding:2px 8px;">
                            {{ Str::limit($ins->keahlian, 30) }}
                        </span>
                    </td>
                    <td style="padding:12px 14px;font-size:13px;font-weight:700;color:#131218;">
                        {{ $ins->pelatihan_count }}
                    </td>
                    <td style="padding:12px 14px;">
                        <div style="display:flex;gap:8px;align-items:center;">
                            <button wire:click="edit('{{ $ins->hashid }}')"
                                    style="color:#FFC81A;font-size:12px;font-weight:700;background:none;border:none;cursor:pointer;padding:4px 8px;border-radius:6px;transition:background .15s;"
                                    onmouseover="this.style.background='rgba(255,200,26,.1)'"
                                    onmouseout="this.style.background='none'">
                                @include('components.icon',['name'=>'edit-2','size'=>13])
                                Edit
                            </button>
                            <button wire:click="delete('{{ $ins->hashid }}')"
                                    wire:confirm="Hapus instruktur {{ $ins->nama }}? Data ini tidak bisa dikembalikan."
                                    wire:loading.attr="disabled"
                                    style="color:#EF4444;font-size:12px;font-weight:700;background:none;border:none;cursor:pointer;padding:4px 8px;border-radius:6px;transition:background .15s;"
                                    onmouseover="this.style.background='rgba(239,68,68,.08)'"
                                    onmouseout="this.style.background='none'">
                                @include('components.icon',['name'=>'trash-2','size'=>13])
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:40px;text-align:center;color:#9CA3B0;font-size:14px;">
                        Belum ada instruktur. Klik "+ Tambah Instruktur" untuk menambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.form-label-fcc { font-size:11px;font-weight:700;color:#6B7280;display:block;margin-bottom:5px;text-transform:uppercase;letter-spacing:.7px; }
.form-error-fcc { color:#EF4444;font-size:12px;margin:4px 0 0; }
</style>

</div>
