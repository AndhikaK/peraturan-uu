@extends('layouts.app-layout')

@section('content')
    <div class="grid lg:grid-cols-[1fr_3fr] gap-4">
        {{-- FILTER --}}
        <div>
            <div class="p-3 bg-white rounded-lg border border-slate-300 border-t-2 border-t-orange-600">
                <form action="{{ route('draft.index') }}" method="GET">
                    @csrf
                    <div>
                        <i class='bx bxs-filter-alt text-lg'></i>
                        <span class="ml-2 text-lg font-bold">Drafting</span>
                    </div>

                    <div>
                        <div class="mb-3">
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="username">
                                Masukkan Tema
                            </label>
                            <textarea name="theme" id="theme" rows="10"
                                class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-3 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline text-sm"></textarea>
                        </div>
                        <button id="applyFilter"
                            class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
        {{-- ARCHIVE --}}
        <div class="p-3 bg-white rounded-lg border border-slate-300 border-t-2 border-t-emerald-900">
            <div class="w-full overflow-x-auto">
                <table class="mt-3 table-auto" id="myTable" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
                    <thead class="stripes hover">
                        <tr class="">
                            <th class="bg-sky-900 text-white">No</th>
                            <th class="bg-sky-900 text-white">Peraturan</th>
                            <th class="bg-sky-900 text-white">Tentang</th>
                            <th class="bg-sky-900 text-white">Kategori</th>
                            <th class="bg-sky-900 text-white">
                                Similaritas
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
                ajax: '{{ route('draft.data') }}',
                columns: [{
                        data: 'id_arsip',
                        name: 'id_arsip'
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
                        data: 'kategori',
                        name: 'kategori'
                    },
                    {
                        data: 'cosSim',
                        name: 'cosSim'
                    },
                ],
                order: [],
                fixedHeader: {
                    header: false
                },
                columnDefs: [{
                        targets: [1, 2, 3],
                        defaultContent: '',
                        className: 'align-top'
                    },
                    {
                        targets: [0, 4],
                        className: 'text-center align-top'
                    },

                ],
                stripeClasses: []
            });

            // APPLY FILTER
            let theme = $('#theme')

            $('#applyFilter').click(function() {
                let url = "{{ route('draft.data') }}"
                let paramUrl = getParamUrl(url);
                table.ajax.url(paramUrl)
                    .load();
            })

            function getParamUrl(url) {
                url = addParameter(url, 'theme', theme.val(), false)

                return url;
            }
        });
    </script>
@endsection
