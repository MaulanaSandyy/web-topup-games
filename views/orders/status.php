<section class="status-page">
    <div class="container">
        <div class="status-header">
            <h1 class="page-title">Order <span class="neon-text">Status</span></h1>
        </div>
        
        <div class="status-content">
            <div class="status-card">
                <div class="status-icon">
                    <?php
                    $statusIcon = '';
                    $statusClass = '';
                    
                    switch($data['order']['status']) {
                        case 'pending':
                            $statusIcon = 'fa-clock';
                            $statusClass = 'status-pending';
                            break;
                        case 'processing':
                            $statusIcon = 'fa-spinner fa-spin';
                            $statusClass = 'status-processing';
                            break;
                        case 'completed':
                            $statusIcon = 'fa-check-circle';
                            $statusClass = 'status-completed';
                            break;
                        case 'failed':
                            $statusIcon = 'fa-times-circle';
                            $statusClass = 'status-failed';
                            break;
                        case 'cancelled':
                            $statusIcon = 'fa-ban';
                            $statusClass = 'status-cancelled';
                            break;
                    }
                    ?>
                    <i class="fas <?php echo $statusIcon; ?> <?php echo $statusClass; ?>"></i>
                </div>
                
                <h2 class="status-title">Order <?php echo ucfirst($data['order']['status']); ?></h2>
                <p class="order-number">Order #<?php echo $data['order']['order_number']; ?></p>
                
                <div class="status-timeline">
                    <div class="timeline-item <?php echo $data['order']['status'] != 'pending' ? 'completed' : ''; ?>">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Order Created</h4>
                            <p><?php echo date('d M Y H:i', strtotime($data['order']['created_at'])); ?></p>
                        </div>
                    </div>
                    
                    <div class="timeline-item <?php echo in_array($data['order']['status'], ['processing', 'completed']) ? 'completed' : ''; ?>">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Payment <?php echo $data['payment'] ? ($data['payment']['payment_status'] == 'paid' ? 'Completed' : 'Processing') : 'Pending'; ?></h4>
                            <?php if($data['payment'] && $data['payment']['paid_at']): ?>
                                <p><?php echo date('d M Y H:i', strtotime($data['payment']['paid_at'])); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="timeline-item <?php echo $data['order']['status'] == 'completed' ? 'completed' : ''; ?>">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h4>Order Completed</h4>
                            <?php if($data['order']['status'] == 'completed'): ?>
                                <p><?php echo date('d M Y H:i', strtotime($data['order']['updated_at'])); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="order-details">
                    <h3>Order Details</h3>
                    <table class="details-table">
                        <tr>
                            <td>Game:</td>
                            <td><strong><?php echo $data['order']['game_name']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Nominal:</td>
                            <td><strong><?php echo $data['order']['nominal_name']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Game Account:</td>
                            <td><strong><?php echo $data['order']['game_account_id']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Server:</td>
                            <td><strong><?php echo $data['order']['game_account_server'] ?: '-'; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Customer Name:</td>
                            <td><strong><?php echo $data['order']['customer_name']; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Total Amount:</td>
                            <td><strong class="neon-text">Rp <?php echo number_format($data['order']['total_amount'], 0, ',', '.'); ?></strong></td>
                        </tr>
                        <?php if($data['payment']): ?>
                        <tr>
                            <td>Payment Method:</td>
                            <td><strong><?php echo $data['payment']['payment_method']; ?></strong></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                
                <?php if($data['order']['status'] == 'pending'): ?>
                <div class="status-actions">
                    <a href="<?php echo APP_URL; ?>/order/payment/<?php echo $data['order']['id']; ?>" class="btn btn-primary">
                        <i class="fas fa-credit-card"></i> Complete Payment
                    </a>
                </div>
                <?php endif; ?>
                
                <?php if($data['order']['status'] == 'completed'): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <p>Your top up has been successfully processed! Enjoy your game!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>