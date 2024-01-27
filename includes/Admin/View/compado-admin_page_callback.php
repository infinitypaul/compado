<?php if (!defined('ABSPATH')) exit;
if (!current_user_can('manage_options')) return;
$options = get_option('compado_products_options');
?>
<?php settings_errors(); ?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php settings_fields('compado_products_options_group'); ?>
        <?php do_settings_sections('compado-products'); ?>
        <?php submit_button('Save Settings'); ?>
    </form>
</div>
