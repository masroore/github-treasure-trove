function processPay() {
    var location = $("#cardPaymentForm").data('action');
    var form = document.getElementById("cardPaymentForm");
    var payData = $("#cardPaymentForm").serializeArray();


    $.ajax({
        type: "POST",
        url: location,
        data: $.param(payData),
        beforeSend: function () {
            $.setLoading("#cardPaymentForm", "Espere un momento, procesando transacción");
        },
        success: function (data) {


            $("#cardPaymentModal").modal("hide");
            $("#cardPaymentForm").unblock();

            $("#cardPaymentForm")
                .find("button")
                .prop("disabled", false);


            $("#profileData").data('process_step', 'parcial_payment');


            $("#receiptIframe").attr('src', data.receipt_url);
            $('#smartwizard').smartWizard("next");
            console.log("Smart wizard step");


            document.getElementById("cardPaymentForm").reset();


        },
        error: function (error) {
            $.unblockUI();
            var objError = error.responseJSON;

            $("html, body").animate({scrollTop: 0}, "slow");

            //Open pay transaction error handling
            if (objError.open_pay_code) {
                $(".pay-errors")
                    .html("<p>" + $.getSpanishError(objError.open_pay_code) + "</p>")
                    .removeClass("d-none");
            }

            //Open pay message error handling
            if (objError.open_pay_message) {
                $(".pay-errors")
                    .html("<p>" + objError.open_pay_message + "</p>")
                    .removeClass("d-none");
            }


            $("html, body").animate({scrollTop: 0}, "slow");

            $("form")
                .find("button")
                .prop("disabled", false);
        }
    });
}

//jQuery generate the token on submit.
$(function () {


    const maternityPackage = $("#profileData").data('maternity_package');

    OpenPay.setId("mxqd0md6sxov3pmg4xew");
    OpenPay.setApiKey("pk_aed17224750f45a5adbf03bc95961e36");
    OpenPay.setSandboxMode(true);

    //ID DEVICE SESSION
    var deviceSessionId = OpenPay.deviceData.setup(
        "cardPaymentForm",
        "deviceIdHiddenFieldName"
    );

    var sucess_callback = function (response) {
        var token_id = response.data.id;
        $("#token_id").val(token_id);
        processPay();
    };

    var error_callback = function (response) {
        if (response.data.error_code) {
            var description = $.getSpanishError(response.data.error_code);
            $(".pay-errors")
                .html("<p>" + description + "</p>")
                .removeClass("d-none");
        }
        $("#pay-button").prop("disabled", false);
    };


    //ADD OR REMOVE TAXES ON ALL PAYMENT METHODS
    $(".addTaxes").on('change', function () {

        const isPaypalForm = $(this).parents('form').attr('id') == 'paypalPaymentForm' ? true : false;
        const addTaxes = $(this).is(':checked') || $(this).val() == 'si';
        const paymentForm = $(isPaypalForm ? '#paypalPaymentForm' : '#cardPaymentForm');


        if (addTaxes) {
            paymentForm.find('input[name="subtotal"]').val(maternityPackage.subtotal);
            paymentForm.find('input[name="iva"]').val(maternityPackage.iva);
            paymentForm.find('input[name="amount"]').val(maternityPackage.total);
            paymentForm.find('.totalNoTaxes').hide();
            paymentForm.find('.totalTaxes').show();
        } else {
            paymentForm.find('input[name="subtotal"]').val(maternityPackage.subtotal);
            paymentForm.find('input[name="iva"]').val(0);
            paymentForm.find('input[name="amount"]').val(maternityPackage.subtotal);
            paymentForm.find('.totalNoTaxes').show();
            paymentForm.find('.totalTaxes').hide();
        }


    });


    $("#cardPaymentForm").submit(function (event) {
        event.preventDefault();

        $("#pay-button").prop("disabled", true);
        $(".pay-errors").addClass("d-none");

        OpenPay.token.extractFormAndCreate(
            "cardPaymentForm",
            sucess_callback,
            error_callback
        );
        return false;
    });
});
