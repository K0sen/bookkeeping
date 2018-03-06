'use strict';

$(document).ready(function() {

    $(".file-upload").submit(function(event) {

        event.preventDefault();

        // Collect data from form
        let file_data = $('#inputFile').prop('files')[0];
        if ( !file_data.name.endsWith('.csv') ) {
            alert("upload a .CSV file");
            return;
        }

        let dateFrom = $('#date-from').val();
        let dateTo = $('#date-to').val();
        let form_data = new FormData();

        form_data.append('file', file_data);
        form_data.append('date-from', dateFrom);
        form_data.append('date-to', dateTo);

        $('.file-upload').hide();
        $('.loader').show();

        $.ajax({
            type: "POST",
            url: '/load',
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('.file-upload input:hidden').val()
            },
            data: form_data,
            success: function(data) {

                $('.loader').fadeOut(400, function(){

                    $('.upload').append('<div class="append-info">'+ data + '</div>');

                    $('.close-info').click(function() {
                        $('.append-info').remove();
                        $('.file-upload').fadeIn();
                    });
                });
            },
            error: function() {
                alert('ajax request failed :(');
            },
        })
    });

});