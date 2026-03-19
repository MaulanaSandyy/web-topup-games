<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">
                Top Up <span class="neon-text">Games</span>
                <br>Instantly & Securely
            </h1>
            <p class="hero-subtitle">Get your favorite game currencies in minutes with the best prices</p>
            
            <div class="hero-cta">
                <a href="<?php echo APP_URL; ?>/game" class="btn btn-primary btn-large">
                    <i class="fas fa-gamepad"></i> Browse Games
                </a>
                <a href="#popular-games" class="btn btn-secondary btn-large">
                    <i class="fas fa-fire"></i> Popular Games
                </a>
            </div>
        </div>
        
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-number">100+</div>
                <div class="stat-label">Games Available</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50K+</div>
                <div class="stat-label">Happy Customers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Customer Support</div>
            </div>
        </div>
    </div>
</section>

<section id="popular-games" class="games-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Popular <span class="neon-text">Games</span></h2>
            <p class="section-subtitle">Choose from our most popular games</p>
        </div>
        
        <div class="games-grid">
            <?php foreach($data['games'] as $game): ?>
            <div class="game-card" data-game="<?php echo $game['game_slug']; ?>">
                <div class="game-card-inner">
                    <div class="game-icon">
                        <i class="fas fa-gamepad"></i>
                        <!-- Replace with actual game icon -->
                    </div>
                    <h3 class="game-name"><?php echo $game['game_name']; ?></h3>
                    <p class="game-description"><?php echo substr($game['description'], 0, 100); ?>...</p>
                    <div class="game-meta">
                        <span class="developer">By <?php echo $game['developer_name'] ?? 'Official'; ?></span>
                    </div>
                    <a href="<?php echo APP_URL; ?>/game/order/<?php echo $game['game_slug']; ?>" class="btn btn-primary btn-block">
                        Top Up Now
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if(empty($data['games'])): ?>
        <div class="no-games">
            <i class="fas fa-gamepad"></i>
            <h3>No Games Available</h3>
            <p>Check back later for new games</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Why Choose <span class="neon-text">Us</span></h2>
            <p class="section-subtitle">We provide the best service for gamers</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Instant Delivery</h3>
                <p>Get your top-up instantly after payment confirmation</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Secure Payment</h3>
                <p>Your payment information is encrypted and secure</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>24/7 Support</h3>
                <p>Our support team is always ready to help you</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-gem"></i>
                </div>
                <h3>Best Prices</h3>
                <p>Competitive prices for all game currencies</p>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Top Up?</h2>
            <p>Join thousands of gamers who already trust us</p>
            <a href="<?php echo APP_URL; ?>/game" class="btn btn-primary btn-large">
                <i class="fas fa-rocket"></i> Start Now
            </a>
        </div>
    </div>
</section>