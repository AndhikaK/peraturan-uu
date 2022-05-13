@extends('layouts.app-layout')

{{-- @section('content')
    <div class="p-5 lg:p-14 lg:py-7">
        <div class="p-5 rounded-lg border bg-white border-slate-400 border-t-4 border-t-sky-700">
            <table>
                <tr>
                    <th class="pr-5 lg:min-w-[200px] align-top text-left">No</th>
                    <td class="align-top font-bold text-sky-600">{{ $archiveUU->uu }}</td>
                </tr>
                <tr>
                    <th class="pr-5 lg:min-w-[200px] align-top text-left">Tentang</th>
                    <td class="align-top">{{ $archiveUU->tentang }}</td>
                </tr>
                <tr>
                    <th class="pr-5 lg:min-w-[200px] align-top text-left">Kategori</th>
                    <td class="align-top">{{ $archiveUU->category->nama_kategori }}</td>
                </tr>
                <tr>
                    <th class="pr-5 lg:min-w-[200px] align-top text-left">Arsip</th>
                    <td class="align-top">
                        <a href="{{ asset('assets/pdf/') . '/' . $archiveUU->file_arsip }}" target="blank">{{ $archiveUU->file_arsip }}</a>
                    </td>
                </tr>
            </table>
        </div>

        @if (!isset($view) || $view == 'penuh')
            <div class="mt-5">
                Menampilkan hasil dari <span class="font-bold italic">"{{ $theme }}"</span>
            </div>
            <div class="mt-5 p-5 shadow-md text-center bg-white roundedlg max-w-full max-h-[50vh] lg:max-h-[110vh] overflow-scroll" id="penuh">
                {{ $penuh }}
            </div>
        @endif
    </div>
@endsection --}}

@section('content')
    <div class="p-5 lg:p-14 lg:py-7">
        <div class=" grid lg:grid-cols-[1fr_4fr] rounded-md shadow-xl">
            <div class="p-5 bg-slate-100">
                <div class="mb-5 flex justify-center">
                    <div class="p-6 bg-white flex justify-center rounded-tl-3xl rounded-br-3xl">
                        <i class='bx bxs-file-pdf text-5xl lg:text-8xl'></i>
                    </div>
                </div>
                <div class="grid gap-2 divide-y divide-slate-300">
                    <div class="py-3">
                        <div class="font-bold">{{ $archiveUU->uu }}</div>
                        <div class="text-sm">
                            {{ $archiveUU->tentang }}
                        </div>
                    </div>
                    <div class="py-3">
                        <div class="font-bold">File</div>
                        <div class="text-sm">
                            <a href="{{ asset('assets/pdf/' . $archiveUU->file_arsip) }}" target="blank">
                                PDF <i class='bx bx-link text-cyan-500'></i>
                            </a>
                        </div>
                    </div>
                    <div class="py-3">
                        <div class="font-bold">Kategori</div>
                        <div class="">
                            {{ $archiveUU->category->nama_kategori }}
                        </div>
                    </div>
                    <div class="py-3">
                        <div class="font-bold">Status</div>
                        <div class="">
                            @if ($archiveUU->status == 1)
                                Belum Verifikasi
                            @elseif($archiveUU->status == 2)
                                Tidak berlaku
                            @elseif($archiveUU->status == 3)
                                Berlaku
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white max-h-screen overflow-y-scroll">
                <div class="p-5">
                    @if ($penuh)
                        <div id="penuh" class=" text-center">
                            {{ $penuh }}
                        </div>
                    @else
                        <div class="font-bold">
                            Belum ada data untuk Undang-Undang ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
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
