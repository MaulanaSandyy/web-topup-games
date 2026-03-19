<?php
// controllers/GameController.php

class GameController extends Controller {
    
    public function index() {
        $gameModel = $this->model('Game');
        $games = $gameModel->getActiveGames();
        
        $data = [
            'title' => 'Game List - ' . APP_NAME,
            'games' => $games
        ];
        
        $this->view('layouts/header', $data);
        $this->view('games/list', $data);
        $this->view('layouts/footer');
    }
    
    public function order($gameSlug) {
        $gameModel = $this->model('Game');
        $nominalModel = $this->model('GameNominal');
        
        $game = $gameModel->getGameBySlug($gameSlug);
        
        if(!$game) {
            $this->redirect('');
        }
        
        $nominals = $nominalModel->getActiveNominalsByGame($game['id']);
        
        $data = [
            'title' => 'Order ' . $game['game_name'] . ' - ' . APP_NAME,
            'game' => $game,
            'nominals' => $nominals
        ];
        
        $this->view('layouts/header', $data);
        $this->view('games/order', $data);
        $this->view('layouts/footer');
    }
}
?>