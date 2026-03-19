<?php
// controllers/OrderController.php

class OrderController extends Controller {
    
    public function checkout() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'game_id' => trim($_POST['game_id']),
                'nominal_id' => trim($_POST['nominal_id']),
                'game_account_id' => trim($_POST['game_account_id']),
                'game_account_server' => trim($_POST['game_account_server']),
                'customer_name' => trim($_POST['customer_name']),
                'customer_email' => trim($_POST['customer_email']),
                'customer_phone' => trim($_POST['customer_phone']),
                'game_id_err' => '',
                'nominal_id_err' => '',
                'game_account_id_err' => '',
                'customer_name_err' => '',
                'customer_email_err' => '',
                'customer_phone_err' => ''
            ];
            
            // Validate data
            if(empty($data['game_account_id'])) {
                $data['game_account_id_err'] = 'Please enter game account ID';
            }
            
            if(empty($data['customer_name'])) {
                $data['customer_name_err'] = 'Please enter your name';
            }
            
            if(empty($data['customer_email']) && empty($data['customer_phone'])) {
                $data['customer_email_err'] = 'Please enter email or phone';
            }
            
            // If no errors
            if(empty($data['game_account_id_err']) && empty($data['customer_name_err']) && empty($data['customer_email_err'])) {
                
                $orderModel = $this->model('Order');
                $nominalModel = $this->model('GameNominal');
                
                // Get nominal price
                $nominal = $nominalModel->getNominalById($data['nominal_id']);
                
                // Create order
                $orderId = $orderModel->createOrder([
                    'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
                    'game_id' => $data['game_id'],
                    'nominal_id' => $data['nominal_id'],
                    'game_account_id' => $data['game_account_id'],
                    'game_account_server' => $data['game_account_server'],
                    'customer_name' => $data['customer_name'],
                    'customer_email' => $data['customer_email'],
                    'customer_phone' => $data['customer_phone'],
                    'total_amount' => $nominal['price']
                ]);
                
                if($orderId) {
                    $this->redirect('order/payment/' . $orderId);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $gameModel = $this->model('Game');
                $game = $gameModel->getGameById($data['game_id']);
                $nominals = $nominalModel->getActiveNominalsByGame($data['game_id']);
                
                $data['game'] = $game;
                $data['nominals'] = $nominals;
                $data['title'] = 'Checkout - ' . APP_NAME;
                
                $this->view('layouts/header', $data);
                $this->view('games/order', $data);
                $this->view('layouts/footer');
            }
        } else {
            $this->redirect('');
        }
    }
    
    public function payment($orderId) {
        $orderModel = $this->model('Order');
        $order = $orderModel->getOrderById($orderId);
        
        if(!$order) {
            $this->redirect('');
        }
        
        $data = [
            'title' => 'Payment - ' . APP_NAME,
            'order' => $order
        ];
        
        $this->view('layouts/header', $data);
        $this->view('orders/payment', $data);
        $this->view('layouts/footer');
    }
    
    public function processPayment() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $orderId = trim($_POST['order_id']);
            $paymentMethod = trim($_POST['payment_method']);
            
            $orderModel = $this->model('Order');
            $paymentModel = $this->model('Payment');
            
            // Create payment
            $paymentId = $paymentModel->createPayment([
                'order_id' => $orderId,
                'payment_method' => $paymentMethod,
                'payment_amount' => $_POST['amount']
            ]);
            
            // Update order status
            $orderModel->updateStatus($orderId, 'processing');
            
            $this->redirect('order/status/' . $orderId);
        }
    }
    
    public function status($orderId) {
        $orderModel = $this->model('Order');
        $paymentModel = $this->model('Payment');
        
        $order = $orderModel->getOrderWithDetails($orderId);
        $payment = $paymentModel->getPaymentByOrder($orderId);
        
        if(!$order) {
            $this->redirect('');
        }
        
        $data = [
            'title' => 'Order Status - ' . APP_NAME,
            'order' => $order,
            'payment' => $payment
        ];
        
        $this->view('layouts/header', $data);
        $this->view('orders/status', $data);
        $this->view('layouts/footer');
    }
}
?>