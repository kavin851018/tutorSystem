$(document).ready(function(){
	//Semantic ui plugin
	$('.ui.dropdown').dropdown({
		on: 'click',
	});
	
	//Menu
	$('.ui.menu').on('click','.item',function(){
		var url = $(this).data('url');
		if(url == 'status')
			$('#' + url).show().append('<iframe frameborder="0" height="1500px" width="1300px" style="margin-left:-85px;" src="../status.php"></iframe>').siblings('.hidden').hide();
		else{
			$('#' + url).show().siblings('.hidden').hide();
		}
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
			  	var day = date.getDate();
			  	var month = ((date.getMonth()+1)>=10)?(date.getMonth()+1):('0'+(date.getMonth()+1)); //Month smaller than 10 add 0 in front of it
			  	var year = date.getFullYear();
			  	return year + '-' + month + '-' + day;
			}
		}
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

	//Select tutor dropdown function
	$('.ui.dropdown.selectTutor').change(function(){
		var rno = ($(this).dropdown('get value'));
		if(rno == 'all')
			$('.RecordRow').fadeIn();
		else{
			$('.RecordRow').hide();
			$('.RecordRow.tutor'+rno).fadeIn();
		}
	})

	//------------------ Status -------------------//
	//Create tutor leave
	$('.ui.button.create-leave').click(function(e){
		$('<div class="ui active loader"></div>').appendTo('body');
		e.preventDefault();
		var form = $('.ui.form.create_leave');
		var tutor = $('.create_leave.tutor').find('.item.selected').data('value');
		var date = $('.create_leave.date').val();
		var period = $('.create_leave.period').find('.item.selected').data('value');
		var reason = $('.create_leave.reason').find('.item.selected').data('value');
		if(!tutor || !date || !period || !reason){
			$('.ui.loader').removeClass('active');
			$('.error.message').show().delay(3000).slideUp();
			$('<div class="header">請確認資料欄不為空</div>').appendTo('.ui.error.message');
		}
		else{
		    $.ajax({
		        type: form.attr('method'),
		        url: form.attr('action'),
				data: {'type':'create_leave','tutor':tutor,'date':date,'period':period,'reason':reason},
				success: function(data){
					if(data.status == 'success'){
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
						$(".success.message").show().delay(2000).slideUp();
		                $('<div class="header">新增請假成功</div>').appendTo('.ui.success.message');
						setTimeout("location.reload();",2500);
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
		                $('.error.message').show().delay(6000).slideUp();
		                $('<div class="header">Error: ' + data.status + '</div>').appendTo('#error_message');
					}
				}
			});
		}
    })
	//------------------ Status -------------------//

	//--------------- View record -----------------//
	//Edit value
	$(".editable").each(function(){
        var label = $(this); //Reference the Label.
        if(label.hasClass('textarea'))
        	label.after('<textarea class="edit-textbox" style="display:none;"></textarea>'); //Add a TextBox next to the Label.
        else
        	label.after('<input class="edit-textbox" type="text" style="display:none;" />'); //Add a TextBox next to the Label.

        var textbox = $(this).next(); //Reference the TextBox.
        textbox[0].name = label.data('value'); //Set the name attribute of the TextBox.
        textbox.val(label.html().replace(/\<br\>/g, "\n").replace(/\<br \/\>/g, "\n")); //Assign the value of Label to TextBox. Replace <br> to \n
        label.dblclick(function(){ //When Label is double clicked, hide Label and show TextBox.
            $(this).hide();
            $(this).next().show().focus();
            label.parents('form').children('.ui.button.edit').removeClass('disabled'); //Enable edit button in selected form
            label.parents('form').children('.ui.button.delete').hide(); //Hide delete button in selected form
            label.parents('form').children('.ui.button.cancel').show(); //Show cancel button in selected form
        });
    })
    //Cancel edit button
    $('.ui.button.cancel').click(function(){
    	$(this).parent().find('.edit-textbox').each(function(){ //Return all textbox back to label in selected form
			$(this).hide(); //Hide textbox
			$(this).prev().show(); //Show label
		})
		$(this).hide(); //Hide this button
		$(this).siblings('.ui.button.delete').show(); //Show delete button in selected form
		$(this).siblings('.ui.button.edit').addClass('disabled'); //Disable edit button in selected form
    })
    //Edit button
    $('.ui.button.edit').click(function(){
    	var editBtn = $(this);
		var rno = $(this).data('rno');
    	var form = $(this).parents('form:first'); //Get form of clicked button
	    $.ajax({
	        type: form.attr('method'),
	        url: form.attr('action'),
			data: form.serialize() + '&type=edit&rno='+rno,
			success: function(data){
				if(data.status == 'success'){
					editBtn.parent().find(".edit-textbox").each(function(){ //Return all textbox back to label in selected form
						$(this).hide(); //Hide textbox
						$(this).prev().html($(this).val().replace(/(\r\n|\n\r|\r|\n)/g, "<br>")); //Assign textbox value to label. Replace \n to <br>
						$(this).prev().show(); //Show label
					})
					editBtn.siblings('.ui.button.success').show().delay(1000).hide(); //Show edit success message in selected form
					editBtn.addClass('disabled'); //Disable edit button in selected form
					editBtn.siblings('.ui.button.cancel').hide(); //Hide cancel button in selected form
					editBtn.siblings('.ui.button.delete').show(); //Show delete button in selected form
				}
				else{ //no function
                    $('html,body').animate({scrollTop: 0});
                    $("#error_message").show().delay(3000).slideUp();
                    $('<p>Error: ' + data.status + '</p>').appendTo('#error_message');
				}
			}
		});
	    event.preventDefault();
    })
	//Delete button
    $('.ui.button.delete').click(function(){
    	var delBtn = $(this);
    	var form = $(this).parents('form:first'); //Get form of clicked button
    	if(confirm('確定刪除？')){
			var rno = $(this).data('rno');
	    	$.ajax({
				type: form.attr('method'),
	        	url: form.attr('action'),
				data: {'type':'delete','rno':rno},
				success: function(data){
					if(data.status == 'success'){
						delBtn.parents('.RecordRow').fadeOut();
					}
					else{ //no function
                        $('html,body').animate({scrollTop: 0});
                        $("#error_message").show().delay(3000).slideUp();
                        $('<div class="header">刪除失敗</div><p>Error: ' + data.status + '</p>').appendTo('#error_message');
					}
				}
			});
		    event.preventDefault();
		}
		else
			return false;
    })
    //--------------- View record -----------------//


    //------------- Record statistics -------------//
    /*$('.download_pdf').click(function(){
    	var stu_id = $(this).data('stu_id');
    	$.ajax({
    		type: 'POST',
    		url: 'cpanel_edit.php',
    		data: {'type':'download_pdf','stu_id':stu_id},
    		success: function(data){
    			if(data.status == 'success'){
    				console.log('s');
    			}
    		}
    	})
    })*/
	$('.ui.button.download_pdf').click(function(){
  	//Source: http://jsfiddle.net/xzZ7n/1/
  		var rno = $(this).data('rno');
	    var pdf = new jsPDF('p', 'pt', 'letter');
	    // source can be HTML-formatted string, or a reference
	    // to an actual DOM element from which the text will be scraped.
	    source = $('#record' + rno)[0];

	    // we support special element handlers. Register them with jQuery-style 
	    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
	    // There is no support for any other type of selectors 
	    // (class, of compound) at this time.
	    specialElementHandlers = {
	        // element with id of "bypass" - jQuery style selector
	        '#bypassme': function (element, renderer) {
	            // true = "handled elsewhere, bypass text extraction"
	            return true
	        }
	    };
	    margins = {
	        top: 80,
	        bottom: 60,
	        left: 40,
	        width: 522
	    };
	    // all coords and widths are in jsPDF instance's declared units
	    // 'inches' in this case
	    pdf.fromHTML(
	    source, // HTML string or DOM elem ref.
	    margins.left, // x coord
	    margins.top, { // y coord
	        'width': margins.width, // max width of content on PDF
	        'elementHandlers': specialElementHandlers
	    },

	    function (dispose) {
	        // dispose: object with X, Y of the last line add to the PDF 
	        //          this allow the insertion of new lines after html
	        pdf.save(rno + '.pdf');
	    }, margins);
	})
    //------------- Record statistics -------------//

    //------------- login -------------//
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
		var form = $('.ui.form.login');
	    $.ajax({
	        type: form.attr('method'),
	        url: form.attr('action'),
			data: form.serialize() + '&type=login',
			success: function(data){
				if(data.status == 'success'){
	                $(".success.message").show().delay(500).slideUp();
					location.reload();
				}
				else{ //no function
	                $(".error.message").show().delay(1200).slideUp();
				}
			}
		});
	    e.preventDefault();
	})
    //------------- login -------------//

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
			$('.error.message').show().delay(3000).slideUp();
			$('<div class="header">請確認資料欄不為空</div>').appendTo('.ui.error.message');
		}
		else{
		    $.ajax({
		        type: form.attr('method'),
		        url: form.attr('action'),
				data: form.serialize()+'&type=create_sem',
				success: function(data){
					if(data.status == 'success'){
						//$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
						$(".success.message").show().delay(2000).slideUp();
		                $('<div class="header">新增學期成功</div>').appendTo('.ui.success.message');
						setTimeout("location.reload();",2500);
					}
					else{ //no function
						$('.ui.loader').removeClass('active');
		                $('html,body').animate({scrollTop: 0});
		                $('.error.message').show().delay(6000).slideUp();
		                $('<div class="header">Error: ' + data.status + '</div>').appendTo('#error_message');
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
	        	url: 'cpanel_edit.php',
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
                        $('<div class="header">刪除失敗</div><p>Error: ' + data.status + '</p>').appendTo('.error.message');
					}
				}
			});
		    e.preventDefault();
		}
		else
			return false;
    })
})

function update_pwd(e){
	var form = $('.ui.form.update_pw');
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
		data: form.serialize() + '&type=update_pw',
		success: function(data){
			if(data.status == 'success'){
                $(".success.update_pw").show().delay(800).slideUp();
                $('<p>更新成功</p>').appendTo('.success.update_pw');
			}
			else{ //no function
                $(".error.update_pw").show().delay(1500).slideUp();
                $('<p>更新失敗，請確認輸入正確密碼。</p>').appendTo('.error.update_pw');
			}
		}
	});
	e.preventDefault();
}