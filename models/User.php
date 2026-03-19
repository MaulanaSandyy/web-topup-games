<?php
// models/User.php

class User extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        
        $row = $this->db->single();
        
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        
        $row = $this->db->single();
        
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function register($data) {
        $this->db->query('INSERT INTO users (username, email, password, full_name, phone) VALUES (:username, :email, :password, :full_name, :phone)');
        
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function login($email, $password) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        
        $row = $this->db->single();
        
        if($row) {
            $hashed_password = $row['password'];
            if(password_verify($password, $hashed_password)) {
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
}
?>