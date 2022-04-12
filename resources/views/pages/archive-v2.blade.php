@extends('layouts.app-layout')

@section('content')
    <div class="grid lg:grid-cols-[1fr_3fr] gap-4">
        {{-- FILTER --}}
        <div>
            <div class="p-3 bg-white rounded-lg border border-slate-300 border-t-2 border-t-orange-600">
                <div>
                    <i class='bx bxs-filter-alt text-lg'></i>
                    <span class="ml-2 text-lg font-bold">Filter</span>
                </div>

                <div>
                    <div class="mb-3">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="username">
                            Kategori
                        </label>
                        <select name="category" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-3 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline text-sm">
                            @foreach ($categories as $category)
                                <option value="{{ $category->kategori_id }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button id="applyFilter" class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                        Terapkan
                    </button>
                </div>
            </div>
        </div>
        {{-- ARCHIVE --}}
        <div class="p-3 bg-white rounded-lg border border-slate-300 border-t-2 border-t-emerald-900">
            <div class="w-full">
                @auth
                    <div class="mb-3 flex flex-row justify-end">
                        <a href="{{ route('archive.create') }}" class="p-2 text-sm bg-sky-700 rounded-sm text-white font-bold">
                            Tambah UU
                        </a>
                    </div>
                @endauth
                <table class="mt-3" id="myTable" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead class="stripes hover">
                        <tr class="">
                            <th class="bg-sky-900 text-white">Peraturan</th>
                            <th class="bg-sky-900 text-white">Tentang</th>
                            <th class="bg-sky-900 text-white">Kategori</th>
                            <th class="bg-sky-900 text-white">Status</th>
                            <th class="bg-sky-900 text-white">
                                <i class='bx bxs-download'></i>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('datatable')
    <script>
        // DISPLAY THE TABLE
        $(document).ready(function() {
            var events = $('#events');
            let table = $('#myTable').DataTable({
                // dataTable query
                processing: true,
                serverSide: true,
                ajax: '{{ route('archive.data') }}',
                columns: [{
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
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'file_arsip',
                        name: 'file_arsip'
                    }
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
                        targets: [3, 4],
                        orderable: false,
                    },
                    {
                        targets: [4],
                        orderable: false,
                        className: "text-center",
                    },
                    {
                        targets: [3],
                        className: "text-center whitespace-nowrap"
                    }
                ],
                stripeClasses: []
            });

            // APPLY FILTER
            let status = $('select[name=category]')

            $('#applyFilter').click(function() {
                let url = "{{ route('archive.data') }}"
                let paramUrl = getParamUrl(url);
                table.ajax.url(paramUrl)
                    .load();
            })

            function getParamUrl(url) {
                url = addParameter(url, 'category', status.val(), false)

                return url;
            }
        });
    </script>
@endsection
