<section class="order-page">
    <div class="container">
        <div class="order-header">
            <h1 class="page-title">Top Up <span class="neon-text"><?php echo $data['game']['game_name']; ?></span></h1>
            <div class="order-progress">
                <div class="progress-step active">
                    <span class="step-number">1</span>
                    <span class="step-label">Game Details</span>
                </div>
                <div class="progress-step">
                    <span class="step-number">2</span>
                    <span class="step-label">Select Nominal</span>
                </div>
                <div class="progress-step">
                    <span class="step-number">3</span>
                    <span class="step-label">Payment</span>
                </div>
                <div class="progress-step">
                    <span class="step-number">4</span>
                    <span class="step-label">Complete</span>
                </div>
            </div>
        </div>
        
        <div class="order-content">
            <div class="order-form-container">
                <form action="<?php echo APP_URL; ?>/order/checkout" method="POST" class="order-form" id="orderForm">
                    <input type="hidden" name="game_id" value="<?php echo $data['game']['id']; ?>">
                    
                    <div class="form-section">
                        <h3 class="section-title">Game Account Information</h3>
                        
                        <div class="form-group">
                            <label for="game_account_id" class="form-label">
                                <i class="fas fa-id-card"></i> Game Account ID / User ID
                            </label>
                            <input type="text" 
                                   class="form-control <?php echo isset($data['game_account_id_err']) && !empty($data['game_account_id_err']) ? 'is-invalid' : ''; ?>" 
                                   id="game_account_id" 
                                   name="game_account_id" 
                                   value="<?php echo $data['game_account_id'] ?? ''; ?>"
                                   placeholder="Enter your game account ID"
                                   required>
                            <?php if(isset($data['game_account_id_err']) && !empty($data['game_account_id_err'])): ?>
                                <div class="invalid-feedback"><?php echo $data['game_account_id_err']; ?></div>
                            <?php endif; ?>
                            <small class="form-text">Enter your game ID correctly to avoid mistakes</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="game_account_server" class="form-label">
                                <i class="fas fa-server"></i> Server (Optional)
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="game_account_server" 
                                   name="game_account_server"
                                   value="<?php echo $data['game_account_server'] ?? ''; ?>"
                                   placeholder="Enter your server">
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3 class="section-title">Select Nominal</h3>
                        
                        <div class="nominals-grid" id="nominalsContainer">
                            <?php foreach($data['nominals'] as $nominal): ?>
                            <div class="nominal-card">
                                <input type="radio" 
                                       name="nominal_id" 
                                       id="nominal_<?php echo $nominal['id']; ?>" 
                                       value="<?php echo $nominal['id']; ?>"
                                       data-price="<?php echo $nominal['price']; ?>"
                                       <?php echo (isset($data['nominal_id']) && $data['nominal_id'] == $nominal['id']) ? 'checked' : ''; ?>
                                       required>
                                <label for="nominal_<?php echo $nominal['id']; ?>" class="nominal-label">
                                    <span class="nominal-name"><?php echo $nominal['nominal_name']; ?></span>
                                    <span class="nominal-price">Rp <?php echo number_format($nominal['price'], 0, ',', '.'); ?></span>
                                    <?php if(!empty($nominal['description'])): ?>
                                        <span class="nominal-desc"><?php echo $nominal['description']; ?></span>
                                    <?php endif; ?>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if(isset($data['nominal_id_err']) && !empty($data['nominal_id_err'])): ?>
                            <div class="alert alert-danger"><?php echo $data['nominal_id_err']; ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-section">
                        <h3 class="section-title">Customer Information</h3>
                        
                        <div class="form-group">
                            <label for="customer_name" class="form-label">
                                <i class="fas fa-user"></i> Your Name
                            </label>
                            <input type="text" 
                                   class="form-control <?php echo isset($data['customer_name_err']) && !empty($data['customer_name_err']) ? 'is-invalid' : ''; ?>" 
                                   id="customer_name" 
                                   name="customer_name" 
                                   value="<?php echo $data['customer_name'] ?? ''; ?>"
                                   placeholder="Enter your name"
                                   required>
                            <?php if(isset($data['customer_name_err']) && !empty($data['customer_name_err'])): ?>
                                <div class="invalid-feedback"><?php echo $data['customer_name_err']; ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="customer_email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <input type="email" 
                                       class="form-control <?php echo isset($data['customer_email_err']) && !empty($data['customer_email_err']) ? 'is-invalid' : ''; ?>" 
                                       id="customer_email" 
                                       name="customer_email" 
                                       value="<?php echo $data['customer_email'] ?? ''; ?>"
                                       placeholder="Enter your email">
                                <?php if(isset($data['customer_email_err']) && !empty($data['customer_email_err'])): ?>
                                    <div class="invalid-feedback"><?php echo $data['customer_email_err']; ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="customer_phone" class="form-label">
                                    <i class="fas fa-phone"></i> Phone Number
                                </label>
                                <input type="tel" 
                                       class="form-control <?php echo isset($data['customer_phone_err']) && !empty($data['customer_phone_err']) ? 'is-invalid' : ''; ?>" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       value="<?php echo $data['customer_phone'] ?? ''; ?>"
                                       placeholder="Enter your phone number">
                                <?php if(isset($data['customer_phone_err']) && !empty($data['customer_phone_err'])): ?>
                                    <div class="invalid-feedback"><?php echo $data['customer_phone_err']; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <small class="form-text">We need either email or phone to send order confirmation</small>
                    </div>
                    
                    <div class="order-summary">
                        <h3>Order Summary</h3>
                        <div class="summary-item">
                            <span>Game:</span>
                            <span><?php echo $data['game']['game_name']; ?></span>
                        </div>
                        <div class="summary-item" id="selectedNominalSummary">
                            <span>Nominal:</span>
                            <span class="nominal-placeholder">Select nominal</span>
                        </div>
                        <div class="summary-item total">
                            <span>Total:</span>
                            <span class="total-price" id="totalPrice">Rp 0</span>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large btn-block" id="submitOrder">
                            <i class="fas fa-shopping-cart"></i> Proceed to Checkout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nominals = document.querySelectorAll('input[name="nominal_id"]');
    const totalPriceElement = document.getElementById('totalPrice');
    const selectedNominalSummary = document.getElementById('selectedNominalSummary').querySelector('span:last-child');
    
    nominals.forEach(nominal => {
        nominal.addEventListener('change', function() {
            const price = this.dataset.price;
            const nominalName = this.closest('.nominal-card').querySelector('.nominal-name').textContent;
            
            totalPriceElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
            selectedNominalSummary.textContent = nominalName;
        });
    });
});
</script>