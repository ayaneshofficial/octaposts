<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php require APPROOT . '/views/inc/navbar.php'; ?>
  <div class="container">
    <?php flash('message') ?>
    <div class="jumbotron mt-3 mb-5 p-4 text-center shadow bg-trans">
      <h3 class="display-4 greenText fw-3">Welcome To OctaPosts</h3>
      <p class="lead loginText">Now Experience The Real People Power</p>
      <a href="<?php echo URLROOT; ?>/posts/create" class="btn success-btn">
        <span><i class="fa fa-plus mr-1"></i></span>  Create Post
      </a>
    </div>

    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <?php foreach($data['posts'] as $post) : ?>

        <div class="card p-5 shadow mb-5 card-border">
          <div class="card-body mb-3">
            <div class="d-flex align-items-center mb-4">
              <h3 class="card-title m-0 loginColor text-truncate"><?php echo $post->title; ?></h3>
              <span class="ml-2 text-truncate"><p class="d-inline lead profile loginText"> by <?php echo ucwords($post->name); ?></p></span>
              <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="ml-auto d-inline"><i class="fa fa-external-link forwardLink"></i></a>
            </div>
            <p class="card-text loginText text-truncate"><?php echo $post->body; ?></p>
          </div>
          
          <img src="<?php echo URLROOT; ?>/img/<?php echo $post->cover_image; ?>" 
          alt="<?php echo $post->title; ?>" class="card-img img-fluid">

          <?php if($post->user_id == $_SESSION['user_id']) : ?>

            <div class="d-flex justify-content-between align-items-center my-4">
              <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $post->postId; ?>" class="btn success-btn btn-lg">Edit</a>
              
              <!-- <a href="#" class="btn danger-btn btn-lg">Delete</a> -->
              <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $post->postId; ?>" method="post">
                <input type="submit" value="Delete" class="btn danger-btn btn-lg">
              </form>
            </div>

          <?php endif; ?>
        </div>

        <?php endforeach; ?>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
