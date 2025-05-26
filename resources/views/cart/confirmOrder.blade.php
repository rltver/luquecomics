<x-layouts.app2>
<div class="flex flex-col md:flex-row justify-center">

    <form method="POST" action="{{route('cart.placeOrder')}}">
        @csrf
        <div class="flex flex-col items-center mt-20">
            <div class="flex flex-col gap-2 w-1/2 min-w-50 lg:w-80">
                <div class="">
                    <x-forms.label for="name">{{__('confirmOrder.name')}}</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{auth()->user()->name}}" name="name" id="name" />
                        <x-forms.error name="name" />
                    </div>
                </div>
                <div class="">
                    <x-forms.label for="surname">{{__('confirmOrder.surname')}}</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{auth()->user()->surname}}" name="surname" id="surname" />
                        <x-forms.error name="surname" />
                    </div>
                </div>
                <div class="">
                    <x-forms.label for="address">{{__('confirmOrder.address')}}</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{old('address')}}" name="address" id="address" type="text" />
                        <x-forms.error name="address" />
                    </div>
                </div>
                <div class="">
                    <x-forms.label for="province">{{__('confirmOrder.province')}}</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{old('province')}}" name="province" id="province" type="text" />
                        <x-forms.error name="province" />
                    </div>
                </div>
                <div class="">
                    <x-forms.label for="city">{{__('confirmOrder.city')}}</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{old('city')}}" name="city" id="city" type="text" />
                        <x-forms.error name="city" />
                    </div>
                </div>
                <div class="">
                    <x-forms.label for="zipcode">{{__('confirmOrder.zipcode')}}</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{old('zipcode')}}" name="zipcode" id="zipcode" type="text" />
                        <x-forms.error name="zipcode" />
                    </div>
                </div>
                <div class="">
                    <x-forms.label for="phone">{{__('confirmOrder.phone')}}</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{old('phone')}}" name="phone" id="phone" type="text" />
                        <x-forms.error name="phone" />
                    </div>
                </div>
                <x-forms.button class="mt-2">{{__('confirmOrder.checkout')}}</x-forms.button>
                <a href="{{route('cart.index')}}" class="py-2 bg-indigo-600 hover:bg-indigo-800 rounded-xs font-semibold text-center text-white">{{__('confirmOrder.edit')}}</a>
            </div>
        </div>
    </form>
    <div class="mt-20 mx-16 md:mx-6">
        @php $total = 0 @endphp
        @foreach(session('cart', []) as $id => $comic)
            @php $total += $comic['price'] * $comic['quantity']@endphp
            <div data-product-id="{{$comic['id']}}" id="{{$comic['id']}}" class="p-3 border-b border-gray-200 last:border-b-0 flex w-80 gap-4">
                <div class="w-16 flex-shrink-0">
                    <img
                        src="{{ asset('storage/comics/'. ($comic['thumbnail_image'] ?? 'default.webp')) }}"
                        alt="{{ $comic['title'] }}"
                        class="w-full h-full object-cover"
                    >
                </div>
                <div class="flex flex-col flex-1 w-full justify-between">
                    <div>
                        <p href="{{route('comics.show',$comic['id'])}}" class="text-gray-900 font-medium capitalize text-normal leading-tight line-clamp-2 transition">
                            {{ $comic['title'] }}
                        </p>
                    </div>
                    <div class="max-w-xs">
                        <p class="text-sm text-gray-500 my-3">{{__('confirmOrder.units')}}: {{$comic['quantity']}}</p>
                    </div>
                    <div>
                        <p class="text-yellow-600 font-bold mt-1">{{ number_format($comic['price'], 2) * $comic['quantity'] }} €</p>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="flex justify-between items-center mb-4">
            <span class="font-medium">Total:</span>
            <span class="font-bold text-lg text-yellow-600">
                        {{ number_format($total,2) }} €
            </span>
        </div>
    </div>
</div>
</x-layouts.app2>
