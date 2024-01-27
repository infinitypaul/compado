<?php
namespace Compado\Products\Admin;

use Compado\Products\CompadoApiClient;
use Compado\Products\Helper\Config;

defined('ABSPATH') || exit;
class CompadoAdmin
{
    /**
     * Registers the hooks for adding admin menus and registering settings.
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
     *
     * @return void
     */
    public static function add_admin_menus() {
        add_menu_page(
            __('Compado', Config::TEXT_DOMAIN),
            __('Compado', Config::TEXT_DOMAIN),
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
     *
     * @return void
     */
    public static function register_settings(): void
    {
        $defaults = [
            'api_endpoint' => Config::API_ENDPOINT,
            'cache_duration' => Config::DEFAULT_CACHE_DURATION,
            'enable_transient' => Config::DEFAULT_ENABLE_TRANSIENT,
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
            __('Compado Products Settings', Config::TEXT_DOMAIN),
            null,
            'compado-products'
        );

        self::add_settings_fields();
    }


    /**
     * Add settings fields to the admin page.
     *
     *
     * @return void
     */
    private static function add_settings_fields(): void {
        add_settings_field(
            'compado_enable_transient',
            __('Enable Caching', Config::TEXT_DOMAIN),
            [self::class, 'compado_enable_transient_callback'],
            'compado-products',
            'compado_products_settings_section'
        );

        add_settings_field(
            'compado_cache_duration',
            __('Cache Duration (in seconds)', Config::TEXT_DOMAIN),
            [self::class, 'compado_cache_duration_callback'],
            'compado-products',
            'compado_products_settings_section'
        );

        add_settings_field(
            'compado_api_endpoint',
            __('API Endpoint URL', Config::TEXT_DOMAIN),
            [self::class, 'compado_api_endpoint_callback'],
            'compado-products',
            'compado_products_settings_section'
        );
    }

    /**
     * Validates the options array and returns the validated values.
     *
     *
     * @param array $input
     *
     * @return array
     */
    public static function validate_options(array $input): array {
        $new_input = [];
        $options = get_option('compado_products_options');

        $new_input['enable_transient'] = isset($input['enable_transient']) ? 1 : 0;

        //$new_input['api_endpoint'] = self::validate_api_endpoint($input['api_endpoint'] ?? '', $options['api_endpoint'] ?? '');
        $new_input['api_endpoint'] = Config::API_ENDPOINT;

        $new_input['cache_duration'] = self::validate_cache_duration($input['cache_duration'] ?? '', $options['cache_duration'] ?? '');

        return $new_input;
    }

    /**
     * Validates the API endpoint URL.
     *
     * @param string $input_api_endpoint The input API endpoint URL to be validated.
     * @param string $existing_api_endpoint
     *
     * @return string
     */
    private static function validate_api_endpoint(string $input_api_endpoint, string $existing_api_endpoint): string {
        if (empty($input_api_endpoint)) {
            self::add_error('api_endpoint', 'empty_api_endpoint', 'API Endpoint URL is required.');
            return $existing_api_endpoint;
        }

        if (!filter_var($input_api_endpoint, FILTER_VALIDATE_URL)) {
            self::add_error('api_endpoint', 'invalid_api_endpoint', 'Invalid API Endpoint URL provided.');
            return $existing_api_endpoint;
        }

        return sanitize_text_field($input_api_endpoint);
    }


    /**
     * Validates the cache duration input and returns the existing cache duration if the input is invalid.
     *
     * @param $input_cache_duration
     * @param string $existing_cache_duration
     * @return string
     */
    private static function validate_cache_duration($input_cache_duration, string $existing_cache_duration): string {
        if (empty($input_cache_duration) || !is_numeric($input_cache_duration)) {
            self::add_error('caching_duration', 'invalid_caching_duration', 'Cache Duration must be a valid number.');
            return $existing_cache_duration;
        }

        return absint($input_cache_duration);
    }

    /**
     * Add an error message to the specified setting.
     *
     *
     * @param string $setting The name of the setting to which the error message should be added.
     * @param string $code The code associated with the error message.
     * @param string $message The error message to be added.
     *
     * @return void
     */
    private static function add_error(string $setting, string $code, string $message): void {
        add_settings_error(
            $setting,
            $code,
            $message
        );
    }



    /**
     * Callback function for enabling transient.
     *
     * @return void
     */
    public static function compado_enable_transient_callback(): void
    {
        include_once 'View/compado-enable-transient-callback.php';
    }

    /**
     * Callback function for compado cache duration.
     *
     * @return void
     */
    public static function compado_cache_duration_callback(): void
    {
        include_once 'View/compado_cache_duration_callback.php';
    }


    /**
     * Callback method for compado API endpoint.
     *
     * @return void
     */
    public static function compado_api_endpoint_callback(): void
    {
        include_once 'View/compado_api_endpoint_callback.php';
    }
}