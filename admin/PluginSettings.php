<?php

namespace Noonelite\NePriceByQuantityForWoocommerce\Admin;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class PluginSettings
{
    public function __construct()
    {
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_tab'), 50);
        add_action('woocommerce_settings_tabs_ne_quantity_pricing', array($this, 'add_settings_fields'));
        add_action('woocommerce_update_options_ne_quantity_pricing', array($this, 'update_settings_fields'));
    }

    public function add_settings_tab($settings_tabs)
    {
        $settings_tabs['ne_quantity_pricing'] = __('Quantity Pricing', 'ne_quantity_pricing');
        return $settings_tabs;
    }

    public function add_settings_fields()
    {
        woocommerce_admin_fields($this->get_settings_fields());
    }

    public function update_settings_fields()
    {
        woocommerce_update_options($this->get_settings_fields());
    }

    private function get_settings_fields()
    {
        return array(
            'section_title' => array(
                'name'     => __('Product page display settings', 'ne_quantity_pricing'),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'ne_quantity_pricing_section_title'
            ),
            'display_title' => array(
                'name' => __('Show table heading', 'ne_quantity_pricing'),
                'type' => 'checkbox',
                'desc' => __('Check this box to display the heading above the quantity pricing table', 'ne_quantity_pricing'),
                'id'   => 'ne_quantity_pricing_display_title',
                'default' => 'yes',
            ),
            'title' => array(
                'name' => __('Title', 'ne_quantity_pricing'),
                'type' => 'text',
                'desc' => __('Enter the text to use for the title', 'ne_quantity_pricing'),
                'id'   => 'ne_quantity_pricing_title',
                'default' => __('Multibuy Discounts Available', 'ne_quantity_pricing'),
            ),
            'section_end' => array(
                'type' => 'sectionend',
                'id' => 'ne_quantity_pricing_section_end'
            ),
            // Donation section
            // 'donation_section' => array(
            //     'name'     => __('Support This Plugin', 'ne_quantity_pricing'),
            //     'type'     => 'title',
            //     'desc'     => '',
            //     'id'       => 'ne_quantity_pricing_donation_section'
            // ),
            // 'donation_text' => array(
            //     'name' => '',
            //     'type' => 'title',
            //     'desc' => __('If you find this plugin helpful, please consider making a donation to support ongoing development.', 'ne_quantity_pricing'),
            //     'id'   => 'ne_quantity_pricing_donation_text',
            // ),
            // 'donation_link' => array(
            //     'name' => '',
            //     'type' => 'title',
            //     'desc' => '<a href="https://www.yourdonationlink.com" class="button button-primary" target="_blank">' . __('Donate', 'ne_quantity_pricing') . '</a>',
            //     'id'   => 'ne_quantity_pricing_donation_link',
            // ),
            // 'donation_section_end' => array(
            //     'type' => 'sectionend',
            //     'id' => 'ne_quantity_pricing_donation_section_end'
            // )
        );
    }
}
