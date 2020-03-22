<?php 
  
  class Pages extends Controller {

    public function __construct() {
      if (isLoggedIn()) {
        redirect('posts');
      }

      $this->userModel = $this->model('User');
    }

    public function index() {

      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process The Form
        // Sanitize POST Data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        // Init Form
        $data = [
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',

          'mainTitle' => 'A Social Media that shows the people power...'
        ];

        // Validate Email
        if (empty($data['email'])) {
          $data['email_err'] = 'Please Enter Email';
        } else {
          if ($this->userModel->findUserByEmail($data['email'])) {
            $data['email_err'] = 'Email Is Already Taken';
          }
        }

        // Validate Name
        if (empty($data['name'])) {
          $data['name_err'] = 'Please Enter Name';
        }

        // Validate Password
        if (empty($data['password'])) {
          $data['password_err'] = 'Please Enter Password';
        } elseif(strlen($data['password']) < 7) {
          $data['password_err'] = 'Password Should be 7 or more characters...';
        }

        // Validate Confirm Password
        if (empty($data['confirm_password'])) {
          $data['confirm_password_err'] = 'Please Confirm Your Password';
        } elseif($data['confirm_password'] !== $data['password']) {
          $data['confirm_password_err'] = 'Passwords Do Not Match';
        }

        // Make Sure Errors Are Empty
        if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
          
          // Validated
          // Hash Password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

          // Register User
          if ($this->userModel->register($data)) {
            flash('message', 'You Have Successfully Registered!');
            redirect('actions/login');
          } else {
            die('SOMETHING WENT WRONG');
          }

        } else {
          // Load View With Errors
          return $this->view('pages/index', $data);
        }


      } else {

        // Init Form
        $data = [
          'name' => '',
          'email' => '',
          'password' => '',
          'confirm_password' => '',
          'name_err' => '',
          'email_err' => '',
          'password_err' => '',
          'confirm_password_err' => '',

          'mainTitle' => 'A Social Media that shows the people power...'
        ];

        $this->view('pages/index', $data);
      }
      
      

    }

    public function about() {
      redirect('pages');
    }
    
  }