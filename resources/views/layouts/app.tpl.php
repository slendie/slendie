<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ env('APP_TITLE') }}</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="@asset('assets/favicon.ico')" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="@asset('css/styles.css')" rel="stylesheet" />
        <link href="@asset('css/custom.css')" rel="stylesheet" />
        <!-- Toastr -->
        <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
        @yield('styles')
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="@route('home')">{{ env('APP_TITLE') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                @include('partials.navbar')
            </div>
        </nav>
        <div class="container px-4 px-lg-3 py-4">
        @yield('content')
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="@asset('js/scripts.js')"></script>
        <!-- Toastr -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        @yield('scripts')
    </body>
</html>