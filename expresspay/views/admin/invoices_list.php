<?php include __DIR__ . '\admin_header.php';?>
<style>
    i.icon,
    a.icon {
        background-image: url("<?php echo expresspay_assets_url('img/icons_grid15x.png'); ?>") !important;
    }
</style>
<div class="add_pay_method_link">
    <a href="<?php echo osc_esc_html(osc_route_admin_url('expresspay-admin-options', array('id' => 0))); ?>"><?php _e('Add a payment method', 'expresspay') ?></a>
</div>
<div class="row">
    <div class="header-table col-md-12">
        <div class="col-md-2"><?php _e('Account number', 'expresspay') ?></div>
        <div class="col-md-2"><?php _e('Amount', 'expresspay') ?></div>
        <div class="col-md-2"><?php _e('Email', 'expresspay') ?></div>
        <div class="col-md-2"><?php _e('Date of creation', 'expresspay') ?></div>
        <div class="col-md-2"><?php _e('Status', 'expresspay') ?></div>
        <div class="col-md-2"><?php _e('Payment date', 'expresspay') ?></div>
    </div>
    <div class="content col-md-12" style="text-align: center;">
        <?php $response = expresspay_get_invoices_list();?>
        <?php foreach ($response as $row) : ?>
            <div class="table-row">
                <div class="col-md-2"><p><?php echo osc_esc_html($row['id']); ?></p></div>
                <div class="col-md-2"><p><?php echo osc_esc_html($row['amount'] . ' BYN'); ?></p></div>
                <div class="col-md-2"><p><?php 
                    $extra_array = osp_get_custom($row['extra']);
                    echo osc_esc_html($extra_array['email']); ?></p></div>
                <div class="col-md-2"><p><?php echo osc_esc_html($row['datecreated']); ?></p></div>
                <div class="col-md-2"><p>
                    <?php
                    switch ($row->status) {
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
                    }
                    ?>
                </p></div>
                <div class="col-md-2"><p><?php echo osc_esc_html($row['dateofpayment']); ?></p></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include __DIR__  . '\admin_footer.php';?>