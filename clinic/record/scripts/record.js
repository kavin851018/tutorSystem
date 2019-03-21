$(document).ready(function(){
	//Semantic ui plugin
	$('.ui.dropdown').dropdown({
		on: 'click',
	});
	$('.ui.checkbox').checkbox();

	//Button link
	$('.ui.button.leave').click(function(){
		window.open('leave.php', '_blank');
	});
	$('.ui.button.booking').click(function(){
		window.open('../booking_system/book.php','_blank');
	});
	$('.ui.button.check').click(function(){
		$('.ui.modal.check').modal('show');
	});

	//Department other input
	$('.other.dept').click(function(){
		$('.dropdown.dept').fadeOut().removeAttr('name');
		$('.text.dept').attr('name','stu_dept').delay(380).fadeIn();
	});

	//Date & time Plugin
	var today = new Date();

	var previousDay = 7; //Limit of deadline to passup record
	if(today.getDay()==1) previousDay = 0;		//Mon
	else if(today.getDay()==2) previousDay = 1; //Tue
	else if(today.getDay()==3) previousDay = 2; //Wed
	else if(today.getDay()==4) previousDay = 3; //Thu
	else if(today.getDay()==5) previousDay = 4; //Fri
	else if(today.getDay()==6) previousDay = 5; //Sat
	else if(today.getDay()==7) previousDay = 6; //Sun

	$('#datepick').calendar({ //Default Date pick
		type: 'date',
		minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() - previousDay),
		maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
		monthFirst: false,
		formatter: {
			date: function (date, settings) {
			  	if (!date) return '';
			  	var day = date.getDate();
			  	var month = date.getMonth() + 1;
			  	var year = date.getFullYear();
			  	return month + '/' + day + '/' + year;
			}
		}
	});
	$('#late').change(function(){ //Date pick for late passup record		
		if($(this).hasClass('checked')){
			$('#datepick').calendar({
				type: 'date',
				minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() - 120),
				maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
				monthFirst: false,
				formatter: {
					date: function (date, settings) {
					  	if (!date) return '';
					  	var day = date.getDate();
					  	var month = date.getMonth() + 1;
					  	var year = date.getFullYear();
					  	return month + '/' + day + '/' + year;
					}
				}
			});
		}
		else{ //Return to default date pick
			$('#datepick').calendar({
				type: 'date',
				minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() - previousDay),
				maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
				monthFirst: false,
				formatter: {
					date: function (date, settings) {
					  	if (!date) return '';
					  	var day = date.getDate();
					  	var month = date.getMonth() + 1;
					  	var year = date.getFullYear();
					  	return month + '/' + day + '/' + year;
					}
				}
			});
		}
	});
	$('#start_timepick').calendar({
		type: 'time',
		ampm: false,
		disableMinute: true,
		minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate(), "13", "00"),
		maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate(), "21", "00")
	});
	$('#end_timepick').calendar({
		type: 'time',
		ampm: false,
		disableMinute: true,
		minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate(), "13", "00"),
		maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate(), "21", "00")
	});

	//Student absent validation change
	$('.ui.form').bind(form_validation());
	$('#stu_absent').change(function(){
		if($(this).hasClass('checked')){
			$('.stu_absent').remove();
			$('.ui.form').unbind(form_validation()).bind(absent_validation()); //Change validation
		}
	});
})

function form_validation(){
	$('.ui.form').form({
	    onSuccess: validation_passed,
		inline: true,
		on: 'blur',
	    fields: {
	     	tutor_name: {
	     		identifier: 'tutor_name',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請選擇您的名稱'
	          	}]
	      	},
	      	date: {
	        	identifier: 'date',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請選擇諮詢日期'
	          	}]
	      	},
	      	start_time: {
	        	identifier: 'start_time',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請選擇開始諮詢時間'
	          	}]
	      	},
	      	end_time: {
	        	identifier: 'end_time',
	        	rules: [
	        		{
	            		type   : 'empty',
	            		prompt : '請選擇結束諮詢時間'
	          		},
	          		{
	          			type   : 'different[start_time]',
	          			prompt : '結束時間與開始時間不能相同'
	          		}
	          	]
	      	},
	      	stu_name: {
	        	identifier: 'stu_name',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請輸入學生姓名'
	          	}]
	      	},
	      	stu_id: {
	        	identifier: 'stu_id',
	        	rules: [
	        		{
	            		type   : 'empty',
	            		prompt : '請輸入學生學號'
	          		},
	          		{
	          			type   : 'exactLength[10]',
	            		prompt : '請輸入正確學號格式'
	          		}
	          	]
	      	},
	      	stu_dept: {
	        	identifier: 'stu_dept',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請選擇/輸入學生系所'
	          	}]
	      	},
	      	stu_year: {
	        	identifier: 'stu_year',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請選擇學生年級'
	          	}]
	      	},
	      	/*stu_phone: {
	        	identifier: 'stu_phone',
	        	rules: [
	        		{
	            		type   : 'empty',
	            		prompt : '請輸入學生聯絡電話'
	          		},
	          		{
	            		type   : 'containsExactly[09]',
	            		prompt : '請輸入正確手機號碼格式'
	          		},
	          		{
	          			type   : 'exactLength[10]',
	            		prompt : '請輸入正確手機號碼格式'
	          		}
	          	]
	      	},
	      	stu_email: {
	        	identifier: 'stu_email',
	        	rules: [
	        		{
	            		type   : 'empty',
	            		prompt : '請輸入學生Email'
	          		},
	        		{
	            		type   : 'email',
	            		prompt : '請確認學生Email格式'
	          		}
	          	]
	      	},*/
	      	record: {
	        	identifier: 'record',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請輸入諮詢內容記錄'
	          	}]
	      	},
	      	suggestion: {
	        	identifier: 'suggestion',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請輸入小老師建議'
	          	}]
	      	}
	    }
	});
}

function absent_validation(){
	$('.ui.form').form({
	    onSuccess: validation_passed,
		inline: true,
		on: 'blur',
	    fields: {
	     	tutor_name: {
	     		identifier: 'tutor_name',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請選擇您的名稱'
	          	}]
	      	},
	      	date: {
	        	identifier: 'date',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請選擇諮詢日期'
	          	}]
	      	},
	      	start_time: {
	        	identifier: 'start_time',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請選擇開始諮詢時間'
	          	}]
	      	},
	      	end_time: {
	        	identifier: 'end_time',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : '請選擇結束諮詢時間'
	          	}]
	      	},
	      	stu_id: {
	        	identifier: 'stu_id',
	        	rules: [
	        		{
	            		type   : 'empty',
	            		prompt : '請輸入學生學號'
	          		},
	          		{
	          			type   : 'exactLength[10]',
	            		prompt : '請輸入正確學號格式'
	          		}
	          	]
	      	}
	    }
	});
}

function validation_passed(e){
	var rform = $('.ui.form');
    $.ajax({
        type: rform.attr('method'),
        url: rform.attr('action'),
        data: rform.serialize(), // serializes the form's elements.
        success: function(data){
        	if(data.status == 'success'){
	        	$('html,body').animate({scrollTop: 0});
				$("#success_message").show().delay(3000).slideUp();
				setTimeout("location.reload();",3500);
			}
			else{
				$('html,body').animate({scrollTop: 0});
	            $('#error_message').show(); //.delay(3500).slideUp();
				$('<p>Error: ' + data.status + '</p>').appendTo('#error_message');
	            //e.preventDefault();
			}
        }
    });
    e.preventDefault();
}

function ValidateNumber(e, pnumber){
    if (!/^\d+$/.test(pnumber))
    {
        e.value = /^\d+/.exec(e.value);
    }
    return false;
}