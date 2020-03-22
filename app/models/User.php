<?php 
  class User {

    private $db;

    public function __construct() {
      $this->db = new Database;
    }

    // Register User
    public function register($data) {

      $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
      // Bind Values
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password']);

      // Execute
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }

    }

    // Login User
    public function login($email, $password) {

      $this->db->query('SELECT * FROM users WHERE email = :email');
      // Bind Values
      $this->db->bind(':email', $email);

      // Return Single Row
      $row = $this->db->single();
      // Unhashing Password
      $hashed_password = $row->password;
      // Verify Password
      if (password_verify($password, $hashed_password)) {
        return $row;
      } else {
        return false;
      }

    }

    // Find User By Id
    public function findUserByEmail($email) {

      $this->db->query('SELECT * FROM users WHERE email = :email');
      // Bind Value(s)
      $this->db->bind(':email', $email);

      // Single Row
      $row = $this->db->single();

      // Chewck Row
      if ($this->db->rowCount() > 0) {
        return true;
      } else {
        return false;
      }

    }

    // Get a specific User by Id
    public function getUserById($id) {
      
      $this->db->query('SELECT * FROM users WHERE id = :id');
      // Bind Values
      $this->db->bind(':id', $id);

      // Getting single row
      $row = $this->db->single();

      return $row;

    }

  }