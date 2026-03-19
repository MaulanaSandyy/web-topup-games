<?php
// controllers/AdminController.php

class AdminController extends Controller {
    
    public function __construct() {
        if(!isset($_SESSION['admin_id'])) {
            $this->redirect('auth/admin-login');
        }
    }
    
    public function index() {
        $this->redirect('admin/dashboard');
    }
    
    public function dashboard() {
        $orderModel = $this->model('Order');
        $gameModel = $this->model('Game');
        
        $data = [
            'title' => 'Admin Dashboard - ' . APP_NAME,
            'totalOrders' => $orderModel->getTotalOrders(),
            'pendingOrders' => $orderModel->getOrdersByStatus('pending'),
            'completedOrders' => $orderModel->getOrdersByStatus('completed'),
            'totalGames' => $gameModel->getTotalGames()
        ];
        
        $this->view('layouts/header', $data);
        $this->view('admin/dashboard', $data);
        $this->view('layouts/footer');
    }
    
    public function orders() {
        $orderModel = $this->model('Order');
        $orders = $orderModel->getAllOrders();
        
        $data = [
            'title' => 'Manage Orders - ' . APP_NAME,
            'orders' => $orders
        ];
        
        $this->view('layouts/header', $data);
        $this->view('admin/orders', $data);
        $this->view('layouts/footer');
    }
    
    public function games() {
        $gameModel = $this->model('Game');
        $games = $gameModel->getAllGames();
        
        $data = [
            'title' => 'Manage Games - ' . APP_NAME,
            'games' => $games
        ];
        
        $this->view('layouts/header', $data);
        $this->view('admin/games', $data);
        $this->view('layouts/footer');
    }
    
    public function updateOrderStatus() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderId = $_POST['order_id'];
            $status = $_POST['status'];
            
            $orderModel = $this->model('Order');
            
            if($orderModel->updateStatus($orderId, $status)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
    }
}
?>