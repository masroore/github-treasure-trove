$(document).ready(function () {

    var table = $('#dataTableBuilder').DataTable();


    $("#ratingForm").parsley();
    //Open modal to create a new rating
    $(document).on("click", "#openRatingModal", function () {
        document.getElementById("ratingForm").reset();

        $("#id").val("");
        $("#ratingForm").data("action", "create");
        $("#modalTitle").text("Nuevo Rating");
        $("#ratingModal").modal("show");

        return false;
    });

    //Open modal to edit a rating
    $(document).on("click", ".editRating", function () {

        $("#ratingForm").data("action", "edit");
        $("#ratingModal").modal("show");
        $("#id").val($(this).data("id"));
        $("input[name='rating_description']").val($(this).data('rating_description'));
        $("select[name='star_number']").val($(this).data('star_number')).trigger("change");
        $("#modalTitle").text("Editar Rating");

        return false;
    });

    //Activate rating
    $(document).on("click", "#activateRating", function () {
        if (confirm("¿Está seguro(a) de activar el rating?"))
            activateDeactive($(this).data("id"), 1);
        return false;
    });

    //Deactivate rating
    $(document).on("click", "#deactivateRating", function () {
        if (confirm("¿Está seguro(a) de desactivar el rating ?"))
            activateDeactive($(this).data("id"), 0);
        return false;
    });

    //Save Rating via AJAX
    $("#ratingForm").on("submit", function (e) {
        e.preventDefault();

        const valid = $("#ratingForm")
            .parsley()
            .isValid();
        if (valid) {
            saveRating();
        }
        return false;
    });

    //Ajax Function to send rating info
    function saveRating() {

        $("input[name='_method']").val(
            $("#ratingForm").data("action") == "create" ? "POST" : "PATCH"
        );

        var url = $("#DATA").data("url") + "/ratings";
        $.formDataAjax({
            modalTitle: "Ratings",
            type: "POST",
            url:
                $("#ratingForm").data("action") == "create"
                    ? url
                    : url + "/" + $("#id").val(),
            form: "ratingForm",
            loadingSelector: "#ratingModal",
            successCallback: function (data) {
                table.ajax.reload();
                $("#ratingModal").modal("hide");
            },
            errorCallback: function (data) {
            }
        });
    }


    //Activate or deactivate rating via AJAX
    function activateDeactive(id, status) {
        $.simpleAjax({
            crud: "Ratings",
            type: "GET",
            url:
                $("#DATA").data("url") + `/ratings/setStatus/${id}/${status}`,
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
