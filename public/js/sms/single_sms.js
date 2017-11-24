$(document).ready(function(){

    $('#btn-send-sms').click(function(){

        //.....
        //show some spinner etc to indicate operation in progress
        //.....
        $(document).on({
            ajaxStart: function() { $('#pleaseWaitDialog').modal();    },
            ajaxStop: function() { $('#pleaseWaitDialog').modal('hide'); }
        });

        var notification, errors;

        $.ajax({
            url: "/sms/send",
            type: "POST",
            data: {
                'number': $( '#number' ).val(),
                'message': $( '#message' ).val(),
                '_token': $('input[name=_token]').val()
            },

            success: function (data) {
                if( data.status === 'success' ) {
                    notification = '<div class="alert alert-success"><i class="fa fa-check fa-lg"></i>&nbsp;';
                    notification += 'Meldingen ble sendt!';
                    notification += '</div>';
                    $('#showresults').html( notification );
                }
                else if (data.status === 'error' ) {
                    notification = '<div class="alert alert-warning"><i class="fa fa-exclamation fa-lg"></i>&nbsp;';
                    notification += data.msg;
                    notification += '</div>';
                    $('#showresults').html( notification );
                }
            },
            error: function (data) {
                if( data.status === 422 ) {
                    var errorsJSON = data.responseJSON;
                    errors = '<div class="alert alert-danger"><i class="fa fa-warning fa-2x"></i>&nbsp;';

                    $.each( errorsJSON, function( key, value ) {
                        errors += value[0]; //showing only the first error.
                    });
                    errors += '</div>';

                    $( '#showresults' ).html( errors );
                }
            },
            complete: function (xhr, status) {

            }
        });

        //.....
        //do anything else you might want to do
        //.....
    });
});