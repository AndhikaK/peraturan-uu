@extends('layouts.app-layout')

@section('content')
    {{-- <div class="p-3 bg-white rounded-md border border-slate-400 border-t-2 border-t-rose-700"> --}}
    {{-- <div class="flex justify-end w-full">
            <a href="{{ route('archive-file.create') }}">
                <button class="bg-sky-800 p-2 text-white font-medium rounded">
                    File upload
                </button>
            </a>
        </div>
    </div> --}}

    <div id='container'>
        <ul id='sortable-input' class="grid gap-2">
            <li class="border border-slate-300 rounded-lg overflow-hidden shadow-lg bg-white">
                <div class="header py-2 flex justify-center hover:bg-slate-100 border-b border-b-slate-300 cursor-move">
                    <img src="{{ asset('assets/svg/grabber.svg') }}" class="rotate-90">
                </div>
                <div class="title px-3 py-2 pb-3 font-bold">Pasal</div>
                <div class="content">
                    <div class="content-item px-3 grid grid-cols-[1fr_auto_auto]">
                        <textarea name="" class="ayat-input w-full h-5 border-0 border-b-2 overflow-y-auto focus:ring-0 p-2 pt-0"></textarea>
                        <div class="content-grab mb-5 cursor-move flex items-center hover:bg-slate-200 h-full">
                            <img src="{{ asset('assets/svg/grabber.svg') }}" class="p-2">
                        </div>
                        <div class="content-grab mb-5 cursor-pointer flex items-center h-full">
                            <img src="{{ asset('assets/svg/x.svg') }}" onclick="removeInput(this)" class="p-2 rounded-full hover:bg-slate-200">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-1 border-t border-t-slate-200 mt-2 p-2">
                    <button type="button" onclick="addInput(this)">
                        <img src="{{ asset('assets/svg/plus-circle.svg') }}" class="p-2 rounded-full fill-slate-600 hover:fill-slate-900 hover:bg-slate-200">
                    </button>
                    <button type="button" onclick="removePasal(this)">
                        <img src="{{ asset('assets/svg/trash.svg') }}" class="p-2 rounded-full fill-slate-600 hover:fill-slate-900 hover:bg-slate-200">
                    </button>
                </div>
            </li>
            <li class="border border-slate-300 rounded-lg overflow-hidden shadow-lg bg-white">
                <div class="header py-2 flex justify-center hover:bg-slate-100 border-b border-b-slate-300 cursor-move">
                    <img src="{{ asset('assets/svg/grabber.svg') }}" class="rotate-90">
                </div>
                <div class="title px-3 py-2 pb-3 font-bold">Pasal</div>
                <div class="content">
                    <div class="content-item px-3 grid grid-cols-[1fr_auto_auto]">
                        <textarea name="" class="ayat-input w-full h-5 border-0 border-b-2 overflow-y-auto focus:ring-0 p-2 pt-0"></textarea>
                        <div class="content-grab mb-5 cursor-move flex items-center hover:bg-slate-200 h-full">
                            <img src="{{ asset('assets/svg/grabber.svg') }}" class="p-2">
                        </div>
                        <div class="content-grab mb-5 cursor-pointer flex items-center h-full">
                            <img src="{{ asset('assets/svg/x.svg') }}" onclick="removeInput(this)" class="p-2 rounded-full hover:bg-slate-200">
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-1 border-t border-t-slate-200 mt-2 p-2">
                    <button type="button" onclick="addInput(this)">
                        <img src="{{ asset('assets/svg/plus-circle.svg') }}" class="p-2 rounded-full fill-slate-600 hover:fill-slate-900 hover:bg-slate-200">
                    </button>
                    <button type="button" onclick="removePasal(this)">
                        <img src="{{ asset('assets/svg/trash.svg') }}" class="p-2 rounded-full fill-slate-600 hover:fill-slate-900 hover:bg-slate-200">
                    </button>
                </div>
            </li>
        </ul>
        <button type="button" onclick="addPasal(this)" class="py-1 px-2 rounded-sm bg-sky-500 mt-3 text-white font-semibold">Pasal baru</button>
    </div>
@endsection


@section('datatable')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="{{ asset('js/input-sort.js') }}"></script>
@endsection
