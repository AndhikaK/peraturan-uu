@extends('design.design_1')

@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-2 mb-2">Drag & Drop File Uploading using Laravel 8 Dropzone JS</h1>

                <form action="{{ route('harmonisasi.store') }}" method="post" enctype="multipart/form-data" id="image-upload" class="dropzone">
                    @csrf
                    <div>
                        <h3>Upload Multiple Image By Click On Box</h3>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('datatable')
    <script type="text/javascript">
        let dropZone = Dropzone.options.imageUpload = {
            maxFiles: 1,
            acceptedFiles: ".pdf",
            init: function() {
                this.on("addedfile", file => {
                    console.log("A file has been added");
                });
            }
        };
    </script>
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
