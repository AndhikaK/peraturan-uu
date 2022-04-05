<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="{{ asset('css/app.css ') }}" rel="stylesheet">
</head>

<body>

    <div class="flex flex-row gap-3 p-4 ">
        <div class="basis-2/4 bg-indigo-500  rounded-lg p-2 shadow-2xl">01</div>
        <div class="basis-1/4 bg-indigo-500 rounded-lg p-2 shadow-lg">02</div>
        <div class="basis-2/3 bg-indigo-500 rounded-lg p-2 shadow-lg">03</div>
    </div>

    <div class="divide-x divide-blue-200">
        <span>dsa</span>

        <span>
            dfas
        </span>
        <div>
            fdas
        </div>
        fdafasf
    </div>

    <div class="text-3xl font-bold">
        Hellow all
    </div>

    <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data" style="padding-bottom: 20px">
        @csrf
        <input type="file" name="file">
        <button type="submit">Submit</button>
    </form>


    <div class="container1">
        <button class="add_form_field">Add New Field &nbsp;
            <span style="font-size:16px; font-weight:bold;">+ </span>
        </button>
        <div><input type="text" name="mytext[]"></div>
    </div>

    <script>
        $(document).ready(function() {
            var max_fields = 100;
            var wrapper = $(".container1");
            var add_button = $(".add_form_field");

            var x = 1;
            $(add_button).click(function(e) {
                e.preventDefault();
                if (x < max_fields) {
                    x++;
                    $(wrapper).append(
                        '<div><input type="text" name="mytext[]"/><a href="#" class="delete">Delete</a></div>'
                    ); //add input box
                } else {
                    alert('You Reached the limits')
                }
            });

            $(wrapper).on("click", ".delete", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();
                x--;
            })
        });
    </script>

</body>

</html>
