<?php
namespace Compado\Products\Helper;

class Config
{
    const PLUGIN_NAME = 'compado-product-list';
    /**
     * Currently plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    const PLUGIN_VERSION = '1.0.0';
    const TEXT_DOMAIN = 'compado-product-list';

    // Assets
    const STYLE_HANDLE = self::PLUGIN_NAME . '-style';
    const SCRIPT_HANDLE = self::PLUGIN_NAME . '-script';
    const CSS_PATH = '../assets/css/style.css';
    const JS_PATH = '../assets/js/script.js';

    // Custom Query Vars
    const QUERY_VAR_REDIRECT = 'compado_redirect';

    // API Related
    const API_BASE_URL = 'https://api.compado.com/';
    const API_VERSION = 'v2_1';
    const API_ENDPOINT = self::API_BASE_URL . self::API_VERSION . '/host/205/category/home/default';

    const TRANSIENT_KEY = 'compado_products';

    const DEFAULT_ENABLE_TRANSIENT =  1;
    // Options
    const OPTION_NAME = 'compado_products_options';
    const DEFAULT_CACHE_DURATION = 5 * HOUR_IN_SECONDS;


    const SHORTCODE_PRODUCTS = 'compado_products';

}