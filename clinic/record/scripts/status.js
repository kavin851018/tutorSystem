$(document).ready(function(){
	$('.large.icon').popup(); //Show description
	
    $('.leave').on('click',function(){
		var leave = $(this).data('value');
		var rno   = $(this).data('rno');
		var tutor = $(this).data('tutor');
		var date = $(this).data('date');
		var period = $(this).data('period');
    	$.ajax({
			type: 'POST',
			url:  'status_submit.php',
			data: {'leave':leave,'rno':rno,'tutor':tutor,'date':date, 'period':period},
			success: function(data){
				if(data.status == 'success'){
					$('html,body').animate({scrollTop: 0});
					$(".success.message").show().delay(2000).slideUp();
					$('<p>審核成功</p>').appendTo('.success.message');
					setTimeout("location.reload();",2500);
				}
				else{
                    $('html,body').animate({scrollTop: 0});
                    $(".error.message").show().delay(3000).slideUp();
                    $('<p>Error! ' + data.status + '</p>').appendTo('.error.message');
				}
			}
		});
	    event.preventDefault();
    });
});