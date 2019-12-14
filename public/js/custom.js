$(document).ready(function () {
    // notification message
    $(".noti-message").animate({
        right: "0"
    }, 400, function () {
        $(this).delay(3000).animate({
            right: "-4000px"
        }, 900);
    });
});
