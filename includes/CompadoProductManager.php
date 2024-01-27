<?php

namespace Compado\Products;
use Compado\Products\Admin\CompadoAdmin;
use Compado\Products\Helper\Config;
use WP_Query;

defined('ABSPATH') || exit;
class CompadoProductManager
{
    /**
     * @var CompadoApiClient
     */
    private $client;

    /**
     * @var CompadoRenderer
     */
    private $renderer;

    /**
     * Constructs a new instance of the class.
     *
     * @param CompadoApiClient $client The instance of `CompadoApiClient` to be used by the class.
     * @param CompadoRenderer $renderer The instance of `CompadoRenderer` to be used by the class.
     * @return void
     */
    public function __construct(CompadoApiClient $client, CompadoRenderer $renderer){

        $this->client = $client;
        $this->renderer = $renderer;
        $this->set_locale();
    }

    /**
     * Runs the necessary actions, shortcodes, and filters for the plugin to function properly.
     *
     * @return void
     */
    public function run(): void
    {
        add_action('template_redirect', [$this, 'handle_custom_redirect']);
        add_filter('query_vars', [$this, 'register_query_vars']);
        add_shortcode(Config::SHORTCODE_PRODUCTS, [$this, 'displayProducts']);

        if (is_admin()) {
            CompadoAdmin::register_hooks();
        }
    }

    /**
     * Sets the locale for the plugin.
     *
     * @return void
     */
    private function set_locale(): void
    {
        add_action('plugins_loaded', ['Compado\Products\CompadoI18n', 'load_textdomain']);
    }

    /**
     * @return void
     */
    private function enqueueAssets(): void {
        wp_enqueue_style(
            Config::STYLE_HANDLE,
            plugin_dir_url(__FILE__) . Config::CSS_PATH,
            [],
            Config::PLUGIN_VERSION
        );
        wp_enqueue_script(
            Config::SCRIPT_HANDLE,
            plugin_dir_url(__FILE__) . Config::JS_PATH,
            ['jquery'],
            Config::PLUGIN_VERSION,
            true
        );
    }

    /**
     * Displays the products on the frontend.
     *
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
    public function register_query_vars(array $vars): array
    {
        $vars[] = Config::QUERY_VAR_REDIRECT;
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

        if (isset($wp_query->query_vars[Config::QUERY_VAR_REDIRECT])) {
            $path_segment = $wp_query->query_vars[Config::QUERY_VAR_REDIRECT];

            $actual_redirect_url = esc_url('https://api.compado.com/' . $path_segment);

            wp_redirect($actual_redirect_url);
            exit;
        }
    }
}
