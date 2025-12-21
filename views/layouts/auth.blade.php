<!DOCTYPE html>
<html lang="{{ env('APP_LOCALE', 'pt') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="light only">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <title>{{ config('app.name', 'Slendie') }}</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Styles / Scripts -->
    @vite(['views/assets/js/app.js'])
    @yield('top-styles')
    @yield('top-scripts')
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50">
    @yield('content')
    @yield('bottom-scripts')
</body>
</html>
