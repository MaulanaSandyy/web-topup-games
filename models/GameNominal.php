<?php
// models/GameNominal.php

class GameNominal extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getActiveNominalsByGame($gameId) {
        $this->db->query('SELECT * FROM game_nominal WHERE game_id = :game_id AND status = "active" ORDER BY price ASC');
        $this->db->bind(':game_id', $gameId);
        
        return $this->db->resultSet();
    }
    
    public function getAllNominalsByGame($gameId) {
        $this->db->query('SELECT * FROM game_nominal WHERE game_id = :game_id ORDER BY created_at DESC');
        $this->db->bind(':game_id', $gameId);
        
        return $this->db->resultSet();
    }
    
    public function getNominalById($id) {
        $this->db->query('SELECT * FROM game_nominal WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }
    
    public function addNominal($data) {
        $this->db->query('INSERT INTO game_nominal (game_id, nominal_name, nominal_value, price, description, status) VALUES (:game_id, :nominal_name, :nominal_value, :price, :description, :status)');
        
        $this->db->bind(':game_id', $data['game_id']);
        $this->db->bind(':nominal_name', $data['nominal_name']);
        $this->db->bind(':nominal_value', $data['nominal_value']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', $data['status']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function updateNominal($data) {
        $this->db->query('UPDATE game_nominal SET nominal_name = :nominal_name, nominal_value = :nominal_value, price = :price, description = :description, status = :status WHERE id = :id');
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':nominal_name', $data['nominal_name']);
        $this->db->bind(':nominal_value', $data['nominal_value']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', $data['status']);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function deleteNominal($id) {
        $this->db->query('DELETE FROM game_nominal WHERE id = :id');
        $this->db->bind(':id', $id);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>