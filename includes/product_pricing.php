<?php
function bn_swo_qp_adjust_price($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $quantity = $cart_item['quantity'];
        $price = floatval($product->get_price());

        // Get the parent ID if the product is a variation
        $product_id = $product->is_type('variation') ? $product->get_parent_id() : $product->get_id();

        $pricing_rules = get_post_meta($product_id, '_bn_swo_qp_pricing_rules', true);
        if (!$pricing_rules) {
            continue;
        }

        // Log the pricing rules
        error_log("Pricing rules: {$pricing_rules}");

        $rules = json_decode($pricing_rules, true);
        if (empty($rules)) {
            continue;
        }

        usort($rules, function ($a, $b) {
            return intval($b['quantity']) - intval($a['quantity']);
        });

        foreach ($rules as $rule) {
            if ($quantity >= intval($rule['quantity'])) {
                if ($rule['discount_type'] == 'percentage') {
                    $discount = ($price * floatval($rule['discount_value'])) / 100;
                } else {
                    $discount = floatval($rule['discount_value']);
                }
                $new_price = max(0, $price - $discount);

                // Log the new price
                error_log("New price: {$new_price}");

                $product->set_price($new_price);
                break;
            }
        }
    }
}

add_action('woocommerce_before_calculate_totals', 'bn_swo_qp_adjust_price', 10);
