<?php if (!defined('ABSPATH')) exit;
$options = get_option('compado_products_options');
$checked = '';
if (is_array($options) && isset($options['enable_transient'])) {
    $checked = checked(1, $options['enable_transient'], false);
}
?>
<input type="checkbox" id="compado_enable_transient" name="compado_products_options[enable_transient]" value="1" <?php echo esc_attr($checked); ?>>
<label for="compado_enable_transient"><?php _e('Enable or disable caching', 'compado-product-list'); ?></label>
