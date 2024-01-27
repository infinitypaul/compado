<?php
namespace Compado\Products\Helper;
class IconGenerator
{
    private string $base_icon_url;
    private array $icon_mapping;

    public function __construct() {
        $this->base_icon_url = "https://media.api-domain-compado.com/img/icons/partner-icons/";
        $this->icon_mapping = [
            'mealkits' => ['icon' => 'mealkits.svg', 'text' => 'Meal Kits'],
            'vegetarian' => ['icon' => 'vegetarian.svg', 'text' => 'Vegetarian'],
            'diabetics' => ['icon' => 'diabetics.svg', 'text' => 'Diabetics'],
            'singles' => ['icon' => 'singles.svg', 'text' => 'Singles'],
            'mastercard' => ['icon' => 'mastercard.svg', 'text' => 'Mastercard'],
            'paypal' => ['icon' => 'paypal.svg', 'text' => 'PayPal'],
            'visa' => ['icon' => 'visa.svg', 'text' => 'Visa'],
            'keto' => ['icon' => 'keto.svg', 'text' => 'Keto'],
            'paleo' => ['icon' => 'paleo.svg', 'text' => 'Paleo'],
            'gluten-free' => ['icon' => 'gluten-free.svg', 'text' => 'Gluten Free'],
            'vegan' => ['icon' => 'vegan.svg', 'text' => 'Vegan'],
            'weight-loss' => ['icon' => 'weight-loss.svg', 'text' => 'Weight Loss'],
            'lowcarb' => ['icon' => 'lowcarb.svg', 'text' => 'Low Carb'],
            'preparedmeals' => ['icon' => 'preparedmeals.svg', 'text' => 'Prepared'],
            'juice' => ['icon' => 'juice.svg', 'text' => 'Juice'],
        ];
    }

    /**
     * Generates HTML code for displaying icons.
     *
     * @param array $icons The icons to be displayed.
     * @param int $product_id The ID of the product.
     * @return string The generated HTML code.
     */
    public function generate_icons_html($icons, $product_id): string {
        $html = '<div class="compado-icons">';
        $icon_count = 0;
        $additional_icons_html = '<div id="additional-icons-' . $product_id . '" class="compado-hidden-icons" style="display: none;">';

        foreach ($icons as $category => $value) {
            if ($value) {
                $items = explode('*', $value);
                foreach ($items as $item) {
                    if (empty($item) || !array_key_exists($item, $this->icon_mapping)) {
                        continue;
                    }

                    $icon_info = $this->icon_mapping[$item];
                    $icon_html = '<div class="compado-icon-container" title="' . esc_attr($icon_info['text']) . '">';
                    $icon_html .= '<img src="' . esc_url($this->base_icon_url . $icon_info['icon']) . '?q=100&d=32x32&color=686769" alt="' . esc_attr($icon_info['text']) . '" loading="lazy">';
                    $icon_html .= '<span class="compado-icon-text">' . esc_html($icon_info['text']) . '</span>';
                    $icon_html .= '</div>';

                    if ($icon_count < 6) {
                        $html .= $icon_html;
                    } else {
                        $additional_icons_html .= $icon_html;
                    }

                    $icon_count++;
                }
            }
        }

        $additional_icons_html .= '</div>';

        if ($icon_count > 6) {
            $html .= '<div class="compado-icon-container more-icons" onclick="toggleAdditionalIcons(' . esc_js($product_id) . ', this);" data-product-id="' . esc_attr($product_id) . '" title="More">';
            $html .= '<span class="compado-text-icon">+' . ($icon_count - 6) . '</span>';
            $html .= '<span class="compado-icon-text">More</span>';
            $html .= '</div>';
        }

        $html .= $additional_icons_html;
        $html .= '</div>';

        return $html;
    }

}