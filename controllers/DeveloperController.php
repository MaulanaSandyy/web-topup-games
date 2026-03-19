<?php
// controllers/DeveloperController.php

class DeveloperController extends Controller {
    
    public function __construct() {
        if(!isset($_SESSION['developer_id'])) {
            $this->redirect('auth/developer-login');
        }
    }
    
    public function index() {
        $this->redirect('developer/dashboard');
    }
    
    public function dashboard() {
        $gameModel = $this->model('Game');
        $games = $gameModel->getGamesByDeveloper($_SESSION['developer_id']);
        
        $data = [
            'title' => 'Developer Dashboard - ' . APP_NAME,
            'games' => $games
        ];
        
        $this->view('layouts/header', $data);
        $this->view('developer/dashboard', $data);
        $this->view('layouts/footer');
    }
    
    public function addGame() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'game_name' => trim($_POST['game_name']),
                'game_slug' => $this->createSlug(trim($_POST['game_name'])),
                'description' => trim($_POST['description']),
                'status' => trim($_POST['status']),
                'game_name_err' => '',
                'description_err' => ''
            ];
            
            if(empty($data['game_name'])) {
                $data['game_name_err'] = 'Please enter game name';
            }
            
            if(empty($data['description'])) {
                $data['description_err'] = 'Please enter description';
            }
            
            if(empty($data['game_name_err']) && empty($data['description_err'])) {
                $gameModel = $this->model('Game');
                
                $data['developer_id'] = $_SESSION['developer_id'];
                
                if($gameModel->addGame($data)) {
                    $this->redirect('developer/dashboard');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('layouts/header', ['title' => 'Add Game - ' . APP_NAME]);
                $this->view('developer/add-game', $data);
                $this->view('layouts/footer');
            }
        } else {
            $data = [
                'game_name' => '',
                'description' => '',
                'status' => 'active',
                'game_name_err' => '',
                'description_err' => ''
            ];
            
            $this->view('layouts/header', ['title' => 'Add Game - ' . APP_NAME]);
            $this->view('developer/add-game', $data);
            $this->view('layouts/footer');
        }
    }
    
    public function addNominal($gameId = null) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'game_id' => trim($_POST['game_id']),
                'nominal_name' => trim($_POST['nominal_name']),
                'nominal_value' => trim($_POST['nominal_value']),
                'price' => trim($_POST['price']),
                'description' => trim($_POST['description']),
                'status' => trim($_POST['status']),
                'nominal_name_err' => '',
                'nominal_value_err' => '',
                'price_err' => ''
            ];
            
            if(empty($data['nominal_name'])) {
                $data['nominal_name_err'] = 'Please enter nominal name';
            }
            
            if(empty($data['nominal_value'])) {
                $data['nominal_value_err'] = 'Please enter nominal value';
            }
            
            if(empty($data['price'])) {
                $data['price_err'] = 'Please enter price';
            }
            
            if(empty($data['nominal_name_err']) && empty($data['nominal_value_err']) && empty($data['price_err'])) {
                $nominalModel = $this->model('GameNominal');
                
                if($nominalModel->addNominal($data)) {
                    $this->redirect('developer/dashboard');
                } else {
                    die('Something went wrong');
                }
            } else {
                $gameModel = $this->model('Game');
                $games = $gameModel->getGamesByDeveloper($_SESSION['developer_id']);
                
                $data['games'] = $games;
                
                $this->view('layouts/header', ['title' => 'Add Nominal - ' . APP_NAME]);
                $this->view('developer/add-nominal', $data);
                $this->view('layouts/footer');
            }
        } else {
            $gameModel = $this->model('Game');
            $games = $gameModel->getGamesByDeveloper($_SESSION['developer_id']);
            
            $data = [
                'game_id' => $gameId,
                'nominal_name' => '',
                'nominal_value' => '',
                'price' => '',
                'description' => '',
                'status' => 'active',
                'games' => $games,
                'nominal_name_err' => '',
                'nominal_value_err' => '',
                'price_err' => ''
            ];
            
            $this->view('layouts/header', ['title' => 'Add Nominal - ' . APP_NAME]);
            $this->view('developer/add-nominal', $data);
            $this->view('layouts/footer');
        }
    }
    
    private function createSlug($string) {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }
}
?>