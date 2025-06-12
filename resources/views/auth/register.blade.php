<x-layouts.app2>
    <form method="POST" id="registerForm" action="{{route('register.store')}}">
        @csrf
        <div class="flex flex-col items-center my-20">
            <div class="flex flex-col gap-2 w-1/2 min-w-50 lg:w-80">
                    <div class="">
                        <x-forms.label for="name">{{__('login.name')}}</x-forms.label>
                        <div class="mt-2">
                            <x-forms.input value="{{old('name')}}" name="name" id="name" />
                            <x-forms.error name="name" />
                        </div>
                    </div>
                    <div class="">
                        <x-forms.label for="surname">{{__('login.surname')}}</x-forms.label>
                        <div class="mt-2">
                            <x-forms.input value="{{old('surname')}}" name="surname" id="surname" />
                            <x-forms.error name="surname" />
                        </div>
                    </div>
                    <div class="">
                        <x-forms.label for="email">Email</x-forms.label>
                        <div class="mt-2">
                            <x-forms.input value="{{old('email')}}" name="email" id="email" type="email" />
                            <x-forms.error name="email" />
                        </div>
                    </div>
                    <div class="">
                        <x-forms.label for="password">{{__('login.password')}}</x-forms.label>
                        <div class="mt-2">
                            <x-forms.input value="{{old('password')}}" name="password" id="password" type="password" />
                            <x-forms.error name="password" />
                        </div>
                    </div>
                    <div class="">
                        <x-forms.label for="password_confirmation">{{__('login.confirm')}}</x-forms.label>
                        <div class="mt-2">
                            <x-forms.input value="{{old('password_confirmation')}}" name="password_confirmation" id="password_confirmation" type="password" />
                            <x-forms.error name="password_confirmation" />
                        </div>
                    </div>
                <x-forms.button id="submitBtn" class="mt-2">
                    <span id="btnText">{{__('login.register')}}</span>
                    <img src="{{asset('storage/spinner.webp')}}" width="30px" alt="..." id="btnLoading" class="hidden"/>
                </x-forms.button>
                <a href="/" class="py-2 bg-indigo-600 hover:bg-indigo-800 rounded-xs font-semibold text-center text-white">{{__('login.cancel')}}</a>
            </div>
        </div>
    </form>


    @push('scripts')
        <script>
            document.querySelector('#registerForm').addEventListener('submit', function () {
                const btn = document.querySelector('#submitBtn');
                btn.disabled = true;
                document.querySelector('#btnText').classList.toggle('hidden');
                document.querySelector('#btnLoading').classList.toggle('hidden');
            });
        </script>
    @endpush

</x-layouts.app2>
