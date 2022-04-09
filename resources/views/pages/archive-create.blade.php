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
@endsection


@section('datatable')
@endsection
