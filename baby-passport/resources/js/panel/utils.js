//AJAX Loader
$.setLoading = function ($selector, $text) {
    $($selector).block({
        message: $text,
        baseZ: 1000,
        // set these to true to have the message automatically centered
        centerX: true, // <-- only effects element blocking (page block controlled via css above)
        centerY: true,
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: .5,
            color: '#fff'
        }
    });
};


//AJAX for attachs
$.formDataAjax = function ($params) {
    var formData = new FormData(document.getElementById($params.form));

    $.ajax({
        type: $params.type,
        url: $params.url,
        contentType: false,
        processData: false,
        cache: false,
        headers: {'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content')},
        beforeSend: function () {
            $.setLoading($params.loadingSelector);
        },
        data: formData,
        success: function (data) {
            $($params.loadingSelector).unblock();

            if (data.message) {

                $.toast({
                    text: data.message,
                    showHideTransition: 'slide',
                    textColor: '#fff',
                    bgColor: 'green',
                    position: 'top-center',
                    allowToastClose: true,
                    hideAfter: 5000
                });
            }


            $params.successCallback(data);
        },
        error: function (error) {

            var msg = '';
            $($params.loadingSelector).unblock();


            const errorData = error.responseJSON;
            if (errorData.errors) {
                $.each(errorData.errors, (key, val) => {
                    msg += `<li> ${val}</li>`;
                });
            }
            if (errorData.message && !errorData.errors) {
                msg = errorData.message;
            }


            $.toast({
                text: msg,
                bgColor: 'red',
                position: 'top-center',
                hideAfter: 20000,
                allowHtml: true
            });


            $params.errorCallback(error);
        }
    });
};


/*Setting Up The bootstrap fileinput plugin
@selector
@extensions:String[]  The allowed file extensions
@language
 */

$.initFileInput = function ($selector, $extensions, $language) {

    $($selector).fileinput({
        theme: 'fas',
        language: $language,
        showUpload: false,
        showRemove: false,
        showCancel: false,
        showUploadedThumbs: true,
        allowedFileExtensions: $extensions,
        previewClass: 'preview-custom-container',
        previewTemplates: {
            image:
                '<div class="file-preview-frame krajee-default  kv-preview-thumb" id="{previewId}" data-fileindex="{fileindex}" data-template="{template}">\n' +
                '   <div class="kv-file-content">' +
                '       <img src="{data}" class="kv-preview-data file-preview-image" title="{caption}" alt="{caption}" {style}>\n' +
                '   </div>\n' +
                '   <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>\n'
        }
    });

};

$.previewsFileInput = function ($selector, $extensions, $language, $previews, $previewsConfig, $datatable = null) {


    $($selector).fileinput("destroy").fileinput({
        theme: 'fas',
        language: $language,
        showUpload: false,
        showRemove: false,
        showCancel: false,
        showUploadedThumbs: true,
        allowedFileExtensions: $extensions,
        previewClass: 'preview-custom-container',
        previewTemplates: {
            image:
                '<div class="file-preview-frame krajee-default  kv-preview-thumb" id="{previewId}" data-fileindex="{fileindex}" data-template="{template}">\n' +
                '   <div class="kv-file-content">' +
                '       <img src="{data}" class="kv-preview-data file-preview-image" title="{caption}" alt="{caption}" {style}>\n' +
                '   </div>\n' +
                '   <button class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>\n'
        },
        initialPreview: $previews,
        initialPreviewConfig: $previewsConfig,
        deleteExtraData: {
            '_token': $('[name="csrf-token"]').attr('content')
        }
    }).on('filedeleted', function (e, params) {
        if ($datatable != null) {
            $datatable.ajax.reload();
        }
    });

};


//Ajax con informacion plana
$.simpleAjax = function ($params) {
    $.ajax({
        type: $params.type,
        url: $params.url,
        headers: {'X-CSRF-TOKEN': $('[name="csrf_token"]').attr('content')},
        beforeSend: function () {
            $.setLoading($params.loadingSelector);
        },
        data: $.param($($params.form).serializeArray()),
        success: function (data) {
            $($params.loadingSelector).unblock();

            if (data.message) {
                $.toast({
                    text: data.message,
                    showHideTransition: 'slide',
                    textColor: '#fff',
                    bgColor: 'green',
                    position: 'top-center',
                    allowToastClose: true,
                    hideAfter: 5000
                });
            }


            $params.successCallback(data);
        },
        error: function (error) {

            var msg = '';
            $($params.loadingSelector).unblock();

            $.each(JSON.parse(error.responseText), function (key, val) {
                msg += val + '<br/>';
            });

            $.toast({
                text: msg,
                bgColor: 'red',
                position: 'top-center',
                hideAfter: 20000,
                allowHtml: true
            });


            //Callback
            $params.errorCallback(error);


        }
    });


};


$.formatNumber = function ($number) {
    return parseFloat($number).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$.searchOnTable = function ($inputId, $tbId, $colIndex) {

    $("#" + $inputId).on("keyup", function () {

        var input, filter, table, tr, td, i;
        input = document.getElementById($inputId);
        filter = input.value.toUpperCase();
        table = document.getElementById($tbId);
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[$colIndex];

            if (td) {

                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    });

};
