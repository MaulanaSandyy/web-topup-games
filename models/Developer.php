<?php
// models/Developer.php

class Developer extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function login($email, $password) {
        $this->db->query('SELECT * FROM developers WHERE email = :email AND status = "active"');
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
    
    public function getDeveloperById($id) {
        $this->db->query('SELECT * FROM developers WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    public function getAllDevelopers() {
        $this->db->query('SELECT * FROM developers ORDER BY company_name ASC');
        return $this->db->resultSet();
    }
}
?>