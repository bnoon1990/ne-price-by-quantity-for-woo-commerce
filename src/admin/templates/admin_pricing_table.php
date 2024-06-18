<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
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