<x-layouts.app2>
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                <img src="{{asset('storage/banner1.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                <img src="{{asset('storage/banner2.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                <img src="{{asset('storage/banner3.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
        </div>
        <div class="absolute z-30 flex top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center bg-indigo-400/30 p-3 rounded-sm">
            <h1 class="text-4xl font-bold text-white">Bienvenido a <span class="text-indigo-600">Luque</span><span class="text-yellow-400">Comics</span></h1>
        </div>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full cursor-pointer" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full cursor-pointer" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full cursor-pointer" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        </div>
    </div>

    <section class="bg-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4">
            {{-- most bought comics --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold ">¡Nuestros top ventas!</h1>
                <p class="mt-2 text-gray-600">¡Compralos antes de que se acaben!</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($comics as $comic)
                    <div
                        href=""
                        onclick="window.location.href='{{route('comics.show',$comic->id)}}'"
                        class="w-full bg-white cursor-pointer flex flex-col items-center sm:m-4 rounded-sm shadow-md p-4 m-auto sm:w-[300px] md:w-auto hover:shadow-xl transition-all duration-300"
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
                @endforeach
            </div>

            {{-- Botón para ver más --}}
            <div class="mt-10 text-center">
                <a href="{{ route('comics.index') }}"
                   class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded shadow">
                    Ver todos los cómics
                </a>
            </div>
        </div>
    </section>
</x-layouts.app2>
