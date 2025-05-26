<x-layouts.account>
    <x-slot:header>{{__('account_info.account_info')}}</x-slot:header>
    <x-slot:slot>
        <div class="flex flex-col mt-10 mb-96 items-center lg:items-start">
            <div class="flex flex-col gap-2 w-3/4 min-w-70 lg:w-full lg:max-w-[600px]">
                <div class="">
                    <x-forms.label for="name">{{__('account_info.name')}}</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{auth()->user()->name}}" name="name" id="name" class="!bg-gray-200 !text-gray-400 !cursor-not-allowed" disabled />
                        <x-forms.error name="name" />
                    </div>
                </div>
                <div class="">
                    <x-forms.label for="surname">{{__('account_info.surname')}}</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{auth()->user()->surname}}" name="surname" id="surname" class="!bg-gray-200 !text-gray-400 !cursor-not-allowed" disabled />
                        <x-forms.error name="surname" />
                    </div>
                </div>
                <div class="">
                    <x-forms.label for="email">Email</x-forms.label>
                    <div class="mt-2">
                        <x-forms.input value="{{auth()->user()->email}}" name="email" id="email" type="email" class="!bg-gray-200 !text-gray-400 !cursor-not-allowed" disabled />
                        <x-forms.error name="email" />
                    </div>
                </div>
                <div>
                    @if(!auth()->user()->hasVerifiedEmail())
                        <p class="text-center text-red-500 font-semibold">{{__('account_info.verify_notice')}}</p>
                        <form method="post" action="{{route('verification.send')}}">
                            @csrf
                            <x-forms.button class="mt-2 !bg-indigo-500 w-full">{{__('account_info.send_email')}}</x-forms.button>
                        </form>
                    @endif
                </div>
{{--                <div class="">--}}
{{--                    <x-forms.label for="password">Contraseña</x-forms.label>--}}
{{--                    <div class="mt-2">--}}
{{--                        <x-forms.input value="{{old('password')}}" name="password" id="password" type="password" />--}}
{{--                        <x-forms.error name="password" />--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="">--}}
{{--                    <x-forms.label for="password_confirmation">Confirmar contraseña</x-forms.label>--}}
{{--                    <div class="mt-2">--}}
{{--                        <x-forms.input value="{{old('password_confirmation')}}" name="password_confirmation" id="password_confirmation" type="password" />--}}
{{--                        <x-forms.error name="password_confirmation" />--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <x-forms.button class="mt-2">Actualizar datos</x-forms.button>--}}
            </div>
        </div>
    </x-slot:slot>
</x-layouts.account>
