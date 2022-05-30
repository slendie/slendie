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
        <link href="http://slendie.php.test/css/auth.css" rel="stylesheet" />
        
    </head>
    <body>
        <div class="content">
        <div class="row">
    <div class="col-12">
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


    </div>
  </div>
  <div class="row">
    <div class="col-12 signin">
      <form class="form-signin" action="<?php echo route( 'signin' ); ?>" method="POST">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <div class="mb-3">
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Email address" value="<?php echo old('email'); ?>" required autofocus>
          <?php if ((has_error('email'))) { ?>
          <p class="small text-danger"><?php echo error('email'); ?></p>
          <?php } ?>
        </div>
        <div class="mb-3">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
          <?php if ((has_error('password'))) { ?>
          <p class="small text-danger"><?php echo error('password'); ?></p>
          <?php } ?>
        </div>
        <div class="checkbox mb-3">
          <label>
          <input type="checkbox" id="rememberme" name="rememberme" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted text-center">&copy; 2017-2018</p>
      </form>
    </div>
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