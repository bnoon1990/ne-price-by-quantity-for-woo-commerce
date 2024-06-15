<?php

function bn_swo_qp_display_pricing_table() {

    global $product;

    $pricing_rules = get_post_meta($product->get_id(), '_bn_swo_qp_pricing_rules', true);
    if (!$pricing_rules) {
        return;
    }

    $rules = json_decode($pricing_rules, true);
    if (empty($rules)) {
        return;
    }

    echo '<h2 style="font-size:1.5rem">Multibuy Discounts Available</h2>';
    echo '<table class="bn-swo-qp-pricing-table">';
    echo '<tr><th>Quantity</th><th>Discount</th></tr>';
    foreach ($rules as $rule) {
        $discount = $rule['discount_type'] == 'percentage' ? $rule['discount_value'] . '%' : get_woocommerce_currency_symbol() . $rule['discount_value'];
        echo '<tr><td>' . esc_html($rule['quantity']) . '</td><td>' . esc_html($discount) . '</td></tr>';
    }
    echo '</table>';
}

add_action('woocommerce_single_product_summary', 'bn_swo_qp_display_pricing_table', 20);
?>