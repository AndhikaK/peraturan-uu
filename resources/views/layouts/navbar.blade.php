<div class="p-3 py-5 md:px-10  flex justify-between shadow-md bg-white">
    <a href="{{ route('index') }}">
        <img src="{{ asset('assets/img/logo-icon.png') }}" alt="peraturan-logo" class="max-h-6 inline-block mr-2">
        <span class="font-bold text-lg">Peraturan</span>
    </a>
    <div class="flex flex-row gap-5 divide-x">
        <div class="flex gap-5">
            <a href="{{ route('archive.index') }}" class="font-medium hover:text-blue-400">Arsip</a>
            <a href="" class="font-medium hover:text-blue-400">Drafting</a>
        </div>
        <div class="pl-5">
            <button class="font-medium">Masuk</button>
        </div>
    </div>
</div>
