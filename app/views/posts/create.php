<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php require APPROOT . '/views/inc/navbar.php'; ?>
  <div class="container">
    <div class="card shadow bigMarg">
      <div class="card-header bg-green text-white card-border">Create Post</div>
      <div class="card-body borderTop">
        <form action="<?php echo URLROOT; ?>/posts/create" method="post" enctype="multipart/form-data">
          <div class="form-group mb-3">
            <label for="title" class="loginColor">Title <sup>*</sup></label>
            <input type="title" name="title" class="form-control form-control-lg form-border-green p-3 <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" 
            value="<?php echo $data['title']; ?>" placeholder="Enter Title">

            <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
          </div>

          <div class="form-group mb-3">
            <label for="body" class="loginColor">Body <sup>*</sup></label>
            <textarea name="body" rows="5" class="form-control form-control-lg form-border-green p-3 <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>" placeholder="Enter Post Body"><?php echo $data['body']; ?></textarea>
            <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
          </div>

          <div class="custom-file mb-4">
            <input type="file" name="cover_image" id="cover_image" class="custom-file-input">
            <label for="cover_image" class="custom-file-label greenBorder">Choose Your File (ONLY JPG, JPEF, PNG)</label>
            <span class="invalid-feedback d-block"><?php echo $data['cover_image_err']; ?></span>
          </div>

          <input type="submit" value="Submit" class="btn success-btn btn-lg my-2">
        </form>
      </div>
    </div>  
  </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>