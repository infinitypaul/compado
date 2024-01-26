<?php

namespace Compado\Products;

class PluginActivator
{
    public static function activate(): void
    {
        add_rewrite_rule('^compado-redirect/(.+)', 'index.php?compado_redirect=$matches[1]', 'top');
        flush_rewrite_rules();
    }

    public static function deactivate(): void
    {
        flush_rewrite_rules();
        delete_transient(ApiClient::TRANSIENT_KEY);
        // delete_option('compado_products_options');
    }
}