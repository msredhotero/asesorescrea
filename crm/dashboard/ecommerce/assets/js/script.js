$(function() {

    var owner = $('#owner');
    var cardNumber = $('#cardNumber');
    var cardNumberField = $('#card-number-field');
    var CVV = $("#cvv");
    var mastercard = $("#mastercard");
    var confirmButton = $('#confirm-purchase');
    var visa = $("#visa");
    //var carnet = $("#carnet");
    //var tipotarjeta = $('#tipotarjeta');

    // Use the payform library to format and validate
    // the payment fields.

    cardNumber.payform('formatCardNumber');
    CVV.payform('formatCardCVC');

    /*
   tipotarjeta.change(function() {
      carnet.removeClass('transparent');
      visa.removeClass('transparent');
      mastercard.removeClass('transparent');

      if (tipotarjeta.val() == 'Visa') {
         carnet.addClass('transparent');
         mastercard.addClass('transparent');
      }
      if (tipotarjeta.val() == 'Mastercard') {
         carnet.addClass('transparent');
         visa.addClass('transparent');
      }
      if (tipotarjeta.val() == 'Carnet') {
         visa.addClass('transparent');
         mastercard.addClass('transparent');
      }
   });
   */

    cardNumber.keyup(function() {

        //carnet.removeClass('transparent');
        visa.removeClass('transparent');
        mastercard.removeClass('transparent');

        if ($.payform.validateCardNumber(cardNumber.val()) == false) {
            cardNumberField.addClass('has-error');
        } else {
            cardNumberField.removeClass('has-error');
            cardNumberField.addClass('has-success');
        }

        if ($.payform.parseCardType(cardNumber.val()) == 'visa') {
            mastercard.addClass('transparent');
            //amex.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') {
            //amex.addClass('transparent');
            visa.addClass('transparent');
        }


    });



    confirmButton.click(function(e) {

        e.preventDefault();

        var isCardValid = $.payform.validateCardNumber(cardNumber.val());
        var isCvvValid = $.payform.validateCardCVC(CVV.val());

        if(owner.val().length < 5){
           swal({
               title: "Error!!",
               text: "Complete Nombre que aparece en la Tarjeta",
               type: "error",
               timer: 2000,
               showConfirmButton: false
           });
        } else if (!isCardValid) {
           swal({
               title: "Error!!",
               text: "Número de tarjeta invalido",
               type: "error",
               timer: 2000,
               showConfirmButton: false
           });
        } else if (!isCvvValid) {
           swal({
               title: "Error!!",
               text: "Complete el CVV",
               type: "error",
               timer: 2000,
               showConfirmButton: false
           });
        } else {
            // Everything is correct. Add your form submission code here.
            swal({
               title: "Respuesta",
               text: "Datos Correctos, vamos a procesar su pago",
               type: "success",
               timer: 1500,
               showConfirmButton: false
            });
            $( "#formPago" ).submit();
        }
    });
});
