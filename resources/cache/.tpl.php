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
        <div class="d-flex" id="wrapper">
                        <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">Start Bootstrap</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Dashboard</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?php echo route( 'tasks.index' ); ?>">Tasks</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?php echo route( 'users.index' ); ?>">Users</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Shortcuts</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Overview</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Events</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Profile</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Status</a>
                </div>
            </div>

            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active"><a class="nav-link @is_route('/admin', 'active')" href="<?php echo route( 'admin' ); ?>">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="<?php echo route( 'home' ); ?>">Frontend</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#!">Action</a>
                                        <a class="dropdown-item" href="#!">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#!">Something else here</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Page content-->
                <div class="container-fluid">
                    <h1 class="mt-4">Tasks</h1>
                    <p>Create a new task</p>
                                        <?php if (has_toasts()) { ?>
                    <?php foreach ( toasts() as $toast ) { ?>
                    <div class="alert alert-<?php echo $toast['level']; ?>" role="alert">
                    <?php echo $toast['message']; ?>
                    </div>
                    <?php } ?>
                    <?php } ?>

                    <form action="<?php echo route( 'tasks.store' ); ?>" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="description">Description</label>
                                <input class="form-control" type="text" name="description" id="description">
                                <?php if (has_error('description')) { ?>
                                <p class="small text-danger"><?php echo error('description'); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <button class="btn btn-success" type="submit">Create</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="http://slendie.php.test/js/scripts.js"></script>
        
    </body>
</html>
