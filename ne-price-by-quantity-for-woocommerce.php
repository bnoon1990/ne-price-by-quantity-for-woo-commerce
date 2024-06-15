<?php

/**
 * Plugin Name: Price by quantity for WooCommerce - By Noon Elite
 * Description: Adds variable pricing by quantity with options for percentage or fixed amount discounts and displays a pricing table on the product page.
 * Version: 1.0
 * Author: Ben Noon
 */

// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue admin scripts
function bn_swo_qp_enqueue_admin_scripts($hook)
{
    $screen = get_current_screen();
    if ($screen->id === 'product') {
        wp_enqueue_script('bn_swo_qp_admin_script', plugin_dir_url(__FILE__) . 'admin-script.js', array('jquery'), '1.11', true);
    }
}
add_action('admin_enqueue_scripts', 'bn_swo_qp_enqueue_admin_scripts');

// Enqueue frontend scripts
function bn_swo_qp_enqueue_public_scripts()
{
    if (is_product()) {
        wp_enqueue_script('bn_swo_qp_public_script', plugin_dir_url(__FILE__) . 'public-script.js', array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bn_swo_qp_enqueue_public_scripts');

require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/product-pricing.php';
require_once plugin_dir_path(__FILE__) . 'includes/pricing-table.php';
