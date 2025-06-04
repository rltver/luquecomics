<x-layouts.app2>

    <form method="post" action="{{route('session.updateComic',$comic->id)}}">
        @csrf
        @method('put')

        <div class="flex flex-col my-10 items-center lg:mx-auto lg:px-10 max-w-[1200px]">
            <div class="grid grid-cols-1 gap-2 lg:gap-x-5 w-3/4 min-w-70 lg:w-full lg:grid-cols-2">
                <div>
                    <x-forms.label for="title">{{__('comic_edit.title')}}</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$comic->title}}" name="title" id="title"/>
                        <x-forms.error name="title" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="author">{{__('comic_edit.author')}}</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$comic->author}}" name="author" id="author"/>
                        <x-forms.error name="author" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="artist">{{__('comic_edit.artist')}}</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$comic->artist}}" name="artist" id="artist"/>
                        <x-forms.error name="artist" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="description">{{__('comic_edit.description')}}</x-forms.label>
                    <div class="">
                        <textarea name="description" id="description" class="px-3 py-2 bg-white border focus:outline-none border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm w-full shadow-sm transition duration-300">{{$comic->description}}</textarea>
                        <x-forms.error name="description" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="price">{{__('comic_edit.price')}}</x-forms.label>
                    <div class="">
                        <x-forms.input type="number" value="{{$comic->price}}" name="price" id="price"/>
                        <x-forms.error name="price" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="stock">Stock</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$comic->stock}}" type="number" name="stock" id="stock"/>
                        <x-forms.error name="stock" />
                    </div>
                </div>

                <div>
                    <x-forms.label for="publisher_id">{{__('comic_edit.publisher')}}</x-forms.label>
                    <select name="publisher_id" id="publisher_id" class="w-full px-2 py-2 text-gray-700 bg-white border border-gray-200 rounded-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="" disabled selected>{{__('comic_edit.select')}}</option>
                        @foreach($publishers as $publisher)
                            <option value="{{$publisher->id}}" {{ $comic->publisher_id == $publisher->id ? 'selected' : '' }}>{{$publisher->name}}</option>
                        @endforeach
                    </select>
                    <x-forms.error name="publisher_id" />
                </div>
                <div>
                    <x-forms.label>{{__('comic_edit.characters')}}</x-forms.label>
                    <div class=" block dropdown dropdown-end">
                        <div tabindex="0" role="button" class="cursor-pointer px-3 py-2 bg-white border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm shadow-sm transition duration-300">{{__('comic_edit.select_characters')}}</div>
                        <ul tabindex="0" class="dropdown-content menu text-black bg-white shadow-xl rounded-sm rounded-box w-full z-50 mt-2 border border-gray-200">
                            @php
                            $charactersIds = [];
                            @endphp
                            @foreach ($comic->characters as $character)
                                @php array_push($charactersIds,$character->id) @endphp
                            @endforeach
                            @foreach($characters as $character)
                                <li>
                                    <label  class="hover:bg-gray-100/75 transition-all duration-300 flex justify-between">
                                        <label for="character-{{$character->id}}">{{$character->name}}</label>
                                        <input
                                            type="checkbox"
                                            name="characters[]"
                                            id="character-{{$character->id}}"
                                            value="{{$character->id}}"
                                        {{ (is_array($charactersIds) && in_array($character->id, $charactersIds)) ? 'checked' : '' }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div>
                    <x-forms.label for="type">{{__('comic_edit.type')}}</x-forms.label>
                    <select name="type" id="type" class="w-full px-2 py-2 text-gray-700 bg-white border border-gray-200 rounded-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="" disabled selected>{{__('add_comic.select')}}</option>
                        <option value="Trade paperback" {{ $comic->type === 'Trade paperback' ? 'selected' : '' }}>Trade paperback</option>
                        <option value="Omnibus" {{ $comic->type === 'Omnibus' ? 'selected' : '' }}>Omnibus</option>
                        <option value="Hard cover" {{ $comic->type === 'Hard cover' ? 'selected' : '' }}>Hard cover</option>
                    </select>
                    <x-forms.error name="type" />
                </div>
                <div>
                    <x-forms.label for="pages">{{__('comic_edit.pages')}}</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$comic->pages}}" type="number" name="pages" id="pages"/>
                        <x-forms.error name="pages" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="weight">{{__('comic_edit.weight')}} (gr)</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$comic->weight}}" type="number" name="weight" id="weight"/>
                        <x-forms.error name="weight" />
                    </div>
                </div>


            </div>
            <x-forms.button class="mt-6 w-3/4 min-w-70 lg:w-full">{{__('comic_edit.update')}}</x-forms.button>
        </div>
    </form>

    <div class="flex justify-center">
        <div class="mx-12 w-full sm:w-2/4 p-6 bg-white rounded-sm shadow">
            <h2 class="text-xl font-semibold mb-4">{{__('comic_edit.thumbnail')}}</h2>

            @if ($comic->thumbnail_image)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">{{__('comic_edit.current')}}:</p>
                    <img src="{{ asset('storage/comics/' . $comic->thumbnail_image) }}" alt="Portada del cómic" class="w-48 h-auto border rounded">
                </div>
            @endif

            <form action="{{route('session.updateThumbnail',$comic->id)}}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="thumbnail_image" class="block text-sm font-medium text-gray-700">{{__('comic_edit.new')}}:</label>
                    <div class="mt-2">
                        <div class="relative">
                            <input
                                type="file"
                                id="file-upload"
                                name="thumbnail_image"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            >
                            <div class="flex items-center justify-between px-3 py-2 bg-white border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm shadow-sm hover:border-yellow-400 transition duration-300">
                                <span class="text-gray-700 truncate cursor-pointer" id="file-name">{{__('comic_edit.file')}}</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-sm font-medium">{{__('comic_edit.choose')}}</span>
                            </div>
                        </div>
                    </div>
                    <x-forms.error name="thumbnail_image" />

                </div>

                <x-forms.button type="submit" class="w-full">{{__('comic_edit.update_thumbnail')}}</x-forms.button>
            </form>
        </div>
    </div>

    <div class="w-full flex justify-center lg:px-10 max-w-[1200px] m-auto">
        <a href="{{route('comics.show',$comic->id)}}" class="mt-6 w-3/4 min-w-70 lg:w-full bg-indigo-600 rounded-sm text-center text-white font-bold py-2">{{__('comic_edit.go_back')}}</a>
    </div>



@push('scripts')
        <script>
            document.getElementById('file-upload').addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || '{{__('comic_edit.file')}}';
                document.getElementById('file-name').textContent = fileName;
            });
        </script>
    @endpush

</x-layouts.app2>
