$(document).ready(function () {
    $('.stts').each(function (j, element) {
        $(element).click(function () {
            let name = $(this).parent().attr('title');
            let id = $(this).parent().attr('id');
            let date = $(this).attr('id');
            $('.modal-title').html(name);
            for (k = 0; k < date; k++) {
                for (i = 0; i < 7; i++) {
                    let statuses = $('.sts' + id + [i] + [k]).attr('title');
                    $('.st' + [i] + [k]).html(statuses);
                }
            }
            $('#statuses').modal('show');
        });
    });
    if ($(window).width() < 770) {
        $('#stats').removeClass('w-75').addClass('w-100');
        $('.subj').removeClass('w-25').addClass('w-100');
        $('#flex').removeClass('flex-row').addClass('flex-column');
    }

    $('select').click(function () {
        let userInput = $('input[name = "id"]');
        let userId = $(this).parents('tr').attr('title');
        userInput.val(userId);
    });
});