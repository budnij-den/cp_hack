$(function () {
    $('body > .spinner-border').addClass('d-none');
    $('.page-header, .page-main, .page-footer').removeClass('d-none');
});
$(function () {
    $('a, button').click(function () {
        $('span').removeClass('d-none');
    });
});
$(window).bind('beforeunload', function () {
    $('span').addClass('d-none');
});