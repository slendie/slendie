<!DOCTYPE html>
<html lang="pt" class="scroll-smooth">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $app_name ?? 'Slendie' }}</title>
  <meta name="description" content="Starter kit PHP moderno, leve e eficiente para desenvolvedores.">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
  
  @yield('styles')
  @asset('js/app.js')
</head>
<body class="antialiased text-slate-800 bg-white font-sans selection:bg-indigo-500 selection:text-white">
  <div class="min-h-screen flex flex-col">
      @yield('content')
      
      <footer class="mt-auto border-t border-slate-100 bg-slate-50">
        @yield('footer')
        <div class="max-w-7xl mx-auto px-6 py-8 text-center">
            <p class="text-sm text-slate-500">
                &copy; {{ $year ?? date('Y') }} <span class="font-semibold text-slate-700">Slendie Framework</span>. 
                <span class="hidden sm:inline">Construído para desenvolvedores.</span>
            </p>
        </div>
      </footer>
  </div>
</body>
</html>
