<x-layouts.account>
    <x-slot:header>{{__('publisher_add.add_publisher')}}</x-slot:header>
    <x-slot:slot>
        <form method="POST" id="addForm" action="{{route('publishers.store')}}" enctype="multipart/form-data">
            @csrf

            <div class="flex flex-col my-10 items-center lg:items-start max-w-[1200px]">
                <div class="grid grid-cols-1 gap-2 lg:gap-x-5 w-3/4 min-w-70 lg:w-full lg:grid-cols-2">
                    <div>
                        <x-forms.label for="name">{{__('publisher_add.name')}}</x-forms.label>
                        <div class="">
                            <x-forms.input value="{{old('name')}}" name="name" id="name"/>
                            <x-forms.error name="name" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="description">{{__('publisher_add.description')}}</x-forms.label>
                        <div class="">
                            <textarea name="description" id="description" class="px-3 py-2 bg-white border focus:outline-none border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm w-full shadow-sm transition duration-300">{{old('description')}}</textarea>
                            <x-forms.error name="description" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="logo">{{__('publisher_add.cover')}}</x-forms.label>
                        <div class="">
                            <div class="">
                                <div class="relative">
                                    <input
                                        type="file"
                                        id="file-upload"
                                        name="logo"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    >
                                    <div class="flex items-center justify-between px-3 py-2 bg-white border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent rounded-sm shadow-sm hover:border-yellow-400 transition duration-300">
                                        <span class="text-gray-700 truncate cursor-pointer" id="file-name">{{__('publisher_add.file')}}</span>
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-sm font-medium">{{__('publisher_add.choose')}}</span>
                                    </div>
                                </div>
                            </div>
                            <x-forms.error name="logo" />
                        </div>
                    </div>
                    <div>
                        <x-forms.label for="creation_date">{{__('publisher_add.first')}}</x-forms.label>
                        <div class="">
                            <x-forms.input value="{{old('creation_date')}}" type="date" name="creation_date" id="creation_date"/>
                            <x-forms.error name="creation_date" />
                        </div>
                    </div>


                </div>
{{--                <x-forms.button class="mt-6 w-3/4 min-w-70 lg:w-full">{{__('publisher_add.upload')}}</x-forms.button>--}}
                <x-forms.button id="submitBtn" class="mt-6 w-3/4 min-w-70 lg:w-full">
                    <span id="btnText">{{__('publisher_add.upload')}}</span>
                    <img src="{{asset('storage/spinner.webp')}}" width="30px" alt="..." id="btnLoading" class="hidden"/>
                </x-forms.button>
            </div>
        </form>

        @push('scripts')
            <script>
                document.querySelector('#file-upload').addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name || '{{__('publisher_add.file')}}';
                    document.querySelector('#file-name').textContent = fileName;
                });
            </script>
            <script>
                document.querySelector('#addForm').addEventListener('submit', function () {
                    const btn = document.querySelector('#submitBtn');
                    btn.disabled = true;
                    document.querySelector('#btnText').classList.toggle('hidden');
                    document.querySelector('#btnLoading').classList.toggle('hidden');
                });
            </script>
        @endpush
    </x-slot:slot>
</x-layouts.account>
