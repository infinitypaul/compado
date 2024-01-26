<?php
namespace Compado\Products\Admin;

use Compado\Products\CompadoApiClient;

defined('ABSPATH') || exit;
class CompadoAdmin
{
    /**
     * Registers the hooks for adding admin menus and registering settings.
     *
     * This method adds the necessary action hooks to register admin menus and register settings
     * in the WordPress admin area.
     *
     * @return void
     */
    public static function register_hooks() {
        add_action('admin_menu', [self::class, 'add_admin_menus']);
        add_action('admin_init', [self::class, 'register_settings']);
    }

    /**
     * Adds the admin menus for the Compado plugin.
     *
     * This method adds the necessary admin menu page for the Compado plugin
     * in the WordPress admin area.
     *
     * @return void
     */
    public static function add_admin_menus() {
        add_menu_page(
            __('Compado', 'compado-product-list'),
            __('Compado', 'compado-product-list'),
            'manage_options',
            'compado-products',
            [self::class, 'admin_page_callback']
        );
    }

    /**
     * Callback function for admin page.
     *
     * This function includes the compado-admin_page_callback.php file.
     *
     * @return void
     */
    public static function admin_page_callback(): void
    {
        include_once plugin_dir_path(__FILE__) . 'View/compado-admin_page_callback.php';
    }

    /**
     * Register settings for Compado Products.
     *
     * This function registers the settings for Compado Products, including options,
     * sanitize callback, default values, and settings section.
     * It also calls the add_settings_fields method to add the settings fields to the section.
     *
     * @return void
     */
    public static function register_settings(): void
    {
        $defaults = [
            'api_endpoint' => CompadoApiClient::DEFAULT_URI,
            'cache_duration' => 5 * HOUR_IN_SECONDS,
            'enable_transient' => 1,
        ];

        add_option('compado_products_options', $defaults);

        register_setting(
            'compado_products_options_group',
            'compado_products_options',
            [
                'sanitize_callback' => [self::class, 'validate_options'],
                'default' => $defaults
            ]
        );

        add_settings_section(
            'compado_products_settings_section',
            __('Compado Products Settings', 'compado-product-list'),
            null,
            'compado-products'
        );

        self::add_settings_fields();
    }


    /**
     * Add settings fields to the admin page.
     *
     * This method adds three settings fields to the "compado-products" admin page:
     * 1. "compado_enable_transient" field with label "Enable Caching" and callback "compado_enable_transient_callback".
     * 2. "compado_cache_duration" field with label "Cache Duration (in seconds)" and callback "compado_cache_duration_callback".
     * 3. "compado_api_endpoint" field with label "API Endpoint URL" and callback "compado_api_endpoint_callback".
     *
     * @return void
     */
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

    /**
     * Validates the options input.
     *
     * This function validates the input options and returns the validated input.
     * It checks the enable_transient option, api_endpoint option, and cache_duration option.
     * If any of the options are invalid, it adds a settings error message.
     *
     * @param array $input The input options to be validated.
     *
     * @return array The validated input options.
     */
    public static function validate_options(array $input): array
    {
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


    /**
     * Callback function for enabling transient.
     *
     * This function includes the 'compado-enable-transient-callback.php' file.
     *
     * @return void
     */
    public static function compado_enable_transient_callback() {
        include_once 'View/compado-enable-transient-callback.php';
    }

    /**
     * Callback function for compado cache duration.
     *
     * This function includes the compado_cache_duration_callback.php file.
     *
     * @return void
     */
    public static function compado_cache_duration_callback() {
        include_once 'View/compado_cache_duration_callback.php';
    }


    /**
     * Callback method for compado API endpoint.
     *
     * This method includes the compado_api_endpoint_callback.php file.
     *
     * @return void
     */
    public static function compado_api_endpoint_callback() {
        include_once 'View/compado_api_endpoint_callback.php';
    }
}