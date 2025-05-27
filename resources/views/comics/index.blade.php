<x-layouts.app2>
    <div x-data="{ open: false }"
         x-init="window.matchMedia('(min-width: 1024px)').addEventListener('change', e => {if (e.matches) open = false;});"
         class="container py-10 m-auto flex flex-col lg:flex-row gap-8"
    >
        <div class="hidden lg:flex ml-10">
            @include('partials.comicsFilters')
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
                @include('partials.comicsFilters')
            </div>
        </div>

        <div>
            <div class="flex lg:justify-end justify-between mx-4">
                <button
                    type="button"
                    @click="open = true"
                    class="block lg:hidden bg-blue-600 text-white px-4 py-2 rounded mb-4"
                >
                    <i class="fa-solid fa-filter"></i>
                </button>
                <form method="GET" action="{{route('comics.index',request()->all())}}" class="mb-6 flex gap-4 justify-end items-center">
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
                    <label for="sort" class="hidden sm:block">{{__('comics_index.order_by')}}</label>
                    <select name="order_by" id="sort" onchange="this.form.submit()" class="border-b px-2 py-1 rounded focus:border-b">
                        <option value="new" {{ request('order_by') == '' || request('order_by') == 'new' ? 'selected' : '' }}>{{__('comics_index.news')}}</option>
                        <option value="name_asc" {{ request('order_by') == 'name_asc' ? 'selected' : '' }}>{{__('comics_index.title')}} A-Z</option>
                        <option value="name_desc" {{ request('order_by') == 'name_desc' ? 'selected' : '' }}>{{__('comics_index.title')}} Z-A</option>
                        <option value="price_asc" {{ request('order_by') == 'price_asc' ? 'selected' : '' }}>{{__('comics_index.price_up')}}</option>
                        <option value="price_desc" {{ request('order_by') == 'price_desc' ? 'selected' : '' }}>{{__('comics_index.price_down')}}</option>
                    </select>
                </form>
            </div>

    <div class="p-4 sm:p-0 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
    @forelse($comics as $comic)
        <div
            href=""
            onclick="window.location.href='{{route('comics.show',$comic->id)}}'"
            class="w-full cursor-pointer flex flex-col items-center sm:m-4 rounded-sm shadow-md p-4 m-auto sm:w-[300px] md:w-auto hover:shadow-xl transition-all duration-300"
        >
            <img class="mb-2 h-96 md:h-72  2xl:h-96 w-full object-contain" src="{{asset('storage/comics/'. ($comic->thumbnail_image ?? 'default.webp'))}}" alt="{{$comic->thumbnail_image}}">
            <h2 class="line-clamp-2 h-15 font-semibold text-center text-xl capitalize" title="{{$comic->title}}">{{$comic->title}}</h2>
            @if($comic->stock)
                @if($comic->stock < 11)
                    <p class="my-2 text-orange-400">{{__('comics_index.last_units')}}</p>
                    <h1 class="font-bold text-xl">{{number_format($comic->price,2)}} €</h1>
                    <a href="{{route('cart.add',$comic->id)}}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-xs transition flex items-center justify-center gap-2 mt-4"><i class="fa-solid fa-cart-shopping"></i>{{__('comics_index.add_to_cart')}}</a>
                @else
                    <p class="my-2 text-green-400">{{__('comics_index.stock')}}</p>
                    <h1 class="font-bold text-xl">{{number_format($comic->price,2)}} €</h1>
                    <a href="{{route('cart.add',$comic->id)}}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-xs transition flex items-center justify-center gap-2 mt-4"><i class="fa-solid fa-cart-shopping"></i>{{__('comics_index.add_to_cart')}}</a>
                @endif
                @else
                <p class="my-2 text-red-500">{{__('comics_index.sold_out')}}</p>
                <h1 class="font-bold text-xl">{{number_format($comic->price,2)}} €</h1>
                <p class="cursor-not-allowed bg-gray-300 hover:bg-gray-400 text-white font-bold py-2 px-4 rounded-xs transition flex items-center justify-center gap-2 mt-4"><i class="fa-solid fa-cart-shopping"></i>{{__('comics_index.add_to_cart')}}</p>
            @endif
        </div>
    @empty
        <div class="min-w-96 font-semibold text-xl">
            <h1 class="">{{__('comics_index.no_results')}}</h1>
            <a href="{{ route('comics.index') }}" class="text-indigo-600">{{__('comics_index.clean_filters')}}.</a>

        </div>


    @endforelse
    </div>
    <div class="overflow-hidden">{{$comics->appends(request()->query())->onEachSide(1)->links()}}</div>
    </div>
    </div>




</x-layouts.app2>
