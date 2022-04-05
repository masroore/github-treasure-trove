// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('a38982f5d8e02b4bb37f', {
    cluster: 'us2',
    forceTLS: true
});

var channel = pusher.subscribe('administrator');
channel.bind('mom-event', function (data) {
    const notify = document.getElementById("notificationSound");
    const notificationsLength = $("#notificationsContainer .dropdown-notification").length;
    notify.play();


    const notification = getNotificationItem(data.notification.id, data.notification.url, data.notification.description, data.notification.date);
    $("#notificationsContainer").prepend(notification);
    $("#notificationsBadge").text(notificationsLength + 1);

});


function getNotificationItem($id, $link, $description, $date) {
    return `
        <a class="dropdown-item dropdown-notification font-campton" href="${$link}" data-id="${$id}">
            <div class="notification-read">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
            <div class="notifications-body text-wrap">
                <p class="notification-texte text-ce-soir">${$description}</p>
                <p class="notification-date text-muted mt-2">
                    <i class="fa fa-clock-o" aria-hidden="true"></i> ${$date}
                </p>
            </div>
        </a>
    `;
}

$(function () {

    $.ajax({
        type: 'GET',
        url: $("#DATA").data('url') + '/notifications',
        success: function (data) {
            var notifications = '';

            $.each(data.notifications, function (key, val) {
                notifications += getNotificationItem(val.id, val.url, val.description, val.date);
            });

            $("#notificationsContainer").html(notifications);
            $("#notificationsBadge").text(data.notifications.length);
        },
        error: function () {

        }
    });

    $(document).on("click", ".dropdown-notification", function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        const deleteUrl = $(this).attr('href');

        $.ajax({
            type: 'GET',
            url: $("#DATA").data('url') + '/notifications/' + id + '/delete',
            success: function () {
                window.location.href = deleteUrl;
            },
            error: function () {

            }
        });
    });


});