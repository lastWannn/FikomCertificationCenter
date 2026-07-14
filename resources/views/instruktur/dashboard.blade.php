<x-layouts::app title="Dashboard Instruktur">
    <div class="mx-auto max-w-5xl px-4 py-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-900">Dashboard Instruktur</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Logout
                </button>
            </form>
        </div>

        <p class="text-gray-600">Selamat datang, {{ auth()->user()->nama }}.</p>
    </div>
</x-layouts::app>
