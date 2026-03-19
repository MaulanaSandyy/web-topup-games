<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? APP_NAME; ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/assets/css/style.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="<?php echo APP_URL; ?>" class="logo">
                    <span class="neon-text">TOPUP</span> GAME
                </a>
            </div>
            
            <div class="nav-menu">
                <ul class="nav-links">
                    <li><a href="<?php echo APP_URL; ?>" class="nav-link">Home</a></li>
                    <li><a href="<?php echo APP_URL; ?>/game" class="nav-link">Games</a></li>
                    <li><a href="<?php echo APP_URL; ?>/order/status" class="nav-link">Check Order</a></li>
                </ul>
                
                <div class="nav-auth">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <button class="dropdown-btn">
                                <i class="fas fa-user"></i> <?php echo $_SESSION['user_name']; ?>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-content">
                                <a href="<?php echo APP_URL; ?>/user/dashboard">Dashboard</a>
                                <a href="<?php echo APP_URL; ?>/user/orders">My Orders</a>
                                <a href="<?php echo APP_URL; ?>/auth/logout">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo APP_URL; ?>/auth/login" class="btn btn-primary">Login</a>
                        <a href="<?php echo APP_URL; ?>/auth/register" class="btn btn-secondary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="nav-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
    
    <main class="main-content">