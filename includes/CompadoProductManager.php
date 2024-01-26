<?php

namespace Compado\Products;
defined('ABSPATH') || exit;
class CompadoProductManager
{
    private CompadoApiClient $client;
    private CompadoRenderer $renderer;

    /**
     * @param CompadoApiClient $client
     * @param CompadoRenderer $renderer
     */
    public function __construct(CompadoApiClient $client, CompadoRenderer $renderer){

        $this->client = $client;
        $this->renderer = $renderer;
    }
    public function run(): void
    {
        add_shortcode('compado_products', [$this, 'displayProducts']);
        add_action('template_redirect', [$this, 'handle_custom_redirect']);
        add_filter('query_vars', [$this, 'register_query_vars']);
    }

    public function enqueueAssets(): void
    {
        wp_enqueue_style('compado-style', plugin_dir_url(__FILE__) . '../assets/css/style.css');
        wp_enqueue_script('compado-script', plugin_dir_url(__FILE__) . '../assets/js/script.js', ['jquery'], true, true);
    }

    public function displayProducts(): string
    {
        $this->enqueueAssets();
        $products = $this->client->getProducts();
        return $this->renderer->render($products);
    }

    public function register_query_vars($vars) {
        $vars[] = 'compado_redirect';
        $vars[] = 'param';
        return $vars;
    }

    public function handle_custom_redirect(): void
    {
        global $wp_query;

        if (isset($wp_query->query_vars['compado_redirect'])) {
            $path_segment = $wp_query->query_vars['compado_redirect'];

            $actual_redirect_url = 'https://api.compado.com/' . $path_segment;

            wp_redirect($actual_redirect_url);
            exit;
        }
    }
}