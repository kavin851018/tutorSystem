$(document).ready(function(){
    $('.large.icon').popup(); //Show description
    $('.ui.radio.checkbox').checkbox();

    var rform = $('.ui.form.leave');
    rform.submit(function(e){
        e.preventDefault();
        if($('input[type=radio]').is(':checked') == true){
            $.ajax({
                type: 'post',
                url: 'leave_submit.php',
                data: rform.serialize(), // serializes the form's elements.
                success: function(data){
                    if(data.status == 'success'){
                        $('html,body').animate({scrollTop: 0});
                        $(".ui.success.message").show().delay(2500).slideUp();
                        setTimeout("location.reload();",3000);
                    }
                    else{
                        $('html,body').animate({scrollTop: 0});
                        $("ui.error.message").show().delay(3500).slideUp();
                        $('<span>Error: ' + data.status + '</span>').appendTo('.ui.error.message');
                    }
                }
            });
        }
    });
});