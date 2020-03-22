<?php require APPROOT . '/views/inc/header.php'; ?>
  <div id="login">
    <nav class="navbar navbar-expand-sm navbar-dark bg-trans mb-5 py-2">
      <div class="container">
        <a href="<?php echo URLROOT; ?>/pages/index" class="navbar-brand"><span>Octa</span> Posts</a>

        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a href="<?php echo URLROOT; ?>/pages/index" class="nav-link">Home</a>
            </li>
            <li class="nav-item mr-2">
              <a href="<?php echo URLROOT; ?>/pages/about" class="nav-link">About</a>
            </li>
            <li class="nav-item">
              <a href="<?php echo URLROOT; ?>/pages/index" class="btn success-btn"><span><i class="fa fa-user-circle mr-1"></i></span> Sign Up</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row justify-content-between align-items-center">
        <div class="col-md-5 mb-5 d-none d-lg-block">
          <span class="d-block text-white text-uppercase mb-3 lp-2 fw-7">Only One Step To Go!</span>
          <h1 class="display-4 text-white mb-0 lp-2"><?php echo $data['mainTitle'] ?></h1>
        </div>

        <div class="col-md-5 mb-5">
          <div class="card bg-light p-3 card-form">
            <div class="card-body">
              <h3 class="fw-4 mb-4">Enter Your Credentials</h3>
                <?php flash('message'); ?>
              <form action="<?php echo URLROOT; ?>/actions/login" method="post">
                <div class="form-group mb-4">
                  <input type="email" name="email" class="form-control form-border p-3 <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" 
                  value="<?php echo $data['email']; ?>" placeholder="Enter Email">

                  <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>

                <div class="form-group mb-4">
                  <input type="password" name="password" class="form-control form-border p-3 <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" 
                  value="<?php echo $data['password']; ?>" placeholder="Enter Password">

                  <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>

                <input type="submit" value="Login" class="btn success-btn btn-block">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>

