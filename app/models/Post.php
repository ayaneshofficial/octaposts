<?php

  class Post {

    private $db;

    public function __construct() {

      $this->db = new Database;

    }

    public function getPosts() {

      $this->db->query('SELECT *,
                        posts.id as postId,
                        users.id as userId,
                        posts.created_at as postCreated, posts.updated_at as postUpdated,
                        users.created_at as userCreated
                        FROM posts
                        INNER JOIN users
                        ON posts.user_id = users.id
                        ORDER BY posts.updated_at DESC');

      // Returning All Posts Belonging to a specific User
      $results = $this->db->resultset();

      return $results;

    }

    public function addPost($data) {

      $this->db->query('INSERT INTO posts (title, body, user_id, cover_image) VALUES(:title, :body, :user_id, :cover_image)');
      // Bind Values
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':cover_image', $data['cover_image']);

      // Execute
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }

    }

    public function getPostById($id) {

      $this->db->query('SELECT * FROM posts WHERE id = :id');
      // Bind Values
      $this->db->bind(':id', $id);

      // Getting single row
      $row = $this->db->single();

      return $row;

    }

    public function updatePost($data) {

      $this->db->query('UPDATE posts SET title = :title, body = :body, cover_image = :cover_image WHERE id = :id');
      // Bind Values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':title', $data['title']);
      $this->db->bind(':body', $data['body']);
      $this->db->bind(':cover_image', $data['cover_image']);

      // Execute
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }

    }

    public function deletePost($id) {

      $this->db->query('DELETE FROM posts WHERE id = :id');
      // Bind Values
      $this->db->bind(':id', $id);

      // Execute
      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }

    }

  }