<form action="{{route('characters.index',request()->all())}}" class="min-w-48">
    @csrf
    <h1 class="text-2xl mb-4 font-bold">Filtros</h1>

    <div class="mb-4">
        <label class="text-lg font-normal flex flex-row items-center">Década de aparición</label>
        <select name="decade" class="w-full border rounded p-1 px-2 mt-2">
            <option value="">Todas</option>
            @foreach($decades as $decade)
                <option value="{{ $decade }}" {{ request('decade') == $decade ? 'selected' : '' }}>
                    {{ $decade }}s
                </option>
            @endforeach
        </select>
    </div>
    <hr class="mb-2 text-yellow-400">

    <div x-data="{open:false}" class="mb-2">
        <h2 @click="open = !open" class="cursor-pointer text-lg font-normal flex flex-row items-center">
            {{__('comics_index.publisher')}}
            @if(request('publishers'))
                <div class="w-3 h-3 bg-red-500 rounded-full ml-4"></div>
            @endif
        </h2>
        <ul x-show="open" x-transition.duration.500ms class="mt-2 pl-4">
            @foreach($publishers as $publisher)
                <li class="flex gap-2">
                    <label class="flex items-center gap-2 cursor-pointer font-light">
                        <input
                            type="radio"
                            name="publishers"
                            id="publisher_{{$publisher->id}}"
                            value="{{$publisher->id}}"
                            {{(request('publishers') == $publisher->id) ? 'checked' : '' }}
                        >
                        {{$publisher->name}}

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
        <a href="{{ route('characters.index') }}" class="w-full text-center bg-amber-400 hover:bg-amber-500 text-blue-900 font-medium py-2 px-4 rounded transition">
            {{__('comics_index.clean_filters')}}
        </a>
    </div>
</form>
