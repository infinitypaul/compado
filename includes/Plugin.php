<?php

namespace Compado\Products;

class Plugin
{
    private ApiClient $client;
    private Renderer $renderer;

    /**
     * @param ApiClient $client
     * @param Renderer $renderer
     */
    public function __construct(ApiClient $client, Renderer $renderer){

        $this->client = $client;
        $this->renderer = $renderer;
    }
    public function run() {
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
        add_shortcode('compado_products', [$this, 'displayProducts']);
    }

    public function enqueueAssets(): void
    {
        wp_enqueue_style('compado-style', plugin_dir_url(__FILE__) . '../assets/css/style.css');
        wp_enqueue_script('compado-script', plugin_dir_url(__FILE__) . '../assets/js/script.js', ['jquery'], false, true);
    }

    public function displayProducts() {
        $products = $this->client->getProducts();
        return $this->renderer->render($products);
    }
}