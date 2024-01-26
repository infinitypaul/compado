<?php if (!isset($product)) return;
$redirectUrl = home_url('/compado-redirect/') . urldecode($product['api_exitover_url']);
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
                    class="img"
            />
        </div>
        <div class="compado-text-container">
            <h2 class="compado-service-title"><?php echo esc_html($product['partner_name']); ?>!</h2>
            <p class="compado-service-description">
                <?= strip_tags(esc_html($product['introduction']), 'ul, li') ?>
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
            <span class="compado-rating"><?=  esc_html($product['score']) ?></span>
            <span class="compado-stars">
                <?php
                $rating = floatval($product['rating']);
                $fullStars = floor($rating);
                $halfStar = $rating - $fullStars > 0 ? 1 : 0;
                $totalStars = 5;
                for ($i = 0; $i < $totalStars; $i++): ?>
                    <?php if ($i < $fullStars): ?>
                        <i class="fa fa-star"></i>
                    <?php elseif ($halfStar && $i === $fullStars): ?>
                        <i class="fa fa-star-half-o"></i>
                    <?php else: ?>
                        <i class="fa fa-star-o"></i>
                    <?php endif; ?>
                <?php endfor; ?>
          </span>
        </div>
    </div>
    <div class="compado-bottom">
        <?=  \Compado\Products\Helper\CompadoMisc::generate_icons_html($product['icons']) ?>
        <button class="compado-plan-btn" onclick="location.href='<?php echo esc_url($redirectUrl); ?>'">View Plan</button>
    </div>
    <div class="compado-hidden-container">
        <ul class="list">
            <li class="item">
                <i class="fa fa-check"></i>
                Save time & money, avoid long lines & high prices at supermarkets
            </li>
            <li class="item">
                <i class="fa fa-check"></i>
                Personalise your plan to deliver the food you want when you want
            </li>
            <li class="item">
                <i class="fa fa-check"></i>
                Make changes at any time using HelloFresh's user-friendly app
            </li>
        </ul>
        <div class="compado-img-container">
            <img
                    src="https://media.api-domain-compado.com/media/phpnQRJxy.jpg"
                    alt=""
                    class="img"
            />
        </div>
    </div>
    <div class="compado-read-more">
        <a href="#" class="compado-read-more-link"
        >Read More
            <i class="fa fa-chevron-down"></i>
        </a>
    </div>
</div>
