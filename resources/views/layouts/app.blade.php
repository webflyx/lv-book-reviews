<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('meta_title')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style type="text/tailwindcss">
        input {
            @apply border border-gray-300 rounded-md px-3 py-1
        }
        .btn-secondary {
            @apply border border-gray-300 rounded-md px-3 py-1 block hover:bg-gray-200
        }
    </style>

</head>
<body class="my-10">

    <header class="container mx-auto max-w-3xl mb-6 border-b pb-2 border-gray-200">
        <h1 class="text-3xl">@yield('title')</h1>
    </header>

    <div class="container mx-auto max-w-3xl">
        @yield('content')
    </div>

</body>
</html>