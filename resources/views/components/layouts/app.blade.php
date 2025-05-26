<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <header class="w-full bg-slate-600 flex align-middle py-2 justify-between">
        <div class="flex">
            <i class="fa-solid toggle-button fa-bars fa-xl text-white flex my-auto px-3"></i>
            <p class="p-1 text-2xl font-bold text-white">LOGO</p>
        </div>
        <div class="flex align-middle text-white">
            <p class="my-auto">Github</p>
            <img src="./img/face.jpeg" alt="" class="rounded-full border my-auto w-8 h-8 mx-3">
            <p class="my-auto me-5">Rafa Luque</p>
        </div>
    </header>
    <div class="relative md:flex">
        <div class="menu z-10 absolute md:relative w-full h-full md:h-auto md:w-0 bg-slate-100 -left-full top-0 transition-all duration-1000">
            <ul class="md:w-80 h-full text-slate-700">
                <li class="py-3 px-3 border border-slate-300 flex justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div>
                        <i class="fa-solid fa-gauge-high"></i> Dashboard
                    </div>
                    <i class="fa-solid fa-chevron-right my-auto text-sm"></i>
                </li>
                <li class="py-3 px-3 border border-slate-300 flex justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div>
                        <i class="fa-brands fa-wpforms"></i> Forms
                    </div>
                    <i class="fa-solid fa-chevron-right my-auto text-sm"></i>
                </li>
                <li class="py-3 px-3 border border-slate-300 flex justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div>
                        <i class="fa-solid fa-ellipsis"></i> Buttons
                    </div>
                    <i class="fa-solid fa-chevron-right my-auto text-sm"></i>
                </li>
                <li class="py-3 px-3 border border-slate-300 flex justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div>
                        <i class="fa-solid fa-table-cells-large"></i> Tables
                    </div>
                    <i class="fa-solid fa-chevron-right my-auto text-sm"></i>
                </li>
                <li class="py-3 px-3 border border-slate-300 flex justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div>
                        <i class="fa-solid fa-gauge-high"></i> Ui Components
                    </div>
                    <i class="fa-solid fa-chevron-right my-auto text-sm"></i>
                </li>
                <li class="py-3 px-3 border border-slate-300 flex justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div>
                        <i class="fa-solid fa-square"></i> Modals
                    </div>
                    <i class="fa-solid fa-chevron-right my-auto text-sm"></i>
                </li>
                <li class="pages py-3 px-3 border border-slate-300 flex justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div>
                        <i class="fa-regular fa-file"></i> Pages
                    </div>
                    <i class="icon fa-solid fa-chevron-right my-auto text-sm !block"></i>
                    <i class="icon fa-solid fa-chevron-down my-auto text-sm !hidden"></i>
                </li>
                <li class="child hidden py-2 px-3 border border-slate-300 bg-slate-200 justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div class="px-4">
                        Login Page
                    </div>
                    <i class="fa-solid fa-chevron-right my-auto text-sm"></i>
                </li>
                <li class="child hidden py-2 px-3 border border-slate-300 bg-slate-200 justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div class="px-4">
                        Register Page
                    </div>
                    <i class="fa-solid fa-chevron-right my-auto text-sm"></i>
                </li>
                <li class="child hidden py-2 px-3 border border-slate-300 bg-slate-200 justify-between align-middle transition-all duration-700 hover:bg-slate-300 cursor-pointer">
                    <div class="px-4">
                        404 Page
                    </div>
                    <i class="fa-solid fa-chevron-right my-auto text-sm"></i>
                </li>
            </ul>

        </div>
        <main>
            {{$slot}}
        </main>
    </div>

    @stack('scripts')
    <script>
        const toggleBtn = document.querySelector(".toggle-button");
        const menu = document.querySelector(".menu");
        toggleBtn.addEventListener("click", () => {
            menu.classList.toggle("-left-full");
            menu.classList.toggle("left-0");
            // menu.classList.toggle("md:hidden");
            menu.classList.toggle("md:w-0");
            menu.classList.toggle("md:w-80");
        });

        const toggleBtn2 = document.querySelector(".pages");
        const menuItems = document.querySelectorAll(".child");
        const icons = document.querySelectorAll(".icon");
        toggleBtn2.addEventListener("click", () => {
            menuItems.forEach(menu => {
                menu.classList.toggle("hidden");
                menu.classList.toggle("flex");
            });
            icons.forEach(icon => {
                icon.classList.toggle("!hidden");
                icon.classList.toggle("!block");
            });
        });

    </script>
</body>
</html>
