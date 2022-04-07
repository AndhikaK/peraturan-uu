@extends('layouts.index-layout')

@section('content')
    <div class="grid lg:grid-cols-[1fr_3fr] gap-4">
        {{-- FILTER --}}
        <div>
            <div class="transition duration-200 ease-in-out rounded-md border border-slate-300 hover:shadow-lg">
                <div class="p-3 bg-rose-500 text-slate-50 font-semibold rounded-t-md">
                    Filter
                </div>
                <div class="p-3 rounded-b-lg bg-white">
                    <form action="">
                        <div class="mb-3">
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="username">
                                Kategori
                            </label>
                            <select name="category"
                                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-3 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">

                            </select>
                        </div>
                        <button
                            class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button">
                            Terapkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        {{-- ARCHIVE --}}
        <div class="p-5 bg-white rounded-lg shadow-lg">

        </div>
    </div>
@endsection

@section('datatable')
    <script>
        $(document).ready(function() {
            var events = $('#events');
            let table = $('#myTable').DataTable({
                // dataTable query
                processing: true,
                serverSide: true,
                ajax: '{{ route('archive.data') }}',
                columns: [{
                        data: 'id_kategori',
                        name: 'id_kategori'
                    },
                    {
                        data: 'judul_arsip',
                        name: 'judul_arsip'
                    },
                    {
                        data: 'jenis_arsip',
                        name: 'jenis_arsip'
                    },
                    {
                        data: 'id_kategori',
                        name: 'id_kategori'
                    },
                ],
                order: [],
                fixedHeader: {
                    header: false
                },
                columnDefs: [{
                        targets: '_all',
                        defaultContent: '',
                    },
                    {
                        targets: [0, 3],
                        orderable: false,
                    },
                ],
                stripeClasses: []
            });
        });
    </script>
@endsection
