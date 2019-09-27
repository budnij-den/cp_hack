$(function () {
    $('#checkbox0').click(function () {
        if ($(this).is(':checked')) {
            $('#control0 .custom-control-input').attr("checked", "checked");
        } else {
            $('#control0 .custom-control-input').removeAttr("checked");
        }
    });
    $('#checkbox1').click(function () {
        if ($(this).is(':checked')) {
            $('#control1 .custom-control-input').attr("checked", "checked");
        } else {
            $('#control1 .custom-control-input').removeAttr("checked");
        }
    });
});