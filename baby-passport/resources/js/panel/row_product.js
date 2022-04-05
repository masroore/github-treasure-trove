//It returns a row of product's detail
$.productDetailRow = function ($id, $detail) {

    const $button = {
        icon: '<i class="fas fa-trash"></i> Borrar',
        class: 'btn-danger',
        id: $id == '' ? 'deleteDetail' : 'deleteDBDetail'
    };

    return `
    <tr>
        <td>
            <input type="hidden" name="product_detail[id][]" value="${$id}"/>
            <input type="text" name="product_detail[detail][]" class="form-control btn-full-rounded" value="${$detail}" required data-parsley-group="details"/>
        </td>
        <td>
            <button type="button"  id="${$button.id}" data-id="${$id}" class="${$button.class} btn-sm">${$button.icon}</button>
        </td>
     </tr>
`;

}

$(document).ready(function () {


    $("#tbDetailsProduct tbody").html("");


    $.searchOnTable('searchDetail', 'tbDetailsProduct', 0);


    $("#addDetail").on("click", function () {
        $("#tbDetailsProduct tbody").append($.productDetailRow('', ''));
        return false;
    });


    //Delete detail when its not stored on database
    $(document).on("click", "#deleteDetail", function () {
        if (confirm('¿Está seguro(a) de eliminar el detalle del producto ?')) {
            $(this).parents("tr").remove();
        }
        return false;
    });


    //Delete detail in DB
    $(document).on("click", "#deleteDBDetail", function () {
        if (confirm('¿Está seguro(a) de eliminar el detalle?')) {
            deleteDetail(this, $(this).data("id"));
        }

        return false;
    });


    //AJAX function to delete a detail
    function deleteDetail($selector, $id) {

        $.simpleAjax({
            type: 'GET',
            url: $("#DATA").data("url") + '/products/detail/' + $id + '/delete',
            form: "",
            loadingSelector: "#tbDetailsProduct",
            crud: "Detalles",
            beforeSend: function () {
                $.setLoading(".modal .modal-content");
            },
            successCallback: function () {
                $(".modal .modal-content").unblock();
                $($selector).parents('tr').remove();
            },
            errorCallback: function () {
                $(".modal .modal-content").unblock();
            }


        });
    }


});
