<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$display_title = get_option('ne_quantity_pricing_display_title', 'no');
$title = get_option('ne_quantity_pricing_title', __('Multibuy Discounts Available', 'ne_quantity_pricing'));
?>

<?php if ($display_title === 'yes') : ?>
    <h2 style="font-size:1.5rem"><?php echo esc_html($title); ?></h2>
<?php endif; ?>

<table class="bn-swo-qp-pricing-table">
    <tr>
        <th>Quantity</th>
        <th>Discount</th>
    </tr>
    <?php foreach ($rules as $rule) : ?>
        <?php $discount = $rule['discount_type'] == 'percentage' ? $rule['discount_value'] . '%' : get_woocommerce_currency_symbol() . $rule['discount_value']; ?>
        <tr>
            <td class="centered-cell"><?php echo esc_html($rule['quantity']); ?></td>
            <td class="centered-cell"><?php echo esc_html($discount); ?></td>
        </tr>
    <?php endforeach; ?>
</table>