<x-layouts.app2>

    <form method="POST" id="editForm" action="{{route('publishers.update',$publisher->id)}}">
        @csrf
        @method('put')

        <div class="flex flex-col my-10 items-center lg:mx-auto lg:px-10 max-w-[1200px]">
            <div class="grid grid-cols-1 gap-2 lg:gap-x-5 w-3/4 min-w-70 lg:w-full lg:grid-cols-2">
                <div>
                    <x-forms.label for="name">{{__('publisher_edit.name')}}</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$publisher->name}}" name="name" id="name"/>
                        <x-forms.error name="name" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="description">{{__('publisher_edit.description')}}</x-forms.label>
                    <div class="">
                        <textarea name="description" id="description" class="px-3 py-2 bg-white border focus:outline-none border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm w-full shadow-sm transition duration-300">{{$publisher->description}}</textarea>
                        <x-forms.error name="description" />
                    </div>
                </div>
                <div>
                    <x-forms.label for="creation_date">{{__('publisher_edit.first')}}</x-forms.label>
                    <div class="">
                        <x-forms.input value="{{$publisher->creation_date->format('Y-m-d')}}" type="date" name="creation_date" id="creation_date"/>
                        <x-forms.error name="creation_date" />
                    </div>
                </div>


            </div>
{{--            <x-forms.button class="mt-6 w-3/4 min-w-70 lg:w-full">{{__('publisher_edit.update')}}</x-forms.button>--}}
            <x-forms.button id="submitBtn" class="mt-6 w-3/4 min-w-70 lg:w-full">
                <span id="btnText">{{__('publisher_edit.update')}}</span>
                <img src="{{asset('storage/spinner.webp')}}" width="30px" alt="..." id="btnLoading" class="hidden"/>
            </x-forms.button>
        </div>
    </form>

    <div class="flex justify-center">
        <div class="mx-12 w-full sm:w-2/4 p-6 bg-white rounded-sm shadow">
            <h2 class="text-xl font-semibold mb-4">{{__('publisher_edit.thumbnail')}}</h2>

            @if ($publisher->logo)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">{{__('publisher_edit.current')}}:</p>
                    <img src="{{ asset('storage/publishers/' . $publisher->logo) }}" alt="Imagen de la editorial {{$publisher->name}}" class="w-48 h-auto border rounded">
                </div>
            @endif

            <form action="{{route('publishers.updateImage',$publisher->id)}}" id="edit2Form" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700">{{__('publisher_edit.new')}}:</label>
                    <div class="mt-2">
                        <div class="relative">
                            <input
                                type="file"
                                id="file-upload"
                                name="logo"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            >
                            <div class="flex items-center justify-between px-3 py-2 bg-white border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm shadow-sm hover:border-yellow-400 transition duration-300">
                                <span class="text-gray-700 truncate cursor-pointer" id="file-name">{{__('publisher_edit.file')}}</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-sm font-medium">{{__('publisher_edit.choose')}}</span>
                            </div>
                        </div>
                    </div>
                    <x-forms.error name="logo" />

                </div>

{{--                <x-forms.button type="submit" class="w-full">{{__('publisher_edit.update_thumbnail')}}</x-forms.button>--}}
                <x-forms.button id="submitBtn2" class="w-full">
                    <span id="btnText2">{{__('publisher_edit.update_thumbnail')}}</span>
                    <img src="{{asset('storage/spinner.webp')}}" width="30px" alt="..." id="btnLoading2" class="hidden"/>
                </x-forms.button>
            </form>
        </div>
    </div>

    <div class="w-full flex justify-center lg:px-10 max-w-[1200px] m-auto">
        <a href="{{route('publishers.show',$publisher->id)}}" class="mt-6 w-3/4 min-w-70 lg:w-full bg-indigo-600 rounded-sm text-center text-white font-bold py-2">{{__('publisher_edit.go_back')}}</a>
    </div>



    @push('scripts')
        <script>
            document.querySelector('#file-upload').addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || '{{__('publisher_edit.file')}}';
                document.querySelector('#file-name').textContent = fileName;
            });
        </script>
        <script>
            document.querySelector('#editForm').addEventListener('submit', function () {
                const btn = document.querySelector('#submitBtn');
                btn.disabled = true;
                document.querySelector('#btnText').classList.toggle('hidden');
                document.querySelector('#btnLoading').classList.toggle('hidden');
            });
        </script>
        <script>
            document.querySelector('#edit2Form').addEventListener('submit', function () {
                const btn = document.querySelector('#submitBtn2');
                btn.disabled = true;
                document.querySelector('#btnText2').classList.toggle('hidden');
                document.querySelector('#btnLoading2').classList.toggle('hidden');
            });
        </script>
    @endpush

</x-layouts.app2>
