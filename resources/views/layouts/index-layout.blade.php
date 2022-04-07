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
    {{-- DATATABLE CSS --}}
    <link rel="stylesheet" href="{{ asset('css/dataTable.css') }}">
</head>

<body class="bg-slate-50">

    <div class="grid grid-rows-[1fr_auto] min-h-screen">
        @include('layouts.navbar')

        <div class="p-10 px-3 md:p-10">
            @isset($breadCrumbs)
                @include('layouts.breadcrumbs')
            @endisset

            @yield('content')
        </div>

        @include('layouts.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/dt-1.11.3/b-2.0.1/fc-4.0.1/sl-1.3.3/datatables.min.js"></script>

    @yield('datatable')

</body>

</html>
