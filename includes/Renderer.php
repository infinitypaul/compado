<?php

namespace Compado\Products;

class Renderer
{
    public function render($products): string
    {
        if (empty($products)) {
            return '<p>' . esc_html__('No products found.', 'compado-product-list') . '</p>';
        }

        $html = '<div class="compado-products-container">';
        foreach ($products['partners'] as $product) {
            $html .= $this->renderSingleProduct($product);
        }
        $html .= '</div>';

        return $html;
    }

    private function renderSingleProduct($product): string
    {
        $productHtml = '<div class="compado-product">';


        $productHtml .= '<div class="header">Today\'s #1 Meal Delivery Service!</div>';


        $productHtml .= '<div class="main-content">';
//        $productHtml .= '<img src="' . esc_url($product['logo_image']) . '" alt="' . esc_attr($product['partner_name']) . '" class="logo">';
        $productHtml .= '<img src="https://media.api-domain-compado.com/media/phplC7VVf.jpg?d=200x120&q=100" alt="' . esc_attr($product['partner_name']) . '" class="logo">';
        $productHtml .= '<div>';
        $productHtml .= '<h1>' . esc_html($product['partner_name']) . '</h1>';
        $productHtml .= '<p>Create unique & delicious meals with ' . esc_html($product['partner_name']) . '\'s easy-to-use meal kits delivered right to you.</p>';
        $productHtml .= '<div class="offer">Get 60% off 1st box, 25% off next 8 boxes + free treats for life!</div>';
        $productHtml .= '</div>';
        $productHtml .= '<div class="rating">';

        for ($i = 0; $i < 10; $i++) {
            $productHtml .= $i < $product['rating'] ? '<img src="path_to_full_star.png" alt="Star" class="star">' : '<img src="path_to_empty_star.png" alt="Star" class="star">';
        }
        $productHtml .= '<span>' . esc_html($product['rating']) . '</span>';
        $productHtml .= '</div>';
        $productHtml .= '</div>';


        if (isset($product['info_icons'])) {
            $productHtml .= '<div class="info-icons">';
            foreach ($product['info_icons'] as $icon) {
                $productHtml .= '<img src="' . esc_url($icon) . '" alt="Icon description">';
            }
            $productHtml .= '</div>';
        }


        $productHtml .= '<div class="buttons">';
        $productHtml .= '<button class="button">View Plan</button>';
        $productHtml .= '<button class="button">Read More</button>';
        $productHtml .= '</div>';

        $productHtml .= '</div>';

        return $productHtml;
    }
}
