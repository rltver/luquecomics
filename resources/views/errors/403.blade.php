404.blade.php<x-layouts.app2>
    <div class="text-center my-20">
        <h1 class="text-7xl font-bold text-yellow-500 mb-4">403</h1>
        <h2 class="text-2xl font-semibold mb-2">Forbidden</h2>
        <h2 class="text-2xl font-semibold mb-2">Acceso no autorizado</h2>
        <p class="mb-6">No tienes permisos para acceder a esta página.</p>
        <a href="{{ route('home') }}"
           class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xs transition">
            Volver al inicio
        </a>
    </div>
</x-layouts.app2>

{{--<x-layouts.app2>--}}
{{--    <div class="text-center my-20">--}}
{{--        <h1 class="text-7xl font-bold text-yellow-500 mb-4">404</h1>--}}
{{--        <h2 class="text-2xl font-semibold mb-2">{{__('errors.404_1')}}</h2>--}}
{{--        <p class="mb-6">{{__('errors.404_2')}}</p>--}}
{{--        <a href="{{ route('home') }}"--}}
{{--           class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xs transition">--}}
{{--            {{__('errors.go_back')}}--}}
{{--        </a>--}}
{{--    </div>--}}
{{--</x-layouts.app2>--}}
