function savePresubscription() {
    var url = $("#DATA").data("url");

    $.ajax({
        type: "POST",
        url: url + "/soy-doctor/suscripcion",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        data: $.param($("form").serializeArray()),
        success: function success(data) {
            $("form").submit();
        },
        error: function error(data) {
            var errors = data.responseJSON.errors;

            // or, what you are trying to achieve
            // render the response via js, pushing the error in your
            // blade page
            var errorsHtml = '<div class="alert alert-danger"><ul>';

            $.each(errors, function(key, value) {
                errorsHtml += "<li>" + value[0] + "</li>"; //showing only the first error.
            });
            errorsHtml += "</ul></di>";

            $(".subscription-errors").html(errorsHtml);
            $(".subscription-errors").removeClass("d-none");
        }
    });
}

$(function() {
    $("#paypalSubmit").on("click", function() {
        var isFormValid = $("form")
            .parsley()
            .validate();

        if (isFormValid) {
            $(".subscription-errors").html("");
            savePresubscription();
        }

        return false;
    });
});
