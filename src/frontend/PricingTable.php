<?php

namespace Noonelite\NePriceByQuantityForWoocommerce\Frontend;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class PricingTable
{
    public function __construct()
    {
        add_action('woocommerce_single_product_summary', array($this, 'display_pricing_table'), 20);
    }

    public function display_pricing_table()
    {
        global $product;

        $pricing_rules = get_post_meta($product->get_id(), '_bn_swo_qp_pricing_rules', true);
        if (!$pricing_rules) {
            return;
        }

        $rules = json_decode($pricing_rules, true);
        if (empty($rules)) {
            return;
        }

        // Load the template file
        include plugin_dir_path(__FILE__) . 'templates/pricing_table.php';
    }
}
