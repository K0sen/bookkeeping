'use strict';

$(document).ready(function() {

    $('input:checkbox').prop('checked', false);
    $('.collapsable').css('display', 'none');

    $('.unfold').on('click', function () {
        if ($(this).prop("checked")) {
            if ($(this).parent().hasClass('category-name')) {
                $(this).parent().parent().find('li.collapsable').show(100, function () {
                    $(this).find('.unfold').prop('checked', false);
                });
            } else {
                $(this).parent().parent().find('ul.collapsable').show(100);
                $(this).parent().parent().find('.form__article').prop('checked', true);
            }
        } else {
            $(this).parent().parent().find('.form__article').prop('checked', false);
            $(this).parent().parent().find('.collapsable').hide(100);
        }
    });

    $('.form-display').submit(function(event) {

        event.preventDefault();

        let articles = $('.form__article:checked').serialize();
        let dateFrom = $('#date-from').val();
        let dateTo = $('#date-to').val();

        $.ajax({
            type: "GET",
            url: '/get-table',
            data: {
                "articles": articles,
                "date-from": dateFrom,
                "date-to": dateTo,
            },
            success: function(data) {

                if ($(".accounting-table").length) {
                    $('.accounting-table').remove();
                }
                $('.main').append(data);

            },
            error: function() {
                alert('ajax request failed :(');
            },
        })
    })

    $('to-top').click(function() {
        window.scrollTo(0, 0);
    });

});