<?php if (!defined('ABSPATH')) exit; ?>

<div class="compado-products-container">
    <?php if (empty($products) || empty($products['partners']) || !is_array($products['partners'])): ?>
        <h1><?php echo esc_html__('No products found.', 'compado-product-list'); ?></h1>
    <?php else: ?>
        <?php foreach ($products['partners'] as $product): ?>
            <section>
                <?php include plugin_dir_path(__FILE__) . 'compado_single-product.php'; ?>
            </section>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
