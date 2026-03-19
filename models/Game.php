<?php
// models/Game.php

class Game extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getActiveGames() {
        $this->db->query('SELECT g.*, d.company_name as developer_name 
                          FROM games g 
                          LEFT JOIN developers d ON g.developer_id = d.id 
                          WHERE g.status = "active" 
                          ORDER BY g.game_name ASC');
        
        return $this->db->resultSet();
    }
    
    public function getAllGames() {
        $this->db->query('SELECT g.*, d.company_name as developer_name 
                          FROM games g 
                          LEFT JOIN developers d ON g.developer_id = d.id 
                          ORDER BY g.created_at DESC');
        
        return $this->db->resultSet();
    }
    
    public function getGamesByDeveloper($developerId) {
        $this->db->query('SELECT * FROM games WHERE developer_id = :developer_id ORDER BY created_at DESC');
        $this->db->bind(':developer_id', $developerId);
        
        return $this->db->resultSet();
    }
    
    public function getGameById($id) {
        $this->db->query('SELECT * FROM games WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    public function getGameBySlug($slug) {
        $this->db->query('SELECT * FROM games WHERE game_slug = :slug AND status = "active"');
        $this->db->bind(':slug', $slug);
        
        return $this->db->single();
    }
    
    public function addGame($data) {
        $this->db->query('INSERT INTO games (developer_id, game_name, game_slug, description, status) VALUES (:developer_id, :game_name, :game_slug, :description, :status)');
        
        $this->db->bind(':developer_id', $data['developer_id']);
        $this->db->bind(':game_name', $data['game_name']);
        $this->db->bind(':game_slug', $data['game_slug']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', $data['status']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function updateGame($data) {
        $this->db->query('UPDATE games SET game_name = :game_name, description = :description, status = :status WHERE id = :id');
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':game_name', $data['game_name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', $data['status']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function deleteGame($id) {
        $this->db->query('DELETE FROM games WHERE id = :id');
        $this->db->bind(':id', $id);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getTotalGames() {
        $this->db->query('SELECT COUNT(*) as total FROM games');
        $row = $this->db->single();
        return $row['total'];
    }
}
?>