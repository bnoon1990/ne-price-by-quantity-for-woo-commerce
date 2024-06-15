jQuery(document).ready(function ($) {
  function bn_swo_qp_refresh_row_indices() {
    $('#bn_swo_qp_pricing_table tbody tr').each(function (index, element) {
      $(element)
        .find('input, select')
        .each(function () {
          const name = $(this).attr('name');
          const newName = name.replace(/\[\d+\]/, '[' + index + ']');
          $(this).attr('name', newName);
        });
    });
  }

  $('#bn_swo_qp_pricing_table').on('click', '.add_row', function () {
    const row = `
          <tr>
              <td><input type="number" name="bn_swo_qp_pricing_rules[0][quantity]" /></td>
              <td>
                  <select name="bn_swo_qp_pricing_rules[0][discount_type]">
                      <option value="percentage">Percentage</option>
                      <option value="fixed">Fixed Amount</option>
                  </select>
              </td>
              <td><input type="number" name="bn_swo_qp_pricing_rules[0][discount_value]" /></td>
              <td><button type="button" class="button remove_row">Remove</button></td>
          </tr>
      `;
    $('#bn_swo_qp_pricing_table tbody').append(row);
    bn_swo_qp_refresh_row_indices();
  });

  $('#bn_swo_qp_pricing_table').on('click', '.remove_row', function () {
    $(this).closest('tr').remove();
    bn_swo_qp_refresh_row_indices();
  });
});
