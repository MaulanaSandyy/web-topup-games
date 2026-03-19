<?php
// models/Admin.php

class Admin extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function login($email, $password) {
        $this->db->query('SELECT * FROM admins WHERE email = :email');
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
    
    public function getAdminById($id) {
        $this->db->query('SELECT * FROM admins WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
}
?>