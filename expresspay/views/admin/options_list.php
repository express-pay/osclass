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
        <div class="col-md-3"><?php _e('Name', 'expresspay') ?></div>
        <div class="col-md-3"><?php _e('Type of', 'expresspay') ?></div>
        <div class="col-md-2"><?php _e('Status', 'expresspay') ?></div>
        <div class="col-md-4"><?php _e('Options', 'expresspay') ?></div>
    </div>
    <div class="content col-md-12" style="text-align: center;">
    
    <?php $response = expresspay_get_options_list();?>
        <?php foreach ($response as $row) : ?>
            <div class="table-row">
                <div class="col-md-3"><p><?php echo osc_esc_html($row['name']); ?></p></div>
                <div class="col-md-3"><p><?php 
                switch ($row['type']):
                    case 'erip':
                        _e('ERIP', 'expresspay');
                    break;
                    case 'card':
                        _e('Internet-acquiring', 'expresspay');
                    break;
                    case 'epos';
                    _e('E-POS', 'expresspay');
                    break;
                    endswitch; ?></p></div>
                <div class="col-md-2">
                    <?php if ($row['isactive'] == 1) : ?>
                        <p class="active"><?php _e('Active', 'expresspay') ?></p>
                    <?php else : ?>
                        <p class="diactive"><?php _e('Disable', 'expresspay') ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <p>
                        <a class="icon icon_edit" title="<?php _e('Edit', 'expresspay') ?>" href="<?php echo osc_esc_html(osc_route_admin_url('expresspay-admin-options', array('id' => $row['id']))); ?>"></a>
                        <?php if ($row['isactive'] == 1) : ?>
                            <a class="icon icon_stop" onclick="paymentMethodOptions('payment_setting_off', <?php echo osc_esc_html($row['id']); ?>)" title="<?php _e('Disable', 'expresspay') ?>"></a>
                        <?php else : ?>
                            <a class="icon icon_on"  onclick="paymentMethodOptions('payment_setting_on', <?php echo osc_esc_html($row['id']); ?>)" title="<?php _e('Enable', 'expresspay') ?>"></a>
                        <?php endif; ?>
                        <a class="icon icon_delete"  onclick="paymentMethodOptions('payment_setting_delete', <?php echo osc_esc_html($row['id']); ?>)" title="<?php _e('Delete', 'expresspay') ?>"></a>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include __DIR__  . '\admin_footer.php';?>