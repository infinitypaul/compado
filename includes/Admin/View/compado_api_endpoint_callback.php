<?php if (!defined('ABSPATH')) exit;
$options = get_option('compado_products_options');
$api_endpoint = $options['api_endpoint'] ?? '';
?>

<div class="compado-field">
    <input type="text" id="compado_api_endpoint" name="compado_products_options[api_endpoint]" value="<?php echo esc_attr($api_endpoint); ?>" size="50">
</div>
