<?php

namespace Compado\Products;

class ApiClient
{
    /**
     * The key used for caching the compado products transient.
     *
     * @var string TRANSIENT_KEY
     */
    const TRANSIENT_KEY = 'compado_products';
    /**
     * The default URI for the API endpoint.
     *
     * @var string DEFAULT_URI
     */
    const DEFAULT_URI = "https://api.compado.com/v2_1/host/205/category/home/default";
    /**
     * The default cache duration in seconds.
     *
     * @var int DEFAULT_CACHE_DURATION Default cache duration is 6 hours.
     */
    const DEFAULT_CACHE_DURATION = HOUR_IN_SECONDS * 6;

    /**
     * Retrieves the products. If the products are already cached, the cached products are returned.
     * Otherwise, the products are fetched from the API, cached, and then returned.
     *
     * @return array The array of products.
     */
    public function getProducts() {
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
            $cache_duration = $options['cache_duration'] ?? self::DEFAULT_CACHE_DURATION;
            set_transient(self::TRANSIENT_KEY, $products, intval($cache_duration));
        }
    }

    /**
     * Get cached products.
     *
     * @return mixed The cached products if available, false otherwise.
     */
    protected function getCachedProducts() {
        $options = get_option('compado_products_options');
        if (!empty($options['enable_transient'])) {
            return get_transient(self::TRANSIENT_KEY);
        }

        return false;
    }

    /**
     * Fetch products from the API.
     *
     * @return array The array of fetched products.
     */
    protected function fetchProductsFromApi(): array {
        $options = get_option('compado_products_options');
        $api_endpoint = $options['api_endpoint'] ?? self::DEFAULT_URI;

        $response = wp_remote_get($api_endpoint);

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
     * If the decoded body is not an array or is empty, an error is logged and an empty array is returned.
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
