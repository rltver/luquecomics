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
                <img src="{{asset('storage/banner2.webp')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                <img src="{{asset('storage/banner3.jpg')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
            </div>
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
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800">Bienvenido a LuqueComics</h1>
                <p class="mt-2 text-gray-600">Tu tienda online de cómics, novelas gráficas y más</p>
            </div>

            {{-- Últimos cómics añadidos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($comics as $comic)
                    <div class="bg-white rounded-xl shadow hover:shadow-lg transition duration-300 overflow-hidden">
                        <a href="{{ route('comics.show', $comic->slug) }}">
                            <img src="{{ asset('storage/comics/' . $comic->thumbnail_image) }}" alt="{{ $comic->title }}" class="w-full h-60 object-cover">
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800">{{ $comic->title }}</h2>
                                <p class="text-sm text-gray-500">{{ $comic->author }}</p>
                                <p class="mt-1 font-bold text-indigo-600">{{ number_format($comic->price, 2) }} €</p>
                            </div>
                        </a>
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
