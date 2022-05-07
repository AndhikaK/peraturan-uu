<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        .bold {
            font-weight: bold;
        }

    </style>

</head>

<body>
    <div class="text-center bold text-lg">Hasil Drafting Undang-Undang</div>

    <div class="py-5">
        @foreach ($data as $item)
            <div class="mt-5">
                <div class="bold">
                    {{ $item->uu->uu }} - {{ $item->uu->tentang }}
                </div>
                <div class="text-sm capitalize">
                    {{ $item->uud_id }}
                </div>
                <div>
                    {{ $item->uud_content }}
                </div>
            </div>
        @endforeach
    </div>
</body>

</html>
