jQuery(document).ready(function ($) {
  function calculateDiscount(quantity) {
    let discount = 0;
    let discountType = '';
    if (bn_swo_pricing_rules && bn_swo_pricing_rules.length) {
      for (let i = 0; i < bn_swo_pricing_rules.length; i++) {
        const rule = bn_swo_pricing_rules[i];
        if (quantity >= parseInt(rule.quantity)) {
          discount = parseFloat(rule.discount_value);
          discountType = rule.discount_type;
        }
      }
    }
    return { discount, discountType };
  }

  function updatePrice() {
    const quantity = parseInt($('#quantity').val());
    if (!quantity || quantity <= 0) return;

    const basePrice = parseFloat(
      $('.woocommerce-Price-amount')
        .first()
        .text()
        .replace(/[^0-9.-]+/g, '')
    );
    const { discount, discountType } = calculateDiscount(quantity);

    let newPrice;
    if (discountType === 'percentage') {
      newPrice = basePrice - basePrice * (discount / 100);
    } else if (discountType === 'fixed') {
      newPrice = basePrice - discount;
    } else {
      newPrice = basePrice;
    }

    $('.woocommerce-Price-amount').text(newPrice.toFixed(2));
  }

  $('#quantity').on('input', function () {
    updatePrice();
  });

  updatePrice(); // Initial call to set the correct price on load
});
