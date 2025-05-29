<x-layouts.app2>
    <div class="container flex flex-col md:flex-row m-auto my-16 gap-8 px-6">
    <div class="md:w-1/2">
        <div class="flex justify-center">
            <img onclick="completeImage.showModal()" class="mb-2 w-full max-w-96 cursor-pointer object-contain" src="{{asset('storage/comics/'. ($comic->thumbnail_image ?? 'default.webp'))}}" alt="{{$comic->thumbnail_image}}">
            <dialog id="completeImage" class="modal">
                <div class="modal-box min-w-1/2">
                    <img class="w-full" src="{{asset('storage/comics/'. ($comic->thumbnail_image ?? 'default.webp'))}}" alt="">
                </div>
                <form method="dialog" class="modal-backdrop">
                    <button>close</button>
                </form>
            </dialog>
        </div>
        <div>
        </div>
    </div>
    <div class="md:w-1/2">
        <h1 class="text-4xl capitalize font-bold mb-4">{{$comic->title}}</h1>
        <a href="#comments" class="flex gap-2 items-baseline">
            <div class="rating rating-xl mb-2">
                <div class="mask mask-star-2 bg-yellow-400" aria-label="1 star" {{round($averageMark) == 1 ? "aria-current=true" : ''}}></div>
                <div class="mask mask-star-2 bg-yellow-400" aria-label="2 star" {{round($averageMark) == 2 ? "aria-current=true" : ''}}></div>
                <div class="mask mask-star-2 bg-yellow-400" aria-label="3 star" {{round($averageMark) == 3 ? "aria-current=true" : ''}}></div>
                <div class="mask mask-star-2 bg-yellow-400" aria-label="4 star" {{round($averageMark) == 4 ? "aria-current=true" : ''}}></div>
                <div class="mask mask-star-2 bg-yellow-400" aria-label="5 star" {{round($averageMark) == 5 ? "aria-current=true" : ''}}></div>
            </div>
            <h1 class="font-semibold text-2xl">{{$averageMark}}</h1>
            <span>"{{count($comic->ComicComments)}} {{__('comics_show.rating')}}"</span>
        </a>
        <h2 class="text-3xl font-bold mb-4">{{$comic->price}}<span class="text-2xl"> €</span></h2>

        @if($comic->stock)
            <div x-data="{ quantity: 1, stock:{{$comic->stock}} }" class="max-w-xs">
                <form action="{{route('cart.add',$comic->id)}}" method="get">
                    @csrf
                    <input type="hidden" name="comic_id" value="{{$comic->id}}"> <!-- ID del producto -->

                    <div class="flex items-center gap-4 mb-4">
                        <!-- Botón disminuir -->
                        <button
                            type="button"
                            @click="if(quantity > 1) quantity--"
                            class="w-10 h-10 flex cursor-pointer items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 transition"
                            :class="{ 'opacity-50 !cursor-not-allowed': quantity === 1 }"
                            :disabled="quantity === 1"
                        >
                            <i class="fa-solid fa-minus pt-1"></i>
                        </button>

                        <!-- Input cantidad -->
                        <input
                            type="number"
                            name="quantity"
                            x-model="quantity"
                            min="1"
                            max="10"
                            class="no-spinners w-16 text-center border border-gray-300 rounded py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        >

                        <!-- Botón aumentar -->
                        <button
                            type="button"
                            @click="if(quantity < 10 && quantity<stock) quantity++"
                            class="w-10 h-10 flex items-center cursor-pointer  justify-center bg-gray-200 rounded-full hover:bg-gray-300 transition"
                            :class="{ 'opacity-50 !cursor-not-allowed': quantity === 10 || quantity===stock }"
                            :disabled="quantity === 10"
                        >
                            <i class="fa-solid fa-plus pt-1"></i>
                        </button>
                    </div>

                    <!-- Botón añadir al carrito -->
                    <button
                        type="submit"
                        class="w-full bg-yellow-500 cursor-pointer hover:bg-yellow-600 text-white font-bold py-3 px-4 rounded-xs transition flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-cart-shopping"></i>
                        {{__('comics_show.add_to_cart')}}
                    </button>
                </form>
            </div>
        @else
            <p class="cursor-not-allowed bg-gray-300 hover:bg-gray-400 text-white font-bold py-2 px-4 rounded-xs transition flex items-center justify-center gap-2 mt-4"><i class="fa-solid fa-cart-shopping"></i>Fuera de stock</p>
        @endif

        <div>
            <h2 class="font-semibold text-xl mt-4 mb-1">{{__('comics_show.description')}}</h2>
            <p>{{$comic->description}}</p>
            <hr class="my-2">
        </div>
        <div>
            <h2 class="font-semibold text-xl mt-4 mb-2">{{__('comics_show.characters')}}</h2>
            <div x-data="{ scrollX: 0 }" class="relative">
                <!-- Botón Izquierdo -->
{{--                <button--}}
{{--                    @click="scrollX -= 300; $refs.scroller.scrollTo({ left: scrollX, behavior: 'smooth' })"--}}
{{--                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow p-2 rounded-full"--}}
{{--                >--}}
{{--                    <i class="fas fa-chevron-left"></i>--}}
{{--                </button>--}}

                <!-- Contenedor scrolleable -->
                <div
                    class="flex scroll overflow-x-auto"
                    style="scroll-behavior: smooth;"
                >
                    @foreach($comic->characters as $character)
                        <a href="{{route('characters.show',$character->id)}}" class="z-10 mx-2 flex-shrink-0 w-40 flex flex-col items-center cursor-pointer hover:shadow-xl transition-all duration-500">
                            <img class="mb-2 h-64 w-full object-contain" src="{{asset('storage/characters/'. ($character->image ?? 'default.webp'))}}" alt="{{$character->name}}">
                            <p class="text-center">{{$character->name}}</p>
                        </a>
                    @endforeach
                </div>

                <!-- Botón Derecho -->
{{--                <button--}}
{{--                    @click="scrollX += 300; $refs.scroller.scrollTo({ left: scrollX, behavior: 'smooth' })"--}}
{{--                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow p-2 rounded-full"--}}
{{--                >--}}
{{--                    <i class="fas fa-chevron-right"></i>--}}
{{--                </button>--}}
            </div>
            <hr class="my-2">
        </div>
        <div>
            <h2 class="font-semibold text-xl mt-4 mb-1">{{__('comics_show.info')}}</h2>
            <p><b>{{__('comics_show.publisher')}}:</b> {{$comic->publisher->name}}</p>
            <p><b>{{__('comics_show.author')}}:</b> {{$comic->author}}</p>
            <p><b>{{__('comics_show.artist')}}:</b> {{$comic->artist}}</p>
            <p><b>{{__('comics_show.type')}}:</b> {{$comic->type}}</p>
            <p><b>{{__('comics_show.pages')}}:</b> {{$comic->pages}}</p>
        </div>
        @auth
            @if(auth()->user()->is_admin)
                <div class="flex gap-3 mt-6 justify-end">
                    <a href="{{route('session.editComic',$comic->id)}}" class="w-8 h-8 leading-8 text-center rounded-sm bg-indigo-700 text-white cursor-pointer hover:text-yellow-500 transition duration-300">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <button class="w-8 h-8 leading-8 text-center rounded-sm bg-red-600 text-white cursor-pointer hover:text-yellow-500 transition duration-300" onclick="deletebox.showModal()">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    <dialog id="deletebox" class="modal ">
                        <div class="modal-box bg-white rounded-sm">
                            <h3 class="text-lg font-bold">¿Borrar cómic?</h3>
                            <p class="py-4">Si borras este comic solo podras recuperarlo desde la base de datos.</p>
                            <form method="post" action="{{route('session.deleteComic',$comic->id)}}">
                                @csrf
                                <x-forms.button class="!bg-red-500 float-end">Borrar</x-forms.button>
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
<div class="container m-auto my-16 px-6 gap-8">
    <h1 class="text-3xl" id="comments">{{__('comics_show.comments')}}</h1>
    <form class="my-2" method="POST" action="{{route('comments.store',$comic->id)}}" class="flex">
        @csrf
        <div class="rating rating-xl my-4">
            <input type="radio" name="mark" value="1" class="mask mask-star-2 bg-yellow-400 text-yellow-400" aria-label="1 star" required />
            <input type="radio" name="mark" value="2" class="mask mask-star-2 bg-yellow-400 text-yellow-400" aria-label="2 star" />
            <input type="radio" name="mark" value="3" class="mask mask-star-2 bg-yellow-400 text-yellow-400" aria-label="3 star" />
            <input type="radio" name="mark" value="4" class="mask mask-star-2 bg-yellow-400 text-yellow-400" aria-label="4 star" />
            <input type="radio" name="mark" value="5" class="mask mask-star-2 bg-yellow-400 text-yellow-400" aria-label="5 star" />
        </div>
        <textarea name="comment" id="comment" class="w-full p-2 border rounded" cols="60" rows="3" placeholder="{{__('comics_show.comment_placeholder')}}" required></textarea>
        <button class="my-3 cursor-pointer px-4 py-2 bg-yellow-500 hover:bg-yellow-600 rounded text-white font-bold transition" type="submit">{{__('comics_show.send')}}</button>
    </form>
    @foreach($comic->ComicComments as $comment)
        <div class="my-4 rounded-sm ring-1 ring-gray-400 p-2">
            <div class="flex items-center justify-between gap-2 mb-2">
                <div class="flex">
                    <h2 class="font-semibold me-2">{{$comment->user->name}}</h2>
                    <span class="font-light">{{$comment->created_at->format('d/m/Y H:i:s')}}</span>
                </div>
                <div class="rating ms-6">
                    <div class="mask mask-star-2 bg-yellow-400" aria-label="1 star" {{$comment->mark == 1 ? "aria-current=true" : ''}}></div>
                    <div class="mask mask-star-2 bg-yellow-400" aria-label="2 star" {{$comment->mark == 2 ? "aria-current=true" : ''}}></div>
                    <div class="mask mask-star-2 bg-yellow-400" aria-label="3 star" {{$comment->mark == 3 ? "aria-current=true" : ''}}></div>
                    <div class="mask mask-star-2 bg-yellow-400" aria-label="4 star" {{$comment->mark == 4 ? "aria-current=true" : ''}}></div>
                    <div class="mask mask-star-2 bg-yellow-400" aria-label="5 star" {{$comment->mark == 5 ? "aria-current=true" : ''}}></div>
                </div>
            </div>
            <p class="">{{$comment->content}}</p>
        </div>
    @endforeach
    <hr class="my-3"/>
</div>
</x-layouts.app2>
