<x-layouts.app2>
    <div class="container flex flex-col md:flex-row m-auto my-16 gap-8 px-6">
        <div class="md:w-1/2">
            <div class="flex justify-center">
                <img onclick="completeImage.showModal()" class="mb-2 w-full max-w-96 cursor-pointer object-contain" src="{{asset('storage/characters/'. ($character->image ?? 'default.webp'))}}" alt="{{$character->image}}">
                <dialog id="completeImage" class="modal">
                    <div class="modal-box min-w-1/2">
                        <img class="w-full" src="{{asset('storage/characters/'. ($character->image ?? 'default.webp'))}}" alt="">
                    </div>
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                </dialog>
            </div>
            <div>
            </div>
        </div>
        <div class="md:w-1/2 flex flex-col justify-between">
            <div>
                <h1 class="text-4xl capitalize font-bold mb-4">{{$character->name}}</h1>
                <div>
                    <h2 class="font-semibold text-xl mt-4 mb-1">{{__('characters_show.description')}}</h2>
                    <p>{{$character->description}}</p>
                    <hr class="my-2">
                </div>
                <div>
                    <h2 class="font-semibold text-xl mt-4 mb-1">{{__('characters_show.info')}}</h2>
                    <p><b>{{__('characters_show.publisher')}}:</b> <a href="{{route('publishers.show',$character->publisher->id)}}" class="text-indigo-600 hover:text-yellow-500 transition duration-300">{{$character->publisher->name}}</a></p>
                    <p><b>{{__('characters_show.first')}}:</b> {{$character->first_appearance->format('Y')}}</p>
                </div>
            </div>
            @auth
                @if(auth()->user()->is_admin)
                    <div class="flex gap-3 mt-6 justify-end items-end">
                        <a href="{{route('characters.edit',$character->id)}}" class="w-8 h-8 leading-8 text-center rounded-sm bg-indigo-700 text-white cursor-pointer hover:text-yellow-500 transition duration-300">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button class="w-8 h-8 leading-8 text-center rounded-sm bg-red-600 text-white cursor-pointer hover:text-yellow-500 transition duration-300" onclick="deletebox.showModal()">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <dialog id="deletebox" class="modal ">
                            <div class="modal-box bg-white rounded-sm">
                                <h3 class="text-lg font-bold">{{__('characters_show.delete_ask')}}</h3>
                                <p class="py-4">{{__('characters_show.delete_confirm')}}</p>
                                <a class="text-indigo-600 hover:text-yellow-500 transitio duration-300" href="{{route('characters.edit',$character->id)}}">{{__('characters_show.edit')}}</a>
                                <form method="post" action="{{route('characters.destroy',$character->id)}}">
                                    @csrf
                                    <x-forms.button class="!bg-red-500 float-end">{{__('characters_show.delete')}}</x-forms.button>
                                    @method('delete')
                                </form>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>
                    </div>
                @endif
            @endauth
        </div>



    </div>

    @if(count($comics)<1)
        <section class="bg-gray-100 py-12">
            <div class="max-w-7xl mx-auto px-4">
                {{-- most bought comics --}}
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold ">{{__('characters_show.no_comics')}}</h1>
                </div>

                {{-- boton para ver más --}}
                <div class="mt-10 text-center">
                    <a href="{{ route('comics.index') }}"
                       class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded shadow">
                        {{__('characters_show.see_all2')}}
                    </a>
                </div>
            </div>
        </section>
    @else
        <section class="bg-gray-100 py-12">
            <div class="max-w-7xl mx-auto px-4">
                {{-- most bought comics --}}
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold ">{{__('characters_show.title')}}</h1>
                    <p class="mt-2 text-gray-600">{{__('characters_show.label')}}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($comics as $comic)
                        <div
                            href=""
                            onclick="window.location.href='{{route('comics.show',$comic->id)}}'"
                            class="w-full bg-white cursor-pointer flex flex-col items-center rounded-sm shadow-md p-4 m-auto hover:shadow-xl transition-all duration-300"
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
                    <a href="{{ route('comics.index').'?characters%5B%5D='.$character->id }}"
                       class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded shadow">
                        {{__('characters_show.see_all')}}
                    </a>
                </div>
            </div>
        </section>
    @endif
</x-layouts.app2>
