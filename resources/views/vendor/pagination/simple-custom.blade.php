@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;width:100%;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding:6px 12px;font-size:12px;font-weight:800;color:#94A3B8;background:#F1F5F9;border:1.5px solid #E2E4EB;border-radius:8px;cursor:not-allowed;display:inline-flex;align-items:center;gap:4px;">
                &larr; Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" wire:click.prevent="previousPage" rel="prev" style="padding:6px 12px;font-size:12px;font-weight:800;color:#131218;background:#FFFFFF;border:1.5px solid #131218;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:all .18s;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">
                &larr; Sebelumnya
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" wire:click.prevent="nextPage" rel="next" style="padding:6px 12px;font-size:12px;font-weight:800;color:#131218;background:#FFFFFF;border:1.5px solid #131218;border-radius:8px;text-decoration:none;display:inline-flex;align-items:center;gap:4px;transition:all .18s;" onmouseover="this.style.background='#FFC81A';" onmouseout="this.style.background='#FFFFFF';">
                Berikutnya &rarr;
            </a>
        @else
            <span style="padding:6px 12px;font-size:12px;font-weight:800;color:#94A3B8;background:#F1F5F9;border:1.5px solid #E2E4EB;border-radius:8px;cursor:not-allowed;display:inline-flex;align-items:center;gap:4px;">
                Berikutnya &rarr;
            </span>
        @endif
    </nav>
@endif
