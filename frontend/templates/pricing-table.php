<h2 style="font-size:1.5rem">Multibuy Discounts Available</h2>
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