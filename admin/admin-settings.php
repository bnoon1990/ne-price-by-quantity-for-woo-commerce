<?php

// Add custom product data tab
function bn_swo_qp_add_custom_product_data_tab($tabs)
{
    $tabs['quantity_pricing'] = array(
        'label'    => __('Quantity Pricing', 'woocommerce'),
        'target'   => 'quantity_pricing_options',
        'class'    => array('show_if_simple', 'show_if_variable'),
        'priority' => 21,
    );
    return $tabs;
}
add_filter('woocommerce_product_data_tabs', 'bn_swo_qp_add_custom_product_data_tab');

// Add custom fields to the custom product tab
function bn_swo_qp_custom_product_data_fields()
{
    global $post;
?>
    <div id="quantity_pricing_options" class="panel woocommerce_options_panel">
        <div class="options_group">
            <?php
            $pricing_rules = get_post_meta($post->ID, '_bn_swo_qp_pricing_rules', true);
            $pricing_rules = $pricing_rules ? json_decode($pricing_rules, true) : array();
            ?>
            <table class="widefat wc_input_table" id="bn_swo_qp_pricing_table">
                <thead>
                    <tr>
                        <th><?php _e('Quantity', 'woocommerce'); ?></th>
                        <th><?php _e('Discount Type', 'woocommerce'); ?></th>
                        <th><?php _e('Discount Value', 'woocommerce'); ?></th>
                        <th><?php _e('Remove', 'woocommerce'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pricing_rules)) : ?>
                        <?php foreach ($pricing_rules as $index => $rule) : ?>
                            <tr>
                                <td><input type="number" name="bn_swo_qp_pricing_rules[<?php echo $index; ?>][quantity]" value="<?php echo esc_attr($rule['quantity']); ?>" /></td>
                                <td>
                                    <select name="bn_swo_qp_pricing_rules[<?php echo $index; ?>][discount_type]">
                                        <option value="percentage" <?php selected($rule['discount_type'], 'percentage'); ?>><?php _e('Percentage', 'woocommerce'); ?></option>
                                        <option value="fixed" <?php selected($rule['discount_type'], 'fixed'); ?>><?php _e('Fixed Amount', 'woocommerce'); ?></option>
                                    </select>
                                </td>
                                <td><input type="number" name="bn_swo_qp_pricing_rules[<?php echo $index; ?>][discount_value]" value="<?php echo esc_attr($rule['discount_value']); ?>" /></td>
                                <td><button type="button" class="button remove_row"><?php _e('Remove', 'woocommerce'); ?></button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><button type="button" class="button add_row"><?php _e('Add Rule', 'woocommerce'); ?></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<?php
}
add_action('woocommerce_product_data_panels', 'bn_swo_qp_custom_product_data_fields');

// Save the custom fields
function bn_swo_qp_save_pricing_rules($post_id)
{
    if (isset($_POST['bn_swo_qp_pricing_rules'])) {
        $pricing_rules = $_POST['bn_swo_qp_pricing_rules'];
        update_post_meta($post_id, '_bn_swo_qp_pricing_rules', json_encode($pricing_rules));
    }
}
add_action('woocommerce_process_product_meta', 'bn_swo_qp_save_pricing_rules');

// Output pricing rules as a JS variable
function bn_swo_qp_output_pricing_rules()
{
    if (is_product()) {
        global $post;
        $pricing_rules = get_post_meta($post->ID, '_bn_swo_qp_pricing_rules', true);
        $pricing_rules = $pricing_rules ? json_decode($pricing_rules, true) : array();
        echo '<script type="text/javascript">var bn_swo_pricing_rules = ' . json_encode($pricing_rules) . ';</script>';
    }
}
add_action('wp_footer', 'bn_swo_qp_output_pricing_rules');
?>