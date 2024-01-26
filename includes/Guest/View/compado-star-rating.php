<?php if (!defined('ABSPATH')) exit; ?>

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