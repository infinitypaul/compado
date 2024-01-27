<?php

namespace Compado\Products;
use Compado\Products\Helper\Config;

defined('ABSPATH') || exit;
class CompadoApiClient
{

    /**
     * Retrieves the products. If the products are already cached, the cached products are returned.
     * Otherwise, the products are fetched from the API, cached, and then returned.
     *
     * @return array The array of products.
     */
    public function getProducts(): array
    {
        $cachedProducts = $this->getCachedProducts();

        if ($cachedProducts !== false) {
            return $cachedProducts;
        }

        $products = $this->fetchProductsFromApi();

        $this->cacheProducts($products);

        return $products;
    }

    /**
     * Caches the given products as a transient, if the enable_transient option is set.
     *
     * @param array $products The array of products to be cached.
     * @return void
     */
    protected function cacheProducts(array $products): void {
        $options = get_option('compado_products_options');
        if (!empty($options['enable_transient'])) {
            $cache_duration = $options['cache_duration'] ?? Config::DEFAULT_CACHE_DURATION;
            set_transient(Config::TRANSIENT_KEY, $products, intval($cache_duration));
        }
    }


    /**
     * Retrieves the cached products from the transient, if the enable_transient option is set.
     *
     * @return mixed|array|bool The cached products, or false if caching is not enabled.
     */
    protected function getCachedProducts()
    {
        $options = get_option('compado_products_options');
        if (!empty($options['enable_transient'])) {
            return get_transient(Config::TRANSIENT_KEY);
        }

        return false;
    }

    /**
     * Fetch products from the API.
     *
     * @return array The array of fetched products.
     */
    protected function fetchProductsFromApi(): array {
        $response = wp_remote_get(Config::API_ENDPOINT);

        if (is_wp_error($response)) {
            $this->logError($response->get_error_message());
            return [];
        }

        if (wp_remote_retrieve_response_code($response) !== 200) {
            $this->logError("API request returned status code: " . wp_remote_retrieve_response_code($response));
            return [];
        }

        return $this->parseApiResponse(wp_remote_retrieve_body($response));
    }

    /**
     * Logs an error message if WP_DEBUG_LOG is defined and set to true.
     *
     * @param string $message The error message to be logged.
     *
     * @return void
     */
    protected function logError(string $message): void {
        if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            error_log($message);
        }
    }

    /**
     * Parses the API response and returns the decoded body as an array.
     *
     * @param string $body The API response body to parse.
     *
     * @return array The decoded body as an array.
     */
    protected function parseApiResponse(string $body): array {
        $decoded_body = json_decode($body, true);

        if (!is_array($decoded_body) || empty($decoded_body)) {
            $this->logError("API response has an unexpected format.");
            return [];
        }

        return $decoded_body;
    }
}
