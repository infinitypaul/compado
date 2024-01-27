<?php if (!defined('ABSPATH')) exit;
$options = get_option('compado_products_options');
$api_endpoint = $options['api_endpoint'] ?? '';
?>

<div class="compado-field">
    <span id="compado_api_endpoint"><?php echo esc_html($api_endpoint); ?></span>
</div>
