<x-layouts.app2>
    <form method="POST" action="{{route('session.store')}}" id="loginForm">
@csrf
<div class="flex flex-col items-center my-20">
        <div class="flex flex-col gap-2 w-1/2 min-w-50 lg:w-80">
            <div>
                <x-forms.label for="email">Email</x-forms.label>
                <div class="mt-2">
                    <x-forms.input name="email" id="email" value="{{old('email')}}" type="email" />
                    <x-forms.error name="email" />
                </div>
            </div>
            <div>
                <x-forms.label for="password">
                    {{__('login.password')}}
                </x-forms.label>
                <div class="mt-2">
                    <x-forms.input name="password" id="password" type="password" />
                    <x-forms.error name="password" />
                </div>
            </div>
            <x-forms.button id="submitBtn" class="mt-2">
                <span id="btnText">{{__('login.login')}}</span>
                <img src="{{asset('storage/spinner.webp')}}" width="30px" alt="..." id="btnLoading" class="hidden"/>
            </x-forms.button>
            <a href="{{url()->previous()}}" class="py-2 bg-indigo-600 hover:bg-indigo-800 rounded-xs font-semibold text-center text-white transition-all duration-300">{{__('login.cancel')}}</a>
                <a class="text-center m-auto mt-3 cursor-pointer hover:underline text-indigo-600 transition-all duration-300 w-fit" href="{{route('register.create')}}">{{__('login.go_to_register')}}</a>
        </div>
</div>
</form>


@push('scripts')
        <script>
            document.getElementById('loginForm').addEventListener('submit', function () {
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                document.getElementById('btnText').classList.toggle('hidden');
                document.getElementById('btnLoading').classList.toggle('hidden');
            });
        </script>
@endpush

</x-layouts.app2>
