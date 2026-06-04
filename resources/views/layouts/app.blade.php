<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    @if (session('message'))
        <div class="
            mx-auto mt-4 max-w-6xl rounded-lg border px-4 py-3 text-sm
            {{ session('status') === 'success'
                ? 'border-green-400 bg-green-100 text-green-700'
                : 'border-red-400 bg-red-100 text-red-700'
            }}
        ">
            {{ session('message') }}
        </div>
    @endif

    @yield('content')
</body>
</html>