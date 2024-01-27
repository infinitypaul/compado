<?php if (!defined('ABSPATH')) exit;
$options = get_option('compado_products_options');
$cache_duration = $options['cache_duration'] ?? '';
?>

<div class="compado-field">
    <input type="number" id="compado_cache_duration" name="compado_products_options[cache_duration]" value="<?php echo esc_attr($cache_duration); ?>"  min="0">
</div>
