<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-10">
    <div class="w-full max-w-md rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
        <h1 class="mb-6 text-xl font-semibold text-gray-900">Daftar Peserta</h1>

        <form wire:submit="register" class="space-y-4">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama" wire:model="nama"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" wire:model="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" wire:model="password"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Ulangi Password</label>
                    <input type="password" id="password_confirmation" wire:model="password_confirmation"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select id="jenis_kelamin" wire:model="jenis_kelamin"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Pilih...</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                @error('jenis_kelamin') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="instansi" class="block text-sm font-medium text-gray-700">Instansi</label>
                <input type="text" id="instansi" wire:model="instansi"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700">No. HP</label>
                <input type="text" id="no_hp" wire:model="no_hp"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('no_hp') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="alamat" wire:model="alamat" rows="2"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>

            <button type="submit"
                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500"
                wire:loading.attr="disabled">
                <span wire:loading.remove>Daftar</span>
                <span wire:loading>Memproses...</span>
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Masuk</a>
        </p>
    </div>
</div>
