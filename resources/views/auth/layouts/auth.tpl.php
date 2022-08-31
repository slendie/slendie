<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Slendie Framework</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="@asset('assets/favicon.ico')" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="@asset('css/styles.css')" rel="stylesheet" />
        <link href="@asset('css/auth.css')" rel="stylesheet" />
        @yield('styles')
    </head>
    <body>
        <div class="content">
        @yield('content')
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="@asset('js/scripts.js')"></script>
        @yield('scripts')
    </body>
</html>