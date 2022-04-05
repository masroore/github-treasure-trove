$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();


    $("#smartwizard").smartWizard({
        theme: 'default',
        lang: {  // Language variables
            previous: 'Anterior',
            next: 'Siguiente'
        }
    }).on('leaveStep', function (e, anchorObject, stepNumber, stepDirection) {

        switch (stepNumber) {
            case 0:
                if (!$("#productForm").parsley().validate({group: 'general'}))
                    return false;
                break;
            case 1:
                if (!$("#productForm").parsley().validate({group: 'details'}))
                    return false;
                break;
        }

    });


    $("#productForm").parsley();
    //Open modal to create a new product
    $(document).on("click", "#openProductModal", function () {
        document.getElementById("productForm").reset();

        $("#id").val("");
        $("#productForm").data("action", "create");
        $("#modalTitle").text("Nuevo Producto");
        $("#productModal").modal("show");
        $("#smartwizard").smartWizard('reset');


        return false;
    });

    //Open modal to edit a product
    $(document).on("click", ".editProduct", function () {

        $("#productForm").data("action", "edit");
        $("#productModal").modal("show");
        $("#id").val($(this).data("id"));
        $("#modalTitle").text("Editar Producto");

        $("#smartwizard").smartWizard('reset');


        getProductInfo($(this).data("id"));
        return false;
    });

    //Activate product
    $(document).on("click", "#activateProduct", function () {
        if (confirm("¿Está seguro(a) de activar el producto?"))
            activateDeactive($(this).data("id"), 1);
        return false;
    });

    //Deactivate product
    $(document).on("click", "#deactivateProduct", function () {
        if (confirm("¿Está seguro(a) de desactivar el producto ?"))
            activateDeactive($(this).data("id"), 0);
        return false;
    });

    //Save Product via AJAX
    $("#productForm").on("submit", function (e) {
        e.preventDefault();

        const valid = $("#productForm")
            .parsley()
            .isValid();
        if (valid) {
            saveProduct();
        }
        return false;
    });


    function getProductInfo($id) {
        $.ajax({
            type: "GET",
            url: $("#DATA").data("url") + "/products/" + $id,
            beforeSend: function () {
                $.setLoading("#dataTableBuilder");
            },
            success: function (data) {
                var detailsRows = '';

                $("#dataTableBuilder").unblock();

                $("input[name='product[product]']").val(data.product.product);
                $("textarea[name='product[description]']").text(data.product.description);


                $.each(data.product.details, function (key, val) {
                    detailsRows += $.productDetailRow(val.id, val.detail);
                });

                $("#tbDetailsProduct tbody").html(detailsRows);


            }, error: function (error) {
                $("#dataTableBuilder").unblock();

            }
        })
    }


    //Ajax Function to send product info
    function saveProduct() {

        $("input[name='_method']").val(
            $("#productForm").data("action") == "create" ? "POST" : "PATCH"
        );

        var url = $("#DATA").data("url") + "/products";
        $.formDataAjax({
            modalTitle: "Productos",
            type: "POST",
            url:
                $("#productForm").data("action") == "create"
                    ? url
                    : url + "/" + $("#id").val(),
            form: "productForm",
            loadingSelector: "#productModal",
            successCallback: function (data) {
                table.ajax.reload();
                $("#productModal").modal("hide");
                document.getElementById('productForm').reset();
                $("#productModal table tbody").html("");

            },
            errorCallback: function (data) {
            }
        });
    }


});
