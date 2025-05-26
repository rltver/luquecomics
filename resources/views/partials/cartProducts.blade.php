<div class="w-full max-w-[1000px] m-auto">
    @if(session('cart', []))
        @php $total = 0 @endphp
        @foreach(session('cart', []) as $id => $comic)
            @php $total += $comic['price'] * $comic['quantity']@endphp
            <div data-product-id="{{$comic['id']}}" id="{{$comic['id']}}" class="p-3 border-b border-gray-200 last:border-b-0 flex w-full gap-4">
                <!-- Imagen del cómic -->
                <div class="w-30 flex-shrink-0">
                    <img
                        src="{{ asset('storage/comics/'. ($comic['thumbnail_image'] ?? 'default.webp')) }}"
                        alt="{{ $comic['title'] }}"
                        class="w-full h-full object-cover"
                    >
                </div>
                <!-- Detalles del producto -->
                <div class="flex flex-col flex-1 w-full justify-between">
                    <div>
                        <a href="{{route('comics.show',$comic['id'])}}" class="text-gray-900 font-medium md:text-2xl capitalize text-lg leading-tight line-clamp-2 transition hover:text-yellow-600">
                            {{ $comic['title'] }}
                        </a>
                    </div>
                    <div class="max-w-xs">
                        <p class="text-sm text-gray-500 mb-3">{{__('cart.units')}}:</p>
                        <form>
                            <div class="flex items-center gap-4 mb-4">
                                <button type="button" class="decrease w-6 h-6 cursor-pointer bg-gray-200 rounded-full"><i class="fa-solid fa-minus"></i></button>

                                <input
                                    type="number"
                                    name="quantity"
                                    value="{{ $comic['quantity'] }}"
                                    id="{{$comic['id']}}"
                                    min="1"
                                    max="{{ $comic['stock'] }}"
                                    class="quantity no-spinners w-10 text-center border rounded"
                                >

                                <button type="button" class="increase w-6 h-6 cursor-pointer bg-gray-200 rounded-full"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </form>
                    </div>
                    <div>
                        <p class="text-yellow-600 font-bold mt-1">{{ number_format($comic['price'], 2) * $comic['quantity'] }} €</p>
                    </div>
                </div>
                <!-- Botón eliminar -->
{{--                <form method="post" action="{{route('cart.unsetComic')}}" class="flex items-center">--}}
{{--                    @csrf--}}
{{--                    @method('put')--}}
{{--                    <input type="hidden" name="id" value="{{$comic['id']}}">--}}
{{--                    <button type="submit" class="text-gray-400 hover:text-red-500 transition">--}}
{{--                        <i class="fa-solid fa-trash-can fa-lg"></i>--}}
{{--                    </button>--}}
{{--                </form>--}}
                <button type="submit" id="remove" class="text-gray-400 cursor-pointer hover:text-red-500 transition">
                    <i class="fa-solid fa-trash-can fa-lg"></i>
                </button>
            </div>
        @endforeach
    @else
        <div class="p-16 text-center text-gray-500 m-auto">
            <i class="fa-solid fa-cart-shopping text-3xl mb-2 text-gray-200"></i>
            <p>{{__('cart.empty')}}</p>
            <a href="{{route('comics.index')}}" class="w-80 text-center underline">{{__('cart.return')}}</a>

        </div>
    @endif
</div>

<!-- Pie del carrito -->
@if(session('cart', []))
    <div class="p-4 border-t border-gray-100 lg:min-w-96">
        <div class="flex justify-between items-center mb-4">
            <span class="font-medium">Total:</span>
            <span class="font-bold text-lg text-yellow-600">
                        {{ number_format($total,2) }} €
                    </span>
        </div>
        <a href="{{route('comics.index')}}" class="w-80 text-center underline">{{__('cart.shopping')}}</a>
        <a
            href="{{ route('cart.confirmOrder') }}"
            class="mt-2 cursor-pointer bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-xs transition flex items-center justify-center gap-2"
        >
            <i class="fa-solid fa-credit-card"></i>
            {{__('cart.checkout')}}
        </a>
    </div>
@endif
