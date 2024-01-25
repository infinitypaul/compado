<?php

namespace Compado\Products;

class Plugin
{

    public function run() {
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    public function enqueueAssets(): void
    {
        wp_enqueue_style('compado-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
        wp_enqueue_script('compado-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', ['jquery'], false, true);
    }
}