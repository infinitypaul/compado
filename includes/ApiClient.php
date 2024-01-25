<?php

namespace Compado\Products;

class ApiClient
{
    const TRANSIENT_KEY = 'compado_products';
    public function getProducts() {
        $products = get_transient(ApiClient::TRANSIENT_KEY);

        if (false === $products) {
            $response = wp_remote_get('https://api.compado.com/v2_1/host/205/category/home/default');

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
                set_transient(ApiClient::TRANSIENT_KEY, $products, HOUR_IN_SECONDS * 6);
            } else {

                error_log("API response has an unexpected format.");
                return [];
            }
        }

        return $products;

        }
}