<?php

/**
 * Plugin Name: Price by quantity for WooCommerce - By Noon Elite
 * Description: Adds variable pricing by quantity with options for percentage or fixed amount discounts and displays a pricing table on the product page.
 * Version: 1.0
 * Author: Ben Noon
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

class BN_Noon_Elite_Price_By_Quantity_For_Woocommerce_Plugin
{
    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'init'));
    }

    public function init()
    {
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            add_action('admin_notices', array($this, 'woocommerce_not_active_notice'));
            deactivate_plugins(plugin_basename(__FILE__));
            return;
        }

        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_styles'));

        require_once plugin_dir_path(__FILE__) . 'admin/plugin_settings.php';
        require_once plugin_dir_path(__FILE__) . 'admin/product_page_settings.php';
        require_once plugin_dir_path(__FILE__) . 'includes/product_pricing.php';
        require_once plugin_dir_path(__FILE__) . 'frontend/pricing_table.php';
    }

    public function woocommerce_not_active_notice()
    {
        echo '<div class="error"><p>' . __('Price by quantity for WooCommerce requires WooCommerce plugin to be running to work.', 'bn-noon-elite-price-by-quantity-for-woocommerce') . '</p></div>';
    }

    public function enqueue_admin_scripts($hook)
    {
        $screen = get_current_screen();
        if ($screen->id === 'product') {
            wp_enqueue_script('bn_swo_qp_admin_script', plugin_dir_url(__FILE__) . 'dist/admin.min.js', array('jquery'), '1.01', true);
        }
    }

    public function enqueue_public_scripts()
    {
        if (is_product()) {
            wp_enqueue_script('bn_swo_qp_public_script', plugin_dir_url(__FILE__) . 'dist/frontend.min.js', array('jquery'), '1.01', true);
        }
    }

    public function enqueue_admin_styles($hook)
    {
        $screen = get_current_screen();
        if ($screen->id === 'product') {
            wp_enqueue_style('bn_swo_qp_admin_style', plugin_dir_url(__FILE__) . '/dist/admin.min.css', array(), '1.0');
        }
    }

    public function enqueue_public_styles()
    {
        if (is_product()) {
            wp_enqueue_style('bn_swo_qp_public_style', plugin_dir_url(__FILE__) . '/dist/frontend.min.css', array(), '1.0');
        }
    }
}

new BN_Noon_Elite_Price_By_Quantity_For_Woocommerce_Plugin();
