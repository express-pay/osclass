<?php include __DIR__ . '\admin_header.php';?>
<style>
    .home-page .wrap-menu ul li a:before {
        background: url("<?php echo expresspay_assets_url('img/client_icons_main.png'); ?>") 0 0 no-repeat;
    }
</style>
<div class="home-page">
    <div class="wrap-menu">
        <ul>
            <li class="menu_2">
                <a href="<?php echo osc_esc_html(osc_route_admin_url('expresspay-admin-invoices-list')); ?>">
                    <div class="text"><?php _e('Invoices and', 'expresspay') ?> <br /> <?php _e('payemnts', 'expresspay') ?></div>
                </a>
            </li>
            <li class="menu_3">
                <a href="<?php echo osc_esc_html(osc_route_admin_url('expresspay-admin-options-list')); ?>">
                    <div class="text"> <?php _e('Options', 'expresspay') ?> </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php include __DIR__ . '\admin_footer.php';?>