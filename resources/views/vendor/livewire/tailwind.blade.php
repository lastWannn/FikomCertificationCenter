@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display:inline-flex;align-items:center;gap:6px;vertical-align:middle;margin:0;padding:0;" wire:key="paginator-nav-{{ $paginator->getPageName() }}">
        {{-- Previous Page Link --}}
        <button type="button"
            wire:key="paginator-btn-prev"
            @if ($paginator->onFirstPage())
                disabled
                style="width:34px;height:34px;min-width:34px;border-radius:8px;background:#F1F5F9;border:1.5px solid #E2E4EB;color:#CBD5E1;display:inline-flex;align-items:center;justify-content:center;cursor:not-allowed;margin:0;padding:0;box-sizing:border-box;line-height:1;appearance:none;-webkit-appearance:none;"
            @else
                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                style="width:34px;height:34px;min-width:34px;border-radius:8px;background:#FFFFFF;border:1.5px solid #131218;color:#131218;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;margin:0;padding:0;box-sizing:border-box;outline:none;font-family:inherit;line-height:1;appearance:none;-webkit-appearance:none;transition:all .15s;"
                onmouseover="this.style.background='#FFC81A';"
                onmouseout="this.style.background='#FFFFFF';"
            @endif
            title="Halaman Sebelumnya">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span wire:key="paginator-dots-{{ $loop->index }}" style="min-width:28px;height:34px;display:inline-flex;align-items:center;justify-content:center;font-size:12.5px;font-weight:800;color:#94A3B8;margin:0;padding:0 4px;box-sizing:border-box;line-height:1;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <button type="button"
                        wire:key="paginator-btn-page-{{ $page }}"
                        @if ($page == $paginator->currentPage())
                            disabled
                            style="min-width:34px;height:34px;padding:0 10px;border-radius:8px;background:#131218;border:1.5px solid #131218;color:#FFC81A;font-size:12.5px;font-weight:900;display:inline-flex;align-items:center;justify-content:center;margin:0;box-sizing:border-box;line-height:1;appearance:none;-webkit-appearance:none;box-shadow:0 2px 6px rgba(19,18,24,0.2);cursor:default;"
                        @else
                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                            style="min-width:34px;height:34px;padding:0 10px;border-radius:8px;background:#FFFFFF;border:1.5px solid #E2E4EB;color:#131218;font-size:12.5px;font-weight:800;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;margin:0;box-sizing:border-box;outline:none;font-family:inherit;line-height:1;appearance:none;-webkit-appearance:none;transition:all .15s;"
                            onmouseover="this.style.background='#FFFDF5';this.style.borderColor='#FFC81A';"
                            onmouseout="this.style.background='#FFFFFF';this.style.borderColor='#E2E4EB';"
                        @endif>
                        {{ $page }}
                    </button>
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        <button type="button"
            wire:key="paginator-btn-next"
            @if ($paginator->hasMorePages())
                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                style="width:34px;height:34px;min-width:34px;border-radius:8px;background:#FFFFFF;border:1.5px solid #131218;color:#131218;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;margin:0;padding:0;box-sizing:border-box;outline:none;font-family:inherit;line-height:1;appearance:none;-webkit-appearance:none;transition:all .15s;"
                onmouseover="this.style.background='#FFC81A';"
                onmouseout="this.style.background='#FFFFFF';"
            @else
                disabled
                style="width:34px;height:34px;min-width:34px;border-radius:8px;background:#F1F5F9;border:1.5px solid #E2E4EB;color:#CBD5E1;display:inline-flex;align-items:center;justify-content:center;cursor:not-allowed;margin:0;padding:0;box-sizing:border-box;line-height:1;appearance:none;-webkit-appearance:none;"
            @endif
            title="Halaman Berikutnya">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </nav>
@endif
