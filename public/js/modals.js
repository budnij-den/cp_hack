$(document).ready(function () {
    $('#timeSet').click(function () {
        $('#timeForm').modal('show')
    });

    $('td > .statusSet').each(function (i, element) {
        $(element).click(function () {
            var id = $(this).parent().attr('id');
            if (id == 'ДЖ') {
                $("input[name='slba']").val(id);
                $('#dzhapaModal').modal('show');
            } else {
                $("input[name='slba']").val(id);
                $('#sluzhbaModal').modal('show');
            }
        });
    });

    $('.service').each(function (i, element) {
       $(element).click(function () {
           let dayNumber = $(this).attr('id');
           $('.description'+(dayNumber)).modal('show');
       })
    });
});