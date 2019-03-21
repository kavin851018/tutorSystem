var check_date;
var check_period;
var check_tutor;
$(document).ready(function(){
	//#rules popup
	if(window.location.hash){
		var hash = window.location.hash;
		$(hash).modal('show');
		$('.rules.disagree.button').hide();
		$('.rules.agree.button').hide();
	}
	//Semantic ui plugin
	$('.large.icon').popup(); //Show description
	$('.ui.dropdown').dropdown();
	$('.icon.register').click(function(e){ //Register
		check_date = $(this).data('date');
		check_period = $(this).data('period');
		check_tutor = $(this).data('tutor');
		$('.ui.modal.rules').modal('show'); //Rules & regulations
		$('.rules.agree.button').click(function(){
			$('.ui.modal.register.'+check_date+'.'+check_period+'.'+check_tutor).modal('show'); //Show specified register modal
		});
		$('.rules.disagree.button').click(function(){
			$('.ui.modal.rules').modal('hide');
		});
	});
	$('.edit.icon').click(function(){ //Delete
		check_date = $(this).data('date');
		check_period = $(this).data('period');
		check_tutor = $(this).data('tutor');
		$('.ui.modal.delete').modal('show');
	});
	$('.ui.modal.register').modal({ //Reset form on close
		onHide: function(){
			$('.ui.form.register').form('reset');
		}
	});
	$('.ui.modal.delete').modal({ //Reset form on close
		onHide: function(){
			$('.ui.form.delete').form('reset');
		}
	});

	//Button link
	$('.ui.button.leave').click(function(){
		window.open('leave.php', '_blank');
	});
	$('.ui.button.booking').click(function(){
		window.open('../booking_system/book.php','_blank');
	});

	//Form
	$('.clear.button').click(function(){
		$('form').form('clear');
	});
	$('.ui.form.register').form({ //Make appointment form validation
	    onSuccess: register_passed,
		inline: true,
		on: 'blur',
	    fields: {
	     	name: {
	     		identifier: 'name',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : 'Please fill in your name'
	          	}]
	      	},
	      	id: {
	        	identifier: 'id',
	        	rules: [
	        		{
		            	type   : 'empty',
		            	prompt : 'Please fill in your student ID'
		          	},
		          	{
		          		type   : 'regExp[/[b|m|n|d|i|j|a|B|M|N|D|I|J|A][0-9]{7,9}$/]', //Can only fill in words starting with b/m/n/d/i/j/a in small or capital letter, only numbers after first letter and total length from 7~9 characters
		          		prompt : 'PLease fill in a valid student ID'
		          	}
	          	]
	      	},
	      	email: {
	        	identifier: 'email',
	        	rules: [{
		            type   : 'email',
		            prompt : 'Please fill in a valid email'
	          	}]
	      	},
	      	phone: {
	        	identifier: 'phone',
	        	rules: [
	        		{
	            		type   : 'empty',
	            		prompt : 'Please fill in your contact number'
	          		},
	          		{
	          			type   : 'number',
	          			prompt : 'Please fill in only numbers'
	          		},
	          		{
	          			type   : 'exactLength[10]',
            			prompt : 'Please fill in exactly 10 digits'
	          		}
	          	]
	      	},
	      	learn_content: {
	      		identifier: 'learn_content',
	      		rules: [{
	      			type   : 'empty',
	      			prompt : 'Please select learning content',
	      		}]
	      	}
	    }
	});
	$('.ui.form.delete').form({ //Cancel appointment form validation
	    onSuccess: delete_passed,
		inline: true,
		on: 'blur',
	    fields: {
	     	name: {
	     		identifier: 'name',
	        	rules: [{
	            	type   : 'empty',
	            	prompt : 'Please fill in your name'
	          	}]
	      	},
	      	id: {
	        	identifier: 'id',
	        	rules: [
	        		{
		            	type   : 'empty',
		            	prompt : 'Please fill in your student ID'
		          	},
		          	{
		          		type   : 'regExp[/[b|m|n|d|i|j|a|B|M|N|D|I|J|A][0-9]{7,9}$/]', //Can only fill in words starting with b/m/n/d/i/j/a in small or capital letter, only numbers after first letter and total length from 7~9 characters
		          		prompt : 'PLease fill in a valid student ID'
		          	}
	          	]
	      	},
	      	phone: {
	        	identifier: 'phone',
	        	rules: [
	        		{
	            		type   : 'empty',
	            		prompt : 'Please fill in your contact number'
	          		},
	          		{
	          			type   : 'number',
	          			prompt : 'Please fill in only numbers'
	          		},
	          		{
	          			 type   : 'exactLength[10]',
            			prompt : 'Please fill in exactly 10 digits'
	          		}
	          	]
	      	}
	    }
	});
})

function register_passed(e){
	$('<div class="ui active loader"></div>').appendTo('body');
	var rform = $('.ui.form.register.'+check_date+'.'+check_period+'.'+check_tutor);
    $.ajax({
        type: rform.attr('method'),
        url : rform.attr('action'),
        data: rform.serialize()+'&type=register&date='+check_date+'&period='+check_period+'&tutor='+check_tutor, // serializes the form's elements.
        success: function(data){
        	if(data.status == 'success'){
				$('.ui.loader').removeClass('active');
        		$('.ui.modal.register').modal('hide');
	        	$('html,body').animate({scrollTop: 0});
				$(".success.message").show().delay(2000).slideUp();
				$('<div class="header">Appointment Created Successfully</div>').appendTo('.success.message');
				setTimeout("location.reload();",2500);
			}
			else if(data.status == 'exist'){ //Check if made appointment at same period
				$('.ui.loader').removeClass('active');
				$('.ui.modal.register').modal('hide');
	        	$('html,body').animate({scrollTop: 0});
				$(".error.message").show().delay(6000).slideUp();
				$('<p>Do not make appointment repeatly</p>').appendTo('.error.message');
			}
			else if(data.status == 'period exist'){ //Check if same period has appointment
				$('.ui.loader').removeClass('active');
				$('.ui.modal.register').modal('hide');
	        	$('html,body').animate({scrollTop: 0});
				$(".error.message").show().delay(4000).slideUp();
				$('<p>Appointment Exist</p>').appendTo('.error.message');
				setTimeout("location.reload();",4500);
			}
			else if(data.status == 'blacklist exist'){
				$('.ui.loader').removeClass('active');
				$('.ui.modal.register').modal('hide');
	        	$('html,body').animate({scrollTop: 0});
				$(".error.message").show().delay(6000).slideUp();
				$('<p>You Have Been Blacklisted, Currently Unable To Make Appointment.</p>').appendTo('.error.message');
			}
			else if(data.status == 'register limit'){
				$('.ui.loader').removeClass('active');
				$('.ui.modal.register').modal('hide');
	        	$('html,body').animate({scrollTop: 0});
				$(".error.message").show().delay(6000).slideUp();
				$('<p>You Have Already Made Two Appointment This Week</p>').appendTo('.error.message');
			}
			else{
				$('.ui.loader').removeClass('active');
				$('.ui.modal.register').modal('hide');
	            $('html,body').animate({scrollTop: 0});
	            $(".error.message").show().delay(6000).slideUp();
	            $('<p>' + data.status + '</p>').appendTo('.error.message');
			}
        }
    });
    e.preventDefault();
}
function delete_passed(event){
	$('<div class="ui active loader"></div>').appendTo('body');
	var rform = $('.ui.form.delete');
    $.ajax({
        type: rform.attr('method'),
        url : rform.attr('action'),
        data: rform.serialize()+'&type=delete&date='+check_date+'&period='+check_period+'&tutor='+check_tutor, // serializes the form's elements.
        success: function(data){
        	if(data.status == 'success'){
				$('.ui.loader').removeClass('active');
        		$('.ui.modal.delete').modal('hide');
	        	$('html,body').animate({scrollTop: 0});
				$(".success.message").show().delay(2000).slideUp();
				$('<div class="header">Appointment Cancelled Successfully</div>').appendTo('.success.message');
				setTimeout("location.reload();",2500);
			}
			else if(data.status == 'check failed'){
				$('.ui.loader').removeClass('active');
				$('.ui.modal.delete').modal('hide');
	            $('html,body').animate({scrollTop: 0});
	            $(".error.message").show().delay(6000).slideUp();
	            $('<p>Name, Student ID or Contact Number Incorrect, Please Try Again Later.</p>').appendTo('.error.message');
			}
			else{
				$('.ui.loader').removeClass('active');
				$('.ui.modal.delete').modal('hide');
	            $('html,body').animate({scrollTop: 0});
	            $(".error.message").show().delay(6000).slideUp();
	            $('<p>' + data.status + '</p>').appendTo('.error.message');
			}
        }
    });
    event.preventDefault();
}