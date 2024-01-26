<?php

namespace Compado\Products;

class PluginActivator
{
    public static function activate() {
        add_rewrite_rule('^compado-redirect/(.+)', 'index.php?compado_redirect=$matches[1]', 'top');
        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }
}