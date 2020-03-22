<?php 
  $post = $data['post'];
  $user = $data['user'];
?>
<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php require APPROOT . '/views/inc/navbar.php'; ?>
  <div class="container mb-5">
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card p-5 shadow mb-5 card-border">
          <div class="card-body mb-3">
            <div class="d-flex align-items-center mb-4">
              <h3 class="card-title m-0 loginColor text-truncate"><?php echo $post->title; ?></h3>
              <span class="ml-2 text-truncate"><p class="d-inline lead profile loginText"> by <?php echo ucwords($user->name); ?></p></span>
            </div>
            <p class="card-text loginText"><?php echo $post->body; ?></p>
          </div>
          
          <img src="<?php echo URLROOT; ?>/img/<?php echo $post->cover_image; ?>" 
          alt="<?php echo $post->title; ?>" class="card-img img-fluid">

          <?php if($post->user_id == $_SESSION['user_id']) : ?>
          <div class="d-flex justify-content-between align-items-center my-4">
            <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $post->id; ?>" class="btn success-btn btn-lg">Edit</a>
            
            <!-- <a href="#" class="btn danger-btn btn-lg">Delete</a> -->
            <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $post->id; ?>" method="post">
              <input type="submit" value="Delete" class="btn danger-btn btn-lg">
            </form>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>