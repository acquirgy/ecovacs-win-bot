$(document).ready( function() {

  var taxTotal = 0;
  var subTotal = 0;
  var total = 0;
  var taxable_subTotal = 0;
  var grand_total = 0;
  var discountTotal = 0;
  var discountCode = {};
  var shippingTotal = 0.00;
  var outsideShipping = false;
  var shiptoBilling = true;

  // Form Validation
  $.validator.addClassRules({
    zip: {
      required: true,
      digits: true,
      minlength: 5,
      maxlength: 5
    }
  });

  $.validator.addMethod('check-PObox', function(value, element) {
    var POboxPattern = new RegExp('[PO.]*\\s?B(ox)?.*\\d+', 'i');
    var POboxPattern2 = new RegExp('^PO BOX', 'i');
    return this.optional(element) || POboxPattern.test(value) == false && POboxPattern2.test(value) == false ;
  }, "<span class='error'>Shipping address cannot be a PO Box.</span>");

  $.validator.addMethod('phone', function (value) {
    return /^\d{10}$/.test(value);
  }, 'Enter 10 digits only');

  $('.cart-form').validate({
    submitHandler: function(form) {
      // do stuff here after form is valid and right before we post the form to server
      //_gaq.push(['_trackEvent', 'Cart', 'Order', 'Place Order']);
      //close_fb();
      $(form).submit();
    }
  });

  // Start off with main item in cart
  addMultipayWinbot();

  // Add Upsell button click
  $('.add').click( function() {

    var productId = $(this).data('id');
    console.log('addProduct', productId);

    row = $('.order-lines tr.product-' + productId);

    // Show the row
    row.show();

    // Find the qty input in that row and upate its value
    var currentValue = parseInt(row.find('.qty').val());
    var newValue = currentValue + 1;
    var price = parseFloat(row.data('price'));
    row.find('.qty').val(newValue);
    $(".rowtotal-" + productId).html(newValue * price);

    updatePricing();

    var title = $(this).siblings("h2").html();
    _gaq.push(['_trackEvent', 'Cart', 'Add Upsell', title]);

  });

  // User changes quantity directly in input box
  $('.qty').on('keyup paste', function() {

    // Get the product id, price, and new quantity for current row
    row = $(this).parent().parent();
    var productid = row.attr('class').substring(8,9);    // pull the product id out of the class name
    var price = parseFloat(row.data('price'));
    var qty = parseInt($(this).val());

    // If user tries to enter 0, or if item is main product ( 1 or 2) or FreeShipping product (7), set value back to 1
    if ( $(this).val() == 0 | productid == 1| productid == 2 | productid == 7)
    {
      $(this).val(1);
    }

    // Find the qty input in lower order-lines table (that has the same product id) and update its value
    var input = "input[name=\'[" + productid + "][qty]\']";   // input[name='[#][qty]']
    $(input).val($(this).val());
     // Also update the subtotal for product in lower order table
     $(".rowtotal-" + productid).html(price * qty);

     updatePricing();
   });

  // copy billing address to shipping fields
  $('#b_first_name').change(function(){
    if (shiptoBilling == true)
    $('#s_first_name').val($('#b_first_name').val());
  })
  $('#b_last_name').change(function(){
    if (shiptoBilling == true)
    $('#s_last_name').val($('#b_last_name').val());
  })

  $('#b_address').change(function(){
    if (shiptoBilling == true)
    $('#s_address').val($('#b_address').val());
  })
  $('#b_apt').change(function(){
    if (shiptoBilling == true)
    $('#s_apt').val($('#b_apt').val());
  })
  $('#b_city').change(function(){
    if (shiptoBilling == true)
    $('#s_city').val($('#b_city').val());
  })
  $('.b_states').change( function() {
    if (shiptoBilling == true) { $('.s_states').val($('.b_states').val());}
    updatePricing();
  });
  $('.b_province').change(function(){
    if (shiptoBilling == true) {$('.s_province').val($('.b_province').val());}
  })
  $('#b_zip').change(function(){
    if (shiptoBilling == true)
    $('#s_zip').val($('#b_zip').val());
  })

  // Shipping state list
  $('.s_states').change( function() {
    updatePricing();
  });

  // Remove button is clicked
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

  // Discount Code Applied
  $('.submit-discount').click( function(event) {
    event.preventDefault();

    console.log('BEFORE ajaxCall');
    $('.totals').hide();
    $('.spinner').show();

    var discountCodeSubmitted = $('input[name=discount-code]').val();
    $.ajax({
      url: '/main/get_discount/' + discountCodeSubmitted,
      dataType: 'JSON',
      success: function(result) {
        discountCode = result ? result : {}
        updatePricing();
        $('.spinner').hide();
        $('.totals').show();
      }
    });

  });

  // Billing Country selection change:
  $('#Country').change( function() {
    // find out value of the country we changed to
    var country = $(this).val();

    // if country is U.S., show it and hide other 2 drop down lists
    if (country == 'United States') {
      $('.b_states').show();
      $('.b_province').hide();
      $('.b_province').removeClass('required');
      $('#b_region').hide();
      if (shiptoBilling == true) {
        $('.s_states').show();
        $('.s_province').hide();
        $('#s_region').hide();
      }
    } else {
      $('.b_states').hide();                    // Hide the billing states list
      $('.b_states').removeClass('required');
      if (shiptoBilling == true) {
          $('.s_states').hide();                // Hide the shipping states list
      }

      // if country is Canada...
      if (country == 'Canada') {
        $('.b_province').show();
        $('.b_province').addClass('required');
        $('#b_region').hide();
        if (shiptoBilling == true)  {
          $('.s_province').show();
          $('#s_region').hide();
        }
      }
      // if country is Puerto Rico...
      if (country == 'Puerto Rico') {
        $('#b_region').show();
        $('.b_province').hide();
        $('.b_province').removeClass('required');
        if (shiptoBilling == true)  {
          $('#s_region').show();
          $('.s_province').hide();
        }
      }
    }

    if (shiptoBilling == true) {$('#s_country').val(country);}

    updatePricing();

  });
  // Shipping Country selection change:
  $('#s_country').change( function() {
    // find out value of the country we changed to
    var country = $(this).val();

    // if country is U.S., show it and hide other 2 drop down lists
    if (country == 'United States') {
      $('.s_states').show();
      $('.s_province').hide();
      $('.s_province').removeClass('required');
      $('#s_region').hide();
    } else {
      $('.s_states').hide();                    // Hide the shipping states list
      $('.s_states').removeClass('required');

      // if country is Canada...
      if (country == 'Canada') {
        $('.s_province').show();
        $('.s_province').addClass('required');
        $('#s_region').hide();
      }
      // if country is Puerto Rico...
      if (country == 'Puerto Rico') {
        $('#s_region').show();
        $('.s_province').hide();
        $('.s_province').removeClass('required');
      }
    }

    updatePricing();

  });

  //Payment Options
  $('#multipay').click( function() {
    addMultipayWinbot();
    $('#Note').show();
    updatePricing();
  });

  $('#singlepay').click( function() {
    addSinglepayWinbot();
    $('#Note').hide();
    updatePricing();
  });

  $('#rushShip').click( function() {
    updatePricing();
    $('.rush').removeClass('hidden');
    $('.standard').addClass('hidden');
  });

  $('#standardShip').click( function() {
    updatePricing();
    $('.standard').removeClass('hidden');
    $('.rush').addClass('hidden');
  });

  // Shipping Address Different is checked
  $('#ckbxAddressDiffer').on('click', function() {
    if ($(this).is(':checked')) {
      shiptoBilling = false;
      $('.shipping-address').slideDown();
      $('.shipping-address input').addClass('required');
      $('.shipping-address #s_apt').removeClass('required');
      $('#s_address').addClass('check-PObox');
      $('#b_address').removeClass('check-PObox');
    } else {
      shiptoBilling = true;
      $('.shipping-address').slideUp();
      $('.shipping-address input').removeClass('required');
      $('#s_address').removeClass('check-PObox');
      $('#b_address').addClass('check-PObox');
    }

    updatePricing();
  })

  // "Receive News & Promotions by Email" checked
  $('#receiveEmail').on('click', function() {
    if ($(this).is(':checked')) {
      $('#opt-out').val('0');
    } else {
      $('#opt-out').val('1');
    }

  })

  function addMultipayWinbot() {

    rowMultipay = $('.order-lines tr.product-2');
    rowSinglepay = $('.order-lines tr.product-1');
    rowFreeShipping = $('.order-lines tr.product-7');

    // Show the row
    rowMultipay.show();
    rowSinglepay.hide();
    rowFreeShipping.hide();

    rowMultipay.find('.qty').val(1);
    rowSinglepay.find('.qty').val(0);
    rowFreeShipping.find('.qty').val(0);

    $('input:radio[name="payment-option"]').filter('[value="multipay"]').attr('checked', true);

    updatePricing();
  }

  function addSinglepayWinbot() {

    rowMultipay = $('.order-lines tr.product-2');
    rowSinglepay = $('.order-lines tr.product-1');
    rowFreeShipping = $('.order-lines tr.product-7');

    // Show the row
    rowMultipay.hide();
    rowSinglepay.show();
    rowFreeShipping.show();

    rowMultipay.find('.qty').val(0);
    rowSinglepay.find('.qty').val(1);
    rowFreeShipping.find('.qty').val(1);

    $('input:radio[name="payment-option"]').filter('[value="singlepay"]').attr('checked', true);

    updatePricing();
  }

  function updatePricing() {

    total = subTotal = discountTotal = taxable_subTotal = 0;

    // Loop through our products and add up price
    $('.preview-table .order-lines tbody tr').each( function() {
      var qty = $(this).find('input.qty').val();
      var price = $(this).data('price');
      subTotal = subTotal + (qty * price);        // Get the first payment subtotal

      // Get the subtotal with full price of winbot in order to calculate tax
      var price2 = $(this).hasClass('product-2') ? 399.95 : $(this).data('price');      // If item is the multipay Winbot, change price to 399.95
      console.log(price2);
      taxable_subTotal += (qty * price2);
    });

    // Check expiration of discount code
    var couponDate = new Date(discountCode.expiration);
    var today = new Date();
    if (today > couponDate) {
      alert('Coupon has expired');
      $('.discount-code').val('');    // clear coupon code
    }

    // Figure out discount codes
    if(discountCode.type == 'flat') {
      discountTotal = parseFloat(discountCode.value);
    }
    if(discountCode.type == 'percent') {
      discountTotal = parseFloat(discountCode.value) * subTotal;
    }

    taxrate = getTaxRate();
    taxTotal = taxrate * taxable_subTotal;
    shippingTotal = getShippingAmount();
    total = subTotal + taxTotal + shippingTotal - discountTotal;
    grand_total = taxable_subTotal + taxTotal + shippingTotal - discountTotal;

    // Adjust dom with update totals
    $('.sub-total').empty().append(subTotal.toFixed(2));
    $('#sub-total').val(subTotal);
    $('.discount-total').empty().append(discountTotal);
    if (discountTotal > 0) {$('.discount-row').show();}
    $('.tax').empty().append(taxTotal.toFixed(2));
    $('#tax-total').val(taxTotal);
    $('#tax-rate').val(taxrate);
    $('.shipping-total').empty().append('$' + shippingTotal.toFixed(2));
    $('#shipping-total').val(shippingTotal);
    $('.total').empty().append(total.toFixed(2));
    $('#total').val(total);
    $('#grandtotal').val(grand_total);
    $('#taxable-subtotal').val(taxable_subTotal);
  }

  function getTaxRate() {
    taxrate = 0;

    if ($('#ckbxAddressDiffer').is(':checked')) {       // If Shipping Address Different is checked
      if ($('#s_country').val() == 'United States')
        {taxrate = ($('.s_states').val() == 'CA') ? 0.08 : 0;}
    } else {
      if ($('#Country').val() == 'United States')
        {taxrate = ($('.b_states').val() == 'CA') ? 0.08 : 0;}
    }
    return taxrate;
  }

  function getShippingAmount() {
    // Remove expedited option if needed
    updateExpediteOption();
    shippingcharge = 0.00;
    shipping = 0.00;

    // Loop through our products and add up shipping
    $('.preview-table .order-lines tbody tr').each( function() {
      var qty = $(this).find('input.qty').val();
      var productid = $(this).attr('class').substring(8,9);    // pull the product id out of the class name
      switch (productid) {
        case '1':
          shipping = 0.00; break;
        case '2':
          shipping = 24.95; break;
        case '3':
          shipping = 8.50; break;
        case '4':
          shipping = 8.50;  break;
        case '5':
          shipping = 8.50;  break;
        case '6':
          shipping = 24.95; break;
        case '7':
          shipping = 0.00; break;
      }

      shippingcharge += (qty * shipping);

      // Add $30.00 per Winbot for outer shipping areas
      if (outsideShipping == true && (productid == 1 | productid == 2 | productid == 6 ) ) {
        shippingcharge += (qty * 30.00);
      }
    });

    // If expedited shipping chosen, add $20.00
    if ($('#rushShip').is(':checked')) {shippingcharge += 20.00;}

    return shippingcharge;
  }

  function updateExpediteOption() {
      if ($('#ckbxAddressDiffer').is(':checked')) {     // If Shipping Address different is checked
          // If shipping country is US and shipping state is not Alaska or Hawaii
          if ( $('#s_country').val() == 'United States' && $('.s_states').val() != 'AK' && $('.s_states').val() != 'HI') {
            $('#expedite').removeClass('hidden');
            outsideShipping = false;
        } else {
          $('#expedite').addClass('hidden');      // Hide expedited shipping option
          $('input:radio[name="shipping"]').filter('[value="Standard"]').attr('checked', true);   // Check Standard Shipping
          $('input:radio[name="shipping"]').filter('[value="Rush"]').attr('checked', false);   // Uncheck Rush Shipping
          outsideShipping = true;
        }
      } else {
        // If billing country is US and billing state is not Alaska or Hawaii
        if ( $('#Country').val() == 'United States' && $('.b_states').val() != 'AK' && $('.b_states').val() != 'HI') {
            $('#expedite').removeClass('hidden');
            outsideShipping = false;
        } else {
          $('#expedite').addClass('hidden');      // Hide expedited shipping option
          $('input:radio[name="shipping"]').filter('[value="Standard"]').attr('checked', true);   // Check Standard Shipping
          $('input:radio[name="shipping"]').filter('[value="Rush"]').attr('checked', false);   // Uncheck Rush Shipping
          outsideShipping = true;
        }
      }
  }

});