<div class="header">
    <div class="logo">
        <img src="<?php echo expresspay_assets_url('img/logo.png'); ?>" alt="exspress-pay.by" title="express-pay.by" width="216" height="55">
    </div>
    <div class="title">
        <h2 class="text-center"><?php _e('Service «Express Payments»', 'expresspay') ?></h2>
    </div>
</div>
<div class="header-menu">
    <div class="menu-item">
        <a href="<?php echo osc_esc_html(osc_route_admin_url('expresspay-admin-home')); ?>"<?php if (expresspay_is_route('expresspay-admin-home')) : ?> class="current" <?php endif; ?>><?php _e('Home', 'expresspay') ?></a>
    </div>
    <div class="menu-item">
        <a href="<?php echo osc_esc_html(osc_route_admin_url('expresspay-admin-invoices-list')); ?>"<?php if (expresspay_is_route('expresspay-admin-invoices-list')) : ?> class="current" <?php endif; ?>><?php _e('Invoices and payemnts', 'expresspay') ?></a>
    </div>
    <div class="menu-item">
        <a href="<?php echo osc_esc_html(osc_route_admin_url('expresspay-admin-options-list')); ?>"<?php if (expresspay_is_route('expresspay-admin-options-list')) : ?> class="current" <?php endif; ?>><?php _e('Settings', 'expresspay') ?></a>
    </div>
    <div class="menu-item">
        <a target="_blank" href="https://express-pay.by/extensions/osclass/"><?php _e('Help', 'expresspay') ?></a>
    </div>
</div>