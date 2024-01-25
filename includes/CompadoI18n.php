<?php

namespace Compado\Products;

class CompadoI18n
{
    public static function load_textdomain(): void
    {
        load_plugin_textdomain(
            'compado-product-list',
            false,
            dirname( plugin_basename( __FILE__ ) ) . '/languages/'
        );
    }
}