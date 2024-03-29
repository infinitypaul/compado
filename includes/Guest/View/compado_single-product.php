<?php if (!defined('ABSPATH')) exit; ?>

<?php if (!isset($product)) return;
$redirectUrl = home_url('/'.\Compado\Products\Helper\Config::QUERY_VAR_REDIRECT.'/') . urldecode($product['api_exitover_url']);

$coverImages = [
    $product['cover_image'] ?? '',
    $product['marketing_properties']['cover_image_2'] ?? '',
    $product['marketing_properties']['cover_image_3'] ?? '',
];

?>

<div class="compado-container">
    <?php
    if(!empty($product['marketing_properties']['bubble'])){
    ?>
    <div class="compado-top">
        <small class=""><?= esc_html($product['marketing_properties']['bubble']) ?></small>
    </div>
    <?php
    }
    ?>

    <div class="compado-inner">
        <div class="compado-img-container">
            <img
                    src="https://media.api-domain-compado.com/<?= esc_html($product['logo_image']) ?>?d=200x120&q=100"
                    alt="<?php echo esc_html($product['partner_name']); ?>"
                    loading="lazy"
                    class="img"
            />
        </div>
        <div class="compado-text-container">
            <h2 class="compado-service-title"><?php echo esc_html($product['partner_name']); ?>!</h2>
            <p class="compado-service-description">
                <?= wp_kses_post($product['pricing']) ?>
            </p>
            <?php
            if(isset($product['marketing_properties']['discount_button'])){
                ?>

                <div class="compado-info-box">
                    <a href="<?php echo esc_url($redirectUrl); ?>" target="_blank" class="compado-info-link"
                    ><?php echo esc_html($product['marketing_properties']['discount_button']); ?></a
                    >
                </div>
                <?php
            }

            ?>

        </div>
        <div class="compado-right">
            <?php include 'compado-star-rating.php'?>
        </div>
    </div>
    <div class="compado-bottom">
        <?= (new \Compado\Products\Helper\IconGenerator())->generate_icons_html($product['icons'], $product['partner_id']) ?>
        <button class="compado-plan-btn compado-plan-btn-closed" data-product-id="<?php echo $product['partner_id']; ?>" onclick="location.href='<?php echo esc_url($redirectUrl); ?>'">View Plan</button>
    </div>
<div class="compado-hidden-container" id="hiddenContainer<?php echo $product['partner_id']; ?>">
    <?php
    if (!empty($product['introduction'])) {
        echo \Compado\Products\Helper\CompadoHelper::extract_ul_from_html($product['introduction']);
    }
    ?>

        <div class="compado-img-container">
            <?php include "compado-carousel.php"; ?>
        </div>


    </div>
    <div class="compado-read-more">

        <a href="javascript:void(0);" data-target="hiddenContainer<?php echo $product['partner_id']; ?>" data-product-id="<?php echo $product['partner_id']; ?>" class="compadoReadMoreToggle compado-read-more-link">Read More <i class="fa fa-chevron-down"></i></a>
    </div>
</div>
