<?php

namespace Compado\Products;

class Renderer
{
    public function render($products): string
    {
        ob_start();
        include 'Guest/View/compado_products-list.php';
        return ob_get_clean();
    }

}
