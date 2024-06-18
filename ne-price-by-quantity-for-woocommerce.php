<?php

/**
 * Plugin Name: Price by quantity for WooCommerce
 * Description: Adds variable pricing by quantity with options for percentage or fixed amount discounts and displays a pricing table on the product page.
 * Version: 1.0.0
 * Author: Ben Noon ( Noon Elite )
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires Plugins: WooCommerce
 * Requires PHP: 7.0
 */

require __DIR__ . '/vendor/autoload.php';

use Noonelite\NePriceByQuantityForWoocommerce\Admin\ProductPageSettings;
use Noonelite\NePriceByQuantityForWoocommerce\Admin\PluginSettings;
use Noonelite\NePriceByQuantityForWoocommerce\Frontend\PricingTable;
use Noonelite\NePriceByQuantityForWoocommerce\Includes\ProductPricing;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class BN_Noon_Elite_Price_By_Quantity_For_Woocommerce_Plugin
{
    private $productPageSettings;
    private $pluginSettings;
    private $pricingTable;
    private $productPricing;

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

        $this->productPageSettings = new ProductPageSettings();
        $this->pluginSettings = new PluginSettings();
        $this->pricingTable = new PricingTable();
        $this->productPricing = new ProductPricing();

        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_styles'));
    }

    public function woocommerce_not_active_notice()
    {
        echo '<div class="error"><p>' . __('Price by quantity for WooCommerce requires WooCommerce plugin to be running to work.', 'bn-noon-elite-price-by-quantity-for-woocommerce') . '</p></div>';
    }

    public function enqueue_admin_scripts($hook)
    {
        $screen = get_current_screen();
        if ($screen->id === 'product') {
            wp_enqueue_script('bn_noon_elite_price_by_quantity_admin_script', plugin_dir_url(__FILE__) . 'assets/js/admin.min.js', array('jquery'), '1.01', true);
        }
    }

    public function enqueue_public_scripts()
    {
        if (is_product()) {
            wp_enqueue_script('bn_noon_elite_price_by_quantity_public_script', plugin_dir_url(__FILE__) . '/assets/js/frontend.min.js', array('jquery'), '1.01', true);
        }
    }

    public function enqueue_admin_styles($hook)
    {
        $screen = get_current_screen();
        if ($screen->id === 'product') {
            wp_enqueue_style('bn_noon_elite_price_by_quantity_admin_style', plugin_dir_url(__FILE__) . '/assets/css/admin.min.css', array(), '1.0');
        }
    }

    public function enqueue_public_styles()
    {
        if (is_product()) {
            wp_enqueue_style('bn_noon_elite_price_by_quantity_public_style', plugin_dir_url(__FILE__) . '/assets/css/frontend.min.css', array(), '1.0');
        }
    }
}

new BN_Noon_Elite_Price_By_Quantity_For_Woocommerce_Plugin();
