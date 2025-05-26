<x-layouts.app2>
    @session('success')
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition
        class="toast toast-top toast-center z-50 rounded-sm overflow-hidden"
    >
        <div class="alert alert-success bg-indigo-600 text-white !z-50">
            <span>{{$value}}</span>
        </div>
    </div>
    @endsession
    <div class="max-w-lg mx-auto mt-16 mb-96 p-6 bg-white shadow-md rounded-md text-center">
        <h1 class="text-2xl font-bold mb-4">{{__('verify.title')}}</h1>

        @if (session('message'))
            <div class="mb-4 text-green-600 font-medium">
                {{ session('message') }}
            </div>
        @endif

        <p class="mb-2 text-gray-700">
            {{__('verify.text')}}
        </p>
        <p class="mb-4">{{__('verify.subtext')}}</p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-forms.button type="submit"
                    class="m-auto">
                {{__('verify.button')}}
            </x-forms.button>
        </form>
    </div>
</x-layouts.app2>
