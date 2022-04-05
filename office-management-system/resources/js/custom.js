const APP_URL = $('meta[name="url"]').attr('content');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('select').niceSelect();
// metisMenu
var metismenu = $("#sidebar_menu");
if (metismenu.length) {
    metismenu.metisMenu();
}

$(".open_miniSide").click(function() {
    $(".sidebar").toggleClass("mini_sidebar");
    $("#main-content").toggleClass("mini_main_content");
});


$(document).click(function(event) {
    if (!$(event.target).closest(".sidebar,.sidebar_icon  ").length) {
        $("body").find(".sidebar").removeClass("active");
    }
});

function slideToggle(clickBtn, toggleDiv) {
    clickBtn.on('click', function() {
        toggleDiv.stop().slideToggle('slow');
    });
}


$(function() {
    $('#theme_nav li label').on('click', function() {
		$('#'+$(this).data('id')).show().siblings('div.Settings_option').hide();
    });
    $('#sms_setting li label').on('click', function() {
		$('#'+$(this).data('id')).show().siblings('div.sms_ption').hide();
    });
});



/*-------------------------------------------------------------------------------
        Start Upload file and chane placeholder name
    -------------------------------------------------------------------------------*/
var fileInput = document.getElementById('browseFile');
if (fileInput) {
    fileInput.addEventListener('change', showFileName);

    function showFileName(event) {
        var fileInput = event.srcElement;
        var fileName = fileInput.files[0].name;
        document.getElementById('placeholderInput').placeholder = fileName;
    }
}

if ($('.multipleSelect').length) {
    $('.multipleSelect').fastselect();
}

/*-------------------------------------------------------------------------------
        End Upload file and chane placeholder name
    -------------------------------------------------------------------------------*/

/*-------------------------------------------------------------------------------
        Start Check Input is empty
    -------------------------------------------------------------------------------*/
$('.input-effect input').each(function() {
    if ($(this).val().length > 0) {
        $(this).addClass('read-only-input');
    } else {
        $(this).removeClass('read-only-input');
    }

    $(this).on('keyup', function() {
        if ($(this).val().length > 0) {
            $(this).siblings('.invalid-feedback').fadeOut('slow');
        } else {
            $(this).siblings('.invalid-feedback').fadeIn('slow');
        }
    });
});

$('.input-effect textarea').each(function() {
    if ($(this).val().length > 0) {
        $(this).addClass('read-only-input');
    } else {
        $(this).removeClass('read-only-input');
    }
});

/*-------------------------------------------------------------------------------
        End Check Input is empty
    -------------------------------------------------------------------------------*/
$(window).on('load', function() {
    $('.input-effect input, .input-effect textarea').focusout(function() {
        if ($(this).val() != '') {
            $(this).addClass('has-content');
        } else {
            $(this).removeClass('has-content');
        }
    });
});

$('.primary-btn').on('click', function(e) {
    // Remove any old one
    $('.ripple').remove();

    // Setup
    var primaryBtnPosX = $(this).offset().left,
        primaryBtnPosY = $(this).offset().top,
        primaryBtnWidth = $(this).width(),
        primaryBtnHeight = $(this).height();

    // Add the element
    $(this).prepend("<span class='ripple'></span>");

    // Make it round!
    if (primaryBtnWidth >= primaryBtnHeight) {
        primaryBtnHeight = primaryBtnWidth;
    } else {
        primaryBtnWidth = primaryBtnHeight;
    }

    // Get the center of the element
    var x = e.pageX - primaryBtnPosX - primaryBtnWidth / 2;
    var y = e.pageY - primaryBtnPosY - primaryBtnHeight / 2;

    // Add the ripples CSS and start the animation
    $('.ripple')
        .css({
            width: primaryBtnWidth,
            height: primaryBtnHeight,
            top: y + 'px',
            left: x + 'px'
        })
        .addClass('rippleEffect');
});



// profile js
$(".fass_form_toggler").click(function() {
    $(this).parent('.password_wrap_inner').hide();
    $(".fass_form").slideDown();
});
$(".fass_form_close").click(function() {
    $(".fass_form").slideUp();
    $('.password_wrap_inner').show();
});

$(document).on('click', '.btn-modal', function(e) {
    e.preventDefault();
    let container = '.' + $(this).data('container');
    $.ajax({
        url: $(this).data('href'),
        dataType: 'html',
        success: function(result) {
            $(container)
                .html(result)
                .modal('show');

            $(container).on('shown.bs.modal', function() {
                $('input:text:visible:first', this).focus();
            })
        },
        error: function(data) {
            toastr.error('Something is not right!', 'Opps!');
        }
    });
});

if ((window.location.hash && window.location.hash === "#_=_")) {
    // If you are not using Modernizr, then the alternative is:
    if (window.history && history.replaceState) {
        window.history.replaceState("", document.title, window.location.pathname);
    } else {
        // Prevent scrolling by storing the page's current scroll offset
        var scroll = {
            top: document.body.scrollTop,
            left: document.body.scrollLeft
        };
        window.location.hash = "";
        // Restore the scroll offset, should be flicker free
        document.body.scrollTop = scroll.top;
        document.body.scrollLeft = scroll.left;
    }
}

if ($('.datatable').length > 0 && $().DataTable) {
    $.extend(true, $.fn.dataTable.defaults, {
        bLengthChange: false,
        "order": [
            [0, "desc"]
        ],
        language: {
            search: "<i class='ti-search'></i>",
            searchPlaceholder: 'Quick Search',
            paginate: {
                next: "<i class='ti-arrow-right'></i>",
                previous: "<i class='ti-arrow-left'></i>"
            }
        },
        dom: 'Bfrtip',
        buttons: [{
                extend: 'copyHtml5',
                text: '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy',
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel',
                margin: [10, 10, 10, 0],
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                },

            },
            {
                extend: 'csvHtml5',
                text: '<i class="fa fa-file-text"></i>',
                titleAttr: 'CSV',
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF',
                exportOptions: {
                    columns: ':visible',
                    columns: ':not(:last-child)',
                },
                orientation: 'landscape',
                pageSize: 'A4',
                margin: [0, 0, 0, 12],
                alignment: 'center',
                header: true,
                customize: function(doc) {
                    doc.content.splice(1, 0, {
                        margin: [0, 0, 0, 12],
                        alignment: 'center',
                        image: 'data:image/png;base64,' + $("#logo_img").val()
                    });
                }

            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                titleAttr: 'Print',
                exportOptions: {
                    columns: ':not(:last-child)',
                }
            },
            {
                extend: 'colvis',
                text: '<i class="fa fa-columns"></i>',
                postfixButtons: ['colvisRestore']
            }
        ],
        columnDefs: [{
            visible: false
        }],
        responsive: true,
        columnDefs: [{
            orderable: false,
            searchable: false,
            width: '100px',
            targets: -1
        }, {
            width: '30px',
            targets: 0
        }]
    });
}


$(document).on('click', '#logout', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
        url: url,
        method: 'Post',
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false,
        dataType: 'JSON',
        success: function(data) {
            toastr.success(data.message, 'Success');
            setTimeout(function() {
                window.location.href = data.goto;
            }, 2000);
        },
        error: function(data) {
            ajax_error(data);
        }
    });
});

$(document).on('keypress', 'input.input_number', function(event) {
    if (is_decimal == 0) {
        if (__currency_decimal_separator == '.') {
            var regex = new RegExp(/^[0-9,-]+$/);
        } else {
            var regex = new RegExp(/^[0-9.-]+$/);
        }
    } else {
        var regex = new RegExp(/^[0-9.,-]+$/);
    }

    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});



/*
=========================================
|                                       |
|               Popovers                |
|                                       |
=========================================
*/

$('.bs-popover').popover();


if($('.primary_select').length){
    $('.primary_select').niceSelect();
}


if ($('.date').length > 0 && $().datepicker) {
    $('.date').datepicker({
        Default: {
            leftArrow: '<i class="fa fa-long-arrow-left"></i>',
            rightArrow: '<i class="fa fa-long-arrow-right"></i>'
        },
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });

    $(document).on('click', '.date-icon', function() {
        $(this).parent().parent().find('.date').focus();
    });

    $(document).on('click', '.add_month', function() {
        let month = $(this).data('month');
        let new_date = moment().add(month, 'months').format("YYYY-MM-DD");

        $(this).parent().parent().parent().find('.date').val(new_date).datepicker('update');
    })
}

$(document).on('click', '.ajax_request', function (e){
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'JSON',
        success: function(data) {
            toastr.success(data.message, 'Success');
            if(data.goto){
                setTimeout(function() {
                    window.location.href = data.goto;
                }, 2000);
            }
            if (data.reload){
                setTimeout(function() {
                    window.location.href = '';
                }, 2000);
            }

        },
        error: function(data) {
            ajax_error(data);
        }
    });

})


//on click show description box
$(document).on('click', 'label[for="description"]', function (){
    $(this).removeClass('click_to_show_description');
    $(this).parent().find('textarea').removeClass('sr-only');
});
function ajax_error(data) {
    if (data.status === 404) {
        toastr.error("What you are looking is not found", 'Opps!');
        return;
    } else if (data.status === 500) {
        toastr.error('Something went wrong. If you are seeing this message multiple times, please contact Spondon IT authors.', 'Opps');
        return;
    } else if (data.status === 200) {
        toastr.error('Something is not right', 'Error');
        return;
    }
    let jsonValue = $.parseJSON(data.responseText);
    let errors = jsonValue.errors;
    if (errors) {
        let i = 0;
        $.each(errors, function(key, value) {
            let first_item = Object.keys(errors)[i];
            let error_el_id = $('#' + first_item);
            if (error_el_id.length > 0) {
                error_el_id.parsley().addError('ajax', {
                    message: value,
                    updateClass: true
                });
            }
            // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
            toastr.error(value, 'Validation Error');
            i++;
        });
    } else {
        toastr.error(jsonValue.message, 'Opps!');
    }
}

function jsUcfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}


function _formValidation(form_id = 'content_form', modal = false, modal_id = 'content_modal', ajax_table = null) {

    const form = $('#' + form_id);

    if (!form.length) {
        return;
    }

    form.parsley().on('field:validated', function() {
        $('.parsley-ajax').remove();
        const ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    });
    form.on('submit', function(e) {
        e.preventDefault();
        $('.parsley-ajax').remove();
        form.find('.submit').hide();
        form.find('.submitting').show();
        const submit_url = form.attr('action');
        const method = form.attr('method');
        //Start Ajax
        const formData = new FormData(form[0]);
        $.ajax({
            url: submit_url,
            type: method,
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
                // form.trigger("reset");
                // form.find("input:text:visible:first").focus();
                toastr.success(data.message, 'Succes');
                if (modal) {
                    $("." + modal_id).modal('hide');
                }
                if (ajax_table) {
                    ajax_table.ajax.reload();
                }

                if (data.goto) {
                    window.location.href = data.goto;
                }

                if (data.reload) {
                    window.location.href = '';
                }

                form.find('.submit').show();
                form.find('.submitting').hide();

            },
            error: function(data) {
                ajax_error(data);
                form.find('.submit').show();
                form.find('.submitting').hide();
            }
        });
    });
}


function change_status(button, ajax_table = null, change_status = false) {
    $(document).on('click', '#' + button, function(e) {
        e.preventDefault();
        var url = $(this).data('href');
        var status = $(this).data('status');
        var msg = '';
        if (status === 1) {
            msg = 'Change status from active to inactive';
        } else {
            msg = 'Change status from inactive to active';
        }

        if (!change_status) {
            msg = $(this).data('msg');
            if (!msg) {
                msg = 'Once deleted, it will delete all related data also';
            }
        } else {
            url = url + '?action=change_status';
        }

        swal({
                title: 'Are you sure?',
                text: msg,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#66cc99',
                cancelButtonColor: '#ff6666',
                confirmButtonText: 'Yes, Do it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger'
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        method: 'Delete',
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        dataType: 'JSON',
                        success: function(data) {
                            toastr.success(data.message, 'Success');
                            if (ajax_table) {
                                ajax_table.ajax.reload();
                            }
                        },
                        error: function(data) {
                            ajax_error(data);
                        }
                    });
                }
            });
    });
}


function convertNumber(number) {
    number = parseFloat(number);
    if (isNaN(number)) {
        return 0;
    }

    return number;
}
function imageChangeWithFile(input, srcId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(srcId)
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$('.popUP_clicker').on('click', function () {
    $('.menu_popUp_list_wrapper').toggleClass('active');
});