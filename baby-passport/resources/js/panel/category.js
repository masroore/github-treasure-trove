$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();


    $("#categoryForm").parsley();
    //Open modal to create a new category
    $(document).on("click", "#openCategoryModal", function () {
        document.getElementById("categoryForm").reset();

        $("#id").val("");
        $("#categoryForm").data("action", "create");
        $("#modalTitle").text("Nueva Categoría");
        $("#categoryModal").modal("show");

        return false;
    });

    //Open modal to edit a category
    $(document).on("click", ".editCategory", function () {

        $("#categoryForm").data("action", "edit");
        $("#categoryModal").modal("show");
        $("#id").val($(this).data("id"));
        $("input[name='category']").val($(this).data('category'));
        $("select[name='color']").val($(this).data('color')).trigger("change");
        $("select[name='text_color']").val($(this).data('text_color')).trigger("change");
        $("#modalTitle").text("Editar Categoría");

        return false;
    });

    //Activate category
    $(document).on("click", "#activateCategory", function () {
        if (confirm("¿Está seguro(a) de activar la categoría?"))
            activateDeactive($(this).data("id"), 1);
        return false;
    });

    //Deactivate category
    $(document).on("click", "#deactivateCategory", function () {
        if (confirm("¿Está seguro(a) de desactivar la categoría ?"))
            activateDeactive($(this).data("id"), 0);
        return false;
    });

    //Save Category via AJAX
    $("#categoryForm").on("submit", function (e) {
        e.preventDefault();

        const valid = $("#categoryForm")
            .parsley()
            .isValid();
        if (valid) {
            saveTag();
        }
        return false;
    });

    //Ajax Function to send category info
    function saveTag() {

        $("input[name='_method']").val(
            $("#categoryForm").data("action") == "create" ? "POST" : "PATCH"
        );

        var url = $("#DATA").data("url") + "/categories";
        $.formDataAjax({
            modalTitle: "Categorías",
            type: "POST",
            url:
                $("#categoryForm").data("action") == "create"
                    ? url
                    : url + "/" + $("#id").val(),
            form: "categoryForm",
            loadingSelector: "#categoryModal",
            successCallback: function (data) {
                table.ajax.reload();
                $("#categoryModal").modal("hide");
            },
            errorCallback: function (data) {
            }
        });
    }


    //Activate or deactivate category via AJAX
    function activateDeactive(id, status) {
        $.simpleAjax({
            crud: "Categorías",
            type: "GET",
            url:
                $("#DATA").data("url") + `/categories/setStatus/${id}/${status}`,
            form: "",
            loadingSelector: ".panel",
            successCallback: function (data) {
                table.ajax.reload();
            },
            errorCallback: function (data) {
            }
        });
    }
});
