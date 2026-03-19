<?php
// controllers/AuthController.php

class AuthController extends Controller {
    
    public function login() {
        // Check if already logged in
        if($this->isLoggedIn()) {
            $this->redirect('user/dashboard');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }
            
            if(empty($data['email_err']) && empty($data['password_err'])) {
                $userModel = $this->model('User');
                
                // Check if user exists
                $loggedInUser = $userModel->login($data['email'], $data['password']);
                
                if($loggedInUser) {
                    // Create session
                    $_SESSION['user_id'] = $loggedInUser['id'];
                    $_SESSION['user_email'] = $loggedInUser['email'];
                    $_SESSION['user_name'] = $loggedInUser['username'];
                    
                    $this->redirect('user/dashboard');
                } else {
                    $data['password_err'] = 'Invalid email or password';
                    
                    $this->view('layouts/header', ['title' => 'Login - ' . APP_NAME]);
                    $this->view('auth/login', $data);
                    $this->view('layouts/footer');
                }
            } else {
                $this->view('layouts/header', ['title' => 'Login - ' . APP_NAME]);
                $this->view('auth/login', $data);
                $this->view('layouts/footer');
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            
            $this->view('layouts/header', ['title' => 'Login - ' . APP_NAME]);
            $this->view('auth/login', $data);
            $this->view('layouts/footer');
        }
    }
    
    public function register() {
        // Check if already logged in
        if($this->isLoggedIn()) {
            $this->redirect('user/dashboard');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate username
            if(empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            }
            
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            
            // Validate password
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif(strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            
            // Validate confirm password
            if(empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
            
            if(empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                
                $userModel = $this->model('User');
                
                // Check if user exists
                if($userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email already taken';
                    
                    $this->view('layouts/header', ['title' => 'Register - ' . APP_NAME]);
                    $this->view('auth/register', $data);
                    $this->view('layouts/footer');
                } elseif($userModel->findUserByUsername($data['username'])) {
                    $data['username_err'] = 'Username already taken';
                    
                    $this->view('layouts/header', ['title' => 'Register - ' . APP_NAME]);
                    $this->view('auth/register', $data);
                    $this->view('layouts/footer');
                } else {
                    // Register user
                    if($userModel->register($data)) {
                        $this->redirect('auth/login');
                    } else {
                        die('Something went wrong');
                    }
                }
            } else {
                $this->view('layouts/header', ['title' => 'Register - ' . APP_NAME]);
                $this->view('auth/register', $data);
                $this->view('layouts/footer');
            }
        } else {
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'full_name' => '',
                'phone' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            $this->view('layouts/header', ['title' => 'Register - ' . APP_NAME]);
            $this->view('auth/register', $data);
            $this->view('layouts/footer');
        }
    }
    
    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        $this->redirect('');
    }
    
    public function adminLogin() {
        if($this->isAdmin()) {
            $this->redirect('admin/dashboard');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];
            
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }
            
            if(empty($data['email_err']) && empty($data['password_err'])) {
                $adminModel = $this->model('Admin');
                
                $loggedInAdmin = $adminModel->login($data['email'], $data['password']);
                
                if($loggedInAdmin) {
                    $_SESSION['admin_id'] = $loggedInAdmin['id'];
                    $_SESSION['admin_email'] = $loggedInAdmin['email'];
                    $_SESSION['admin_name'] = $loggedInAdmin['full_name'];
                    
                    $this->redirect('admin/dashboard');
                } else {
                    $data['password_err'] = 'Invalid email or password';
                    
                    $this->view('layouts/header', ['title' => 'Admin Login - ' . APP_NAME]);
                    $this->view('auth/admin-login', $data);
                    $this->view('layouts/footer');
                }
            } else {
                $this->view('layouts/header', ['title' => 'Admin Login - ' . APP_NAME]);
                $this->view('auth/admin-login', $data);
                $this->view('layouts/footer');
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            
            $this->view('layouts/header', ['title' => 'Admin Login - ' . APP_NAME]);
            $this->view('auth/admin-login', $data);
            $this->view('layouts/footer');
        }
    }
    
    public function developerLogin() {
        if($this->isDeveloper()) {
            $this->redirect('developer/dashboard');
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];
            
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            
            if(empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }
            
            if(empty($data['email_err']) && empty($data['password_err'])) {
                $developerModel = $this->model('Developer');
                
                $loggedInDev = $developerModel->login($data['email'], $data['password']);
                
                if($loggedInDev) {
                    $_SESSION['developer_id'] = $loggedInDev['id'];
                    $_SESSION['developer_email'] = $loggedInDev['email'];
                    $_SESSION['developer_name'] = $loggedInDev['company_name'];
                    
                    $this->redirect('developer/dashboard');
                } else {
                    $data['password_err'] = 'Invalid email or password';
                    
                    $this->view('layouts/header', ['title' => 'Developer Login - ' . APP_NAME]);
                    $this->view('auth/developer-login', $data);
                    $this->view('layouts/footer');
                }
            } else {
                $this->view('layouts/header', ['title' => 'Developer Login - ' . APP_NAME]);
                $this->view('auth/developer-login', $data);
                $this->view('layouts/footer');
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            
            $this->view('layouts/header', ['title' => 'Developer Login - ' . APP_NAME]);
            $this->view('auth/developer-login', $data);
            $this->view('layouts/footer');
        }
    }
    
    public function adminLogout() {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_name']);
        session_destroy();
        $this->redirect('auth/admin-login');
    }
    
    public function developerLogout() {
        unset($_SESSION['developer_id']);
        unset($_SESSION['developer_email']);
        unset($_SESSION['developer_name']);
        session_destroy();
        $this->redirect('auth/developer-login');
    }
}
?>  