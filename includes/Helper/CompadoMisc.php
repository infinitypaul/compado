<?php
namespace Compado\Products\Helper;
class CompadoMisc
{
    public static function generate_icons_html($icons) {
        $base_icon_url = "https://media.api-domain-compado.com/img/icons/partner-icons/";

        $icon_mapping = [
            'mealkits' => ['icon' => 'mealkits.svg', 'text' => 'Meal Kits'],
            'vegetarian' => ['icon' => 'vegetarian.svg', 'text' => 'Vegetarian'],
            'diabetics' => ['icon' => 'diabetics.svg', 'text' => 'Diabetics'],
            'singles' => ['icon' => 'singles.svg', 'text' => 'Singles'],
            'mastercard' => ['icon' => 'mastercard.svg', 'text' => 'Mastercard'],
            'paypal' => ['icon' => 'paypal.svg', 'text' => 'PayPal'],
            'visa' => ['icon' => 'visa.svg', 'text' => 'Visa'],
        ];

        $html = '<div class="compado-icons">';
        foreach ($icons as $category => $value) {
            if ($value) {
                $items = explode('*', $value);
                foreach ($items as $item) {
                    if (empty($item)) {
                        continue;
                    }
                    if (array_key_exists($item, $icon_mapping)) {
                        $icon_info = $icon_mapping[$item];
                        $html .= '<div class="compado-icon-container">';
                        $html .= '<img src="' . $base_icon_url . $icon_info['icon'] . '?q=100&d=32x32&color=686769" alt="' . $icon_info['text'] . '">';
                        $html .= '<span class="compado-icon-text">' . $icon_info['text'] . '</span>';
                        $html .= '</div>';
                    }
                }
            }
        }
        $html .= '</div>';

        return $html;
    }

}