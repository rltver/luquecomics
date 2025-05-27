<div class="dropdown dropdown-end">
    <!-- button -->
    <div tabindex="0" role="button" class="relative">
        <div class="cursor-pointer hover:text-yellow-400 transition duration-300 p-1">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="absolute -top-1 -right-1 bg-yellow-500 text-gray-800 text-xs font-bold rounded-full h-4 w-4 flex items-center justify-center transform hover:scale-110 transition-transform">
                {{ count(session('cart', [])) }}
            </span>
        </div>
    </div>

    <!-- dropdown -->
    <ul tabindex="0" class="dropdown-content menu text-black bg-white shadow-xl rounded-box w-80 z-50 mt-2 border border-gray-100">
        <!-- header -->
        <div class="p-4 border-b border-gray-100">
            <h3 class="font-bold text-lg flex items-center gap-2">
                <i class="fa-solid fa-cart-shopping text-yellow-500"></i>
                {{__('home.your_cart')}} ({{ count(session('cart', [])) }})
            </h3>
        </div>

        <!-- comic list -->
        <div class="max-h-96 overflow-y-auto w-full">
            @if(session('cart', []))
                @foreach(session('cart', []) as $id => $comic)
                    <li onclick="window.location.href='{{route('comics.show',$comic['id'])}}'" class="hover:bg-gray-50 p-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex gap-4 items-center">
                            <!-- thumbnail -->
                            <div class="w-16 h-16 flex-shrink-0 rounded overflow-hidden">
                                <img
                                    src="{{ asset('storage/comics/'. ($comic['thumbnail_image'] ?? 'default.webp')) }}"
                                    alt="{{ $comic['title'] }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>

                            <!-- comic details -->
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 truncate max-w-32">{{ $comic['title'] }}</h4>
                                <p class="text-sm text-gray-500">{{__('home.units')}}: {{$comic['quantity']}}</p>
                                <p class="text-yellow-600 font-bold mt-1">{{ number_format($comic['price'], 2) }} €</p>
                            </div>

                            <!-- delete button -->
                            <form method="post" action="{{route('cart.removeFromCart')}}">
                                @csrf
                                @method('put')
                                <input type="hidden" name="id" value="{{$comic['id']}}">
                                <button type="submit" class="cursor-pointer text-gray-400 hover:text-red-500 transition">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            @else
                <li class="p-6 text-center text-gray-500">
                    <i class="fa-solid fa-cart-shopping text-3xl mb-2 text-gray-200"></i>
                    <p>{{__('home.empty_cart')}}</p>
                </li>
            @endif
        </div>

        <!-- footer -->
        @if(session('cart', []))
            <div class="p-4 border-t border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-medium">Total:</span>
                    <span class="font-bold text-lg text-yellow-600">
                        {{ number_format(array_sum(array_column(session('cart', []), 'price')), 2) }} €
                    </span>
                </div>
                <a href="{{route('cart.index')}}" class="w-80 text-center underline">{{__('home.edit')}}</a>
                <a
                    href="{{ route('cart.confirmOrder') }}"
                    class="btn btn-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-xs transition flex items-center justify-center gap-2"
                >
                    <i class="fa-solid fa-credit-card"></i>
                    {{__('home.payment')}}
                </a>
            </div>
        @endif
    </ul>
</div>
