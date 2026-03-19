<?php
// controllers/HomeController.php

class HomeController extends Controller {
    
    public function index() {
        $gameModel = $this->model('Game');
        $games = $gameModel->getActiveGames();
        
        $data = [
            'title' => 'Home - ' . APP_NAME,
            'games' => $games
        ];
        
        $this->view('layouts/header', $data);
        $this->view('home/index', $data);
        $this->view('layouts/footer');
    }
}
?>