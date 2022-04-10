@extends('layouts.app-layout')

@section('content')
    <div class="p-5 bg-violet-300 rounded-md">
        <table>
            <tr>
                <th class="pr-5 lg:min-w-[200px] align-top text-left">No</th>
                <td class="align-top">{{ $archiveUU->judul_arsip }}</td>
            </tr>
            <tr>
                <th class="pr-5 lg:min-w-[200px] align-top text-left">Tentang</th>
                <td class="align-top">{{ $archiveUU->jenis_arsip }}</td>
            </tr>
            <tr>
                <th class="pr-5 lg:min-w-[200px] align-top text-left">Kategori</th>
                <td class="align-top">{{ $archiveUU->category->nama_kategori }}</td>
            </tr>
        </table>
    </div>

    <div class="flex border-b mt-5">
        <a href="{{ route('draft.show', $archiveUU->id_arsip) . '?view=penuh' }}">
            <button
                class="h-10 px-4 py-2 -mb-px text-sm text-center text-gray-700 hover:border-gray-400 bg-transparent border-b-2 {{ $view == 'penuh' || !isset($view) ? 'border-blue-500 text-blue-600 hover:border-blue-500' : '' }} sm:text-base  whitespace-nowrap focus:outline-none">
                Penuh
            </button>
        </a>
        <a href="{{ route('draft.show', $archiveUU->id_arsip) . '?view=pasal' }}">
            <button
                class="h-10 px-4 py-2 -mb-px text-sm text-center text-gray-700 hover:border-gray-400 bg-transparent border-b-2 {{ $view == 'pasal' ? 'border-blue-500 text-blue-600 hover:border-blue-500' : '' }} sm:text-base  whitespace-nowrap focus:outline-none">
                Pasal
            </button>
        </a>
    </div>

    @if (!isset($view) || $view == 'penuh')
        <div class="mt-5 p-5 shadow-md text-center max-w-full max-h-[50vh] lg:max-h-[110vh] overflow-scroll" id="penuh">
            {{ $penuh }}
        </div>
    @endif

    @if ($view == 'pasal')
        <div>pasal</div>
    @endif
@endsection


@section('datatable')
    <script>
        // let penuhTag = document.getElementById('penuh')
        // penuhTag.innerHTML = penuh;
        $(document).ready(function() {
            let penuh = "<html>{{ json_encode($penuh) }}</html>"
            $('#penuh').html(
                // create an element where the html content as the string
                $('<div/>', {
                    html: penuh
                    // get text content from element for decoded text  
                }).text()
            )
        });
    </script>
@endsection
