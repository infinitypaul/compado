<?php if (!defined('ABSPATH')) exit; ?>

<div class="compado-carousel">
    <div class="carousel-images">
        <?php
        foreach ($coverImages as $index => $coverImage) {
            if ($coverImage) {
                $isActive = $index === 0 ? ' active' : '';
                echo '<img src="https://media.api-domain-compado.com/' . esc_attr($coverImage) . '" alt="" class="img' . $isActive . '">';
            }
        }
        ?>
    </div>
    <div class="carousel-dots">
        <span class="dot active" data-slide="0"></span>
        <span class="dot" data-slide="1"></span>
        <span class="dot" data-slide="2"></span>
    </div>

</div>
<div class="compado-carousel-buttons">
    <button class="compado-plan-btn compado-plan-btn-open" data-product-id="<?php echo $product['partner_id']; ?>" onclick="location.href='<?php echo esc_url($redirectUrl); ?>'">View Plan</button>
</div>