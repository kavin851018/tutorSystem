$(document).ready(function(){
	//Semantic ui plugin
	$('.ui.dropdown').dropdown({
		on: 'click',
	});
	$('.ui.checkbox').checkbox();

	//Menu
	$('.ui.menu').on('click','.item',function(){
		url = $(this).data('url');
		$('#' + url).show().siblings('.hidden').hide();
		$(this).addClass('active').siblings('.item').removeClass('active'); //Active clicking button and deactive other button
	});

	//Date & time Plugin
	var today = new Date();
	$('.datepick').calendar({ //Default Date pick
		type: 'date',
		//minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
		//maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
		monthFirst: false,
		formatter: {
			date: function (date, settings) {
			  	if (!date) return '';
			  	var day = ((date.getDate())>=10)?(date.getDate()):('0'+(date.getDate())); //Day smaller than 10 add 0 in front of it
			  	var month = ((date.getMonth()+1)>=10)?(date.getMonth()+1):('0'+(date.getMonth()+1)); //Month smaller than 10 add 0 in front of it
			  	var year = date.getFullYear();
			  	return year + '-' + month + '-' + day;
			}
		}
	});

	//Booking Search
	$('.ui.calendar.booking').calendar({
		type: 'date',
		monthFirst: false,
		formatter: {
			date: function (date, settings) {
			  	if (!date) return '';
			  	var day = ((date.getDate())>=10)?(date.getDate()):('0'+(date.getDate())); //Day smaller than 10 add 0 in front of it
			  	var month = ((date.getMonth()+1)>=10)?(date.getMonth()+1):('0'+(date.getMonth()+1)); //Month smaller than 10 add 0 in front of it
			  	var year = date.getFullYear();
			  	return year + '-' + month + '-' + day;
			}
		},
		onChange: function (date, text){
		    var date = text;
		    if(date == ''){
		    	$('.booking_search').fadeIn();
		    }
		    else{
		    	$('.booking_search').hide();
				$('.booking_search.'+date).fadeIn();
			}
	    },
	});

	//Back to top
	if ($('#back-to-top').length) { //Source: http://jsfiddle.net/gilbitron/Lt2wH/
	    var scrollTrigger = 100, // px
	        backToTop = function () {
	            var scrollTop = $(window).scrollTop();
	            if (scrollTop > scrollTrigger) {
	                $('#back-to-top').addClass('show');
	            } else {
	                $('#back-to-top').removeClass('show');
	            }
	        };
	    backToTop();
	    $(window).on('scroll', function () {
	        backToTop();
	    });
	    $('#back-to-top').on('click', function (e) {
	        e.preventDefault();
	        $('html,body').animate({
	            scrollTop: 0
	        }, 700);
	    });
	}

	//Update password form validation
	$('.ui.form.update_pw').form({
	    onSuccess: update_pwd,
		inline: true,
		on: 'blur',
	    fields: {
	     	pw: {
	     		identifier: 'pw',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請輸入舊密碼'
	          	}]
	      	},
	      	new_pw: {
	        	identifier: 'new_pw',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請輸入新密碼'
	          	}]
	      	},
	      	c_new_pw: {
	        	identifier: 'c_new_pw',
	        	rules: [
	        		{
	            		type   : 'empty',
	            		prompt : '請再次輸入新密碼'
	          		},
	          		{
	          			type   : 'match[new_pw]',
	          			prompt : '請確認新密碼相同'
	          		}
	          	]
	      	}
	    }
	})

	//Login function
	$('.ui.button.login').click(function(e){
		$('<div class="ui active loader"></div>').appendTo('body');
		var form = $('.ui.form.login');
	    $.ajax({
	        type: form.attr('method'),
	        url: form.attr('action'),
			data: form.serialize() + '&type=login',
			success: function(data){
				if(data.status == 'success'){
					$('.ui.loader').removeClass('active');
	                $(".success.message").show().delay(500).slideUp();
					location.reload();
				}
				else{ //no function
					$('.ui.loader').removeClass('active');
	                $(".error.message").show().delay(1200).slideUp();
				}
			}
		});
	    e.preventDefault();
	})

	//Delete booking
	$('.ui.button.delete').click(function(e){
    	if(confirm('確定刪除預約？')){
			$('<div class="ui active loader"></div>').appendTo('body');
			var rno = $(this).data('rno');
	    	$.ajax({
				type: 'POST',
	        	url: 'cpanel_update.php',
				data: {'type':'delete','rno':rno},
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
						$('#'+rno).fadeOut();
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
                        $('html,body').animate({scrollTop: 0});
                        $("#error_message").show().delay(3000).slideUp();
	           			$('.append').remove();
                        $('<div class="header append">刪除失敗</div><p class="append">Error: ' + data.status + '</p>').appendTo('#error_message');
					}
				}
			});
		    e.preventDefault();
		}
		else
			return false;
    })

	blacklist();
	holiday();
	semester();
	create_tutor();
	create_schedule();
})

function update_pwd(e){
	var form = $('.ui.form.update_pw');
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
		data: form.serialize() + '&type=update_pw',
		success: function(data){
			if(data.status == 'success'){
                $(".success.message").show().delay(800).slideUp();
                $('<p>更新成功</p>').appendTo('.success.message.update_pw');
			}
			else{ //no function
                $(".error.message").show().delay(1500).slideUp();
	            $('.append').remove();
                $('<p class="append">更新失敗，請確認輸入正確密碼。</p>').appendTo('.error.message.update_pw');
			}
		}
	});
	e.preventDefault();
}

function blacklist(){
    //Create blacklist
	$('.ui.button.create-blacklist').click(function(e){
		$('<div class="ui active loader"></div>').appendTo('body');
		e.preventDefault();
		var form = $('.ui.form.create_blacklist');
		var blacklist_id = $('.create_blacklist.id');
		var blacklist_start_date = $('.create_blacklist.start_date');
		if(!blacklist_id.val() || !blacklist_start_date.val()){
			$('.ui.loader').removeClass('active');
			$('html,body').animate({scrollTop: 0});
			$('.error.message').show().delay(3000).slideUp();
	        $('.append').remove();
			$('<div class="header append">請確認資料欄不為空</div>').appendTo('.ui.error.message');
		}
		else{
		    $.ajax({
		        type: form.attr('method'),
		        url: form.attr('action'),
				data: form.serialize()+'&type=create_blacklist',
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
						$(".success.message").show().delay(2000).slideUp();
		                $('<div class="header">新增黑名單成功</div>').appendTo('.ui.success.message');
						setTimeout("location.reload();",2500);
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
		                $('.error.message').show().delay(6000).slideUp();
	            		$('.append').remove();
		                $('<div class="header append">Error: ' + data.status + '</div>').appendTo('#error_message');
					}
				}
			});
		}
    })
	//Delete blacklist
	$('.ui.button.blacklist-delete').click(function(e){
		$('<div class="ui active loader"></div>').appendTo('body');
    	if(confirm('確定刪除黑名單？')){
			var rno = $(this).data('rno');
	    	$.ajax({
				type: 'POST',
	        	url: 'cpanel_update.php',
				data: {'type':'delete_blacklist','rno':rno},
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
						$('#blacklist'+rno).fadeOut();
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
                        $('html,body').animate({scrollTop: 0});
                        $(".error.message").show().delay(3000).slideUp();
	            		$('.append').remove();
                        $('<div class="header append">刪除失敗</div><p class="append">Error: ' + data.status + '</p>').appendTo('.error.message');
					}
				}
			});
		    e.preventDefault();
		}
		else
			return false;
    })
}

function holiday(){	
    //Create holiday
	$('.ui.button.create-holiday').click(function(e){
		$('<div class="ui active loader"></div>').appendTo('body');
		e.preventDefault();
		var form = $('.ui.form.create_holiday');
		var holiday_start_date = $('.create_holiday.start_date');
		var holiday_end_date = $('.create_holiday.end_date');
		if(!holiday_start_date.val() || !holiday_end_date.val()){
			$('.ui.loader').removeClass('active');
			$('html,body').animate({scrollTop: 0});
			$('.error.message').show().delay(3000).slideUp();
			$('.append').remove();
			$('<div class="header append">請確認資料欄不為空</div>').appendTo('.ui.error.message');
		}
		else{
		    $.ajax({
		        type: form.attr('method'),
		        url: form.attr('action'),
				data: form.serialize()+'&type=create_holiday',
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
						$(".success.message").show().delay(2000).slideUp();
		                $('<div class="header">新增假期成功</div>').appendTo('.ui.success.message');
						setTimeout("location.reload();",2500);
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
		                $('.error.message').show().delay(6000).slideUp();
	            		$('.append').remove();
		                $('<div class="header append">Error: ' + data.status + '</div>').appendTo('#error_message');
					}
				}
			});
		}
    })
	//Delete holiday
	$('.ui.button.holiday-delete').click(function(e){
    	if(confirm('確定刪除假期？')){
			$('<div class="ui active loader"></div>').appendTo('body');
			var rno = $(this).data('rno');
	    	$.ajax({
				type: 'POST',
	        	url: 'cpanel_update.php',
				data: {'type':'delete_holiday','rno':rno},
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
						$('#holiday'+rno).fadeOut();
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
                        $('html,body').animate({scrollTop: 0});
                        $(".error.message").show().delay(3000).slideUp();
	            		$('.append').remove();
                        $('<div class="header append">刪除失敗</div><p>Error: ' + data.status + '</p>').appendTo('.error.message');
					}
				}
			});
		    e.preventDefault();
		}
		else
			return false;
    })
}

function semester(){	
    //Create semester
	$('.ui.button.create-sem').click(function(e){
		$('<div class="ui active loader"></div>').appendTo('body');
		e.preventDefault();
		var form = $('.ui.form.create_sem');
		var sem_start_date = $('.create_sem.sem_start_date');
		var sem_end_date = $('.create_sem.sem_end_date');
		var sem_year = $('.create_sem.sem_year');
		if(!sem_start_date.val() || !sem_end_date.val() || !sem_year.val()){
			$('.ui.loader').removeClass('active');
			$('html,body').animate({scrollTop: 0});
			$('.error.message').show().delay(3000).slideUp();
	        $('.append').remove();
			$('<div class="header append">請確認資料欄不為空</div>').appendTo('.ui.error.message');
		}
		else{
		    $.ajax({
		        type: form.attr('method'),
		        url: form.attr('action'),
				data: form.serialize()+'&type=create_sem',
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
						$(".success.message").show().delay(2000).slideUp();
		                $('<div class="header">新增學期成功</div>').appendTo('.ui.success.message');
						setTimeout("location.reload();",2500);
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
		                $('.error.message').show().delay(6000).slideUp();
	           			$('.append').remove();
		                $('<div class="header append">Error: ' + data.status + '</div>').appendTo('#error_message');
					}
				}
			});
		}
    })
	//Delete semester
	$('.ui.button.sem-delete').click(function(e){
    	if(confirm('確定刪除學期？')){
			$('<div class="ui active loader"></div>').appendTo('body');
			var rno = $(this).data('rno');
	    	$.ajax({
				type: 'POST',
	        	url: 'cpanel_update.php',
				data: {'type':'delete_sem','rno':rno},
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
						$('#sem'+rno).fadeOut();
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
                        $('html,body').animate({scrollTop: 0});
                        $(".error.message").show().delay(3000).slideUp();
	            		$('.append').remove();
                        $('<div class="header append">刪除失敗</div><p>Error: ' + data.status + '</p>').appendTo('.error.message');
					}
				}
			});
		    e.preventDefault();
		}
		else
			return false;
    })
}

function create_tutor(){	
    //Create tutor
	$('.ui.button.create-tutor').click(function(e){
		$('<div class="ui active loader"></div>').appendTo('body');
		e.preventDefault();
		var form = $('.ui.form.create_tutor');
		var tutor_name = $('.create_tutor.name');
		var tutor_id = $('.create_tutor.id');
		var tutor_dept = $('.create_tutor.dept');
		var tutor_phone = $('.create_tutor.phone');
		var tutor_email = $('.create_tutor.email');
		if(!tutor_name.val() || !tutor_id.val() || !tutor_phone.val() || !tutor_email.val()){
			$('.ui.loader').removeClass('active');
			$('.error.message.create_tutor').show().delay(3000).slideUp();
	        $('.append').remove();
			$('<div class="header append">請確認資料欄不為空</div>').appendTo('.ui.error.message.create_tutor');
		}
		else{
		    $.ajax({
		        type: form.attr('method'),
		        url: form.attr('action'),
				data: form.serialize()+'&type=create_tutor',
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
						$(".success.message").show().delay(2000).slideUp();
		                $('<div class="header">新增小老師成功</div>').appendTo('.ui.success.message');
						setTimeout("location.reload();",2500);
					}
					else if(data.status == 'exist'){
						$('.ui.loader').removeClass('active');
						$('.error.message.create_tutor').show().delay(3000).slideUp();
	            		$('.append').remove();
						$('<div class="header append">Tutor exist</div>').appendTo('.error.message.create_tutor');
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
		                $('.error.message').show().delay(6000).slideUp();
	            		$('.append').remove();
		                $('<div class="header append">Error: ' + data.status + '</div>').appendTo('#error_message');
					}
				}
			});
		}
    })
	//Delete tutor
	$('.ui.button.tutor-delete').click(function(e){
    	if(confirm('確定刪除小老師？')){
			$('<div class="ui active loader"></div>').appendTo('body');
			var rno = $(this).data('rno');
	    	$.ajax({
				type: 'POST',
	        	url: 'cpanel_update.php',
				data: {'type':'delete_tutor','rno':rno},
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
						$('#tutor'+rno).fadeOut();
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
                        $('html,body').animate({scrollTop: 0});
                        $(".error.message").show().delay(3000).slideUp();
	            		$('.append').remove();
                        $('<div class="header append">刪除失敗</div><p class="append">Error: ' + data.status + '</p>').appendTo('.error.message');
					}
				}
			});
		    e.preventDefault();
		}
		else
			return false;
    })
}

function create_schedule(){
	//Create tutor schedule
	$('.ui.button.create-schedule').click(function(e){
		$('<div class="ui active loader"></div>').appendTo('body');
		e.preventDefault();
		var form = $('.ui.form.create_schedule');
		var tutor = $('.create_schedule.tutor').dropdown('get value');
		var foreign = $('.create_schedule.tutor').find('.item.selected').data('foreign');
		var sem = $('.create_schedule.sem').val();
		var desc = $('.create_schedule.desc').dropdown('get value');
		if(!tutor || !sem || !$.isNumeric(sem) || !desc){ //Empty or non-numeric in sem
			$('.ui.loader').removeClass('active');
			$('.error.message.create_schedule').show().delay(5000).slideUp();
	        $('.append').remove();
			$('<div class="header append">請確認資料格式正確及資料欄不為空</div>').appendTo('.ui.error.message.create_schedule');
		}
		else{
		    $.ajax({
		        type: form.attr('method'),
		        url: form.attr('action'),
				data: form.serialize()+'&foreign='+foreign+'&type=create_schedule',
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
						$(".success.message").show().delay(2000).slideUp();
		                $('<div class="header">新增班表成功</div>').appendTo('.ui.success.message');
						setTimeout("location.reload();",2500);
					}
					else if(data.status == 'exist'){
						$('.ui.loader').removeClass('active');
						$(".error.message.create_schedule").show().delay(3000).slideUp();
	            		$('.append').remove();
						$('<div class="header append">該小老師已有班表</div>').appendTo('.error.message.create_schedule');
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
		                $('.error.message').show().delay(6000).slideUp();
	            		$('.append').remove();
		                $('<div class="header append">Error: ' + data.status + '</div>').appendTo('#error_message');
					}
				}
			});
		}
    })
    //Delete tutor schedule
	$('.ui.button.schedule-delete').click(function(e){
    	if(confirm('確定刪除小老師班表？')){
			$('<div class="ui active loader"></div>').appendTo('body');
			var rno = $(this).data('rno');
	    	$.ajax({
				type: 'POST',
	        	url: 'cpanel_update.php',
				data: {'type':'delete_schedule','rno':rno},
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
						$('#schedule'+rno).fadeOut();
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
                        $('html,body').animate({scrollTop: 0});
                        $(".error.message").show().delay(3000).slideUp();
	            		$('.append').remove();
                        $('<div class="header append">刪除失敗</div><p class="append">Error: ' + data.status + '</p>').appendTo('.error.message');
					}
				}
			});
		    e.preventDefault();
		}
		else
			return false;
    })
}