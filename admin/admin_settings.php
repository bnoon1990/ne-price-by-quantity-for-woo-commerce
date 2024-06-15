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

            // Include the pricing table template
            include plugin_dir_path(__FILE__) . 'templates/admin_pricing_table.php';
            ?>
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