$(document).ready(function(){
	
	$(".btnwrap").addClass("active");
	$(".showhidebtn").click(function(){		
		$(".hasSideButtons").toggleClass("opened");
		$(".btnwrap").toggleClass("active")
		$(".showhidebtn").toggleClass("active")
	});
	// add class to body tag
	$("body").addClass('hold-transition skin-blue sidebar-mini');
	$("#frm_search select,.frm_addedit select").selectize();
	
	var isInIframe = self != top;
	if(isInIframe) {
		$(".main-header").hide();
		$(".main-sidebar").hide();
		$(".main-footer").hide();
		$(".content-wrapper").css("margin-left","0px");
		$(".main-footer").css("margin-left","0px");
	}else{
		/*showNotification();
		setInterval(function(){ showNotification(); }, 50000);*/
	}
	
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};	
	
	var inputs = $('input')
	.not(':input[type=button], :input[type=submit], :input[type=reset]');
	//$(inputs).keydown(function(event){
		$(document).on("keypress",":input:not(textarea):not([type=button]):not([type=submit]):not([type=reset])",function(event){
			if(event.keyCode == 13) {
			//console.log("enter pressed");
			event.preventDefault();
			return false;
		}
	});
		$("#frm_login").find("input:text:visible, input:password").on("keydown",function(event){
		//console.log(1);
		if(event.keyCode==13){
			event.preventDefault();
			$("#btn_submit").trigger("click");
		}
	});
		
	//shortcut keys	
	shortcut.add("Ctrl+s",function() {				
		$(".frm_addedit:visible").submit();
	});
	/*shortcut.add("F9",function() {			
		search_sp_vehicle();
	});
	shortcut.add("F1",function() {		
		window.location='index.php?view=transaction_addedit';
	});*/
	
	$(document).on("click",".checkAllemail",function(event){
		if($(this).prop('checked')){
			$('.emailAll:visible').prop('checked',$(this).prop('checked'));
		}else{
			$('.emailAll').prop('checked',$(this).prop('checked'));
		}
	});
	$(document).on("click",".emailAll",function(event){
		var member_checkbox=document.getElementsByName('email[]');
		var member_len=member_checkbox.length;
		var count=0
		for(var i=0; i<member_len; i++){
			if(member_checkbox[i].checked==true){
				count++;
			}
		}
		if(count==member_len){
			$('.checkAllemail').prop('checked',true);
		}else{
			$('.checkAllemail').prop('checked',false);
		}
	});
	$('.checkAll').click(function(){	
		if($(this).prop('checked')){
			$('.delAll:visible').prop('checked',$(this).prop('checked'));
		}else{
			$('.delAll').prop('checked',$(this).prop('checked'));
		}			
	});
	$('.delAll').click(function(){
		var member_checkbox=document.getElementsByName('del[]');
		var member_len=member_checkbox.length;
		var count=0
		for(var i=0; i<member_len; i++){
			if(member_checkbox[i].checked==true){
				count++;
			}
		}
		if(count==member_len){
			$('.checkAll').prop('checked',true);
		}else{
			$('.checkAll').prop('checked',false);
		}
	});
	
	$('.checkAllAccess').click(function(){	
		if($(this).prop('checked')){
			$('.page_select:visible').prop('checked',$(this).prop('checked'));
		}else{
			$('.page_select').prop('checked',$(this).prop('checked'));
		}			
	});
	$('.page_select').click(function(){
		var member_checkbox=document.getElementsByName('page_name[]');
		var member_len=member_checkbox.length;
		var count=0
		for(var i=0; i<member_len; i++){
			if(member_checkbox[i].checked==true){
				count++;
			}
		}
		if(count==member_len){
			$('.checkAllAccess').prop('checked',true);
		}else{
			$('.checkAllAccess').prop('checked',false);
		}
	});
	
	$('.checkAllAccess').click(function(){
		$('.page_select').prop('checked',$(this).prop('checked'));			
	});
	$("input:button").button();
	
	//if($('form').attr('name')=="frm_search"){
		$("#frm_search").find("input:text:visible, select").on("keypress",function(event){
			//console.log(1);
			if(event.keyCode==13){
				event.preventDefault();
				$("#btn_search").trigger("click");
			}
		});
	//}
	
	if($('#save_print').length>0){
		$("#save_print").on("click",function() {
			save_print($(this));
		});
	}	
	$(".cheque_row").hide();
	//validator methods
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
		if(value)
			return arg != value;
		else
			return true;	 
	}, "Please Select Value");
	$.validator.addMethod("regex", function(value, element, regexp) {		
		if(value){
			var re = new RegExp(regexp);
			return re.test(value);
		}
		else{
			return true;
		}
	},"Please check your input.");
	$.validator.addMethod("contactNumber", function(value, element) {
		return this.optional(element) || /[0-9 -()+]+$/i.test(value);
	}, "numbers and space only please");
	$.validator.addMethod("mobileNumber", function(value, element) {
		return this.optional(element) || /^[6-9]{1}[0-9]{9}$/i.test(value);
	}, "Please Enter Valid Mobile No.");
	$.validator.addMethod("greaterThan", function(value, element, params) {
		//console.log(this.optional(element));
		if(this.optional(element)){
			return this.optional(element);
		}else{
			var target = $(params).val();
			value=value.replace(/[^0-9]/g, '');
			target=target.replace(/[^0-9]/g, '');
			var isValueNumeric = !isNaN(parseFloat(value)) && isFinite(value);
			var isTargetNumeric = !isNaN(parseFloat(target)) && isFinite(target);
			if (isValueNumeric && isTargetNumeric) {
				return Number(value) >= Number(target);
			}else{
				return false;
			}
		}
	},'Must be greater than {0}.');
	$.validator.addMethod("lessThan", function(value, element, params) {
		//console.log(this.optional(element));
		if(this.optional(element)){
			return this.optional(element);
		}else{
			var target = $(params).val();
			value=value.replace(/[^0-9]/g, '');
			target=target.replace(/[^0-9]/g, '');
			var isValueNumeric = !isNaN(parseFloat(value)) && isFinite(value);
			var isTargetNumeric = !isNaN(parseFloat(target)) && isFinite(target);
			if (isValueNumeric && isTargetNumeric) {
				return Number(value) <= Number(target);
			}else{
				return false;
			}
		}
	},function(params, element) {
		return 'Please Enter A Value Less Than Or Equal To '+$(params).val()+'.'
	});
	
	$.validator.addMethod("greaterThanInvoice",
		function(value, element, param) {
			var i = parseFloat(value);
			var j = parseFloat(param);
			return (i >= j);
		},'Must be greater than {0}.');
	$.validator.addMethod("lessThanInvoice",
		function(value, element, param) {
			var i = parseFloat(value);
			var j = parseFloat(param);
			return (i <= j);
		},'Must be less than {0}.');
	$.validator.addMethod("equalTextValue",
		function(value, element, param) {
			//console.log(value+" : "+param);
			var i = value;
			if(param.is('select')){
				var j = $(param).find('option:selected').text();
			}else{
				var j = $(param).val();
			}
			console.log(i+" : "+j);
			return (i == j);
		},'Must be same.');
	jQuery.validator.addMethod("validDate", function(value, element) {
		return this.optional(element) || (!/Invalid|NaN/.test(new Date($.datepicker.formatDate("mm/dd/yy",$.datepicker.parseDate("dd-mm-yy",value)))));
	}, "Please enter a valid date in the format DD-MM-YYYY");
	$.validator.addMethod("website", function(value, element) {
		return this.optional(element) || /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/i.test(value);
	}, "Please Enter Valid Website URL");
	$.validator.addMethod("GSTIN", function(value, element) {
		return this.optional(element) || /^([0][1-9]|[1-2][0-9]|[3][0-7])[a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ][0-9a-zA-Z]{1}$/i.test(value);
	}, "Please Enter Valid GSTIN");
	$.validator.addMethod("PAN", function(value, element) {
		return this.optional(element) || /^[a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}$/i.test(value);
	}, "Please Enter Valid PAN");
	$.validator.addMethod("TAN", function(value, element) {
		return this.optional(element) || /^[a-zA-Z]{4}[0-9]{5}[a-zA-Z]{1}$/i.test(value);
	}, "Please Enter Valid TAN");
	//Internation cell number 
	$.validator.addMethod("cellNumber", function(value, element) {
		return this.optional(element) || /^[+]{1}[0-9]{11,12}$/i.test(value);
	}, "Please Enter Valid Cell No.");
	$(document).on("keypress","input.hasDatepicker, input.pickTime",function(event) { if(!$(this).hasClass("receipt_date")) event.preventDefault();});
	$(document).on("focus","input.hasDatepicker",function() {$(this).attr('autocomplete', 'off');});
	$.datepicker.setDefaults({
		onSelect:function(){this.focus();},				  
	});		
	$(document).on("focus keyup","input.allow_num",function(event){
		$(this).keypress(function (e) {			
			var charCode = (e.which) ? e.which : e.keyCode	
			//console.log(charCode);					
			if(charCode!=8 && charCode!=0  && (charCode != 46 || $(this).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
				(charCode < 48 || charCode > 57) &&
				$.inArray(charCode, [8, 9, 27, 13, 190]) === -1 &&
				!(charCode >= 35 && charCode <= 40)
				){
				return false;
		}
			/*if($(this).hasClass("allow_sign") && (charCode != 45 || this.selectionStart> 0)){
				return false;
			}*/
		});
		/*//dont allow to paste value
		$(this).bind("paste",function(e) {
			e.preventDefault();
		});*/
		//dont allow to paste value
		if($(this).attr("name")!='mobile_no' && $(this).attr("name")!='mobile_number' && $(this).attr("name")!='mobile_number2'){
			$(this).bind("paste",function(e) {
				e.preventDefault();
			});
		}
	});
	$(document).on("focus keyup","input.allow_digits",function(event){
		$(this).keypress(function (e) {			
			var charCode = (e.which) ? e.which : e.keyCode	
			//console.log(charCode);					
			if(charCode!=8 && charCode!=0  && 
				(charCode < 48 || charCode > 57) &&
				$.inArray(charCode, [8, 9, 27, 13, 190]) === -1 &&
				!(charCode >= 35 && charCode <= 40)
				){
				return false;
		}
			/*if($(this).hasClass("allow_sign") && (charCode != 45 || this.selectionStart> 0)){
				return false;
			}*/
		});
		/*//dont allow to paste value
		$(this).bind("paste",function(e) {
			e.preventDefault();
		});*/
		//dont allow to paste value
		if($(this).attr("name")!='mobile_no' && $(this).attr("name")!='mobile_number' && $(this).attr("name")!='mobile_number2'){
			$(this).bind("paste",function(e) {
				e.preventDefault();
			});
		}
	});
	/* use class moveUpDown to navigate textbox with up & down arrow keys */
	$(document).on('keydown','.moveUpDown',function (e) {		
		if (e.which === 38) {
			$(this).closest("tr").prev("tr").find('.moveUpDown').focus();
		}
		if (e.which === 40) {
			$(this).closest("tr").next("tr").find('.moveUpDown').focus();
		}
	});
	
	$("#frm_search .date").datepicker({
		dateFormat: 'd-m-yy',
		changeMonth: true,
		changeYear: true,
	});
	$("#frm_search #car_rate_id,#frm_search select#branch_id").selectize({ 
		openOnFocus:true,  
	});
	
	if($('form').attr('name')!="frm_search"){		
		$("#frm_login,#frm_forgot_password,.frm_addedit").find("input:text:visible, textarea:visible, input:radio:visible, input:checkbox:visible, input:password:visible").first().focus();	
	}
	
	$(document).on("change","input[type=file]",function(event){
		if($(this).attr("name")=="id_card_photo"){			
			read_url(this,"id_card_photo_div");
		}else{
			if(!$(this).hasClass('all_files')){	
				if($(this).hasClass('image_pdf')){
					read_url_imagepdf(this);
				}else{		
					read_url(this,"show_image");		
				}
			}
		}
	});
	if($('.popup_image').length>0){
		$(".popup_image").fancybox({
			'autoScale'	: true,
		});
	}
	//rich text editor
	//$('.jqte-test').jqte();	
	/* ======== hide success/error message ======== */
	if($(".success_msg").length>0){
		setTimeout(function() {
			$(".success_msg").hide('blind', {}, 500)
		}, 5000);
	}
	if($(".error_msg").length>0){
		setTimeout(function() {
			$(".error_msg").hide('blind', {}, 500)
		}, 5000);
	}
	if($(".warning_msg").length>0){
		setTimeout(function() {
			$(".warning_msg").hide('blind', {}, 500)
		}, 5000);
	}
	/*$(document).on("load","input.hasDatepicker",function() {
		if(isMobile.any()){
			//alert(isMobile.any());
			$(this).attr("readonly","readonly");	
		}
	});*/
	
	$(".pickTime").timepicker({
		'timeFormat': 'h:i A',
		'minTime':($(this).closest("form").find(".pickDate").datepicker('getDate')==new Date()?get_current_time(new Date()):'12:00am'),
		'step':15,
		'maxTime':'11:45pm'
	});
	
	$(window).load(function(e) {
		$("input[readonly]").each(function(e) {       
			$(this).attr("tabindex","-1");
		});
		if(isMobile.any()){			
			$("input.hasDatepicker").prop("readonly",true);
			$("input.allow_num").attr("type","number");
			$("input.allow_num").attr("step","any");
		}
	});	
});
function print_without_paging(type,page){
	$.fancybox({
		'width'				: '95%',
		'height'			: '75%',
		'autoSize'			: false,
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'type'				: 'iframe',
		'titleShow'  	: false,
		'href'				: 'index.php?view='+page+'&print=yes'+(type=='export'?'&export=yes':''),
	});
}
function save_print(el){
	//var form = $(el).parents().find('form');	
	var form = $(el).closest('form')
	$('<input>').attr({
		type: 'hidden',
		id: 'print',
		name: 'print',
		value: 'yes',							
	}).appendTo(form.get(0));
	form.submit();
}
function common_function(optns){
	var frm = $("<form>", {'method':'post'});
	for(key in optns){
		$("<input>", {'type':'hidden', 'name':key, 'value':optns[key]}).appendTo(frm);
	}
	frm.appendTo("body");
	frm.submit();
}
function confirm_del(optns){	
	$.confirm({
		title: 'Confirmation Dialog',
		icon:'glyphicon glyphicon glyphicon-exclamation-sign',
		content: 'Do you really want to delete?',		
		theme: 'skin-blue',    	
		buttons: {
			confirm: function () {
				text: 'Proceed';
				var frm = $("<form>", {'method':'post'});
				for(key in optns){
					$("<input>", {'type':'hidden', 'name':key, 'value':optns[key]}).appendTo(frm);
				}
				frm.appendTo("body");
				frm.submit();
			},
			cancel: function () {
				text: 'Cancel';
			},
		}		
	});
}
function mulitple_delete(formname){
	var ellen=document.getElementById(formname).elements.length;
	var count=0;
	for(var i=0;i<ellen;i++){
		if(document.getElementById(formname).elements[i].name=="del[]"){	
			if(document.getElementById(formname).elements[i].checked==true){
				count=count+1;
			}
		}
	}
	if(count==0){
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"Please Select Record To Delete",
			theme: 'skin-blue',
			confirm: function(){				
			}});			
		return false;
	}else{
		$.confirm({
			title: 'Confirmation Dialog',
			icon:'glyphicon glyphicon glyphicon-exclamation-sign',
			content: 'Are you sure you want to delete records?',
			theme: 'skin-blue',			
			buttons: {
				confirm: function () {
					text: 'Proceed';
					document.getElementById(formname).act.value='multi_delete';
					document.getElementById(formname).submit();
				},
				cancel: function () {
					text: 'Cancel';
				},
			}			
		});
	}
}
function confirm_restore(optns){
	$.confirm({
		title: 'Confirmation Dialog',
		icon:'glyphicon glyphicon glyphicon-exclamation-sign',
		content: 'Do you really want to restore?',		
		theme: 'skin-blue',    	
		buttons: {
			confirm: function () {
				text: 'Proceed';
				var frm = $("<form>", {'method':'post'});
				for(key in optns){
					$("<input>", {'type':'hidden', 'name':key, 'value':optns[key]}).appendTo(frm);
				}
				frm.appendTo("body");
				frm.submit();
			},
			cancel: function () {
				text: 'Cancel';
			},
		}			
	});
}
function confirm_send_sms(optns){	
	$.confirm({
		title: 'Confirmation Dialog',
		icon:'glyphicon glyphicon glyphicon-exclamation-sign',
		content: 'Do you really want to send SMS?',		
		theme: 'skin-blue',    	
		buttons: {
			confirm: function () {
				text: 'Proceed';
				var frm = $("<form>", {'method':'post'});
				for(key in optns){
					$("<input>", {'type':'hidden', 'name':key, 'value':optns[key]}).appendTo(frm);
				}
				frm.appendTo("body");
				frm.submit();
			},
			cancel: function () {
				text: 'Cancel';
			},
		}		
	});
}
function mulitple_send_sms(formname){
	var ellen=document.getElementById(formname).elements.length;
	var count=0;
	for(var i=0;i<ellen;i++){
		if(document.getElementById(formname).elements[i].name=="del[]"){	
			if(document.getElementById(formname).elements[i].checked==true){
				count=count+1;
			}
		}
	}
	if(count==0){
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"Please Select Record To Send SMS",
			theme: 'skin-blue',
			confirm: function(){				
			}});			
		return false;
	}else{
		$.confirm({
			title: 'Confirmation Dialog',
			icon:'glyphicon glyphicon glyphicon-exclamation-sign',
			content: 'Are you sure you want to Send SMS to Selected?',
			theme: 'skin-blue',			
			buttons: {
				confirm: function () {
					text: 'Proceed';
					document.getElementById(formname).act.value='multi_send_sms';
					document.getElementById(formname).submit();
				},
				cancel: function () {
					text: 'Cancel';
				},
			}			
		});
	}
}
function confirm_approve(optns){	
	$.confirm({
		title: 'Confirmation Dialog',
		icon:'glyphicon glyphicon glyphicon-exclamation-sign',
		content: 'Do you really want to Approve ?',		
		theme: 'skin-blue',    	
		buttons: {
			confirm: function () {
				text: 'Proceed';
				var frm = $("<form>", {'method':'post'});
				for(key in optns){
					$("<input>", {'type':'hidden', 'name':key, 'value':optns[key]}).appendTo(frm);
				}
				frm.appendTo("body");
				frm.submit();
			},
			cancel: function () {
				text: 'Cancel';
			},
		}		
	});
}
function search_records(){
	var valid=0;
	$("#frm_search input[type=text],#frm_search textarea").each(function(){
		if($(this).val() != "") valid+=1;
	});
	$("#frm_search select").each(function(){
		if($(this).val() != "") valid+=1;
	});
	$("#frm_search input[type=radio]:checked").each(function(){
		if($(this).val() != "" && $(this).val()!=0) valid+=1;
	});
	if(valid==0){
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"Please Select Some Search Criteria",
			theme: 'skin-blue',
			confirm: function(){				
			}});		
		return false;
	}else{
		document.frm_search.submit();
		return true;
	}
}
function change_status(id, table_name, current_status){
	$('#status_'+id).removeAttr('onclick');
	$.ajax({
		type: "POST",
		url: "../scripts/ajax/index.php",
		data: "method=change_status&id="+id+"&table_name="+table_name+"&current_status="+current_status,
		success: function(msg){
			if(msg=='OK'){
				var status = (current_status=='Active')?'images/inactive.png':'images/active.png';
				$('#status_'+id).attr('src',status);
				$('#status_'+id).unbind('click');
				$('#status_'+id).click(function(){change_status(id, table_name, current_status=='Active'?'Inactive':'Active')});
				$.alert({
					title: 'Alert!',
					icon:'glyphicon glyphicon-info-sign',
					content:"SUCCESS!! \n\n\Status changed successfully...",
					theme: 'skin-blue',
					confirm: function(){ }
				});
			}else if(msg=='CANCEL'){
				$.alert({
					title: 'Alert!',
					icon:'glyphicon glyphicon-info-sign',
					content:"\nERROR!! \n\n\Ooops problem in change status. \n\n\ Please try again",
					theme: 'skin-blue',
					confirm: function(){ }
				});	
			}else{
				$.alert({
					title: 'Alert!',
					icon:'glyphicon glyphicon-info-sign',
					content:msg,
					theme: 'skin-blue',
					confirm: function(){ }
				});	
			}
		}
	});
}
function change_payment_status(val,id,table_name){	
	$.confirm({
		title: 'Confirmation Dialog',
		icon:'glyphicon glyphicon glyphicon-exclamation-sign',
		content: 'Do you really want to change status?',		
		theme: 'skin-blue',
		buttons: {
			confirm: function () {
				text: 'Proceed';
				$.ajax({
					type: "POST",
					url: "../scripts/ajax/index.php",
					data: "method=change_payment_status&id="+id+"&val="+val+"&table_name="+table_name,
					success: function(msg){
						if(msg=='OK'){
							$.alert({
								title: 'Alert!',
								icon:'glyphicon glyphicon-info-sign',
								content:"SUCCESS!! \n\n\Status changed successfully...",
								theme: 'skin-blue',
								confirm: function(){ }
							});
						}else{
							$.alert({
								title: 'Alert!',
								icon:'glyphicon glyphicon-info-sign',
								content:"\nERROR!! \n\n\Ooops problem in change status. \n\n\ Please try again",
								theme: 'skin-blue',
								confirm: function(){ }
							});	
						}
					}
				});
			},
			cancel: function () {
				text: 'Cancel';
			},
		}	
	});
}
function change_table_status(val,id,table_name){
	if(table_name=='manifest' && val=='Arrived'){
		$.confirm({
			onOpen: function(){
				$("#frm_disp_arrived .date").datepicker({dateFormat: 'dd-mm-yy'});
				$("#frm_disp_arrived .date").datepicker("setDate",new Date());
			},
			onClose: function(){
				$("#frm_disp_arrived .date").datepicker("destroy");
			},			
			title: 'Arrived on Date :',
			theme: 'skin-blue',
			content: '' +
			'<form action="" class="frm_addedit" id="frm_disp_arrived" name="frm_disp_arrived">' +
			'<div class="form-group">' +
			'<strong>Select Date</strong>' +
			'<input type="text" placeholder="Select Date" class="date form-control" autocomplete="off" onkeypress="event.preventDefault();" required/>' +
			'</div>' +			
			'</form>',
			buttons: {
				formSubmit: {
					text: 'Submit',					
					action: function () {
						var date = this.$content.find('.date').val();
						if(!date){
							$.alert({
								title: 'Alert!',
								icon:'glyphicon glyphicon-info-sign',
								content:"Select a valid date",
								theme: 'skin-blue',
								onDestroy: function(){ $("#frm_disp_arrived").find('.date').focus(); }
							});							
							return false;
						}else{
							$.ajax({
								type: "POST",
								url: "../scripts/ajax/index.php",
								data: "method=save_manifest_arrive_date&id="+id+"&val="+val+"&table_name="+table_name+"&arrived_date="+date,
								success: function(msg){
									if(msg=='OK'){
										location.reload();
									}else{
										$.alert({
											title: 'Alert!',
											icon:'glyphicon glyphicon-info-sign',
											content:"\nERROR!! \n\n\Ooops problem in saving date. \n\n\ Please try again",
											theme: 'skin-blue',
											onDestroy: function(){ location.reload(); }
										});
									}
								}
							});
						}
					}
				},
				cancel: function () {
					location.reload();
				},
			},
			onContentReady: function () {
				// bind to events
				var jc = this;
				this.$content.find('form').on('submit', function (e) {
					// if the user submits the form by pressing enter in the field.
					e.preventDefault();
					jc.$$formSubmit.trigger('click'); // reference the button and click it
				});
			}
		});
	}else{
		$.confirm({
			title: 'Confirmation Dialog',
			icon:'glyphicon glyphicon glyphicon-exclamation-sign',
			content: 'Do you really want to change status?',		
			theme: 'skin-blue',
			buttons: {
				confirm: function () {
					text: 'Proceed';
					$.ajax({
						type: "POST",
						url: "../scripts/ajax/index.php",
						data: "method=change_table_status&id="+id+"&val="+val+"&table_name="+table_name,
						success: function(msg){
							if(msg=='OK'){
								location.reload();
							}else{
								$.alert({
									title: 'Alert!',
									icon:'glyphicon glyphicon-info-sign',
									content:"\nERROR!! \n\n\Ooops problem in change status. \n\n\ Please try again",
									theme: 'skin-blue',
									onDestroy: function(){ location.reload(); }
								});
							}
						}
					});
				},
				cancel: function () {
					location.reload();
				},
			},
		});
	}
}
function confirm_change(optns){
	$.confirm({
		title: 'Confirmation Dialog',
		icon:'glyphicon glyphicon glyphicon-exclamation-sign',
		content: 'Do you really want to change status?',		
		theme: 'skin-blue',
		buttons: {
			confirm: function () {
				text: 'Proceed';
				var frm = $("<form>", {'method':'post'});
				for(key in optns){
					$("<input>", {'type':'hidden', 'name':key, 'value':optns[key]}).appendTo(frm);
				}
				frm.appendTo("body");
				frm.submit();
			},
			cancel: function () {
				text: 'Cancel';
				var frm = $("<form>", {'method':'post'});
				$("<input>", {'type':'hidden', 'name':'act', 'value':'load_data'}).appendTo(frm);
				frm.appendTo("body");
				frm.submit();
			},
		}		
	});
}
function get_sms_template(id){
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "../scripts/ajax/index.php",
		data: "method=get_sms_template_data&sms_template_id="+id,
		success: function(data){
			//console.log(data);
			if(id!='0')
				$('#message').val(data[0]['message']);
			else
				$("#message").val("");
		}
	});	
}
function read_url(input,disp_field) {	
	var files = !!input.files ? input.files : [];	
	if (!files.length || !window.FileReader){ $('#'+disp_field).html(""); return; }// no file selected, or no FileReader support
	if (/^image/.test( files[0].type)){ 
		// only image file
		if(disp_field!=''){
			var reader = new FileReader(); // instance of the FileReader
			reader.readAsDataURL(files[0]); // read the local file
			reader.onload = function(e){ 
				$('#'+disp_field).html($('<img />')
					.attr('src', "" + e.target.result + ""));         // ADD IMAGE PROPERTIES.
			}			
		}
	}else{
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"Please upload only images",
			theme: 'skin-blue',
			confirm: function(){ }
		});
		input.value="";
	}
}
function read_url_imagepdf(input) {	
	var files = !!input.files ? input.files : [];	
	if (!files.length || !window.FileReader){ return; }// no file selected, or no FileReader support
	if (/^image/.test( files[0].type) || /pdf/.test( files[0].type)){ 
		// only pdf file		
	}else{
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"Please upload Image or PDF file",
			theme: 'skin-blue',
			confirm: function(){ }
		});
		input.value="";
	}
}
function get_suggession(table,field,value,branch_id,type){	
	if (typeof(branch_id)==='undefined') branch_id = '';
	if (typeof(type)==='undefined') type = '';
	$(".auto").each(function(index, element) {
		var get_users=($(this).hasClass("get_users")?'Yes':'');
		$(this).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url : '../scripts/ajax/index.php',		      			
					type: 'post',
					dataType: "json",
					data: "method=get_suggession&table="+table+"&field="+field+"&value="+encodeURIComponent(request.term)+"&branch_id="+branch_id+"&branch_id="+branch_id+"&type="+type+"&get_users="+get_users,
					success: function(data) {	
						response($.map(data,function(item,i) {	
							if(table == "account"){
								return {							
									label: data[i][field] +' ['+ data[i]['id'] + ']',
									value: data[i][field]
								}
							}else{
								return {							
									label: data[i][field],
									value: data[i][field]
								} 
							}
						}));
					},
					error: function(xhr, desc, err) {
						console.log(xhr);
						console.log("Details: " + desc + "\nError:" + err);
					}
				});
			},
			minLength: 1,
		});	
	});
}
function add_multiple_image(original_path_config,resize_path_config,ftp){
	$("head").append('<link rel="stylesheet" href="js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />');
	$("head").append('<script type="text/javascript" src="js/jquery.plupload.queue/plupload.full.min.js"></script>');
	$("head").append('<script type="text/javascript" src="js/jquery.plupload.queue/jquery.plupload.queue.js"></script>');
	// Setup html5 version
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : '../scripts/ajax/upload_multiple_images.php?original_path_config='+original_path_config+"&resize_path_config="+resize_path_config+(ftp?"&ftp="+ftp:''),
		chunk_size: '1mb',
		rename : true,
		dragdrop: true,
		
		filters : {
			// Maximum file size
			max_file_size : '10mb',
			// Specify what files to browse for
			mime_types: [
			{title : "Image files", extensions : "jpg,gif,png,jpeg"},
			{title : "Zip files", extensions : "zip"}
			]
		},
		// Resize images on clientside if we can
		//resize : {width : 320, height : 240, quality : 90},
		flash_swf_url : 'js/plupload.Moxie.swf',
		silverlight_xap_url : 'js/plupload.Moxie.xap',
		init: {
			FileUploaded: function(up, file, info) {
				//console.log(file);
				//console.log(info.response);				
				var names;
				var files_name=$('#files_name').val();
				if(info.response!='' && info.response!=null){
					if(files_name!=''){
						names=files_name+","+info.response;
					}else{
						names=info.response;
					}
					$('#files_name').val(names);
				}				
			},
			Error: function(up, args){
				if(args.file){
					console.log('[error]', args, "File:", args.file);
				} else {
					console.log('[error]', args);
				}
			}
		}
	});
	$('#clear').click(function(e) {
		e.preventDefault();
		$("#uploader").pluploadQueue().splice();
		$('.plupload_buttons').css("display","block");
		$('.plupload_upload_status').css("display","none");
		$('.plupload_total_file_size').html("0 b");
		$('.plupload_total_status').css("0%");
	});	
}
function excel_export(name,filename) {
	$("head").append('<script type="text/javascript" src="js/jquery/jquery.techbytarun.excelexportjs.js"></script>');
	//console.log(name);
	//console.log(filename);
	$(".print_header").show();
	$(".records_table").excelexportjs({
		containerid: "tblExport",
		datatype: 'table',
		ignoreClass: 'hide_print',
		worksheetName: name,
		fileName: filename,
		fileExt: ".xls"
	});	
	$(".print_header").css("display","none");	
}
function send_pdf_email(page_name,table_name,id){
	var email_id='';
	if(table_name!='' && id!=''){		
		$.ajax({
			url: '../scripts/ajax/index.php',
			type: 'post',
			async:false,		  
			data: "method=get_email_id&table_name="+table_name+"&id="+id,
			success: function(data) {
			  //console.log(data);
			  email_id=data;
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
			}
		}); // end ajax call
	}
	$.confirm({					
		title: 'Enter Email-Id to send Email',
		theme: 'skin-blue',
		content: '' +
		'<form action="" class="frm_addedit" id="frm_send_mail" name="frm_send_mail">' +
		'<div class="form-group">' +
		'<strong>Enter Email</strong>' +
		'<input type="email" placeholder="Enter Email" class="email form-control" value="'+email_id+'" autocomplete="off" required/>' +
		'</div>' +
		'</form>',
		buttons: {
			formSubmit: {
				text: 'Submit',					
				action: function () {
					var email = this.$content.find('.email').val();
					var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;						
					if(!email || !emailExp.test(email)){
						$.alert({
							title: 'Alert!',
							icon:'glyphicon glyphicon-info-sign',
							content:"Enter Valid Email Id",
							theme: 'skin-blue',
							onDestroy: function(){ $("#frm_send_mail").find('.email').focus(); }
						});							
						return false;
					}else{
						location.href='index.php?view='+page_name+(id!=''?'&id='+id:'')+'&send=mail&email_id='+encodeURIComponent(email)
					}
				}
			},
			cancel: function () {
				//location.reload();
			},
		},
		onContentReady: function () {
			// bind to events
			var jc = this;
			this.$content.find('form').on('submit', function (e) {
				// if the user submits the form by pressing enter in the field.
				e.preventDefault();
				jc.$$formSubmit.trigger('click'); // reference the button and click it
			});
		}
	});	
}
function get_numbers(){
	var branch_id = $("#branch_id").val();
	var groups=[];
	$("[id^=group]:checked").each(function(){
		groups.push($(this).val());
	});
	$("#contact_tbl").empty();
	if(groups!=''){
		$.ajax({
			url: '../scripts/ajax/index.php',
			type: 'post',
			data: "method=get_contacts&groups="+groups+"&branch_id="+branch_id,
			success: function(data) {
        //console.log(data);
        if(data!=''){
        	var table_html='';
        	table_html+='<input type="checkbox" class="check_all_contact" style="margin-left:15px;">&nbsp;<strong>Select All Contacts</strong><span style="float:right" id="selected_count"></span><ul id="contact_list" style="list-style-type:none;text-align:left;margin-top: 0;">';
        	var opts = $.parseJSON(data);
        	for(var i=0;i<opts.length;i++){
        		table_html+='<li>'+'<input type="checkbox" name="contact[]" value="'+opts[i]['mobile']+'" class="all_contact">&nbsp;'+opts[i]['name']+' ('+opts[i]['mobile']+')</li>';
        	}
        	table_html+='</ul>';
        	$("#contact_tbl").append(table_html);
        	$("#contact_list").quickPagination({pagerLocation:"both",pageSize:"200"});
        }
      },
      error: function(xhr, desc, err) {
      	console.log(xhr);
      	console.log("Details: " + desc + "\nError:" + err);
      }
    });
	}
}
function change_pwd_alert(){
	$.confirm({
		title: 'Confirmation Dialog',
		icon:'glyphicon glyphicon glyphicon-exclamation-sign',
		content: 'Are you sure you want to continue without Change Password ?',		
		theme: 'skin-blue',
		buttons: {
			confirm: {
				text: 'Proceed',
				action: function(){
					$.ajax({
						url: "../scripts/ajax/continue_change_pwd.php",
						type: "GET",						
					});
				},
			},
			cancel: {
				text: 'Change Password',
				action: function(){
					location.href='index.php?view=change_password';	
				}
			},
		}		
	});
}
function inrFormat(nStr) { // nStr is the input string
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	var z = 0;
	var len = String(x1).length;
	var num = parseInt((len/2)-1);
	while (rgx.test(x1))
	{
		if(z > 0)
		{
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		else
		{
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
			rgx = /(\d+)(\d{2})/;
		}
		z++;
		num--;
		if(num == 0)
		{
			break;
		}
	}
	return x1 + x2;
}
function padding_left(s, c, n) {
	if (! s || ! c || s.length >= n) {
		return s;
	}
	var max = (n - s.length)/c.length;
	for (var i = 0; i < max; i++) {
		s = c + s;
	}
	return s;
}
var tableToExcel = (function () {
	var uri = 'data:application/vnd.ms-excel;base64,',
	template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
	base64 = function (s) {
		return window.btoa(unescape(encodeURIComponent(s)))
	}, format = function (s, c) {
		return s.replace(/{(\w+)}/g, function (m, p) {
			return c[p];
		})
	}
	return function (table, name, filename) {
		var table = document.getElementById(table),
		table = table.cloneNode(true),
		elementsToRemove = table.querySelectorAll('.hide_print');
		for(var i = elementsToRemove.length; i--;){
			var td = elementsToRemove[i];
			if(td){				
				td.remove();
			}
		}
		if (!table.nodeType) table = document.getElementById(table);
		table.innerHTML = table.innerHTML.replace(/<\s*a[^>]*>/gi,'');
		var ctx = {
			worksheet: name || 'Worksheet',
			table: table.innerHTML
		}	
		a = document.createElement("a");
		a.download = filename;
		a.href = uri + base64(format(template, ctx));
		document.body.appendChild(a);
		a.click();
		document.body.removeChild(a);
	}
})()
function multiple_print(print_page_name){
	var count=$(".delAll:checked").length;
	if(count==0){
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"Please Select Record First",
			theme: 'skin-blue',
			confirm: function(){				
			}});			
		return false;
	}else{
		var allVals = [];
		$('input[type=checkbox]:checked').each(function() {
			if($(this).attr("class")=="delAll"){
				allVals.push($(this).val());
			}
		});
		$.fancybox({
			'width'				: '95%',
			'height'			: '75%',
			'autoScale'			: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe',
			'titleShow'  	: false,
			'href'				: 'index.php?view='+print_page_name+'&id='+allVals,		
		});
	}
}
function update_table_data(el,table_name,field_name,field_value){
	var table_id=$(el).closest("tr").find(".delAll").val();	
	$.confirm({
		title: 'Confirmation Dialog',
		icon:'glyphicon glyphicon glyphicon-exclamation-sign',
		content: 'Do you really want to change?',		
		theme: 'skin-blue',
		buttons: {
			confirm: {
				text: 'OK',
				action: function () {
					$.ajax({
						url : '../scripts/ajax/index.php',		      			
						type: 'post',		
						data: "method=update_table_data&table_id="+table_id+"&table_name="+table_name+"&field_name="+field_name+"&field_value="+field_value,
						success: function(msg) {
							//console.log(msg);
							if(msg=='OK'){
								location.reload(true);
							}else{
								$.alert({
									title: 'Alert!',
									icon:'glyphicon glyphicon-info-sign',
									content:"\nERROR!! \n\n\Ooops some problem occurred. \n\n\ Please try again",
									theme: 'skin-blue',
									confirm: function(){ }
								});
								return false;
							}
						},
						error: function(xhr, desc, err) {
							console.log(xhr);
							console.log("Details: " + desc + "\nError:" + err);
						}
					});
				}
			},
			cancel: function () {
				location.reload();
			},
		}
	});
}
function show_hide_cheque_row(){
	var bank_acc=0;
	var acc_group_id = $("#frm_booking_complete .acc_group_id").val();
	if(acc_group_id=='9'){
		bank_acc++;	
	}	
	if(bank_acc>0){
		$("#frm_booking_complete .cheque_row").show();	
	}else{
		$("#frm_booking_complete .cheque_row").hide();
		$("#frm_booking_complete .cheque_row #ref_number").val("");
		$("#frm_booking_complete .cheque_row #bank_name").val("");
	}
}
function check_exist_account(){
	var flag=false;
	$.ajax({
		async: false,
		type:"post",
		url:"../scripts/ajax/check_exist_account.php?field_name=name",					
		data: {			
			id:function(){ return $("#id").val(); },
			name:function(){ return $("#name").val(); },
			mobile: function() { return $( "#mobile" ).val(); },
			email: function() { return $( "#email" ).val(); },			
		},
		success: function(data) {
			//console.log(data);
			if(data=='true'){
				flag=true;	
			}
		},
		error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nError:" + err);
		}
	}); // end ajax call
	return flag;	
}
function get_dropdown(table_name,key,value,element_id,first_option,where_condition){
	if(!(where_condition)){
		where_condition = "";
	}
	var is_selectize ="no";
	if($("#"+element_id)[0].selectize){
		is_selectize="yes";
		$("#"+element_id)[0].selectize.destroy();
	}
	$.ajax({
		url: '../scripts/ajax/index.php',
		type: 'post',
		data: "method=get_dropdown&table_name="+table_name+"&key="+key+"&value="+value+"&where_condition="+where_condition+"&from=admin",
		success: function(data) {
			//console.log(data);
			$("#"+element_id).html("");
			if(data!=''){
				var dd_html='';	
				if(first_option){					
					dd_html+="<option value=''>" + first_option + "</option>";
				}else{		
					dd_html+="<option value=''>" + $("#"+element_id).attr("placeholder") + "</option>";
				}
				var opts = $.parseJSON(data);								
				for(var i=0;i<opts.length;i++){
					dd_html+="<option value='" + opts[i][key] +"'>" + opts[i][value] + "</option>";
				}
				$("#"+element_id).html(dd_html);
			}
			if(is_selectize=='yes'){
				$("#"+element_id).selectize();	
			}
		},
		error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nError:" + err);
		}
	});
}
function initAutocomplete() {
	var acInputs = $(".google_autocomplete");
	// bounds for INDIA
	var defaultBounds = new google.maps.LatLngBounds(
		new google.maps.LatLng(6.4626999,68.1097),
		new google.maps.LatLng(35.513327,97.39535869999999)
		);
	for (var i = 0; i < acInputs.length; i++) {
		var autocomplete = new google.maps.places.SearchBox(acInputs[i], {bounds: defaultBounds});
		autocomplete.inputId = acInputs[i].id;
		autocomplete.addListener('places_changed', function () {
			var place = this.getPlaces();   
      // get lat
      var lat = place[0].geometry.location.lat();
      // get lng
      var lng = place[0].geometry.location.lng();
      // get locality, state, city
      var locality='';
      var state='';
      for (var i=0; i < place[0].address_components.length; i++) {
      	for (var j=0; j < place[0].address_components[i].types.length; j++) {
      		if (place[0].address_components[i].types[j] == "locality") {
      			locality = place[0].address_components[i].long_name;              
      		}
      		if (place[0].address_components[i].types[j] == "administrative_area_level_1") {
      			state = place[0].address_components[i].long_name;              
      		}
      	}
      }
      $("#"+this.inputId).closest("td").find(".google_latitude").val(lat);
      $("#"+this.inputId).closest("td").find(".google_longitude").val(lng);
      $("#"+this.inputId).closest("td").find(".google_locality").val(locality);
      if($("#state").length==1){
      	$("#state").val(state);
      }
      if($("#city").length==1){
      	$("#city").val(locality);
      }                
    });
	}
	$('.google_autocomplete').keyup(function(e){
		if(e.keyCode==8 || e.keyCode==46){
			$(this).closest("td").find(".google_latitude").val("");
			$(this).closest("td").find(".google_longitude").val("");
			$(this).closest("td").find(".google_locality").val("");
			if ($('#sp_location_id').length > 0){
				$('#sp_location_id').val(0);
			}
			if ($('#city_id').length > 0){
				$('#city_id').val(0);
			}
			if($("#state").length==1){
				$("#state").val('');
			}
		}
	});
}  
function set_order_arrow(new_index,old_index){
	$(".arrow_up:first").hide();
	$(".arrow_down:last").hide();
	$(".arrow_up:not(:first)").show();
	$(".arrow_down:not(:last)").show();
	$('.sort_order').each(function(i) {		
		this.value = i+1;
		$(this).closest("td").find(".sort_order_lbl").text($(this).val());			
	});
	//console.log(new_index+" : "+old_index);
	if(typeof(new_index)!=='undefined'){
		//console.log('in');
		$('.stop_name').each(function(i) {
			var $this=$(this);
			//console.log(i+" : "+new_index);
			if(old_index && old_index<new_index){
				index=old_index;	
			}else{
				index=new_index;	
			}			
		});
	}
}
function copy_uname(){
	var copy_field = $(".use_mob:checked").val();  
	if(copy_field!="" && $(".use_mob:checked").length==1){  	
		$("#username").val($("#"+copy_field).val());   	
	}else{
		$("#username").val("");
	}
}
function show_hide_login_field(){
	var create_login=$("#create_login:checked").val();	
	if(create_login!='' && $("#create_login:checked").length==1){		
		$(".login_fields").show();
	}else{
		$(".login_fields").hide();
		$("#username").val("");
	}
}
function show_cheque_row(){	
	/*var bank_acc=0;
	$("[id^=acc_group_id]").each(function(index,el){
		var acc_group_id = $(el).closest("tr").find("[id^=acc_group_id]").val();
		if(acc_group_id=='9'){
			bank_acc++;	
		}
	});
	if(bank_acc>0){
		$(".cheque_row").show();	
	}else{
		$(".cheque_row").hide();
		$(".cheque_row #cheque_no").val("");
		$(".cheque_row #bank_name").val("");
	}*/
	var bank_acc=0;
	$(".cheque_row").hide();
	/*$(".cheque_row #cheque_no").val("");
	$(".cheque_row #bank_name").val("");*/
	$(".cheque_row").find("input").attr("disabled","disabled");
	$("select[id^=account_id]:enabled").each(function(index,el){
		var account_id = $(el).val();		
		if(typeof account_id != 'undefined' && account_id>0){
			$.ajax({
				url: '../scripts/ajax/index.php',
				type: 'post',
				dataType: 'json',
			  //async:false,
			  data: "method=get_account_details&acc_rel_id="+account_id,
			  success: function(data) {			
			  	if(data!='' && data!=null){
			  		if(data[0]['acc_group_id']=='9'){
						//bank_acc++;	
						$(".cheque_row").show();
						$(".cheque_row").find("input").removeAttr("disabled");
					}
				}
			},
			error: function(xhr, desc, err) {
				console.log(xhr);
				console.log("Details: " + desc + "\nError:" + err);
			}
			}); // end ajax call
		}		
	});
}
function fetch_nested_list(element_id,branch_id,skip_group){	
	var is_selectize ="no";
	if($("#"+element_id)[0].selectize){
		is_selectize="yes";
		$("#"+element_id)[0].selectize.destroy();
	}
	$.ajax({
		type: "POST",		
		url: "../scripts/ajax/index.php",
		data: "method=fetch_nested_list&branch_id="+branch_id+"&skip_group="+skip_group,
		success: function(data){			
			$("#"+element_id).html("");
			if(data!='' && data!=null){
				var html = "";
				var opts = $.parseJSON(data);					
				for(var i=0;i<opts.length;i++){
					html+="<option value='" + opts[i]["id"] +"'>" + opts[i]["group_name"] + "</option>";
				}					
				$("#"+element_id).html(html);
			}
			if(is_selectize=='yes'){
				$("#"+element_id).selectize();	
			}			
		},
		error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nError:" + err);
		}
	});
}
function add_email_id_box(el){
	var tr=$("table#email_table").find("tbody tr:last");	
	if(tr.find(".email").val()==''){
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"Please Enter Email ID",
			theme: 'skin-blue',
			confirm: function(){ }
		});
	}else{
		var new_tr = $("table#email_table").find("tbody tr:last").clone()
		.find("input:text").val("").end()						  
		.appendTo($("table#email_table"));
		new_tr.find("input:checkbox").removeAttr("checked");				  
		set_send_alert(new_tr.find(".send_alert_check"));
		set_email_rule();
		new_tr.find(".email").focus();
		new_tr.find("label.error").remove();
		new_tr.find(".error").removeClass("error");
	}
}
function delete_email_id_box(el){
	var email = $(el).closest("tr").find(".email").val();
	var count = $("#email_table tbody").find("tr .email").length;	
	if(count>1){
		$(el).closest("tr").remove();				
	}else{
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"There must be atleast One Row. You can not delete it.",
			theme: 'skin-blue',
			confirm: function(){ }
		});
	}
}
function add_contact_box(el){
	var tr=$("table#contact_table").find("tbody tr:last");	
	if(tr.find(".mobile").val()=='' || tr.find(".mobile").hasClass('error')){
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"Please Enter Valid Contact Number",
			theme: 'skin-blue',
			confirm: function(){ }
		});
	}else{
		var new_tr = $("table#contact_table").find("tbody tr:last").clone()
		.find("input:text").val("").end()						  
		.appendTo($("table#contact_table"));
		new_tr.find("input:checkbox").removeAttr("checked");				  
		set_send_alert(new_tr.find(".send_alert_check"));
		set_contact_rule();
		new_tr.find(".mobile").focus();
		//new_tr.find("label.error").remove();
		//new_tr.find(".error").removeClass("error");
	}
}
function delete_contact_box(el){
	var email = $(el).closest("tr").find(".mobile").val();
	var count = $("#contact_table tbody").find("tr .mobile").length;	
	if(count>1){
		$(el).closest("tr").remove();				
	}else{
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"There must be atleast One Row. You can not delete it.",
			theme: 'skin-blue',
			confirm: function(){ }
		});
	}
}
function get_current_time(dt){
	dt.setHours(dt.getHours());
	dt.setMinutes(dt.getMinutes() + (15 - dt.getMinutes() % 15))
  //console.log(dt.getHours() + ':' + ('0' + dt.getMinutes()).slice(-2) + (dt.getHours() >= 12 ? 'pm' : 'am'));
  return dt.getHours() + ':' + ('0' + dt.getMinutes()).slice(-2) + (dt.getHours() >= 12 ? 'pm' : 'am');
}
function get_balance(){
	var balance='';
	$.ajax({
		url: '../scripts/ajax/index.php',
		type: 'post',
		async:false,
		dataType:"json",
		data: "method=get_sms_balance",
		success: function(data) {
		  //console.log(data);
		  balance=data;			  
		},
		error: function(xhr, desc, err) {
			console.log(xhr);
			console.log("Details: " + desc + "\nError:" + err);
		}
	});
	$.alert({
		title: 'Alert!',
		icon:'glyphicon glyphicon-info-sign',
		content:"Current SMS Balance : "+balance,
		theme: 'skin-blue',
		confirm: function(){ }
	});
}
let timerOn = true;
function timer(remaining) {
	var m = Math.floor(remaining / 60);
	var s = remaining % 60;
	m = m < 10 ? '0' + m : m;
	s = s < 10 ? '0' + s : s;
	document.getElementById('timer').innerHTML = m + ':' + s;
	remaining -= 1;
	if(remaining >= 0 && timerOn) {
		setTimeout(function() {
			timer(remaining);
		}, 1000);
		return;
	}
	if(!timerOn) {
		return;
	}	
	$("#send_otp").show();
	$("#timer_hide").hide();
}