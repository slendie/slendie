<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Slendie Framework</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="http://slendie.php.test/assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="http://slendie.php.test/css/styles.css" rel="stylesheet" />
        
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?php echo route( 'home' ); ?>">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link @is_route('/', 'active')" @is_route('', 'aria-current="page"') href="<?php echo route( 'home' ); ?>">Home</a></li>
                        <li class="nav-item"><a class="nav-link @is_route('/about', 'active')" @is_route('/about', 'aria-current="page"') href="<?php echo route( 'about' ); ?>">About</a></li>
                        <li class="nav-item"><a class="nav-link @is_route('/contact', 'active')" @is_route('/contact', 'aria-current="page"') href="<?php echo route( 'contact' ); ?>">Contact</a></li>
                        <li class="nav-item"><a class="nav-link @is_route('/blog', 'active')" @is_route('/blog', 'aria-current="page"') href="<?php echo route( 'blog' ); ?>">Blog</a></li>
                        <li class="nav-item"><a class="nav-link @is_route('/admin', 'active')" @is_route('/admin', 'aria-current="page"') href="<?php echo route( 'admin' ); ?>">Admin</a></li>
                        <li class="nav-item"><a class="nav-link @is_route('/login', 'active')" @is_route('/login', 'aria-current="page"') href="<?php echo route( 'login' ); ?>">Login</a></li>
                    </ul>
                </div>

            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
            <div class="text-center mt-5">
                <h1>A Bootstrap 5 Starter Template</h1>
                <p class="lead">A complete project boilerplate built with Bootstrap</p>
                <p>Bootstrap v5.1.3</p>
            </div>
        </div>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="http://slendie.php.test/js/scripts.js"></script>
        
    </body>
</html>