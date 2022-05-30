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
        <link href="http://slendie.php.test/css/app.css" rel="stylesheet" />
        
    </head>
    <body>
        <div class="d-flex" id="wrapper">
                        <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">Start Bootstrap</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Dashboard</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?php echo route( 'tasks.index' ); ?>">Tasks</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="<?php echo route( 'cards.index' ); ?>">Cards</a>
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
                    <h1 class="mt-4">Cards</h1>
                    <p>Edit a card</p>
                                        <?php if (has_toasts()) { ?>
                    <?php foreach ( toasts() as $toast ) { ?>
                    <div class="alert alert-<?php echo $toast['level']; ?>" role="alert">
                    <?php echo $toast['message']; ?>
                    </div>
                    <?php } ?>
                    <?php } ?>
                                        <?php if (has_errors()) { ?>
                    <div class="alert alert-danger" role="alert">
                    <?php foreach ( errors() as $error ) { ?>
                    <span class="text-danger"><?php echo $error; ?></span><br>
                    <?php } ?>
                    </div>
                    <?php } ?>


                    <form action="<?php echo route( 'cards.update', ['id' => $card->id] ); ?>" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="title">Title</label>
                                <input class="form-control" type="text" name="title" id="title" value="<?php echo old('title', $card->title); ?>">
                                <?php if (has_error('title')) { ?>
                                <p class="small text-danger"><?php echo error('title'); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="slug">Slug</label>
                                <input class="form-control" type="text" name="slug" id="slug" value="<?php echo old('slug', $card->slug); ?>" disabled="disabled">
                                <?php if (has_error('slug')) { ?>
                                <p class="small text-danger"><?php echo error('slug'); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="resume">Resume</label>
                                <textarea class="form-control" id="resume" name="resume" rows="5" cols="80"><?php echo old('resume', $card->resume); ?></textarea>
                                <?php if (has_error('resume')) { ?>
                                <p class="small text-danger"><?php echo error('resume'); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="content">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="15" cols="80"><?php echo old('content', $card->content); ?></textarea>
                                <?php if (has_error('content')) { ?>
                                <p class="small text-danger"><?php echo error('content'); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <button class="btn btn-primary" type="submit">Update</button>
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
