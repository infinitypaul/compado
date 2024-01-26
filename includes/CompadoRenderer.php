<?php

namespace Compado\Products;
defined('ABSPATH') || exit;
class CompadoRenderer
{
    /**
     * Renders the HTML view of a list of products.
     *
     * @param array $products An array of product objects to be rendered in the list.
     * @return string The generated HTML code representing the products list.
     */
    public function render(array $products): string
    {
        ob_start();
        include 'Guest/View/compado_products-list.php';
        return ob_get_clean();
    }

}
