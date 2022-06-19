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
        <link href="@asset('css/app.css')" rel="stylesheet" />
        @yield('styles')
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            @include('admin.partials.sidebar')
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                @include('admin.partials.navbar')
                <!-- Page content-->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="@asset('js/scripts.js')"></script>
        @yield('scripts')
    </body>
</html>
