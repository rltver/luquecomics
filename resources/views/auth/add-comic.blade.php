<x-layouts.account>
    <x-slot:header>{{__('add_comic.add_comic')}}</x-slot:header>
    <x-slot:slot>
        <form method="POST" action="{{route('session.storeComic')}}" enctype="multipart/form-data">
        @csrf

            <div class="flex flex-col my-10 items-center lg:items-start max-w-[1200px]">
                <div class="grid grid-cols-1 gap-2 lg:gap-x-5 w-3/4 min-w-70 lg:w-full lg:grid-cols-2">
                    <div>
                        <x-forms.label for="title">{{__('add_comic.title')}}</x-forms.label>
                        <div class="">
                            <x-forms.input value="{{old('title')}}" name="title" id="title"/>
                            <x-forms.error name="title" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="author">{{__('add_comic.author')}}</x-forms.label>
                        <div class="">
                            <x-forms.input value="{{old('author')}}" name="author" id="author"/>
                            <x-forms.error name="author" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="artist">{{__('add_comic.artist')}}</x-forms.label>
                        <div class="">
                            <x-forms.input value="{{old('artist')}}" name="artist" id="artist"/>
                            <x-forms.error name="artist" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="description">{{__('add_comic.description')}}</x-forms.label>
                        <div class="">
                            <textarea name="description" id="description" class="px-3 py-2 bg-white border focus:outline-none border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm w-full shadow-sm transition duration-300">{{old('description')}}</textarea>
                            <x-forms.error name="description" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="price">{{__('add_comic.price')}}</x-forms.label>
                        <div class="">
                            <x-forms.input type="number" value="{{old('price')}}" name="price" id="price"/>
                            <x-forms.error name="price" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="stock">Stock</x-forms.label>
                        <div class="">
                            <x-forms.input value="{{old('stock')}}" type="number" name="stock" id="stock"/>
                            <x-forms.error name="stock" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="thumbnail_image">{{__('add_comic.cover')}}</x-forms.label>
                        <div class="">
                            <div class="">
                                <div class="relative">
                                    <input
                                        type="file"
                                        id="file-upload"
                                        name="thumbnail_image"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    >
                                    <div class="flex items-center justify-between px-3 py-2 bg-white border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm shadow-sm hover:border-yellow-400 transition duration-300">
                                        <span class="text-gray-700 truncate cursor-pointer" id="file-name">{{__('add_comic.file')}}</span>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-sm font-medium">{{__('add_comic.choose')}}</span>
                                    </div>
                                </div>
                            </div>
                            <x-forms.error name="thumbnail_image" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="publisher_id">{{__('add_comic.publisher')}}</x-forms.label>
                        <select name="publisher_id" id="publisher_id" class="w-full px-2 py-2 text-gray-700 bg-white border border-gray-200 rounded-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                            <option value="" disabled selected>{{__('add_comic.select')}}</option>
                            @foreach($publishers as $publisher)
                                <option value="{{$publisher->id}}" {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>{{$publisher->name}}</option>
                            @endforeach
                        </select>
                        <x-forms.error name="publisher_id" />
                    </div>
                    <div>
                                                <x-forms.label>{{__('add_comic.characters')}}</x-forms.label>
                                                <div class=" block dropdown dropdown-end">
                                                    <div tabindex="0" role="button" class="cursor-pointer px-3 py-2 bg-white border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm shadow-sm transition duration-300">{{__('add_comic.select_characters')}}</div>
                                                    <ul tabindex="0" class="dropdown-content menu text-black bg-white shadow-xl rounded-sm rounded-box w-full z-50 mt-2 border border-gray-200">
                                                        @foreach($characters as $character)
                                                            <li>
                                                                <label  class="hover:bg-gray-100/75 transition-all duration-300 flex justify-between">
                                                                    <label for="character-{{$character->id}}">{{$character->name}}</label>
                                                                    <input
                                                                        type="checkbox"
                                                                        name="characters[]"
                                                                        id="character-{{$character->id}}"
                                                                        value="{{$character->id}}"
                                                                    {{ (is_array(old('characters')) && in_array($character->id, old('characters'))) ? 'checked' : '' }}
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                    </div>
                    <div>
                        <x-forms.label for="type">{{__('add_comic.type')}}</x-forms.label>
                        <select name="type" id="type" class="w-full px-2 py-2 text-gray-700 bg-white border border-gray-200 rounded-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                            <option value="" disabled selected>{{__('add_comic.select')}}</option>
                            <option value="Trade paperback" {{ old('type') === 'Trade paperback' ? 'selected' : '' }}>Trade paperback</option>
                            <option value="Omnibus" {{ old('type') === 'Omnibus' ? 'selected' : '' }}>Omnibus</option>
                            <option value="Hard cover" {{ old('type') === 'Hard cover' ? 'selected' : '' }}>Hard cover</option>
                        </select>
                        <x-forms.error name="type" />
                    </div>
                    <div>
                        <x-forms.label for="pages">{{__('add_comic.pages')}}</x-forms.label>
                        <div class="">
                            <x-forms.input value="{{old('pages')}}" type="number" name="pages" id="pages"/>
                            <x-forms.error name="pages" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="weight">{{__('add_comic.weight')}} (gr)</x-forms.label>
                        <div class="">
                            <x-forms.input value="{{old('weight')}}" type="number" name="weight" id="weight"/>
                            <x-forms.error name="weight" />
                        </div>
                    </div>


                </div>
                <x-forms.button class="mt-6 w-3/4 min-w-70 lg:w-full">{{__('add_comic.upload')}}</x-forms.button>
            </div>
        </form>

        @push('scripts')
            <script>
                document.getElementById('file-upload').addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name || '{{__('add_comic.file')}}';
                    document.getElementById('file-name').textContent = fileName;
                });
            </script>
        @endpush
    </x-slot:slot>
</x-layouts.account>
