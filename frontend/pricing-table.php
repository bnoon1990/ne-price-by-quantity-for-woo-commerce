<?php

function bn_swo_qp_display_pricing_table()
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
    include plugin_dir_path(__FILE__) . 'templates/pricing-table.php';
}

add_action('woocommerce_single_product_summary', 'bn_swo_qp_display_pricing_table', 20);
