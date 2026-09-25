@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display:inline-flex;align-items:center;gap:6px;" wire:key="paginator-simple-{{ $paginator->getPageName() }}">
        {{-- Previous Page Link --}}
        <button type="button"
            wire:key="paginator-sbtn-prev"
            @if ($paginator->onFirstPage())
                disabled
                style="width:34px;height:34px;border-radius:8px;background:#F1F5F9;border:1.5px solid #E2E4EB;color:#CBD5E1;display:inline-flex;align-items:center;justify-content:center;cursor:not-allowed;appearance:none;-webkit-appearance:none;"
            @else
                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                style="width:34px;height:34px;border-radius:8px;background:#FFFFFF;border:1.5px solid #131218;color:#131218;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:all .15s;appearance:none;-webkit-appearance:none;"
                onmouseover="this.style.background='#FFC81A';"
                onmouseout="this.style.background='#FFFFFF';"
            @endif
            title="Halaman Sebelumnya">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        {{-- Next Page Link --}}
        <button type="button"
            wire:key="paginator-sbtn-next"
            @if ($paginator->hasMorePages())
                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                style="width:34px;height:34px;border-radius:8px;background:#FFFFFF;border:1.5px solid #131218;color:#131218;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:all .15s;appearance:none;-webkit-appearance:none;"
                onmouseover="this.style.background='#FFC81A';"
                onmouseout="this.style.background='#FFFFFF';"
            @else
                disabled
                style="width:34px;height:34px;border-radius:8px;background:#F1F5F9;border:1.5px solid #E2E4EB;color:#CBD5E1;display:inline-flex;align-items:center;justify-content:center;cursor:not-allowed;appearance:none;-webkit-appearance:none;"
            @endif
            title="Halaman Berikutnya">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </nav>
@endif
