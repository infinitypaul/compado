<?php

namespace Compado\Products;

class ApiClient
{
    const TRANSIENT_KEY = 'compado_products';
    const DEFAULT_URI = "https://api.compado.com/v2_1/host/205/category/home/default";
    const DEFAULT_CACHE_DURATION = HOUR_IN_SECONDS * 6;

    public function getProducts() {
        $cachedProducts = $this->getCachedProducts();

        if ($cachedProducts !== false) {
            return $cachedProducts;
        }

        $products = $this->fetchProductsFromApi();

        $this->cacheProducts($products);

        return $products;
    }

    protected function cacheProducts(array $products): void {
        $options = get_option('compado_products_options');
        if (!empty($options['enable_transient'])) {
            $cache_duration = $options['cache_duration'] ?? self::DEFAULT_CACHE_DURATION;
            set_transient(self::TRANSIENT_KEY, $products, intval($cache_duration));
        }
    }

    protected function getCachedProducts() {
        $options = get_option('compado_products_options');
        if (!empty($options['enable_transient'])) {
            return get_transient(self::TRANSIENT_KEY);
        }

        return false;
    }

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

    protected function logError(string $message): void {
        if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
            error_log($message);
        }
    }

    protected function parseApiResponse(string $body): array {
        $decoded_body = json_decode($body, true);

        if (!is_array($decoded_body) || empty($decoded_body)) {
            $this->logError("API response has an unexpected format.");
            return [];
        }

        return $decoded_body;
    }
}
