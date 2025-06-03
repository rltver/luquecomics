<div class="dropdown dropdown-end">
    <div tabindex="0" role="button" class="flex items-center cursor-pointer transition duration-300 leading-tight px-2 py-2 bg-indigo-800 rounded-sm shadow-sm hover:text-yellow-400">
        @php
            $locale = app()->getLocale();
            $flag = $locale === 'en' ? '🇬🇧' : '🇪🇸';

        @endphp
        <span class="text-xl">
            @if($locale == 'en')
                <img src="{{asset('storage/UK.png')}}" class="w-6" alt="">
            @else
                <img src="{{asset('storage/spain.png')}}" class="w-6" alt="">
            @endif
        </span>
    </div>
    <ul tabindex="0" class="dropdown-content  menu mt-2 w-32 bg-indigo-800 rounded-sm shadow-md">
        <li>
            <a href="{{ route('language.switch', 'es') }}" class="flex rounded items-center px-4 py-2 hover:bg-indigo-700">
                <img src="{{asset('storage/spain.png')}}" class="w-6" alt=""> <span class="ml-2">Español</span>
            </a>
        </li>
        <li>
            <a href="{{ route('language.switch', 'en') }}" class="flex rounded items-center px-4 py-2 hover:bg-indigo-700">
                <img src="{{asset('storage/uk.png')}}" class="w-6" alt=""> <span class="ml-2">English</span>
            </a>
        </li>
    </ul>
</div>
