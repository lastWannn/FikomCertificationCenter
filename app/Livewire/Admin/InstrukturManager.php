<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class InstrukturManager extends Component
{
    public bool $showForm = false;

    public ?int $editingId = null;

    public string $no_identitas = '';

    public string $nama = '';

    public string $alamat = '';

    public string $email = '';

    public string $jenis_kelamin = '';

    public string $no_hp = '';

    public string $keahlian = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function render()
    {
        return view('livewire.admin.instruktur-manager', [
            'instrukturs' => User::query()
                ->where('role', 'instruktur')
                ->with('instrukturDetail')
                ->orderBy('nama')
                ->get(),
        ]);
    }

    public function createNew()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id)
    {
        $instruktur = User::where('role', 'instruktur')->with('instrukturDetail')->findOrFail($id);

        $this->editingId = $instruktur->id;
        $this->no_identitas = $instruktur->instrukturDetail->no_identitas;
        $this->nama = $instruktur->nama;
        $this->alamat = (string) $instruktur->instrukturDetail->alamat;
        $this->email = $instruktur->email;
        $this->jenis_kelamin = $instruktur->instrukturDetail->jenis_kelamin;
        $this->no_hp = $instruktur->instrukturDetail->no_hp;
        $this->keahlian = $instruktur->instrukturDetail->keahlian;
        $this->password = '';
        $this->password_confirmation = '';
        $this->showForm = true;
    }

    public function save()
    {
        $passwordRules = $this->editingId
            ? ['nullable', 'confirmed', Password::min(8)]
            : ['required', 'confirmed', Password::min(8)];

        $data = $this->validate([
            'no_identitas' => ['required', 'string', 'max:50', Rule::unique('instruktur_detail', 'no_identitas')->ignore($this->editingId, 'id_user')],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editingId)],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'no_hp' => ['required', 'string', 'max:20'],
            'keahlian' => ['required', 'string', 'max:255'],
            'password' => $passwordRules,
        ]);

        unset($data['password_confirmation']);

        DB::transaction(function () use ($data) {
            $user = User::updateOrCreate(
                ['id' => $this->editingId],
                array_filter([
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'role' => 'instruktur',
                    'password' => filled($data['password']) ? Hash::make($data['password']) : null,
                ], fn ($value) => $value !== null)
            );

            $user->instrukturDetail()->updateOrCreate(['id_user' => $user->id], [
                'no_identitas' => $data['no_identitas'],
                'alamat' => $data['alamat'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'no_hp' => $data['no_hp'],
                'keahlian' => $data['keahlian'],
            ]);
        });

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete(int $id)
    {
        User::where('role', 'instruktur')->findOrFail($id)->delete();
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingId', 'no_identitas', 'nama', 'alamat', 'email',
            'jenis_kelamin', 'no_hp', 'keahlian', 'password', 'password_confirmation',
        ]);
        $this->resetErrorBag();
    }
}
