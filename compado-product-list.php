<?php
/**
 * Plugin Name: Compado Product List
 * Plugin URI:  https://infinitypaul.medium.com
 * Description: Fetches and displays a list of products from Compado's API.
 * Version:     1.0.0
 * Author:      Paul Edward
 * Author URI:  https://infinitypaul.medium.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: compado-product-list
 * Domain Path:       /languages
 */

use Compado\Products\Plugin;

defined('ABSPATH') || exit;

require_once __DIR__ . '/vendor/autoload.php';

function compado_product_list_activate() {

}
register_activation_hook(__FILE__, 'compado_product_list_activate');

function compado_product_list_deactivate() {

}
register_deactivation_hook(__FILE__, 'compado_product_list_deactivate');

function run_compado_product_list(): void
{
    $plugin = new Plugin();
    $plugin->run();
}

run_compado_product_list();

