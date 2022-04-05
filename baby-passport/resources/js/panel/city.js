$(document).ready(function () {


    $.initFileInput('#image', ['jpg', 'jpeg', 'bmp', 'gif', 'bmp', 'svg', 'png'], 'es');
    $.initFileInput('#bg_image', ['jpg', 'jpeg', 'bmp', 'gif', 'bmp', 'svg', 'png'], 'es');

    var table = $('#dataTableBuilder').DataTable();


    $("#cityForm").parsley();
    //Open modal to create a new city
    $(document).on("click", "#openCityModal", function () {
        document.getElementById("cityForm").reset();

        $("#id").val("");
        $("#cityForm").data("action", "create");
        $("#modalTitle").text("Nueva Ciudad");
        $("#cityModal").modal("show");

        return false;
    });

    //Open modal to edit a city
    $(document).on("click", ".editCity", function () {

        const city = $(this).data('city');
        const copy = $(this).data('copy');
        const cityId = $(this).data("id");

        const images = {
            poster: $(this).data('image'),
            web: $(this).data('bg_image')
        }


        $("#cityForm").data("action", "edit");
        $("#cityModal").modal("show");
        $("#id").val(cityId);
        $("input[name='city']").val(city);
        $("textarea[name='copy']").val(copy);
        $("#modalTitle").text("Editar Ciudad");

        if (images.poster != undefined) {
            $.previewsFileInput(
                '#image',
                ['jpg', 'jpeg', 'bmp', 'gif', 'bmp', 'svg', 'png'],
                'es',
                ["<img src='" + images.poster + "' class='file-preview-image' style='width: 100%;height: inherit;' alt='Desert' title='Desert'>"],
                [{
                    type: "image",
                    caption: city,
                    size: 817000,
                    url: $("#DATA").data("url") + '/cities/' + cityId + '/deleteImage/image',
                    key: 1
                }],
                table
            );

        }


        if (images.web != undefined) {
            $.previewsFileInput(
                '#bg_image',
                ['jpg', 'jpeg', 'bmp', 'gif', 'bmp', 'svg', 'png'],
                'es',
                ["<img src='" + images.web + "' class='file-preview-image' style='width: 100%;height: inherit;' alt='Desert' title='Desert'>"],
                [{
                    type: "image",
                    caption: city,
                    size: 817000,
                    url: $("#DATA").data("url") + '/cities/' + cityId + '/deleteImage/bg_image',
                    key: 1
                }],
                table
            );

        }


        return false;
    });

    //Activate city
    $(document).on("click", "#activateCity", function () {
        if (confirm("¿Está seguro(a) de activar la ciudad?"))
            activateDeactive($(this).data("id"), 1);
        return false;
    });

    //Deactivate city
    $(document).on("click", "#deactivateCity", function () {
        if (confirm("¿Está seguro(a) de desactivar la ciudad ?"))
            activateDeactive($(this).data("id"), 0);
        return false;
    });

    //Save City via AJAX
    $("#cityForm").on("submit", function (e) {
        e.preventDefault();

        const valid = $("#cityForm")
            .parsley()
            .isValid();
        if (valid) {
            saveCity();
        }
        return false;
    });

    //Ajax Function to send city info
    function saveCity() {

        $("input[name='_method']").val(
            $("#cityForm").data("action") == "create" ? "POST" : "PATCH"
        );


        var url = $("#DATA").data("url") + "/cities";
        $.formDataAjax({
            modalTitle: "Ciudades",
            type: "POST",
            url:
                $("#cityForm").data("action") == "create"
                    ? url
                    : url + "/" + $("#id").val(),
            form: "cityForm",
            loadingSelector: "#cityModal .modal-content",
            successCallback: function (data) {
                table.ajax.reload();
                $("#cityModal").modal("hide");
                $(".file-preview-thumbnails").html('');
            },
            errorCallback: function (data) {
            }
        });
    }


    //Activate or deactivate category via AJAX
    function activateDeactive(id, status) {
        $.simpleAjax({
            crud: "Ciudades",
            type: "GET",
            url:
                $("#DATA").data("url") + `/cities/setStatus/${id}/${status}`,
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
