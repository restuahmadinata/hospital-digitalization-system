@if ($paginator->hasPages())
<div class="rounded-b-lg border-t border-gray-200 px-4 py-2">
    <ol class="flex justify-end gap-1 text-xs font-medium">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li>
                <span
                    class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-400 cursor-not-allowed"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            </li>
        @else
            <li>
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-400">
                    {{ $element }}
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="block size-8 rounded border-blue-600 bg-blue-600 text-center leading-8 text-white">
                            {{ $page }}
                        </li>
                    @else
                        <li>
                            <a
                                href="{{ $url }}"
                                class="block size-8 rounded border border-gray-100 bg-white text-center leading-8 text-gray-900"
                            >
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-900"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </li>
        @else
            <li>
                <span
                    class="inline-flex size-8 items-center justify-center rounded border border-gray-100 bg-white text-gray-400 cursor-not-allowed"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            </li>
        @endif
    </ol>
</div>
@endif
