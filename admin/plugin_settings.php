<?php
class BN_Noon_Elite_Quantity_Pricing_Settings
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
                'name'     => __('Section Title', 'ne_quantity_pricing'),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'ne_quantity_pricing_section_title'
            ),
            'display_title' => array(
                'name' => __('Display Title', 'ne_quantity_pricing'),
                'type' => 'checkbox',
                'desc' => __('Check this box to display the title on the product page', 'ne_quantity_pricing'),
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
            )
        );
    }
}

new BN_Noon_Elite_Quantity_Pricing_Settings();
