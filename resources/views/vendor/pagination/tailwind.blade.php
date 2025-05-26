@if ($paginator->hasPages())
        <div class="flex flex-col md:flex-row items-center justify-between mx-4 my-4">
            <div>
                <p class="text-sm text-gray-700 leading-5 mb-2">
                    {!! __('pagination.Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('pagination.to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('pagination.of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('pagination.results') !!}
                </p>
            </div>

            <div class="overflow-hidden">
                <span class="relative z-0 inline-flex rtl:flex-row-reverse gap-1 ">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative h-full inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md leading-5 " aria-hidden="true">
                                <i class="fa-solid fa-chevron-left align-middle"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative  inline-flex items-center px-2 py-2 text-sm font-medium text-blue-500 bg-white border border-blue-300 rounded-md leading-5 hover:text-blue-400 focus:z-10 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-blue-100 active:text-blue-500 transition ease-in-out duration-150  " aria-label="{{ __('pagination.previous') }}">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-2 py-1 rounded-md -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 h-full ">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-2 py-1 rounded-md -ml-px text-sm font-medium text-yellow-500 bg-white border border-yellow-300 cursor-default leading-5 h-full ">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-2 py-1 rounded-md -ml-px text-sm font-medium text-blue-700 bg-white border border-blue-300 leading-5 hover:text-blue-500 focus:z-10 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-blue-100 active:text-blue-700 transition ease-in-out duration-150 " aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-blue-500 bg-white border border-blue-300 rounded-md leading-5 hover:text-blue-400 focus:z-10 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-blue-100 active:text-blue-500 transition ease-in-out duration-150  " aria-label="{{ __('pagination.next') }}">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative h-full inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md leading-5 " aria-hidden="true">
                                <i class="fa-solid fa-chevron-right align-middle"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
