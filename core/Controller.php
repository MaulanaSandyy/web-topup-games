<?php
// core/Controller.php

class Controller {
    
    public function model($model) {
        require_once '../models/' . $model . '.php';
        return new $model();
    }
    
    public function view($view, $data = []) {
        if(file_exists('../views/' . $view . '.php')) {
            require_once '../views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
    
    public function redirect($url) {
        header('Location: ' . APP_URL . '/' . $url);
        exit();
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function isAdmin() {
        return isset($_SESSION['admin_id']);
    }
    
    public function isDeveloper() {
        return isset($_SESSION['developer_id']);
    }
}
?>