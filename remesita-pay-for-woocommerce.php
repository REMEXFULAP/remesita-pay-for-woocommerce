<?php

/** 
 * Plugin Name:       RemesitaPay
 * Plugin URI:        https://https://github.com/REMEXFULAP/remesita-pay-for-woocommerce
 * Description:       Usa este plugin para aceptar pagos con RemesitaPay en tu tienda woocommerce
 * Author:            REMEXFULAP
 * Author URI:        https://https://github.com/REMEXFULAP/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       remesita-pay-for-woocommerce
 * Domain Path:       /languages
 * Requires at least: 4.7
 * Requires PHP: 7.1
 * WC requires at least: 3.4
 * WC tested up to: 8.4
 * Version: 1.0.0
 *
 * @link              https://https://github.com/REMEXFULAP
 * @since             1.0.0
 * @package           Remesita_Pay_For_Woocommerce
 * @copyright Copyright (c) 2024, Remex & Fulap Fintech Group
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0 
 * 
 */

// If this file is called directly, abort.
defined('ABSPATH') or exit;

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('REMESITA_PAY_FOR_WOOCOMMERCE_VERSION', '1.0.0');

// Make sure WooCommerce is active
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    return;
}

add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});



/*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
add_filter('woocommerce_payment_gateways', 'wc_remesita_pay_add_gateway_class');
function wc_remesita_pay_add_gateway_class($gateways)
{
    $gateways[] = 'WC_RemesitaPay_Gateway'; // your class name is here
    return $gateways;
}

// Add custom action links
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'remesita_pay_action_links');
function remesita_pay_action_links($links)
{
    $plugin_links = array(
        '<a href="' . admin_url('admin.php?page=wc-settings&tab=checkout&section=remesita-pay') . '">Configuración</a>',
    );
    return array_merge($plugin_links, $links);
}



/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action('plugins_loaded', 'wc_remesita_pay_init_gateway_class', 10);
function wc_remesita_pay_init_gateway_class()
{ 
    include_once plugin_dir_path(__FILE__) . 'WC_Remesita_Pay.php'; 
    
}


add_action('admin_menu', 'add_remesita_pay_submenu_page');
function add_remesita_pay_submenu_page() {
    add_submenu_page(
        'woocommerce', // Slug del menú principal (WooCommerce)
        'Remesita Pay Settings', // Título de la página
        'Remesita Pay', // Nombre del submenú
        'manage_woocommerce', // Capacidad requerida
        '?page=wc-settings&tab=checkout&section=remesita-pay', // Slug de la página
        null                          // Callback (no necesario porque estamos redirigiendo)
    );
}

 