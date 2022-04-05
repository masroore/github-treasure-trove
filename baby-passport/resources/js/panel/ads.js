$(function () {

    //----INITIALIZING COMPONENTS----
    var table = $('#dataTableBuilder').DataTable();

    $('#adForm').parsley();

    $.initFileInput('input[name="image"]', ['jpg', 'jpeg', 'bmp', 'gif', 'bmp', 'svg', 'png'], 'es');


    if ($("#adForm").data("advertising_id")) {

        var posterImage = $("input[name='image']");

        $.previewsFileInput(
            'input[name="image"]',   //input selector
            ['jpg', 'jpeg', 'bmp', 'gif', 'bmp', 'svg', 'png'], // allowed extensions
            'es', //language
            ["<img src='" + posterImage.data('url') + "' class='file-preview-image' style='width: 100%;height: inherit;'>"],
            [{
                type: "image",
                caption: posterImage.data('caption'),
                size: 817000,
                url: $("#DATA").data("url") + '/ads/deleteImage/' + $("#adForm").data("advertising_id"),
                key: 1
            }]
        );

    }

    $(".datepicker").datepicker({
        language: 'es',
        autoclose: true,
        format: 'yyyy-mm-dd'
    });


    //----INITIALIZING AND  VALIDATION ON FORM WIZARD----
    $("#smartwizard").smartWizard({
        theme: 'default',
        selected: 0,
        lang: {  // Language variables
            previous: 'Anterior',
            next: 'Siguiente'
        }
    }).on('leaveStep', function (e, anchorObject, stepNumber, stepDirection) {

        switch (stepNumber) {
            case 0:
                if (!$("#blogForm").parsley().validate({group: 'general'}))
                    return false;
                break;
            case 1:
                if (!$("#blogForm").parsley().validate({group: 'images'}))
                    return false;
                break;
            case 2:
                if (!$("#blogForm").parsley().validate({group: 'topics'}))
                    return false;
                break;
        }

    });

    //---- PARSLEY VALIDATION ON COMPONENTS
    $(".datepicker").on("changeDate", function () {
        $(this).parsley().validate();

    });


    $("#adForm").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);

        $.formDataAjax({
            form: 'adForm',
            loadingSelector: 'body',
            url: $("#DATA").data('url') + form.data('action'),
            type: 'POST',
            successCallback: function () {

            },
            errorCallback: function () {

            }
        });
    });


});
