<x-layouts.app2>
    <div class="flex flex-col lg:flex-row mt-16">
        <div class="mx-6 flex flex-col gap-4 min-w-60">
            <a
                href="{{route('session.orders')}}"
                class="{{request()->routeIs('session.orders') ? 'text-indigo-600' : 'hover:text-indigo-600'}} transition duration-300"
            >
                {{__('account_layout.orders')}}
            </a>
            <hr class="text-yellow-500">
            <a
                href="{{route('session.accountInfo')}}"
                class="{{request()->routeIs('session.accountInfo') ? 'text-indigo-600' : 'hover:text-indigo-600'}} transition duration-300"
            >
                {{__('account_layout.info')}}
            </a>
            <hr class="text-yellow-500">
            @if(auth()->user()->is_admin)
                <a
                    href="{{route('session.addComic')}}"
                    class="{{request()->routeIs('session.addComic') ? 'text-indigo-600' : 'hover:text-indigo-600'}} transition duration-300"
                >
                    {{__('account_layout.add_comic')}}
                </a>
                <hr class="text-yellow-500">
                <a
                    href="{{route('characters.create')}}"
                    class="{{request()->routeIs('characters.create') ? 'text-indigo-600' : 'hover:text-indigo-600'}} transition duration-300"
                >
                    {{__('account_layout.add_character')}}
                </a>
                <hr class="text-yellow-500">
                <a
                    href="{{route('publishers.create')}}"
                    class="{{request()->routeIs('publishers.create') ? 'text-indigo-600' : 'hover:text-indigo-600'}} transition duration-300"
                >
                    {{__('account_layout.add_publisher')}}
                </a>
                <hr class="text-yellow-500">
            @endif
            <form method="post" action="{{route('session.destroy')}}" class="w-full">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 cursor-pointer transition-all duration-300">{{__('account_layout.logout')}}</button>
            </form>
        </div>
        <div class="mx-6 mt-14 lg:mt-0 lg:w-full">
            <h1 class="text-2xl font-semibold mb-8">{{$header}}</h1>

            <div>{{$slot}}</div>
        </div>
    </div>
</x-layouts.app2>
