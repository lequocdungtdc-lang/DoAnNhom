<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin dashboard">
    <meta property="og:title" content="Admin dashboard">
    <meta property="og:description" content="Modern admin workspace">
    <meta property="og:type" content="website">
    <title>{{ $title ?? 'Admin Workspace' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/admin.css', 'resources/css/style.css', 'resources/js/app.js'])
    <!-- admin.js -->
</head>
