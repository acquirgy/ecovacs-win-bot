$(document).ready( function() {

  var tax = 0;
  var taxTotal = 0;
  var subTotal = 0;
  var total = 0;
  var discountTotal = 0;
  var discountCode = {};

  // Start off with main item in cart
  addMainItem();

  $('.add').click( function() {

    var productId = $(this).data('id');
    console.log('addProduct', productId);

    row = $('.order-lines tr.product-' + productId);

    // Show the row
    row.show();

    // Find the qty input in that row and upate its value
    var currentValue = parseInt(row.find('.qty').val());
    row.find('.qty').val(currentValue + 1);

    updatePricing();

  });

  $('.qty').on('keyup paste', function() {
    console.log('qtyChange');
    //If user tries to enter 0, change qty to 1
    if ($(this).val() == 0) {$(this).val(1);}
    updatePricing();
  });

  $('.states').change( function() {
    // find out value of the state we changed to
    var state = $(this).val();

    // if state is CA update tax rate value
    tax = (state == 'CA') ? 0.08 : 0;

    updatePricing();
  });

  $('.remove').click( function() {
    var productId = $(this).data('id');
    console.log('removeProduct',productId);

    row = $('.order-lines tr.product-' + productId);

    // Hide the row
    row.hide();

    // Find the qty input in that row and upate its value to 0
    row.find('.qty').val(0);

    updatePricing();

  });

  $('.submit-discount').click( function(event) {
    event.preventDefault();

    console.log('BEFORE ajaxCall');
    $('.totals').hide();
    $('.spinner').show();

    var discountCodeSubmitted = $('input[name=discount_code]').val();
    $.ajax({
      url: '/test/get_discount/' + discountCodeSubmitted,
      dataType: 'JSON',
      success: function(result) {
        discountCode = result ? result : {}
        updatePricing();
        $('.spinner').hide();
        $('.totals').show();
      }
    });

    console.log('AFTER ajaxCall');

  });

  function addMainItem() {

    row = $('.order-lines tr.product-1');

    // Show the row
    row.show();

    row.find('.qty').val(1);

    updatePricing();
  }

  function updatePricing() {

    console.log('updatePricing');

    total = subTotal = discountTotal = 0;

    // Loop through our products and add up price
    $('.order-lines tbody tr').each( function() {
      var qty = $(this).find('input.qty').val();
      var price = $(this).data('price');
      subTotal = subTotal + (qty * price);
    });

    // Figure out discount codes
    if(discountCode.type == 'flat') {
      discountTotal = parseFloat(discountCode.value);
    }
    if(discountCode.type == 'percent') {
      discountTotal = parseFloat(discountCode.value) * subTotal;
    }

    taxTotal = tax * subTotal;
    total = subTotal + taxTotal - discountTotal;

    // Adjust dom with update totals
    $('.sub-total').empty().append(subTotal);
    $('.discount-total').empty().append(discountTotal);
    $('.tax-total').empty().append(taxTotal);
    $('.total').empty().append(total);

  }

});