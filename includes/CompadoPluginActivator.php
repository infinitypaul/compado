<?php

namespace Compado\Products;
use Compado\Products\Helper\Config;

defined('ABSPATH') || exit;
class CompadoPluginActivator
{
    /**
     * Activates the plugin by adding a rewrite rule and flushing the rewrite rules.
     *
     * @return void
     */
    public static function activate(): void
    {
        add_rewrite_rule(
            '^' . Config::QUERY_VAR_REDIRECT . '/(.+)',
            'index.php?' . Config::QUERY_VAR_REDIRECT . '=$matches[1]',
            'top'
        );
        flush_rewrite_rules();
    }

    /**
     * Deactivates the plugin by performing necessary cleanup tasks
     *
     * @return void
     */
    public static function deactivate(): void
    {
        flush_rewrite_rules();
        delete_transient(Config::TRANSIENT_KEY);
        // delete_option('compado_products_options');
    }
}