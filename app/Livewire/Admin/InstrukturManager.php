<?php

namespace App\Livewire\Admin;

use App\Models\Instruktur;
use App\Services\Admin\InstrukturService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

/**
 * Livewire InstrukturManager
 *
 * Adaptasi dari project teman (riz) — InstrukturManager versi User+detail.
 * Disesuaikan dengan arsitektur kita:
 *   - Model Instruktur (bukan User + instrukturDetail)
 *   - Tabel instruktur langsung (no_identitas, nama, email, no_hp, kelamin, alamat, keahlian)
 *   - InstrukturService untuk logika bisnis
 *   - Hashids untuk menyembunyikan ID (editingHashid bukan editingId)
 *
 * Keunggulan vs controller biasa:
 *   - Form tambah/edit tampil inline tanpa page reload
 *   - Validasi real-time langsung muncul di bawah field
 *   - Konfirmasi hapus via wire:confirm bawaan
 */
class InstrukturManager extends Component
{
    // ── State UI ──────────────────────────────────────────────
    public bool    $showForm     = false;
    public ?string $editingHashid = null;  // hashid, bukan ID numerik

    // ── Form fields ───────────────────────────────────────────
    public string $no_identitas = '';
    public string $nama         = '';
    public string $email        = '';
    public string $no_hp        = '';
    public string $kelamin      = '';
    public string $alamat       = '';
    public string $keahlian     = '';
    public string $password     = '';
    public string $password_confirmation = '';

    // ── Computed: resolve hashid ke model (lazy) ──────────────
    private function getEditingInstruktur(): ?Instruktur
    {
        return $this->editingHashid
            ? Instruktur::findByHashid($this->editingHashid)
            : null;
    }

    // ── Render ─────────────────────────────────────────────────
    public function render()
    {
        return view('livewire.admin.instruktur-manager', [
            'instrukturs' => Instruktur::withCount('pelatihan')
                ->orderBy('nama')
                ->get(),
        ]);
    }

    // ── CRUD Actions ───────────────────────────────────────────
    public function createNew(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(string $hashid): void
    {
        $instruktur = Instruktur::findByHashidOrFail($hashid);

        $this->editingHashid = $hashid;
        $this->no_identitas  = $instruktur->no_identitas ?? '';
        $this->nama          = $instruktur->nama;
        $this->email         = $instruktur->email;
        $this->no_hp         = $instruktur->no_hp;
        $this->kelamin       = $instruktur->kelamin;
        $this->alamat        = $instruktur->alamat ?? '';
        $this->keahlian      = $instruktur->keahlian;
        $this->password      = '';
        $this->password_confirmation = '';
        $this->showForm      = true;
    }

    public function save(): void
    {
        $editingId = $this->editingHashid
            ? (app(\App\Services\HashidService::class)->decode($this->editingHashid, Instruktur::class))
            : null;

        $passwordRules = $editingId
            ? ['nullable', 'confirmed', Password::min(8)]
            : ['required', 'confirmed', Password::min(8)];

        $this->validate([
            'no_identitas' => [
                'required', 'string', 'max:50',
                Rule::unique('instruktur', 'no_identitas')->ignore($editingId),
            ],
            'nama'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'email',
                Rule::unique('instruktur', 'email')->ignore($editingId),
            ],
            'no_hp'    => ['required', 'string', 'max:20'],
            'kelamin'  => ['required', 'in:L,P'],
            'keahlian' => ['required', 'string', 'max:200'],
            'alamat'   => ['nullable', 'string', 'max:500'],
            'password' => $passwordRules,
        ], [
            'no_identitas.unique' => 'No. identitas sudah terdaftar.',
            'email.unique'        => 'Email sudah digunakan instruktur lain.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'no_identitas' => $this->no_identitas,
            'nama'         => $this->nama,
            'email'        => $this->email,
            'no_hp'        => $this->no_hp,
            'kelamin'      => $this->kelamin,
            'alamat'       => $this->alamat ?: null,
            'keahlian'     => $this->keahlian,
            'password'     => $this->password ?: null,
        ];

        $service = app(InstrukturService::class);

        if ($editingId) {
            $instruktur = Instruktur::findOrFail($editingId);
            $service->update($instruktur, $data);
        } else {
            $service->create($data);
        }

        $this->resetForm();
        $this->showForm = false;

        // Kirim event toast ke FCC modal system
        $this->dispatch('fcc-toast', message: $editingId
            ? 'Data instruktur berhasil diperbarui.'
            : 'Instruktur berhasil ditambahkan.',
            type: 'success'
        );
    }

    public function delete(string $hashid): void
    {
        $instruktur = Instruktur::findByHashidOrFail($hashid);

        try {
            app(InstrukturService::class)->delete($instruktur);
            $this->dispatch('fcc-toast', message: 'Instruktur berhasil dihapus.', type: 'success');
        } catch (\RuntimeException $e) {
            $this->dispatch('fcc-toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function cancel(): void
    {
        $this->resetForm();
        $this->showForm = false;
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingHashid', 'no_identitas', 'nama', 'email',
            'no_hp', 'kelamin', 'alamat', 'keahlian',
            'password', 'password_confirmation',
        ]);
        $this->resetErrorBag();
    }
}
