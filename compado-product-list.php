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

use Compado\Products\CompadoProductManager;

defined('ABSPATH') || exit;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('COMPADO_PLUGIN_NAME_VERSION', '1.0.0');

register_activation_hook(__FILE__, ['Compado\Products\CompadoPluginActivator', 'activate']);
register_deactivation_hook(__FILE__, ['Compado\Products\CompadoPluginActivator', 'deactivate']);

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_compado_product_list(): void
{
    $client = new \Compado\Products\CompadoApiClient();
    $render = new \Compado\Products\CompadoRenderer();

    $plugin = new CompadoProductManager($client, $render);
    $plugin->run();


}
run_compado_product_list();

