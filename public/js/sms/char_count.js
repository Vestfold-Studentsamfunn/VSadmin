$(document).ready(function(){

    part1Count = 160;
    part2Count = 145;

    $('#message').keyup(function(){
        var chars = $(this).val().length;
        messages = 0;
        total = 0;
        if (chars <= part1Count) {
            messages = 1;
        }
        else if (chars <= (part1Count + part2Count)) {
            messages = 2;
        }

        $('#messages').text(messages);
        $('#total').text(chars);

        if (messages > 1) $('.mplural').show();
        else $('.mplural').hide();
    });

    $('#sms').keyup();
});