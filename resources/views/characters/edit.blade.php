<x-layouts.app2>

    <form method="POST" action="{{route('characters.update',$character->id)}}">
        @csrf
        @method('put')

        <div class="flex flex-col my-10 items-center lg:mx-auto lg:px-10 max-w-[1200px]">
            <div class="grid grid-cols-1 gap-2 lg:gap-x-5 w-3/4 min-w-70 lg:w-full lg:grid-cols-2">
                <div>
                    <x-forms.label for="name">{{__('character_edit.name')}}</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$character->name}}" name="name" id="name"/>
                        <x-forms.error name="name" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="description">{{__('character_edit.description')}}</x-forms.label>
                    <div class="">
                        <textarea name="description" id="description" class="px-3 py-2 bg-white border focus:outline-none border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm w-full shadow-sm transition duration-300">{{$character->description}}</textarea>
                        <x-forms.error name="description" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="publisher_id">{{__('character_edit.publisher')}}</x-forms.label>
                    <select name="publisher_id" id="publisher_id" class="w-full px-2 py-2 text-gray-700 bg-white border border-gray-200 rounded-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200">
                        <option value="" disabled selected>{{__('character_edit.select')}}</option>
                        @foreach($publishers as $publisher)
                            <option value="{{$publisher->id}}" {{ $character->publisher_id == $publisher->id ? 'selected' : '' }}>{{$publisher->name}}</option>
                        @endforeach
                    </select>
                    <x-forms.error name="publisher_id" />
                </div>
                <div>
                    <x-forms.label for="first_appearance">{{__('character_edit.first')}}</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$character->first_appearance->format('Y-m-d')}}" type="date" name="first_appearance" id="first_appearance"/>
                        <x-forms.error name="first_appearance" />
                    </div>
                </div>


            </div>
            <x-forms.button class="mt-6 w-3/4 min-w-70 lg:w-full">{{__('character_edit.update')}}</x-forms.button>
        </div>
    </form>

    <div class="flex justify-center">
        <div class="mx-12 w-full sm:w-2/4 p-6 bg-white rounded-sm shadow">
            <h2 class="text-xl font-semibold mb-4">{{__('character_edit.thumbnail')}}</h2>

            @if ($character->image)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">{{__('character_edit.current')}}:</p>
                    <img src="{{ asset('storage/characters/' . $character->image) }}" alt="Imagen del personaje {{$character->name}}" class="w-48 h-auto border rounded">
                </div>
            @endif

            <form action="{{route('characters.updateImage',$character->id)}}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">{{__('character_edit.new')}}:</label>
                    <div class="mt-2">
                        <div class="relative">
                            <input
                                type="file"
                                id="file-upload"
                                name="image"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            >
                            <div class="flex items-center justify-between px-3 py-2 bg-white border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm shadow-sm hover:border-yellow-400 transition duration-300">
                                <span class="text-gray-700 truncate cursor-pointer" id="file-name">{{__('character_edit.file')}}</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-sm font-medium">{{__('character_edit.choose')}}</span>
                            </div>
                        </div>
                    </div>
                    <x-forms.error name="image" />

                </div>

                <x-forms.button type="submit" class="w-full">{{__('character_edit.update_thumbnail')}}</x-forms.button>
            </form>
        </div>
    </div>

    <div class="w-full flex justify-center lg:px-10 max-w-[1200px] m-auto">
        <a href="{{route('characters.show',$character->id)}}" class="mt-6 w-3/4 min-w-70 lg:w-full bg-indigo-600 rounded-sm text-center text-white font-bold py-2">{{__('character_edit.go_back')}}</a>
    </div>



    @push('scripts')
        <script>
            document.getElementById('file-upload').addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || '{{__('character_edit.file')}}';
                document.getElementById('file-name').textContent = fileName;
            });
        </script>
    @endpush

</x-layouts.app2>
