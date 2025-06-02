<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('home.title')}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{Storage::url('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans antialiased min-h-screen flex flex-col">
@session('success')
<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 3000)"
    x-show="show"
    x-transition
    class="toast toast-top toast-center z-50 rounded-sm overflow-hidden"
>
    <div class="alert alert-success bg-indigo-600 text-white !z-50">
        <span>{{$value}}</span>
    </div>
</div>
@endsession
<!-- Header -->
<header class="bg-indigo-900 text-white shadow-md">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Logo y botón móvil -->
        <div class="flex items-center space-x-4">
            <!-- Botón menú móvil -->
            <button id="mobile-menu-button" class="lg:hidden cursor-pointer text-white focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Logo -->
            <a href="{{route('home')}}" class="flex items-center space-x-2">
                <i class="fa-solid fa-person-falling-burst fa-xl"></i>
                <h1 class="text-xl sm:text-2xl font-bold">Luque<span class="text-yellow-400">Comics</span></h1>
            </a>
        </div>

        <!-- Barra de búsqueda (oculta en móviles) -->
        <div class="hidden lg:block lg:w-1/4 xl:w-1/3">
            <form class="flex" action="{{route('comics.index')}}">
                <input name="search"
                       type="text"
                       placeholder="{{__('home.search_desktop')}}"
                       value="{{ request('search') ? request('search') : '' }}"
                       class="w-full px-4 py-2 rounded-l border-none text-gray-300 focus:outline-none  transition duration-300">
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 cursor-pointer border-none text-gray-800 px-4 py-2 rounded-r transition duration-300">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>


        <!-- Navegación desktop (oculta en móviles) -->
        <nav class="hidden lg:flex items-center space-x-4">
            @include('components.langSwitch')
            <a href="{{route('comics.index')}}"  class="{{request()->routeIs('comics.index') ? 'text-yellow-400' : 'hover:text-yellow-400'}}  transition duration-300">{{ __('home.comics') }}</a>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="m-1 hover:text-yellow-400 focus:text-yellow-400 cursor-pointer transition-all duration-300 bg-indigo-800 py-1 px-2 rounded-sm">Explorar ️</div>
                <ul tabindex="0" class="dropdown-content menu bg-indigo-800 shadow-xl rounded-box w-60 z-50 mt-2 rounded-sm">
                    <li><a href="{{route('characters.index')}}" class="hover:bg-indigo-700 rounded-sm transition-all duration-300">Personajes</a></li>
                    <li><hr class="mt-4"></li>
                    @foreach($publishers as $publisher)
                        <li><a href="{{route('publishers.show',$publisher->id)}}" class="hover:bg-indigo-700 rounded-sm transition-all duration-300">{{$publisher->name}}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- carrito -->

            @if(!request()->routeIs('cart.index') && !request()->routeIs('cart.confirmOrder'))
            @include('partials.cart')
            @endif

            <!-- Autenticación -->
            @auth

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="m-1 hover:text-yellow-400 focus:text-yellow-400 cursor-pointer transition-all duration-300 bg-indigo-800 py-1 px-2 rounded-sm"><i class="fa-solid fa-user me-2"></i>{{auth()->user()->name}} ️</div>
                    <ul tabindex="0" class="dropdown-content menu bg-indigo-800 shadow-xl rounded-box w-60 z-50 mt-2 rounded-sm">
                        <li><a href="{{route('cart.index')}}" class="hover:bg-indigo-700 rounded-sm transition-all duration-300">{{__('home.cart')}}</a></li>
                        <li><a href="{{route('session.orders')}}" class="hover:bg-indigo-700 rounded-sm transition-all duration-300">{{__('home.orders')}}</a></li>
                        <li><a href="{{route('session.accountInfo')}}" class="hover:bg-indigo-700 rounded-sm transition-all duration-300">{{__('home.personal_data')}}</a></li>
                        <li class="hover:bg-indigo-700 rounded-sm transition-all duration-300">
                            <form method="post" action="{{route('session.destroy')}}" class="w-full">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 cursor-pointer transition-all duration-300">{{__('home.logout_desktop')}}</button>
                            </form>
                        </li>
                    </ul>
                </div>

            @endauth
            @guest
                <a href="{{route('login')}}" class="{{request()->routeIs('login') ? 'text-yellow-400' : 'hover:text-yellow-400'}}  transition duration-300">{{__('home.login_desktop')}}</a>
                <a href="{{route('register.create')}}" class="bg-yellow-500 hover:bg-yellow-600 text-gray-800 px-3 py-1 rounded transition duration-300">{{__('home.register_desktop')}}</a>
            @endguest
        </nav>

        <!-- Iconos móviles (carrito y búsqueda) -->
        <div class="flex lg:hidden items-center space-x-4 ms-2">
            @include('components.langSwitch')
            <button class="text-white focus:outline-none cursor-pointer" onclick="searchbox.showModal()">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <dialog id="searchbox" class="modal">
                <div class="modal-box  bg-white rounded-sm p-3">
                    <form class="flex" action="{{route('comics.index')}}">
                        <input name="search"
                               type="text"
                               placeholder="{{__('home.search_desktop')}}"
                               value="{{ request('search') ? request('search') : '' }}"
                               class="w-full px-4 py-2 rounded-l border-none text-gray-800 ring-2 ring-indigo-600 focus:outline-none  transition duration-300">
                        <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-600 cursor-pointer ring-2 ring-indigo-600 border-none text-gray-800 px-4 py-2 rounded-r transition duration-300">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
                <form method="dialog" class="modal-backdrop">
                    <button>close</button>
                </form>
            </dialog>
{{--            <a href="#" class="relative text-white">--}}
{{--                <i class="fa-solid fa-cart-shopping"></i>--}}
{{--                <span class="absolute -top-2 -right-2 bg-yellow-500 text-xs text-gray-800 font-bold rounded-full h-5 w-5 flex items-center justify-center">--}}
{{--                        0--}}
{{--                    </span>--}}
{{--            </a>--}}
            @if(!request()->routeIs('cart.index') && !request()->routeIs('cart.confirmOrder'))
                @include('partials.cart')
            @endif
        </div>
    </div>
</header>

<!-- offcanvas for mobile -->
<div id="mobile-menu" class="fixed inset-0 z-50 hidden bg-gray-900/50 transition-opacity">
    <div class="fixed inset-y-0 left-0 w-5/6 max-w-xs bg-indigo-900 text-white shadow-lg transform transition-transform ease-in-out duration-300 -translate-x-full">
        <div class="flex flex-col h-full">
            <!-- offcanvas header -->
            <div class="flex items-center justify-between p-4 border-b border-indigo-800">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-person-falling-burst fa-2xl"></i>
{{--                    <h2 class="text-xl font-bold">Menú</h2>--}}
                </div>
                <button id="close-mobile-menu" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- mobile menu -->
            <nav class="flex-1 overflow-y-auto p-4 space-y-4">
                <a href="{{route('home')}}"  class="{{request()->routeIs('home') ? 'text-yellow-400 bg-indigo-800' : 'hover:text-yellow-400 hover:bg-indigo-800'}} block py-2 px-4 rounded transition duration-300">{{__('home.home')}}</a>
                <a href="{{route('comics.index')}}"  class="{{request()->routeIs('comics.index') ? 'text-yellow-400 bg-indigo-800' : 'hover:text-yellow-400 hover:bg-indigo-800'}} block py-2 px-4 rounded transition duration-300">{{ __('home.comics') }}</a>
                <a href="{{route('characters.index')}}"  class="{{request()->routeIs('characters.index') ? 'text-yellow-400 bg-indigo-800' : 'hover:text-yellow-400 hover:bg-indigo-800'}} block py-2 px-4 rounded transition duration-300">Personajes</a>
                @foreach($publishers as $publisher)
                    <a
                        href="{{ route('publishers.show', $publisher->id) }}"
                        class="{{ request()->routeIs('publishers.show') && request()->route('publisher')?->id === $publisher->id
                        ? 'text-yellow-400 bg-indigo-800'
                        : 'hover:text-yellow-400 hover:bg-indigo-800' }}
                        block py-2 px-4 rounded transition duration-300">
                        {{ $publisher->name }}
                    </a>
                @endforeach
                <div class="pt-4 border-t border-indigo-800">
                    @auth
                        @auth
                            <a href="{{route('session.orders')}}"  class="{{request()->routeIs('session.orders') ? 'text-yellow-400 bg-indigo-800' : 'hover:text-yellow-400 hover:bg-indigo-800'}} block py-2 px-4 rounded transition duration-300 mb-2"><i class="fa-solid fa-user me-2"></i>{{auth()->user()->name}}</a>
                            <form method="post" action="{{route('session.destroy')}}">
                                @csrf
                                <x-forms.button class="font-normal text-black block w-full text-left">Log Out</x-forms.button>
                            </form>
                        @endauth
                    @endauth
                    @guest
                        <a href="{{route('login')}}" class="block py-2 px-4 hover:bg-indigo-800 rounded transition duration-300">{{__('home.login_desktop')}}</a>
                        <a href="{{route('register.create')}}" class="block py-2 px-4 bg-yellow-500 text-gray-800 rounded hover:bg-yellow-600 transition duration-300">{{__('home.register_desktop')}}</a>
                    @endguest
                </div>
            </nav>

            <!-- offcanvas footer -->
            <div class="p-4 border-t border-indigo-800">
                <div class="flex space-x-4 justify-center">
                    <a href="https://x.com/ikercasillas?lang=es" class="text-white hover:text-yellow-400">
                        <i class="fa-brands fa-twitter fa-xl"></i>
                    </a>
                    <a href="https://www.instagram.com/ikercasillas/?hl=es" class="text-white hover:text-yellow-400">
                        <i class="fa-brands fa-instagram fa-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- menu for other links -->
{{--<div class="bg-indigo-800 text-white shadow-md hidden">--}}
{{--    <div class="container mx-auto px-4">--}}
{{--        <nav class="flex justify-center flex-wrap py-2 space-x-6">--}}
{{--            <a href="#" class="whitespace-nowrap hover:text-yellow-400 transition duration-300">Superhéroes</a>--}}
{{--            <a href="#" class="whitespace-nowrap hover:text-yellow-400 transition duration-300">Manga</a>--}}
{{--            <a href="#" class="whitespace-nowrap hover:text-yellow-400 transition duration-300">Cómics Europeos</a>--}}
{{--            <a href="#" class="whitespace-nowrap hover:text-yellow-400 transition duration-300">Independientes</a>--}}
{{--            <a href="#" class="whitespace-nowrap hover:text-yellow-400 transition duration-300">Clásicos</a>--}}
{{--            <a href="#" class="whitespace-nowrap hover:text-yellow-400 transition duration-300">Novelas Gráficas</a>--}}
{{--        </nav>--}}
{{--    </div>--}}
{{--</div>--}}

<main class="flex-1">
    {{-- dinamic views --}}
    {{$slot}}
</main>

<!-- footer -->
<footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- shop info -->
            <div>
                <h3 class="text-xl font-bold mb-4 text-white">Luque<span class="text-yellow-400">Comics</span></h3>
                <p class="mb-2">{{__('home.description')}}</p>
                <p>{{__('home.shipments')}}</p>
            </div>

            <!-- quick links -->
            <div>
                <h4 class="text-lg font-semibold mb-4">{{__('home.quick_links')}}</h4>
                <ul class="space-y-2">
                    <li><a href="{{route('home')}}" class="hover:text-yellow-400 transition duration-300">{{__('home.home')}}</a></li>
                    <li><a href="{{route('comics.index')}}" class="hover:text-yellow-400 transition duration-300">{{__('home.footer_comics')}}</a></li>
                </ul>
            </div>

            <!-- categories -->
            <div>
                <h4 class="text-lg font-semibold mb-4">{{__('home.categories')}}</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-yellow-400 transition duration-300">DC</a></li>
                    <li><a href="#" class="hover:text-yellow-400 transition duration-300">Marvel</a></li>
                </ul>
            </div>

            <!-- contact -->
            <div>
                <h4 class="text-lg font-semibold mb-4">{{__('home.contact')}}</h4>
                <div class="space-y-2">
                    <p>luquecomicstfg@gmail.com</p>
                    <p>+34 645 653 428</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="https://x.com/ikercasillas?lang=es" class="hover:text-yellow-400 transition duration-300">
                            <i class="fa-brands fa-twitter fa-xl"></i>
                        </a>
                        <a href="https://www.instagram.com/ikercasillas/?hl=es" class="hover:text-yellow-400 transition duration-300">
                            <i class="fa-brands fa-instagram fa-xl"></i>

                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- copyright -->
        <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
            <p>&copy; 2025 <a href="https://github.com/rltver" class="text-gray-300 hover:underline transition">Rafael Luque Trujillo</a>{{__('home.copyright')}}</p>
        </div>
    </div>
</footer>

<!-- offcanvas script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const closeMobileMenu = document.getElementById('close-mobile-menu');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.remove('hidden');
            setTimeout(() => {
                mobileMenu.querySelector('div > div').classList.remove('-translate-x-full');
            }, 20);
        });

        closeMobileMenu.addEventListener('click', function() {
            mobileMenu.querySelector('div > div').classList.add('-translate-x-full');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300);
        });

        // close the menu when clicking outside
        mobileMenu.addEventListener('click', function(e) {
            if (e.target === mobileMenu) {
                mobileMenu.querySelector('div > div').classList.add('-translate-x-full');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
            }
        });
    });



</script>

<!-- other scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script>
    //ajax
</script>
@stack('scripts')
</body>
</html>
