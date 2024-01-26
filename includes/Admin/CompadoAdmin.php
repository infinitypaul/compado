<?php
namespace Compado\Products\Admin;
class CompadoAdmin
{
    public static function register_hooks() {
        add_action('admin_menu', [self::class, 'add_admin_menus']);
        add_action('admin_init', [self::class, 'register_settings']);
    }

    public static function add_admin_menus() {
        add_menu_page(
            __('Compado', 'compado-product-list'),
            __('Compado', 'compado-product-list'),
            'manage_options',
            'compado-products',
            [self::class, 'admin_page_callback']
        );
    }

    public static function admin_page_callback(): void
    {
        include_once plugin_dir_path(__FILE__) . 'View/compado-admin_page_callback.php';
    }

    public static function register_settings() {
        register_setting('compado_products_options_group', 'compado_products_options', [
            'sanitize_callback' => [self::class, 'validate_options']
        ]);

        add_settings_section(
            'compado_products_settings_section',
            __('Compado Products Settings', 'compado-product-list'),
            null,
            'compado-products'
        );

        self::add_settings_fields();
    }

    private static function add_settings_fields(): void {
        add_settings_field(
            'compado_enable_transient',
            __('Enable Caching', 'compado-product-list'),
            [self::class, 'compado_enable_transient_callback'],
            'compado-products',
            'compado_products_settings_section'
        );

        add_settings_field(
            'compado_cache_duration',
            __('Cache Duration (in seconds)', 'compado-product-list'),
            [self::class, 'compado_cache_duration_callback'],
            'compado-products',
            'compado_products_settings_section'
        );

        add_settings_field(
            'compado_api_endpoint',
            __('API Endpoint URL', 'compado-product-list'),
            [self::class, 'compado_api_endpoint_callback'],
            'compado-products',
            'compado_products_settings_section'
        );
    }

    public static function validate_options($input) {
        $new_input = [];


        $new_input['enable_transient'] = isset($input['enable_transient']) ? 1 : 0;

        if (isset($input['api_endpoint'])) {
            $new_input['api_endpoint'] = sanitize_text_field($input['api_endpoint']);

            if (empty($new_input['api_endpoint'])) {
                add_settings_error(
                    'api_endpoint',
                    'empty_api_endpoint',
                    'API Endpoint URL is required.'
                );
            } else if (!filter_var($new_input['api_endpoint'], FILTER_VALIDATE_URL)) {
                add_settings_error(
                    'api_endpoint',
                    'invalid_api_endpoint',
                    'Invalid API Endpoint URL provided.'
                );
                $new_input['api_endpoint'] = '';
            }
        }

        if (isset($input['cache_duration'])) {
            $new_input['cache_duration'] = absint($input['cache_duration']);

            if (empty($new_input['cache_duration']) || !is_numeric($new_input['cache_duration'])) {
                add_settings_error(
                    'caching_duration',
                    'invalid_caching_duration',
                    'Cache Duration must be a valid number.'
                );
                $new_input['cache_duration'] = '';
            }
        }


        return $new_input;
    }



    public static function compado_enable_transient_callback() {
        include_once 'View/compado-enable-transient-callback.php';
    }

    public static function compado_cache_duration_callback() {
        include_once 'View/compado_cache_duration_callback.php';
    }


    public static function compado_api_endpoint_callback() {
        include_once 'View/compado_api_endpoint_callback.php';
    }
}