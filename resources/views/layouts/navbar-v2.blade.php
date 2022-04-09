<div>
    <div class="px-3 py-3 lg:px-8 lg:py-3 flex flex-row justify-between"
        style="background-image: url('{{ asset('assets/img/pattern.svg') }}')">
        <a href="{{ route('index') }}">
            <div class="flex items-center">
                <img src="{{ asset('assets/img/logo-icon.png') }}" class="mr-3 h-10" alt="app-logo">
                <div>
                    <div class="text-white font-bold text-xl">Omnilaw</div>
                    <div class="text-white text-sm">Universitas Lampung</div>
                </div>
            </div>
        </a>
        {{-- LOGIN ICON FOR AUTHENTICATION --}}
        @auth
            <div class="dropdown">
                <button class="p-2.5 text-white dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ $user->name }}
                </button>
                <nav class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item px-2 py-2 hover:bg-sky-50  ">Log out</button>
                    </form>
                </nav>
            </div>
        @endauth
        @guest
            <a href="{{ route('login') }}" class="p-2.5 text-white">Login</a>
        @endguest
    </div>
    {{-- RENDER NAVBAR FOR LARGE SCREEN --}}
    @isset($navs)
        <div class="px-3 bg-white hidden lg:flex lg:flex-row lg:px-8 drop-shadow">
            @foreach ($navs as $nav)
                <li
                    class="p-3 text-sm list-none hover:bg-sky-700 hover:text-white {{ $active == $nav['title'] ? 'bg-sky-700 text-white' : '' }}">
                    <a href="{{ $nav['route'] }}">{{ $nav['title'] }}</a>
                </li>
            @endforeach
            </li>
        </div>
    @endisset

    {{-- DROPDOWN MENU FOR SMALL VIEW --}}
    <div class="px-3 py-2 flex flex-row justify-betwen lg:hidden bg-blue-900">
        <div class="dropdown">
            <button
                class="p-1 px-2 text-white rounded-md hover:bg-sky-600 active:bg-sky-700 focus:outline-none focus:ring focus:ring-sky-300"
                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            <nav class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @isset($navs)
                    @foreach ($navs as $nav)
                        <button class="dropdown-item">
                            <a href="{{ $nav['route'] }}">{{ $nav['title'] }}</a>
                        </button>
                    @endforeach
                @endisset
                {{-- <button class="dropdown-item">
                    <a href="{{ route('index') }}">Beranda</a>
                </button>
                <button class="dropdown-item">
                    <a href="{{ route('archive.index') }}">Arsip</a>
                </button>
                <button class="dropdown-item">
                    <a href="{{ route('draft.index') }}">Drafting</a>
                </button> --}}
            </nav>
        </div>
    </div>

</div>
