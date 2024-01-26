<div class="compado-products-container">
    <?php if (empty($products)): ?>
        <p><?php echo esc_html__('No products found.', 'compado-product-list'); ?></p>
    <?php else: ?>
        <?php foreach ($products['partners'] as $product): ?>
            <?php include 'compado_single-product.php';  ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
