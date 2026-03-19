<section class="payment-page">
    <div class="container">
        <div class="payment-header">
            <h1 class="page-title">Complete Your <span class="neon-text">Payment</span></h1>
            <div class="order-progress">
                <div class="progress-step completed">
                    <span class="step-number">1</span>
                    <span class="step-label">Game Details</span>
                </div>
                <div class="progress-step completed">
                    <span class="step-number">2</span>
                    <span class="step-label">Select Nominal</span>
                </div>
                <div class="progress-step active">
                    <span class="step-number">3</span>
                    <span class="step-label">Payment</span>
                </div>
                <div class="progress-step">
                    <span class="step-number">4</span>
                    <span class="step-label">Complete</span>
                </div>
            </div>
        </div>
        
        <div class="payment-content">
            <div class="order-details-card">
                <h3 class="card-title">Order Details</h3>
                <div class="order-info">
                    <div class="info-row">
                        <span>Order Number:</span>
                        <strong><?php echo $data['order']['order_number']; ?></strong>
                    </div>
                    <div class="info-row">
                        <span>Game:</span>
                        <strong><?php echo $data['order']['game_name']; ?></strong>
                    </div>
                    <div class="info-row">
                        <span>Nominal:</span>
                        <strong><?php echo $data['order']['nominal_name']; ?></strong>
                    </div>
                    <div class="info-row">
                        <span>Account ID:</span>
                        <strong><?php echo $data['order']['game_account_id']; ?></strong>
                    </div>
                    <div class="info-row total">
                        <span>Total Payment:</span>
                        <strong class="neon-text">Rp <?php echo number_format($data['order']['total_amount'], 0, ',', '.'); ?></strong>
                    </div>
                </div>
            </div>
            
            <div class="payment-methods-card">
                <h3 class="card-title">Choose Payment Method</h3>
                
                <form action="<?php echo APP_URL; ?>/order/processPayment" method="POST" class="payment-form" id="paymentForm">
                    <input type="hidden" name="order_id" value="<?php echo $data['order']['id']; ?>">
                    <input type="hidden" name="amount" value="<?php echo $data['order']['total_amount']; ?>">
                    
                    <div class="payment-methods-grid">
                        <!-- Dummy Payment Methods -->
                        <div class="payment-method">
                            <input type="radio" name="payment_method" id="method_bca" value="BCA Virtual Account" required>
                            <label for="method_bca" class="method-label">
                                <i class="fas fa-university"></i>
                                <span class="method-name">BCA Virtual Account</span>
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" name="payment_method" id="method_mandiri" value="Mandiri Virtual Account">
                            <label for="method_mandiri" class="method-label">
                                <i class="fas fa-university"></i>
                                <span class="method-name">Mandiri Virtual Account</span>
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" name="payment_method" id="method_gopay" value="GoPay">
                            <label for="method_gopay" class="method-label">
                                <i class="fas fa-wallet"></i>
                                <span class="method-name">GoPay</span>
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" name="payment_method" id="method_ovo" value="OVO">
                            <label for="method_ovo" class="method-label">
                                <i class="fas fa-mobile-alt"></i>
                                <span class="method-name">OVO</span>
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" name="payment_method" id="method_dana" value="DANA">
                            <label for="method_dana" class="method-label">
                                <i class="fas fa-mobile-alt"></i>
                                <span class="method-name">DANA</span>
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" name="payment_method" id="method_alfamart" value="Alfamart">
                            <label for="method_alfamart" class="method-label">
                                <i class="fas fa-store"></i>
                                <span class="method-name">Alfamart</span>
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" name="payment_method" id="method_indomaret" value="Indomaret">
                            <label for="method_indomaret" class="method-label">
                                <i class="fas fa-store"></i>
                                <span class="method-name">Indomaret</span>
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" name="payment_method" id="method_credit" value="Credit Card">
                            <label for="method_credit" class="method-label">
                                <i class="fas fa-credit-card"></i>
                                <span class="method-name">Credit Card</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="payment-instructions" id="paymentInstructions" style="display: none;">
                        <div class="instructions-content">
                            <h4>Payment Instructions</h4>
                            <div id="instructionText"></div>
                        </div>
                    </div>
                    
                    <div class="payment-actions">
                        <button type="submit" class="btn btn-primary btn-large btn-block" id="payButton">
                            <i class="fas fa-lock"></i> Pay Now
                        </button>
                        <p class="payment-security">
                            <i class="fas fa-shield-alt"></i> Your payment is secure and encrypted
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const instructionsDiv = document.getElementById('paymentInstructions');
    const instructionText = document.getElementById('instructionText');
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            const methodName = this.value;
            let instructions = '';
            
            // Dummy instructions based on payment method
            switch(methodName) {
                case 'BCA Virtual Account':
                    instructions = `
                        <p>1. Go to any BCA ATM or BCA mobile banking</p>
                        <p>2. Select "Virtual Account" menu</p>
                        <p>3. Enter BCA Virtual Account Number: <strong>88012<?php echo $data['order']['id']; ?></strong></p>
                        <p>4. Confirm payment amount: Rp <?php echo number_format($data['order']['total_amount'], 0, ',', '.'); ?></p>
                        <p>5. Complete the transaction</p>
                    `;
                    break;
                case 'GoPay':
                    instructions = `
                        <p>1. Open Gojek app on your phone</p>
                        <p>2. Select "Pay" or "Scan QR"</p>
                        <p>3. Scan the QR code or enter GoPay number</p>
                        <p>4. Confirm payment amount</p>
                        <p>5. Enter your PIN to complete</p>
                    `;
                    break;
                default:
                    instructions = `
                        <p>1. Follow the payment instructions from your selected method</p>
                        <p>2. Complete the payment within 24 hours</p>
                        <p>3. After payment, your order will be processed automatically</p>
                    `;
            }
            
            instructionText.innerHTML = instructions;
            instructionsDiv.style.display = 'block';
        });
    });
});
</script>