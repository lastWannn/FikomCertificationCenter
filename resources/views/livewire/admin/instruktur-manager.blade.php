<div class="mx-auto max-w-5xl px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-900">Data Instruktur</h1>
        <button wire:click="createNew" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
            + Tambah Instruktur
        </button>
    </div>

    @if ($showForm)
        <div class="mb-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-medium text-gray-900">
                {{ $editingId ? 'Edit Instruktur' : 'Tambah Instruktur' }}
            </h2>

            <form wire:submit="save" class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">No. Identitas</label>
                    <input type="text" wire:model="no_identitas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('no_identitas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" wire:model="nama" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select wire:model="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Pilih...</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">No. HP</label>
                    <input type="text" wire:model="no_hp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('no_hp') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Keahlian</label>
                    <input type="text" wire:model="keahlian" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('keahlian') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea wire:model="alamat" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Password {{ $editingId ? '(kosongkan jika tidak diubah)' : '' }}
                    </label>
                    <input type="password" wire:model="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ulangi Password</label>
                    <input type="password" wire:model="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div class="col-span-2 flex justify-end gap-2">
                    <button type="button" wire:click="cancel" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500" wire:loading.attr="disabled">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">No. Identitas</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-500">Keahlian</th>
                    <th class="px-4 py-3 text-right text-xs font-medium uppercase text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($instrukturs as $instruktur)
                    <tr wire:key="instruktur-{{ $instruktur->id }}">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $instruktur->instrukturDetail->no_identitas }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $instruktur->nama }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $instruktur->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $instruktur->instrukturDetail->keahlian }}</td>
                        <td class="px-4 py-3 text-right text-sm">
                            <button wire:click="edit({{ $instruktur->id }})" class="text-indigo-600 hover:underline">Edit</button>
                            <button wire:click="delete({{ $instruktur->id }})" wire:confirm="Hapus instruktur ini?" class="ml-3 text-red-600 hover:underline">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Belum ada data instruktur.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
