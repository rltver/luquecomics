<x-layouts.app2>
    <div x-data="{ open: false }"
         x-init="window.matchMedia('(min-width: 1024px)').addEventListener('change', e => {if (e.matches) open = false;});"
         class="container py-10 m-auto flex flex-col lg:flex-row gap-8"
    >
        <div class="hidden lg:flex ml-10">
            @include('partials.charactersFilters')
        </div>
        <!-- Fondo oscuro + menú offcanvas -->
        <div
            x-show="open"
            x-transition.opacity
            class="fixed inset-0 bg-blue-800/50 z-40"
            @click="open = false"
        ></div>
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed right-0 top-0 w-64 h-full bg-white shadow-lg z-50 p-4 overflow-y-auto"
            @click.away="if (!['LABEL', 'INPUT'].includes($event.target.tagName)) {open = false}"            {{-- 👈 Esto lo controla --}}
        >{{-- Aquí copias tu bloque de filtros --}}
            <div class="mb-30 me-10 ">
                @include('partials.charactersFilters')
            </div>
        </div>

        <div>
            <div class="flex lg:justify-end justify-between mx-4">
                <button
                    type="button"
                    @click="open = true"
                    class="block lg:hidden bg-blue-600 text-white cursor-pointer px-4 py-2 rounded mb-4"
                >
                    <i class="fa-solid fa-filter"></i>
                </button>
                <form method="GET" action="{{route('characters.index',request()->all())}}" class="mb-6 flex gap-4 justify-end items-center">
                    @csrf
                    @foreach(request()->except('order_by') as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $item)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <label for="sort" class="hidden sm:block">{{__('characters_index.order_by')}}</label>
                    <select name="order_by" id="sort" onchange="this.form.submit()" class="border-b px-2 py-1 pe-6 rounded focus:border-b">
                        <option value="name_asc" {{ request('order_by') == 'name_asc' ? 'selected' : '' }}>{{__('characters_index.name')}} (A-Z)</option>
                        <option value="name_desc" {{ request('order_by') == 'name_desc' ? 'selected' : '' }}>{{__('characters_index.name')}} (Z-A)</option>
                        <option value="appearance_asc" {{ request('order_by') == 'appearance_asc' ? 'selected' : '' }}>{{__('characters_index.first')}} ({{__('characters_index.oldest')}})</option>
                        <option value="appearance_desc" {{ request('order_by') == 'appearance_desc' ? 'selected' : '' }}>{{__('characters_index.first')}} ({{__('characters_index.newest')}})</option>
                    </select>
                </form>
            </div>
            <div class="p-4 sm:p-0 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($characters as $character)
                    <div
                        href="{{route('characters.show',$character->id)}}"
                        onclick="window.location.href='{{route('characters.show',$character->id)}}'"
                        class="w-full cursor-pointer bg-white  flex flex-col items-center rounded-sm shadow-md p-4 mx-auto hover:shadow-xl transition-all duration-300"
                    >
                        <img class="mb-2 h-96 md:h-72  2xl:h-96 w-full object-contain bg-yellow-50" src="{{asset('storage/characters/'. ($character->image ?? 'default.webp'))}}" alt="{{$character->thumbnail_image}}">
                        <h2 class="line-clamp-1 font-semibold text-center text-xl capitalize text-indigo-900" title="{{$character->name}}">{{$character->name}}</h2>
                    </div>
                @empty
                    <div class="min-w-96 font-semibold text-xl">
                        <h1 class="">{{__('comics_index.no_results')}}</h1>
                        <a href="{{ route('characters.index') }}" class="text-indigo-600">{{__('comics_index.clean_filters')}}.</a>

                    </div>


                @endforelse
            </div>
            <div class="overflow-hidden">{{$characters->appends(request()->query())->onEachSide(1)->links()}}</div>
        </div>
    </div>
</x-layouts.app2>
