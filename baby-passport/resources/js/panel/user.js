$(function () {

    var table = $('#dataTableBuilder').DataTable();
    $(".datepicker").datepicker({
        language: 'es',
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    table.on('preXhr.dt', function (e, settings, data) {
        data.user_type = $('#userFilter').val();
        data.from = $('#registerFrom').val();
        data.to = $('#registerTo').val();
        data.step = $('#stepFilter').val();
    });


    //RELOAD TABLE ON SELECT USER TYPE
    $("#filterSubmit").on("click", function () {
        table.ajax.reload();
    });

});
