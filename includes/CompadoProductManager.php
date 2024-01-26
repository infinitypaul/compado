<?php

namespace Compado\Products;
use WP_Query;

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

    /**
     * Runs the necessary actions, shortcodes, and filters for the plugin to function properly.
     *
     * This method adds action hooks to enqueue assets, register a shortcode, and handle custom redirects. It also adds a filter to register query vars.
     * These actions and filters are essential for the plugin to work as intended.
     *
     * @return void
     */
    public function run(): void
    {
        add_shortcode('compado_products', [$this, 'displayProducts']);
        add_action('template_redirect', [$this, 'handle_custom_redirect']);
        add_filter('query_vars', [$this, 'register_query_vars']);
    }

    /**
     * @return void
     */
    public function enqueueAssets(): void
    {
        wp_enqueue_style('compado-style', plugin_dir_url(__FILE__) . '../assets/css/style.css');
        wp_enqueue_script('compado-script', plugin_dir_url(__FILE__) . '../assets/js/script.js', ['jquery'], false, true);
    }

    /**
     * Displays the products on the frontend.
     *
     * This method enqueues necessary assets, retrieves the products from the client, and renders them using the renderer.
     * The products are then returned as a string to be displayed on the frontend.
     *
     * @return string The HTML representation of the products.
     */
    public function displayProducts(): string
    {
        $this->enqueueAssets();
        $products = $this->client->getProducts();
        return $this->renderer->render($products);
    }

    /**
     * Registers custom query variables for the plugin.
     *
     * @param array $vars The array of query variables.
     * @return array The modified array of query variables.
     */
    public function register_query_vars($vars): mixed
    {
        $vars[] = 'compado_redirect';
        return $vars;
    }

    /**
     * Handles the custom redirect for the plugin.
     *
     * @return void
     * @global WP_Query $wp_query The global WP_Query object.
     *
     */
    public function handle_custom_redirect(): void
    {
        global $wp_query;

        if (isset($wp_query->query_vars['compado_redirect'])) {
            $path_segment = $wp_query->query_vars['compado_redirect'];

            $actual_redirect_url = esc_url('https://api.compado.com/' . $path_segment);

            wp_redirect($actual_redirect_url);
            exit;
        }
    }
}
