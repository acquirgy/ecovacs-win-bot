var order = [];

$(document).ready( function() {


  $("#pnlShipAddress").hide();
  $('#Province').hide();
  $('#Region').hide();

  $('#btnContinue').hide();

  $('tr[data-id="1"] td input').prop('disabled', true);

  $('#ckbxAddressDiffer').click( function(){
    $("#pnlShipAddress").show();
  });

  $('#multiPay').click( function() {
   order.paymentType = 'multipay';
   order.paymentTypeUpdated = true;
   $('#HiddenFieldId').val('multiPay');
   $('#panel1').show();
   $radios.filter('[value=multiPay]').prop('checked', true);
   // Remove FREE shipping to the cart
  //   updatePrices();
});

  $('#singlePay').click( function() {
   order.paymentType = 'singlepay';
   order.paymentTypeUpdated = true;
   $('#HiddenFieldId').val('singlePay');
   $('#panel1').hide();

  // Add FREE shipping to the cart

  //Remove Multi-Pay Winbot
  var form_data = {
    rowid: $('tr[data-id="2"]').attr("data-row"),   // Get the cart rowid from the Winbot row
    ajax: '1'
  };

  $.ajax({
    url: "http://ecovacs.local/index.php/main/removeMultiPayWinbot",
    type: 'POST',
    data: form_data,
    success: function() {
      window.location = 'http://ecovacs.local/index.php/main/shopping_cart';
    }
  });


  //   updatePrices();
});

});
