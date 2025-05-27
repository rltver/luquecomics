<x-layouts.account>
    <x-slot:header>{{__('account_layout.orders')}}</x-slot:header>
    <x-slot:slot>
        @forelse(auth()->user()->orders->sortByDesc('created_at') as $order)
            <div class="rounded-sm overflow-hidden my-4 shadow-lg">
                <div class="bg-indigo-600 flex  justify-between py-2 px-3 text-white">
                    <p title="Fecha del pedido">{{date_format($order->created_at,'d/m/Y')}}</p>
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="cursor-pointer hover:text-yellow-400 focus:text-yellow-400">{{__('orders.details')}} <i class="fa-solid fa-chevron-down fa-xs"></i></div>
                        <ul tabindex="0" class="dropdown-content rounded-sm text-white p-2 bg-indigo-600 shadow-xl rounded-box w-60 z-50 mt-2 border border-gray-100">
                            <li><b>{{__('orders.province')}}:</b> {{$order->province}}</li>
                            <li><b>{{__('orders.city')}}:</b> {{$order->city}}</li>
                            <li><b>{{__('orders.address')}}:</b> {{$order->address}}</li>
                            <li><b>{{__('orders.zipcode')}}:</b> {{$order->zipcode}}</li>
                        </ul>
                    </div>
                    <p>{{__('orders.order_number')}}{{$order->id}}</p>
                </div>
                <div class="min-h-40">
                    @foreach($order->items as $item)
                        <div class="m-2 flex gap-4">
                            <div class="w-30 flex-shrink-0">
                                <img
                                    src="{{ asset('storage/comics/'. ($item->comic->thumbnail_image ?? 'default.webp')) }}"
                                    alt="{{ $item->comic->title }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                            <div class="mt-3 flex flex-col justify-between">
                                @if($item->comic->trashed())
                                    <p class="capitalize text-lg font-semibold">
                                        {{$item->comic->title}}
                                        <span class="text-red-500"> (not available anymore)</span>
                                    </p>
                                @else
                                    <a href="{{route('comics.show',$item->comic->id)}}" class="capitalize text-lg font-semibold hover:text-yellow-500 transition duration-300">{{$item->comic->title}}</a>
                                @endif
                                <div>
                                    <p>{{__('orders.units')}}: {{$item->quantity}}</p>
                                    <p>{{__('orders.unit_price')}}: {{$item->unit_price}} €</p>
                                    <p>{{__('orders.total_comic')}}: {{$item->unit_price * $item->quantity}} €</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between bg-indigo-600 text-white py-1 px-3">
                    <p>{{__('orders.total')}}:</p>
                    <b>{{$order->total_price}} €</b>
                </div>

            </div>

            <hr class="mx-auto w-60 h-1 my-8 bg-yellow-500 border-0 rounded-sm lg:w-80">

        @empty
            <div>{{__('orders.empty')}} <a class="text-yellow-600" href="{{route('comics.index')}}">{{__('orders.shop')}}</a></div>
        @endforelse
    </x-slot:slot>
</x-layouts.account>
