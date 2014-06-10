$(document).ready( function() {

  var taxTotal = 0;
  var subTotal = 0;
  var total = 0;
  var taxable_subTotal = 0;
  var grand_total = 0;
  var discountTotal = 0;
  var coupon = {};
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
      // If no token has been created, do so, otherwise submit!
      showFormLoader(true);
      if(!$('#card_id').val()) {
        tokenizeCard();
      } else {
        $('#card_number').val('');
        $('#card_code').val('');
        form.submit();
      }
    }
  });

  // Start off with main item in cart
  addMultipayWinbot();

  populateStateProvinces();

  // Add Upsell button click
  $('.add').click( function() {
    var productId = $(this).data('id');
    var row = $('.order-lines tr.product-' + productId);
    // Show the row
    row.show();
    // Find the qty input in that row and upate its value
    var currentValue = parseInt(row.find('.qty').val());
    var newValue = currentValue + 1;
    var price = parseFloat(row.data('price'));
    row.find('.qty').val(newValue);
    $(".rowtotal-" + productId).html(newValue * price);
    updatePricing();
    _gaq.push(['_trackEvent', 'Cart', 'Add Upsell', $(this).siblings("h2").html()]);

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

  // Discount Code Applied
  $('.submit-coupon').on('click', function(e) {
    e.preventDefault();
    applyCoupon();
  });

  // Lets populate the state_province dropdown with options based on country
  $('.country').on('change', function()  {
    populateStateProvinces();
  });

  $('#b_state_province').on('change', function() {
    updatePricing();
  });

  // Update shipping address in the background as they type in the billing address
  $('.billing-address input, .billing-address select').on('keyup paste change', function() {
    if(!$('#shipping_address_different').is(':checked')) {
      var value = $(this).val();
      var fieldName = $(this).attr('id').substr(2);
      $('.shipping-address #s_' + fieldName).val(value);
    }
  });

  // Deal with customer checking and unchecking the shipping address is different checkbox
  $('#shipping_address_different').on('click', function() {
    var isDifferent = $(this).is(':checked');
    $('.shipping-address input, .shipping-address select').each( function() {
      if(isDifferent) {
        $(this).val('');
        $('.shipping-address').show();
      } else {
        var fieldName = $(this).attr('id').substr(2);
        var value = $('.billing-address #b_' + fieldName).val();
        $(this).val(value);
        $('.shipping-address').hide();
      }
    });
  });

  // Remove button is clicked
  $('.remove').click( function() {
    var productId = $(this).data('id');
    var row = $('.order-lines tr.product-' + productId);
    // Hide the row
    row.hide();
    // Find the qty input in that row and upate its value to 0
    row.find('.qty').val(0);
    updatePricing();
  });

  //Payment Options
  $('#multipay').click( function() {
    addMultipayWinbot();
  });

  $('#singlepay').click( function() {
    addSinglepayWinbot();
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

  function addMultipayWinbot() {

    $('#Note').show();

    var rowMultipay = $('.order-lines tr.product-2');
    var rowSinglepay = $('.order-lines tr.product-1');
    var rowFreeShipping = $('.order-lines tr.product-7');

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

    $('#Note').hide();

    var rowMultipay = $('.order-lines tr.product-2');
    var rowSinglepay = $('.order-lines tr.product-1');
    var rowFreeShipping = $('.order-lines tr.product-7');

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

  function applyCoupon() {
    var couponCode = $('#coupon_code_temp').val();
    var address = $('#b_address').val();
    var city = $('#b_city').val();

    if(!couponCode || !address || !city) {
      $('#coupon_code').val('');
      alert('Billing Address and Coupon Code must be filled in.');
      return false;
    }

    showFormLoader(true);

    $.ajax({
      url: '/index.php/main/get_coupon/',
      data: $('form').serialize(),
      type: 'POST',
      dataType: 'JSON',
      success: function(result) {
        if(result.coupon && !result.error) {
          $('#coupon_code').val(couponCode);
          updatePricing();
        } else {
          showFormLoader(false);
          alert(result.error);
        }
      }
    });
  }

  function populateStateProvinces() {

    var bCountry = $('#b_country').val();
    if(bCountry == 'United States') var options = stateOptions;
    if(bCountry == 'Canada') var options = provinceOptions;
    if(bCountry == 'Puerto Rico') var options = regionOptions;
    $('#b_state_province').empty().append(createHtmlOptions(options));

    var sCountry = $('#s_country').val();
    if(sCountry == 'United States') var options = stateOptions;
    if(sCountry == 'Canada') var options = provinceOptions;
    if(sCountry == 'Puerto Rico') var options = regionOptions;
    $('#s_state_province').empty().append(createHtmlOptions(options));

  }

  function createHtmlOptions(options) {
    htmlOptions = '';
    for(var key in options) {
      htmlOptions += '<option value="' + key + '">' + options[key] + '</option>';
    }
    return htmlOptions;
  }


  function updatePricing() {
    showFormLoader(true);
    $.ajax({
      type: 'POST',
      url: '/main/get_pricing',
      data: $('form').serialize(),
      dataType: 'JSON',
      success: function(result) {
        showFormLoader(false);
        // Adjust dom with update totals
        $('.sub-total').empty().append(toDollar(result.subtotal));
        $('.discount-total').empty().append(toDollar(result.discount_total));
        $('.discount-row').toggle(result.discount_total > 0 ? true : false);
        $('.tax').empty().append(toDollar(result.tax_total));
        $('.shipping-total').empty().append(toDollar(result.shipping_total));
        $('.total').empty().append(toDollar(result.total));
      }
    });
  }

  function tokenizeCard() {
    $.ajax({
      type: 'POST',
      url: '/main/tokenize_card',
      data: $('form').serialize(),
      dataType: 'JSON',
      success: function(result) {
        if(result.error) {
          showFormLoader(false);
          $('.card-error').empty().append(result.error).show();
        } else {
          $('#card_id').val(result.card_id);
          $('form').submit();
        }
      }
    });
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

  function showFormLoader(show) {
    $('#totals').toggle(!show);
    $('.submit-order').toggle(!show);
    $('.form-loader').toggle(show);
  }

  function toDollar(amount) {
    return '$' + amount.toFixed(2);
  }

});