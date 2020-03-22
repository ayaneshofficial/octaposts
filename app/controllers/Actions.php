<?php 
  class Actions extends Controller {

    public function __construct() {
      if (isLoggedIn()) {
        redirect('posts');
      }
      
      $this->userModel = $this->model('User');
    }

    public function index() {
      redirect('pages/index');
    }

    
    public function login() {

      // Check for Post
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Process The Form
        // Sanitize Post Data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // Init Form
        $data = [
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'email_err' => '',
          'password_err' => '',
          'mainTitle' => 'Welcome to OctoPosts. Say hello!'
        ];

        // Validate Email
        if (empty($data['email'])) {
          $data['email_err'] = 'Please Enter Your Email';
        }

        // Validate Password
        if (empty($data['password'])) {
          $data['password_err'] = 'Please Enter Your Password';
        }

        // Find For User/Email
        if (!empty($data['email']) && !$this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email Not Found';
        }

        // Make Sure Errors are Empty
        if (empty($data['email_err']) && empty($data['password_err'])) {
          // Validated
          // Check And Set Login User
          $loggedInUser = $this->userModel->login($data['email'], $data['password']);
          // Check If Logged In
          if ($loggedInUser) {
            // Create Session
            $this->createUserSession($loggedInUser);
            
          } else {
            $data['password_err'] = 'Incorrect Password';
            $this->view('actions/login', $data);
          }

        } else {
          // Load View With Errors
          $this->view('actions/login', $data);
        }

      } else {

        $data = [
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
          'mainTitle' => 'Welcome to OctoPosts. Say hello!'
        ];
        $this->view('actions/login', $data);

      }

    }

    public function createUserSession($user) {

      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email;
      $_SESSION['user_name'] = $user->name;

      flash('message', 'You Have Successfully Logged In');
      redirect('posts/index');

    }

    public function logout() {

      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();

      //flash('message', 'You Have Successfully Logged Out!');
      redirect('actions/login');

    }


  }