<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peraturan UU</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/x-icon">


    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

    {{-- BOXICONS CDN --}}
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    {{-- TAILWIND CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- CHECKBOX BUTTON LIKE STYLE --}}
    <link rel="stylesheet" href="{{ asset('css/button-like-checkbox.css') }}">
    {{-- DATATABLE CSS --}}
    <link rel="stylesheet" href="{{ asset('css/dataTable.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
</head>

<body class="min-h-screen text-slate-700 bg-gradient-to-tr from-slate-100 to-slate-50">

    <div class="grid grid-rows-[auto_1fr_auto] min-h-screen">
        {{-- NAVBAR --}}
        @include('layouts.navbar')
        {{-- MAIN CONTENT --}}
        {{-- <div class="p-5 lg:p-12 lg:py-7"> --}}
        @yield('content')
        {{-- </div> --}}
        {{-- FOOTER --}}
        <div class="py-3 text-center text-sm bg-slate-200">
            Copyright &copy; {{ date('Y') }} Powered by Universitas Lampung
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/b-2.0.1/fc-4.0.1/sl-1.3.3/datatables.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script src="{{ asset('js/dataTableFilter.js') }}"></script>

    @yield('datatable')

</body>

</html>
