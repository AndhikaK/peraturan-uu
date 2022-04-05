<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peraturan UU</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <div class="grid grid-rows-[1fr_auto] min-h-screen">
        @include('layouts.navbar')

        <div class="p-10 px-3 md:p-10 mt-16">
            @yield('content')
        </div>

        @include('layouts.footer')
    </div>

</body>

</html>
