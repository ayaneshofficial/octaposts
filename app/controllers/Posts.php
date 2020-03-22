<?php 
  class Posts extends Controller {

    
    public function __construct() {

      if (!isLoggedIn()) {
        redirect('actions/login');
      }

      $this->postModel = $this->model('Post');
      $this->userModel = $this->model('User');

    }

    
    public function index() {
      
      $posts = $this->postModel->getPosts();
      
      $data = ['posts' => $posts];

      $this->view('posts/index', $data);

    }

    public function create() {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'cover_image' => '',
          'title_err' => '',
          'body_err' => '',
          'cover_image_err' => ''
        ];

        if (!empty($_FILES['cover_image'])) {
      
          $fileName = $_FILES['cover_image']['name'];
          $fileTempName = $_FILES['cover_image']['tmp_name'];
          $fileSize = $_FILES['cover_image']['size'];
          $fileError = $_FILES['cover_image']['error'];
          $fileType = $_FILES['cover_image']['type'];

          $file = pathinfo($fileName, PATHINFO_FILENAME);

          $fileExt = explode('.', $fileName);
          $fileActualExt = strtolower(end($fileExt));

          $allowed = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];

          if(in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
              if ($fileSize < 1000000) {
                $fileNameNew = $file . '_' . time() . '.' . $fileActualExt;
                $fileDestination = IMGROOT . $fileNameNew;
                move_uploaded_file($fileTempName, $fileDestination);
                $data['cover_image'] = filter_var($fileNameNew, FILTER_SANITIZE_STRING);
              } else {
                $data['cover_image_err'] = 'Your File Is Too Big';
              }
            } else {
              $data['cover_image_err'] = 'There was an error uploading the file';
            }
          } else {
            $data['cover_image_err'] = 'You Cannot Upload This Type Of File';
          }

        }

        // Validate Title Error
        if (empty($data['title'])) {
          $data['title_err'] = 'Please Enter Title';
        }

        // Validate Body Error
        if (empty($data['body'])) {
          $data['body_err'] = 'Please Enter Body';
        }

        // Make Sure Errors are Empty
        if (empty($data['title_err']) && empty($data['body_err']) && empty($data['cover_image_err'])) {

          // Validated
          if ($this->postModel->addPost($data)) {
            flash('message', 'Post Created!');
            redirect('posts');
          } else {
            die('SOMETHIGN WENT WRONG!');
          }

        } else {
          // Load View With Errors
          $this->view('posts/create', $data);
        }

      } else {

        $data = [
          'title' => '',
          'body' => '',
          'cover_image' => '',
          'title_err' => '',
          'body_err' => '',
          'cover_image_err' => ''
        ];
  
        $this->view('posts/create', $data);

      }

    }

    public function show($id) {

      $post = $this->postModel->getPostById($id);
      $user = $this->userModel->getUserById($post->user_id);

      $data = [
        'post' => $post,
        'user' => $user
      ];

      $this->view("posts/show", $data);

    }

    public function edit($id) {
      
      // Get existing Post From Model
      $post = $this->postModel->getPostById($id);

      // Check For Owner
      if ($post->user_id != $_SESSION['user_id']) {
        redirect('posts');
      }

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
          'id' => $id,
          'title' => trim($_POST['title']),
          'body' => trim($_POST['body']),
          'user_id' => $_SESSION['user_id'],
          'cover_image' => '',
          'title_err' => '',
          'body_err' => '',
          'cover_image_err' => ''
        ];

        if (!empty($_FILES['cover_image'])) {
      
          $fileName = $_FILES['cover_image']['name'];
          $fileTempName = $_FILES['cover_image']['tmp_name'];
          $fileSize = $_FILES['cover_image']['size'];
          $fileError = $_FILES['cover_image']['error'];
          $fileType = $_FILES['cover_image']['type'];

          $file = pathinfo($fileName, PATHINFO_FILENAME);

          $fileExt = explode('.', $fileName);
          $fileActualExt = strtolower(end($fileExt));

          $allowed = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];

          if(in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
              if ($fileSize < 1000000) {
                $fileNameNew = $file . '_' . time() . '.' . $fileActualExt;
                $fileDestination = IMGROOT . $fileNameNew;
                move_uploaded_file($fileTempName, $fileDestination);
                $data['cover_image'] = filter_var($fileNameNew, FILTER_SANITIZE_STRING);
              } else {
                $data['cover_image_err'] = 'Your File Is Too Big';
              }
            } else {
              $data['cover_image_err'] = 'There was an error uploading the file';
            }
          } else {
            $data['cover_image_err'] = 'You Cannot Upload This Type Of File';
          }

        }

        // Validate Title Error
        if (empty($data['title'])) {
          $data['title_err'] = 'Please Enter Title';
        }

        // Validate Body Error
        if (empty($data['body'])) {
          $data['body_err'] = 'Please Enter Body';
        }

        // Make Sure Errors are Empty
        if (empty($data['title_err']) && empty($data['body_err']) && empty($data['cover_image_err'])) {

          // Validated
          if ($this->postModel->updatePost($data)) {
            flash('message', 'Post Updated!');
            redirect('posts');
          } else {
            die('SOMETHING WENT WRONG!');
          }

        } else {
          // Load View With Errors
          $this->view('posts/edit', $data);
        }

      } else {

        // Get existing Post From Model
        $post = $this->postModel->getPostById($id);

        // Check For Owner
        if ($post->user_id != $_SESSION['user_id']) {
          redirect('posts');
        }

        $data = [
          'id' => $id,
          'title' => $post->title,
          'body' => $post->body,
          'cover_image' => $post->cover_image
        ];

        $this->view('posts/edit', $data);

      }

    }

    public function delete($id) {

      // Get existing Post From Model
      $post = $this->postModel->getPostById($id);

      // Check For Owner
      if ($post->user_id != $_SESSION['user_id']) {
        redirect('posts');
      }

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($this->postModel->deletePost($id)) {
          flash('message', 'Post Removed!');
          redirect('posts');
        } else {
          die('SOMETHING WENT WRONG!');
        }

      } else {
        redirect('posts');
      }

    }

  }