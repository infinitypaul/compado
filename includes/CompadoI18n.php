<?php

namespace Compado\Products;

class CompadoI18n
{
    /**
     * Loads the text domain for the plugin.
     *
     * @return void
     */
    public static function load_textdomain(): void
    {
        load_plugin_textdomain(
            'compado-product-list',
            false,
            dirname( plugin_basename( __FILE__ ) ) . '/languages/'
        );
    }
}