<?php

namespace Compado\Products;

class ApiClient
{
    const TRANSIENT_KEY = 'compado_products';

    const URI = "https://api.compado.com/v2_1/host/205/category/home/default";

    const TIMER = 6;

    public function getProducts() {
        $options = get_option('compado_products_options');

        if (!empty($options['enable_transient'])) {
            $products = get_transient(ApiClient::TRANSIENT_KEY);

            if (false !== $products) {
                return $products;
            }
        }

        $api_endpoint = $options['api_endpoint'] ?? ApiClient::URI;

        $response = wp_remote_get($api_endpoint);

        if (is_wp_error($response)) {
            error_log($response->get_error_message());
            return [];
        }

        $status_code = wp_remote_retrieve_response_code($response);
        if ($status_code != 200) {
            error_log("API request returned status code: " . $status_code);
            return [];
        }

        $body = wp_remote_retrieve_body($response);
        $decoded_body = json_decode($body, true);

        if (is_array($decoded_body) && !empty($decoded_body)) {
            $products = $decoded_body;

            if (!empty($options['enable_transient'])) {
                $cache_duration = !empty($options['cache_duration']) ? intval($options['cache_duration']) : HOUR_IN_SECONDS * ApiClient::TIMER;
                set_transient(ApiClient::TRANSIENT_KEY, $products, $cache_duration);
            }
        } else {
            error_log("API response has an unexpected format.");
            return [];
        }

        return $products;
    }
}
