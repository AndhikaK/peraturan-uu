<div class="hidden lg:flex px-14 bg-white justify-between items-center border-b">
    <div>
        Omnilaw
    </div>
    <div>
        {{-- NAVIGATION MENU --}}
        <div class="inline-block">
            @foreach ($navs as $nav)
                <button class="p-3 py-5 font-medium hover:text-cyan-600 border-y-4 border-y-transparent {{ $active == $nav['title'] ? 'border-b-cyan-600 font-bold text-cyan-600' : '' }}">
                    {{ $nav['title'] }}
                </button>
            @endforeach
        </div>
        {{-- IF USER LOGGED IN --}}
        <div class="inline-block ml-5 pl-5 border-l border-l-slate-200">
            @auth
                <button class="p-1.5 px-7 text-red-500 rounded-full bg-white border border-red-600 hover:text-white hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-200">
                    Logout
                </button>
            @endauth
            {{-- IF USER NOT LOGGED IN --}}
            @guest
                <button class="p-1.5 px-7 text-slate-50 rounded-full bg-cyan-600 border border-cyan-600 hover:text-cyan-700 hover:bg-white focus:outline-none focus:ring focus:ring-cyan-200">
                    Login
                </button>
            @endguest
        </div>
    </div>
</div>

<div class="lg:hidden px-5 py-3 flex justify-between items-center bg-white">
    <div>
        Omnilaw
    </div>
    {{-- <a href="#my-modal-2">
        <button class="p-1 px-2 rounded-md bg-cyan-600 focus:outline-none focus:ring focus:ring-cyan-200" data-bs-toggle="modal" data-bs-target="#smallMenuModal">
        </button>
    </a> --}}
    <label for="my-modal-4" class="p-1 px-2 rounded-md bg-cyan-600 focus:outline-none focus:ring focus:ring-cyan-200">
        <i class='bx bx-menu-alt-left text-white text-2xl'></i>
    </label>

</div>
<!-- SMALL NAVIGATION MENU MODAL -->
<!-- The button to open modal -->

<!-- Put this part before </body> tag -->
<input type="checkbox" id="my-modal-4" class="modal-toggle">
<label for="my-modal-4" class="modal cursor-pointer">
    <label class="p-5 bg-white rounded-md modal-box relative">
        <div class="flex justify-between">
            <h2 class="text-lg w-10/12 font-bold">Menu</h2>
            <label for="my-modal-4" class="rounded-full text-red-500 hover:text-cyan-600">
                <i class='bx bx-x text-3xl'></i>
            </label>
        </div>
        <div class="flex flex-col items-start">
            @foreach ($navs as $nav)
                <button class="py-5 hover:font-bold hover:text-cyan-600 {{ $active == $nav['title'] ? 'font-bold text-cyan-600' : '' }}">
                    {{ $nav['title'] }}
                </button>
            @endforeach
        </div>
        <div class="py-5 flex gap-3 border-t border-t-slate-300">
            @guest
                <button class="p-1.5 px-7 text-slate-50 rounded-full bg-cyan-600 border border-cyan-600 hover:text-cyan-700 hover:bg-white focus:outline-none focus:ring focus:ring-cyan-200">
                    Login
                </button>
            @endguest
            @auth
                <button class="p-1.5 px-7 text-red-500 rounded-full bg-white border border-red-600 hover:text-white hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-200">
                    Logout
                </button>
            @endauth
        </div>
    </label>
</label>
