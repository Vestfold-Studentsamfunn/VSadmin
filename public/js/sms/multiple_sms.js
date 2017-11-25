$(document).ready(function(){

    $('#btn-send-sms').click(function(){

        //.....
        //show some spinner etc to indicate operation in progress
        //.....
        $(document).on({
            ajaxStart: function() { $('#pleaseWaitDialog').modal('show');    },
            ajaxStop: function() { $('#pleaseWaitDialog').modal('hide'); }
        });

        var table = $('#smsTable').DataTable();
        var message = $('#message').val();
        var _token = $('input[name=_token]').val();
        var numbers = $('.send_sms:checked', table.rows().nodes()).size();
        var numbersDone = 0;
        var notification, errors;

        $('.send_sms:checked', table.rows().nodes()).each(function() {
            $.ajax({
                url: "/sms/send",
                type: "POST",
                data: {
                    'number': $(this).val(),
                    'message': message,
                    '_token': _token
                },

                success: function (data) {
                    if (data.status === 'success') {
                        notification = '<div class="text-success">&nbsp;&nbsp;<i class="fa fa-check fa-lg"></i>&nbsp;';
                        notification += data.msg;
                        notification += '</div>';
                        $('#response_' + data.id, table.rows().nodes()).html(notification);

                        numbersDone++;
                        updateProgress((numbersDone/numbers)*100);
                    }
                    else if (data.status === 'error') {
                        notification = '<div class="text-warning">&nbsp;&nbsp;<i class="fa fa-exclamation fa-lg"></i>&nbsp;';
                        notification += data.msg;
                        notification += '</div>';
                        $('#response_' + data.id, table.rows().nodes()).html(notification);

                        numbersDone++;
                        updateProgress((numbersDone / numbers) * 100);
                    }
                    else {
                        notification = '<div class="alert alert-danger"><i class="fa fa-warning fa-2x"></i>&nbsp;';
                        notification += data.msg;
                        notification += '</div>';
                        $('#showresults').html(notification);
                    }
                },
                error: function (data) {
                    if (data.status === 422) {
                        var errorsJSON = data.responseJSON;
                        errors = '<div class="alert alert-danger"><i class="fa fa-warning fa-2x"></i>&nbsp;';

                        $.each(errorsJSON, function (key, value) {
                            errors += value[0]; //showing only the first error.
                        });
                        errors += '</div>';

                        $('#showresults').html(errors);
                    }
                },
                complete: function (xhr, status) {

                }
            });
        });

        //.....
        //do anything else you might want to do
        //.....
        function updateProgress(percentage){
            if(percentage > 100) percentage = 100;
            $('#progressBar').css('width', percentage+'%');
            $('#progressBar').html(numbersDone+' av '+numbers);
        }
    });
});