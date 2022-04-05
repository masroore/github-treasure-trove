$(function () {

    $("#orderSelect").on("change", function () {
        window.location.href = $(this).val();
    });
});
