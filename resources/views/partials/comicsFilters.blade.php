<form action="{{route('comics.index',request()->all())}}" class="min-w-48">
    @csrf
    <h1 class="text-2xl mb-4 font-bold">Filtros</h1>

    <div x-data="{open:false}" class="mb-2">
        <h2 @click="open = !open" class="cursor-pointer text-lg flex flex-row items-center font-normal">
            {{__('comics_index.availability')}}
            @if(request('stock'))
                <div class="w-3 h-3 bg-red-500 rounded-full ml-4"></div>
            @endif
        </h2>
        <ul x-show="open" x-transition.duration.500ms class="mt-2 pl-4 font-light">
            <li class="flex gap-2">
                <label class="flex items-center gap-2 cursor-pointer" for="stock">
                    <input
                        type="checkbox"
                        name="stock"
                        id="stock"
                        value="yes"
                        {{request('stock')  == 'yes' ? 'checked' : ''}}
                    >
                    {{__('comics_index.stock')}}
                </label>

            </li>
        </ul>
    </div>
    <hr class="mb-2 text-yellow-400">

{{--    <div x-data="{open:false}" class="mb-2">--}}
{{--        <h2 @click="open = !open" class="cursor-pointer text-lg font-semibold flex flex-row items-center">--}}
{{--            Precio--}}
{{--            @if(request('priceRange'))--}}
{{--                <div class="w-3 h-3 bg-red-500 rounded-full ml-4"></div>--}}
{{--            @endif--}}
{{--        </h2>--}}
{{--        <div x-show="open" x-transition.duration.500ms class="mt-2 pl-4">--}}

{{--            --}}

{{--        </div>--}}
{{--    </div>--}}
{{--    <hr class="mb-2 text-yellow-400">--}}

    <div x-data="{open:false}" class="mb-2">
        <h2 @click="open = !open" class="cursor-pointer text-lg font-normal flex flex-row items-center">
            {{__('comics_index.publisher')}}
            @if(count(request('publishers', [])) > 0)
                <div class="w-3 h-3 bg-red-500 rounded-full ml-4"></div>
            @endif
        </h2>
        <ul x-show="open" x-transition.duration.500ms class="mt-2 pl-4">
            @foreach($publishers as $publisher)
                <li class="flex gap-2">
                    <label class="flex items-center gap-2 cursor-pointer font-light">
                        <input
                            type="checkbox"
                            name="publishers[]"
                            id="publisher_{{$publisher->id}}"
                            value="{{$publisher->id}}"
                            {{ in_array((string)$publisher->id, request()->input('publishers', [])) ? 'checked' : '' }}
                        >
                        {{$publisher->name}}

                    </label>

                </li>
            @endforeach
        </ul>
    </div>
    <hr class="mb-2 text-yellow-400">

    <div x-data="{open:false}" class="mb-2">
        <h2 @click="open = !open" class="cursor-pointer text-lg font-normal flex flex-row items-center">
            {{__('comics_index.characters')}}
            @if(count(request('characters', [])) > 0)
                <div class="w-3 h-3 bg-red-500 rounded-full ml-4"></div>
            @endif
        </h2>
        <ul x-show="open" x-transition.duration.500ms class="mt-2 pl-4 transition-all">
            @foreach($characters as $character)
                <li class="flex gap-2">
                    <label class="flex items-center gap-2 cursor-pointer font-light">
                        <input
                            class=""
                            type="checkbox"
                            name="characters[]"
                            id="character_{{$character->id}}"
                            value="{{$character->id}}"
                            {{ in_array((string)$character->id, request()->input('characters', [])) ? 'checked' : '' }}
                        >
                        {{$character->name}}
                    </label>
                </li>
            @endforeach
        </ul>
    </div>
    <hr class="mb-2 text-yellow-400">

    <div class="mt-6 flex flex-col space-y-2">
        <button type="submit" class="w-full cursor-pointer bg-blue-600 hover:bg-blue-800 text-amber-100 font-medium py-2 px-4 rounded transition">
            {{__('comics_index.filter')}}
        </button>
        <a href="{{ route('comics.index') }}" class="w-full text-center bg-amber-400 hover:bg-amber-500 text-blue-900 font-medium py-2 px-4 rounded transition">
            {{__('comics_index.clean_filters')}}
        </a>
    </div>
</form>
