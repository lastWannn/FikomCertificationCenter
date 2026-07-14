<x-layouts::app title="Sistem Pelatihan & Sertifikasi">
    <div class="flex min-h-screen flex-col items-center justify-center gap-6 bg-gray-50 px-4">
        <h1 class="text-2xl font-semibold text-gray-900">Sistem Manajemen Pelatihan & Sertifikasi</h1>

        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                Login
            </a>
            <a href="{{ route('peserta.register') }}" class="rounded-md border border-indigo-600 px-4 py-2 text-sm font-medium text-indigo-600 hover:bg-indigo-50">
                Daftar Peserta
            </a>
        </div>
    </div>
</x-layouts::app>
