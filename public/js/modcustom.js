$("#modloginform").click(function () {
    var name = $.session.get("loginemail");

    if ($("#remember").prop("checked")) {
        alert(name);
    }
});

$(document).ready(function () {
    setTimeout(function () {
        $("#message").fadeOut("fast");
    }, 5000);
});
