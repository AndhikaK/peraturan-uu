@extends('layouts.app-layout')

@section('content')
    <div class="p-3 bg-white rounded-md border border-slate-400 border-t-2 border-t-rose-700">
        <div class="flex justify-end w-full">
            <a href="{{ route('archive-file.create') }}">
                <button class="bg-sky-800 p-2 text-white font-medium rounded">
                    File upload
                </button>
            </a>
        </div>
    </div>

    <div id='container'>
        <ul id='sortable-input'>
            <li class="my-2 rounded-xl shadow-lg border border-slate-300 border-l-4 border-l-sky-600">
                <div class="header py-2 text-center flex justify-center border-b border-b-slate-400/20 cursor-move">
                    <img src="{{ asset('assets/svg/grabber.svg') }}" class="rotate-90">
                </div>
                <div class="title p-3 pb-0 font-semibold text-lg">
                    Pasal
                </div>
                <div class="content py-3">
                    <div class="content-item group grid grid-cols-[auto_1fr] w-full">
                        <div class="content-grab px-1 cursor-move flex items-center">
                            <img src="{{ asset('assets/svg/grabber.svg') }}" class="invisible group-hover:visible">
                        </div>
                        <div class="pr-5">
                            <div class="ayat-title mb-2">Ayat</div>
                            <textarea name="" class="ayat-input w-full p-1" onkeyup="$(this).height(0);$(this).height($(this).prop('scrollHeight'))"></textarea>
                        </div>
                    </div>
                    <div class="content-item group grid grid-cols-[auto_1fr] w-full">
                        <div class="content-grab px-1 cursor-move flex items-center">
                            <img src="{{ asset('assets/svg/grabber.svg') }}" class="invisible group-hover:visible">
                        </div>
                        <div class="pr-5">
                            <div class="ayat-title mb-2">Ayat</div>
                            <textarea name="" class="ayat-input w-full p-1" onkeyup="$(this).height(0);$(this).height($(this).prop('scrollHeight'))"></textarea>
                        </div>
                    </div>
                    <div class="content-item group grid grid-cols-[auto_1fr] w-full">
                        <div class="content-grab px-1 cursor-move flex items-center">
                            <img src="{{ asset('assets/svg/grabber.svg') }}" class="invisible group-hover:visible">
                        </div>
                        <div class="pr-5">
                            <div class="ayat-title mb-2">Ayat</div>
                            <textarea name="" class="ayat-input w-full p-1" onkeyup="$(this).height(0);$(this).height($(this).prop('scrollHeight'))"></textarea>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
@endsection


@section('datatable')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="{{ asset('js/input-sort.js') }}"></script>
@endsection
