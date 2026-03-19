<?php
// models/Payment.php

class Payment extends Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function createPayment($data) {
        $this->db->query('INSERT INTO payments (order_id, payment_method, payment_amount) VALUES (:order_id, :payment_method, :payment_amount)');
        
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':payment_method', $data['payment_method']);
        $this->db->bind(':payment_amount', $data['payment_amount']);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    
    public function getPaymentByOrder($orderId) {
        $this->db->query('SELECT * FROM payments WHERE order_id = :order_id');
        $this->db->bind(':order_id', $orderId);
        
        return $this->db->single();
    }
    
    public function updatePaymentStatus($id, $status) {
        $this->db->query('UPDATE payments SET payment_status = :status WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        
        if($status == 'paid') {
            $this->db->query('UPDATE payments SET paid_at = NOW() WHERE id = :id');
            $this->db->bind(':id', $id);
        }
        
        return $this->db->execute();
    }
}
?>