function showLoading(isShowLoading = true) {
    if (isShowLoading) $("#loading").show();
    else $("#loading").hide();
}

$(document).ready(function () {
    $("#loading").hide();
});
