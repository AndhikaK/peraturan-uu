<div>
    <div class="px-3 py-3 lg:px-8 lg:py-3" style="background-image: url('{{ asset('assets/img/pattern.svg') }}')">
        <a href="{{ route('index') }}">
            <div class="flex items-center">
                <img src="{{ asset('assets/img/logo-icon.png') }}" class="mr-3 h-10" alt="app-logo">
                <div>
                    <div class="text-white font-bold text-xl">Omnilaw</div>
                    <div class="text-white text-sm">Universitas Lampung</div>
                </div>
            </div>
        </a>
    </div>
    <div class="px-3 bg-white hidden lg:flex lg:flex-row lg:px-8 drop-shadow">
        <li class="p-3 text-sm list-none hover:bg-sky-700 hover:text-white">
            <a href="{{ route('index') }}">Beranda</a>
        </li>
        <li class="p-3 text-sm list-none hover:bg-sky-700 hover:text-white">
            <a href="{{ route('archive.index') }}">Arsip</a>
        </li>
        <li class="p-3 text-sm list-none hover:bg-sky-700 hover:text-white">
            <a href="">Drafting</a>
        </li>
    </div>

    {{-- DROPDOWN MENU FOR SMALL VIEW --}}
    <div class="px-3 py-2 flex flex-row justify-betwen lg:hidden bg-blue-900">
        <div class="dropdown">
            <button
                class="p-1 px-2 text-white rounded-md hover:bg-sky-600 active:bg-sky-700 focus:outline-none focus:ring focus:ring-sky-300"
                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class='bx bx-menu text-2xl'></i>
            </button>
            <nav class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <button class="dropdown-item">
                    <a href="{{ route('index') }}">Beranda</a>
                </button>
                <button class="dropdown-item">
                    <a href="{{ route('archive.index') }}">Arsip</a>
                </button>
                <button class="dropdown-item">
                    <a href="">Drafting</a>
                </button>
            </nav>
        </div>
    </div>

</div>
