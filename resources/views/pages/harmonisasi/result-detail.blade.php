@extends('layouts.app-layout')

@section('script-header')
    {{-- <script src='https://cdnjs.com/libraries/pdf.js'></script> --}}
@endsection

@section('content')
    <div class="p-5 lg:p-14 lg:py-7">
        <div class="grid grid-cols-1 md:grid-cols-2 divide-x-2 min-h-screen ">
            <div class="p-5 shadow-lg rounded bg-white">
                <div class="mb-5 font-bold">Pembanding</div>
                <embed src="{{ $pembandingPath }}" class="w-full h-full">
            </div>
            <div class="p-5 shadow-lg rounded bg-white">
                <div class="mb-5 font-bold">{{ $archive->uu }}</div>
                <embed src="{{ $archivePath }}" class="w-full h-full">
            </div>
        </div>

    </div>
@endsection

@section('datatable')
    <script>
    </script>
@endsection
