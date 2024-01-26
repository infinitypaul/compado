<?php if (!isset($product)) return;
$redirectUrl = home_url('/compado-redirect/') . urldecode($product['api_exitover_url']);

?>

<div class="compado-product">
    <div class="header">Today's #1 Meal Delivery Service!</div>

    <div class="main-content">
        <img src="<?php echo esc_url($product['logo_image']); ?>" alt="<?php echo esc_attr($product['partner_name']); ?>" class="logo">
        <div>
            <h1><?php echo esc_html($product['partner_name']); ?></h1>
            <p>Create unique & delicious meals with <?php echo esc_html($product['partner_name']); ?>'s easy-to-use meal kits delivered right to you.</p>
            <div class="offer">Get 60% off 1st box, 25% off next 8 boxes + free treats for life!</div>
        </div>
        <div class="rating">
            <?php for ($i = 0; $i < 10; $i++): ?>
                <img src="<?php echo $i < $product['rating'] ? 'path_to_full_star.png' : 'path_to_empty_star.png'; ?>" alt="Star" class="star">
            <?php endfor; ?>
            <span><?php echo esc_html($product['rating']); ?></span>
        </div>
    </div>

    <?php if (isset($product['info_icons'])): ?>
        <div class="info-icons">
            <?php foreach ($product['info_icons'] as $icon): ?>
                <img src="<?php echo esc_url($icon); ?>" alt="Icon description">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="buttons">
        <button class="button" onclick="location.href='<?php echo esc_url($redirectUrl); ?>'">View Plan</button>
        <button class="button">Read More</button>
    </div>
</div>
