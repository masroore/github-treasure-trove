$(function () {

    $(".openPaymentHistoryModal").on("click", function () {

        console.log("Hospital");
        const cartId = $(this).data("cartid");

        $.ajax({
            url: $("#DATA").data("url") + '/paymentHistory/' + cartId,
            type: 'GET',
            success: function (data) {
                var payments = '';

                $.each(data.history, function (key, val) {
                    payments += `
                            <tr>
                                <td>${val.payment_uuid}</td>
                                <td>${val.description}</td>
                                <td>${val.old_balance} USD</td>
                                <td>${val.subtotal} USD</td>
                                <td>${val.new_balance} USD</td>
                                <td>
                                    <a class="btn btn-ce-soir btn-full-rounded " href="${val.receipt}" download="comprobante.pdf">
                                        <i class="fas fa-file-pdf"></i> Descargar Comprobante
                                    </a>
                                </td>
                             </tr>
                            `;
                });


                if (payments == '') {
                    $("#tbPaymentHistory tbody").html(`
                        <tr>
                            <td colspan="6" class="text-center font-campton text-ce-soir">
                                No hay pagos registrados
                            </td>    
                        </tr>
                    `);

                } else {
                    $("#tbPaymentHistory tbody").html(payments);

                }


                $("#paymentHistoryModal").modal("show");
            },
            error: function (error) {

            }
        });
    });


});
