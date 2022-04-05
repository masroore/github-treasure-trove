$(function () {

    //----INITIALIZING COMPONENTS----
    var table = $('#dataTableBuilder').DataTable();

    $("#categorySelect").selectpicker({
        language: 'es',
        multipleSeparator: ','
    });

    $("textarea[name='blog[intro]']").froalaEditor({
        language: 'es'
    });


    $(".froala").on('froalaEditor.image.beforeUpload', function (e, editor, files) {
        if (files.length) {
            // Create a File Reader.
            var reader = new FileReader();

            // Set the reader to insert images when they are loaded.
            reader.onload = function (e) {
                var result = e.target.result;
                editor.image.insert(result, null, null, editor.image.get());
            };

            // Read image as base64.
            reader.readAsDataURL(files[0]);
        }

        editor.popups.hideAll();

        // Stop default upload chain.
        return false;
    });


    $.initFileInput('input[name="blog[poster_image]"],input[name="blog[detail_image]"]', ['jpg', 'jpeg', 'bmp', 'gif', 'bmp', 'svg', 'png'], 'es');


    if ($("#blogForm").data("blog_id") != null) {

        $('.froala').froalaEditor({
            language: 'es'
        });

        var posterImage = $("input[name='blog[poster_image]']");
        var detailImage = $("input[name='blog[detail_image]']");


        $.previewsFileInput(
            'input[name="blog[poster_image]"]',   //input selector
            ['jpg', 'jpeg', 'bmp', 'gif', 'bmp', 'svg', 'png'], // allowed extensions
            'es', //language
            ["<img src='" + posterImage.data('url') + "' class='file-preview-image' style='width: 100%;height: inherit;'>"],
            [{
                type: "image",
                caption: posterImage.data('caption'),
                size: 817000,
                url: $("#DATA").data("url") + '/blogs/deleteImage/' + $("#blogForm").data("blog_id") + '/poster_image',
                key: 1
            }]
        );


        $.previewsFileInput(
            'input[name="blog[detail_image]"]',
            ['jpg', 'jpeg', 'bmp', 'gif', 'bmp', 'svg', 'png'],
            'es',
            ["<img src='" + detailImage.data('url') + "' class='file-preview-image' style='width: 100%;height: inherit;'>"],
            [{
                type: "image",
                caption: detailImage.data('caption'),
                size: 817000,
                url: $("#DATA").data("url") + '/blogs/deleteImage/' + $("#blogForm").data("blog_id") + '/detail_image',
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

    $(".selectpicker").on("changed.bs.select", function () {
        $(this).parsley().validate();
    });

    $(".froala").on("froalaEditor.contentChanged", function () {
        $(this).parsley().validate();
    });

    $(".datepicker").on("changeDate", function () {
        $(this).parsley().validate();

    });


    //----DATATABLE FILTERING
    $('#dataTableBuilder').on('preXhr.dt', function (e, settings, data) {
        data.category = $('#categorySelect').val();
    });

    $("#categorySelect").on("change", function () {
        table.ajax.reload();
    });


    //---- ADD A TOPIC ON CREATE BLOG ----

    $('#addTopic').on("click", function () {

        $('.blog-topics').append(`
                
                <div class="topic">
                    <div class="form-group">
                        <label>Título del subtema</label>
                        <input type="hidden" name="blog_topic[id][]" value=""  />
                        <input type="text" name="blog_topic[title][]" required data-parsley-group="topics" class="form-control btn-full-rounded" />
                    </div>
                    
                    <div class="form-group">
                        <label>Contenido</label>
                        <textarea class="froala form-control" name="blog_topic[content][]" data-parsley-group="topics" required></textarea>
                    </div>
                    
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-danger deleteRAMTopic">
                            <i class="fas fa-trash"></i> Borrar
                        </button>
                    </div>
                    
                       <hr class="my-4 border border-ce-soir">
                </div>
                
              
           
        `);


        $('.blog-topics .topic:last-child').find('textarea').froalaEditor({
            language: 'es'
        });

    });


    $(document).on("click", ".deleteRAMTopic", function () {
        $(this).parents('.topic').remove();
        return false;
    });

    //----DELETE TOPIC ON DB----
    $(document).on('click', '.deleteROMTopic', function () {

        const url = $(this).data('url');
        const topic = $(this).parents('.topic');


        if (confirm('¿Está seguro(a) de eliminar el subtema?')) {
            $.ajax({
                type: 'DELETE',
                url: url,
                headers: {'X-CSRF-TOKEN': $('[name="csrf-token"]').attr('content')},
                beforeSend: function () {
                    $.setLoading('body');
                },
                success: function (data) {
                    $('body').unblock();
                    topic.remove();
                },
                error: function (error) {
                    $('body').unblock();
                }
            })
        }
        return false;
    });

    $("#blogForm").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);

        $.formDataAjax({
            form: 'blogForm',
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
