<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $app_name }}</title>
    @yield('styles')
  @asset('js/main.js')
</head>
<body>
  <header>
    <h1>{{ $app_name }}</h1>
  </header>
  <main>
    @yield('content')
  </main>
  <footer>
    @yield('footer')
    <small>&copy; {{ $year }}</small>
  </footer>
</body>
</html>
