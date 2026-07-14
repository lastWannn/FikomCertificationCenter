<div class="flex min-h-screen items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-sm rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
        <h1 class="mb-6 text-xl font-semibold text-gray-900">Login</h1>

        <form wire:submit="login" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" wire:model="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" wire:model="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500"
                wire:loading.attr="disabled">
                <span wire:loading.remove>Masuk</span>
                <span wire:loading>Memproses...</span>
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            Belum punya akun peserta? <a href="{{ route('peserta.register') }}" class="text-indigo-600 hover:underline">Daftar</a>
        </p>
    </div>
</div>
