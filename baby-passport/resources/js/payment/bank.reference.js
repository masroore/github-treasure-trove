$(function () {

    //OPEN BANK REFERENCE MODAL
    $(".openBankReferenceModal").on("click", function () {

        const maternityPackage = $("#profileData").data('maternity_package');


        $("#bankReferenceForm input[name='item']").val(maternityPackage.description);
        $("#bankReferenceForm input[name='subtotal']").val(maternityPackage.subtotal);
        $("#bankReferenceForm input[name='iva']").val(maternityPackage.iva);
        $("#bankReferenceForm input[name='amount']").val(maternityPackage.subtotal);
        $("#bankReferenceForm input[name='cart_id']").val(maternityPackage.id);


        $("#subtotalLabel").text($.formatNumber(maternityPackage.subtotal) + ' USD');
        $("#ivaLabel").text($.formatNumber(0) + ' USD');
        $("#totalLabel").text($.formatNumber(maternityPackage.subtotal) + ' USD');


        $("#invoiceCheck").prop('checked', false);

        $("#bankReferenceModal").modal("show");
    });


    //ADD THE IVA TO DEPOSIT OR NOT
    $(".invoiceCheck").on("change", function () {

        const isInvoiceRequired = $(this).is(':checked');
        const referenceForm = $("#bankReferenceForm");


        const subtotal = $("#profileData").data('maternity_package').subtotal;
        const iva = $("#profileData").data('maternity_package').iva;
        const amount = $("#profileData").data('maternity_package').total;


        console.log(subtotal, iva, amount);

        if (isInvoiceRequired) {

            referenceForm.find("input[name='subtotal']").val(subtotal);
            referenceForm.find("input[name='iva']").val(iva);
            referenceForm.find("input[name='amount']").val(amount);

            referenceForm.find('#subtotalLabel').text($.formatNumber(subtotal) + ' USD');
            referenceForm.find('#ivaLabel').text($.formatNumber(iva) + ' USD');
            referenceForm.find('#totalLabel').text($.formatNumber(amount) + ' USD');

        } else {
            referenceForm.find("input[name='subtotal']").val(subtotal);
            referenceForm.find("input[name='iva']").val(0);
            referenceForm.find("input[name='amount']").val(subtotal);

            referenceForm.find('#subtotalLabel').text($.formatNumber(subtotal) + ' USD');
            referenceForm.find('#ivaLabel').text($.formatNumber(0) + ' USD');
            referenceForm.find('#totalLabel').text($.formatNumber(subtotal) + ' USD');
        }

    });

    $("#submitBankReference").on("click", function () {


        //GET THE CURRENT EXCHANGE RATE USD -> MXN AND DOWNLOAD THE REFERENCE FROM BANXICO
        $.ajax({
            url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43787/datos/oportuno?token=19c1cf1ca150581301a28c730cfedbe0daefd2c998a37373e9cd0dc3f801181d",
            jsonp: "callback",
            dataType: "jsonp",
            success: function (response) {
                const bmx = response.bmx.series[0].datos[0];

                $("#bankReferenceForm input[name='exchange_rate']").val(bmx.dato);
                $("#bankReferenceForm").submit();
            }
        });


    });


});
