<?php

namespace Compado\Products;
defined('ABSPATH') || exit;
class CompadoPluginActivator
{
    public static function activate(): void
    {
        add_rewrite_rule('^compado-redirect/(.+)', 'index.php?compado_redirect=$matches[1]', 'top');
        flush_rewrite_rules();
    }

    public static function deactivate(): void
    {
        flush_rewrite_rules();
        delete_transient(CompadoApiClient::TRANSIENT_KEY);
        // delete_option('compado_products_options');
    }
}