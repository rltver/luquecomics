<x-layouts.app2>
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

        <form method="POST" id="verificationForm" action="{{ route('verification.send') }}">
            @csrf
            <x-forms.button id="submitBtn" class="m-auto w-full">
                <span id="btnText">{{__('verify.button')}}</span>
                <img src="{{asset('storage/spinner.webp')}}" width="30px" alt="..." id="btnLoading" class="hidden"/>
            </x-forms.button>
        </form>
    </div>


    @push('scripts')
        <script>
            document.getElementById('verificationForm').addEventListener('submit', function () {
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                document.getElementById('btnText').classList.toggle('hidden');
                document.getElementById('btnLoading').classList.toggle('hidden');
            });
        </script>
    @endpush
</x-layouts.app2>
