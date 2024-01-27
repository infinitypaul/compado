<?php

namespace Compado\Products;

use Compado\Products\Helper\Config;

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
            Config::TEXT_DOMAIN,
            false,
            dirname( plugin_basename( __FILE__ ) ) . '/languages/'
        );
    }
}