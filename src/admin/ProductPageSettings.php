<?php

namespace Noonelite\NePriceByQuantityForWoocommerce\Admin;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class ProductPageSettings
{
    public function __construct()
    {
        add_filter('woocommerce_product_data_tabs', array($this, 'add_custom_product_data_tab'));
        add_action('woocommerce_product_data_panels', array($this, 'custom_product_data_fields'));
        add_action('woocommerce_process_product_meta', array($this, 'save_pricing_rules'));
        add_action('wp_footer', array($this, 'output_pricing_rules'));
    }

    public function add_custom_product_data_tab($tabs)
    {
        $tabs['quantity_pricing'] = array(
            'label'    => __('Quantity Pricing', 'woocommerce'),
            'target'   => 'quantity_pricing_options',
            'class'    => array('show_if_simple', 'show_if_variable'),
            'priority' => 21,
        );
        return $tabs;
    }

    public function custom_product_data_fields()
    {
        global $post;
        echo '<div id="quantity_pricing_options" class="panel woocommerce_options_panel">';
        echo '<div class="options_group">';
        $pricing_rules = get_post_meta($post->ID, '_bn_swo_qp_pricing_rules', true);
        $pricing_rules = $pricing_rules ? json_decode($pricing_rules, true) : array();

        // Add nonce field
        wp_nonce_field('save_bn_swo_qp_pricing_rules_nonce', 'bn_swo_qp_pricing_rules_nonce');

        include plugin_dir_path(__FILE__) . 'templates/admin_pricing_table.php';
        echo '</div>';
        echo '</div>';
    }

    public function save_pricing_rules($post_id)
    {
        // Check if nonce is set and valid
        if (isset($_POST['bn_swo_qp_pricing_rules_nonce']) && wp_verify_nonce($_POST['bn_swo_qp_pricing_rules_nonce'], 'save_bn_swo_qp_pricing_rules_nonce')) {
            if (isset($_POST['bn_swo_qp_pricing_rules'])) {
                $pricing_rules = $_POST['bn_swo_qp_pricing_rules'];
                update_post_meta($post_id, '_bn_swo_qp_pricing_rules', wp_json_encode($pricing_rules));
            }
        } else {
            // Log nonce verification failure
            error_log('Nonce verification failed for save_bn_swo_qp_pricing_rules_nonce in ProductPageSettings class.');
        }
    }

    public function output_pricing_rules()
    {
        if (is_product()) {
            global $post;
            $pricing_rules = get_post_meta($post->ID, '_bn_swo_qp_pricing_rules', true);
            $pricing_rules = $pricing_rules ? json_decode($pricing_rules, true) : array();
            echo '<script type="text/javascript">var bn_swo_pricing_rules = ' . wp_json_encode($pricing_rules) . ';</script>';
        }
    }
}
