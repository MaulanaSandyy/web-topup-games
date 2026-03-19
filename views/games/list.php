<section class="page-header">
    <div class="container">
        <h1 class="page-title">All <span class="neon-text">Games</span></h1>
        <p class="page-subtitle">Choose your favorite game and top up now</p>
    </div>
</section>

<section class="games-section">
    <div class="container">
        <div class="games-filter">
            <input type="text" id="searchGame" placeholder="Search games..." class="search-input">
            <select id="sortGames" class="sort-select">
                <option value="name">Sort by Name</option>
                <option value="popular">Most Popular</option>
                <option value="newest">Newest</option>
            </select>
        </div>
        
        <div class="games-grid" id="gamesContainer">
            <?php foreach($data['games'] as $game): ?>
            <div class="game-card" data-game="<?php echo $game['game_slug']; ?>">
                <div class="game-card-inner">
                    <div class="game-badge">HOT</div>
                    <div class="game-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h3 class="game-name"><?php echo $game['game_name']; ?></h3>
                    <p class="game-description"><?php echo substr($game['description'], 0, 80); ?>...</p>
                    <div class="game-price-range">
                        <span class="price-label">Starting from</span>
                        <span class="price-value">Rp 12,000</span>
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