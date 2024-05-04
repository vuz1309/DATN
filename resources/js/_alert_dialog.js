// alert_dialog.js

function showAlert(title, content, cb) {
    $("#alertTitle").text(title);
    $("#alertContent").text(content);
    $("#alertDialog").show();
    $("#alertOKButton").click(function () {
        $("#alertDialog").hide();
        cb?.();
    });
}

$(document).ready(function () {
    $("#alertOKButton").click(function () {
        $("#alertDialog").hide();
    });
});
