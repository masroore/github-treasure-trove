$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();


    $("#tagForm").parsley();
    //Open modal to create a new tag
    $(document).on("click", "#openTagModal", function () {
        document.getElementById("tagForm").reset();

        $("#id").val("");
        $("#tagForm").data("action", "create");
        $("#modalTitle").text("Nueva Etiqueta");
        $("#tagModal").modal("show");

        return false;
    });

    //Open modal to edit a tag
    $(document).on("click", ".editTag", function () {

        $("#tagForm").data("action", "edit");
        $("#tagModal").modal("show");
        $("#id").val($(this).data("id"));
        $("input[name='tag']").val($(this).data('tag'));
        $("#modalTitle").text("Editar Etiqueta");

        return false;
    });

    //Activate tag
    $(document).on("click", "#activateTag", function () {
        if (confirm("¿Está seguro(a) de activar la etiqueta?"))
            activateDeactive($(this).data("id"), 1);
        return false;
    });

    //Deactivate tag
    $(document).on("click", "#deactivateTag", function () {
        if (confirm("¿Está seguro(a) de desactivar la etiqueta ?"))
            activateDeactive($(this).data("id"), 0);
        return false;
    });

    //Save Tag via AJAX
    $("#tagForm").on("submit", function (e) {
        e.preventDefault();

        const valid = $("#tagForm")
            .parsley()
            .isValid();
        if (valid) {
            saveTag();
        }
        return false;
    });

    //Ajax Function to send tag info
    function saveTag() {

        $("input[name='_method']").val(
            $("#tagForm").data("action") == "create" ? "POST" : "PATCH"
        );

        var url = $("#DATA").data("url") + "/tags";
        $.formDataAjax({
            modalTitle: "Etiquetas",
            type: "POST",
            url:
                $("#tagForm").data("action") == "create"
                    ? url
                    : url + "/" + $("#id").val(),
            form: "tagForm",
            loadingSelector: "#tagModal",
            successCallback: function (data) {
                table.ajax.reload();
                $("#tagModal").modal("hide");
            },
            errorCallback: function (data) {
            }
        });
    }


    //Activate or deactivate tag via AJAX
    function activateDeactive(id, status) {
        $.simpleAjax({
            crud: "Etiquetas",
            type: "GET",
            url:
                $("#DATA").data("url") + `/tags/setStatus/${id}/${status}`,
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
