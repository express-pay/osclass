<?php include __DIR__ . '\admin_header.php';?>
<div class="table-list">
    <div class="header-table">
        <div class="cell-2"><?php _e('Account number', 'expresspay') ?></div>
        <div class="cell-2"><?php _e('Amount', 'expresspay') ?></div>
        <div class="cell-2"><?php _e('Email', 'expresspay') ?></div>
        <div class="cell-2"><?php _e('Date of creation', 'expresspay') ?></div>
        <div class="cell-2"><?php _e('Status', 'expresspay') ?></div>
        <div class="cell-2"><?php _e('Payment date', 'expresspay') ?></div>
    </div>
    <div class="content-table">
        <?php $response = expresspay_get_invoices_list();?>
        <?php foreach ($response as $row) : ?>
            <div class="row-table">
                <div class="cell-2 cell-center"><p><?php echo osc_esc_html($row['id']); ?></p></div>
                <div class="cell-2 cell-center"><p><?php echo osc_esc_html($row['amount'] . ' BYN'); ?></p></div>
                <div class="cell-2 cell-center"><p><?php 
                    $extra_array = osp_get_custom($row['extra']);
                    echo osc_esc_html($extra_array['email']); ?></p></div>
                <div class="cell-2 cell-center"><p><?php echo osc_esc_html($row['datecreated']); ?></p></div>
                <div class="cell-2 cell-center"><p>
                    <?php
                    switch ($row['status']) {
                        case 0:
                            _e('During', 'expresspay');
                            break;
                        case 1:
                            _e('Awaiting payment', 'expresspay');
                            break;
                        case 2:
                            _e('Expired', 'expresspay');
                            break;
                        case 3:
                            _e('Paid up', 'expresspay');
                            break;
                        case 4:
                            _e('Paid in part', 'expresspay');
                            break;
                        case 5:
                            _e('Canceled', 'expresspay');
                            break;
                        case 6:
                            _e('Paid with a bank card', 'expresspay');
                            break;
                        case 7:
                            _e('Payment returned', 'expresspay');
                            break;
                    }
                    ?>
                </p></div>
                <div class="cell-2 cell-center"><p><?php echo osc_esc_html($row['dateofpayment']); ?></p></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include __DIR__  . '\admin_footer.php';?>