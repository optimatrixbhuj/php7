<style>

  .contact_div {

   border: 1px solid #808080;	

   height: 500px;

   overflow: auto;

   margin: 5px;	

 }

 @media screen and (max-width: 767px){

  .contact_div {

   min-height:100px;

   height:auto;	

 }

}

</style>

<?php $this->addJS("js/jquery/jquery-smshelper.min.js");

$this->addJS("js/jquery/jquery.quick.pagination.js");

$this->addCSS("js/jquery/jquery.quick.pagination.css"); ?>

<script type="text/javascript">

  $(document).ready(function() {	

	// validate signup form on keyup and submit

	var validator = $("#frm_sms_addedit").validate({		

		rules: {			

			//subject_id: {min : 1 },			

			message: "required",

			single_num: {

       mobileNumber: true,

     },

     branch_id: "required",

   },

   messages: {

			//subject_id: "Please Select Subject",			

			message: "Please Enter your message to send",

			single_num: {

				mobileNumber: "Please Enter Valid Mobile Number"

			},

      branch_id: "Please Select Branch / Company",

    },

		// the errorPlacement has to take the table layout into account

		errorPlacement: function(error, element) {

			if ( element.is(":radio") )

				error.appendTo( element.parent().next());

			else if ( element.is(":checkbox") )

				error.appendTo( element.closest('div').next());

			else

				error.appendTo( element.parent() );

		},		

	});

	$("input:button").button();

	$("input:submit").button();

 

	$('#message').smsHelper({lastBracket: ' SMS Credit)'});

  <?php if($_SESSION['admin_user_group_id']=='1'){ ?>

    $("#branch_id").selectize({ 

      openOnFocus:true,  

    })[0].selectize;

    $("#branch_id").change(function(e){            

      get_numbers();   

    });

  <?php } ?>

  

});

</script>

<?php include("includes/header.php") ?>







<div class="content pt-3">

	<div class="container-fluid">

  <div class="card card-primary card-outline">
  	<div class="card-header">
			<div class="row mb-2">
				<div class="col-md-12">
            		<h1>Send SMS Manager</h1>

            	</div>
            	
			</div>
		</div>
  <div class="card-body mb-0">

	<?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_sms_addedit");?>

    <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"send_message"), "act");?>

	<?php echo $this->utility->get_message()?>

	<div class="row">

		<div class="col-md-4 col-sm-6 border p-3 smsAddEditCol1">

			<div class="form-group">

				<?php if($_SESSION['admin_user_group_id']=='1'){ ?>                            

                <strong>Branch :</strong><br><?php $this->htmlBuilder->buildTag("select", array("class"=>"form-control","style"=>"width:200px !important;","values"=>$this->branch), "branch_id");?>

              <?php  }else{ $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$_SESSION['branch_id']), "branch_id");  }?>

			</div>

			<div class="form-group">

				<strong>Select SMS Group</strong>

              <?php if(count($this->sms_group)>0){

                for($i=0; $i<count($this->sms_group); $i++){

                 ?>

                 <div class="form-check"><input type="checkbox" name="group[]" id="group[]" onchange="get_numbers();" value="<?php echo $this->sms_group[$i]?>" class="form-check-input"><label class="form-check-label"><?php echo ucwords($this->sms_group[$i]); ?></label></div>

                <?php }

              }?>

			</div>

		</div>

		<div class="col-md-4 col-sm-6  border p-3 smsAddEditCol2">

			<div id="contact_tbl" style="float:left;text-align:left;width: 100%;"></div>

		</div>

		<div class="col-md-4 col-sm-12  border p-3 smsAddEditCol3">

			<div class="form-group row">

				<label class="col-sm-4">Single Number</label>

				<div class="col-sm-8">

					<?php $this->htmlBuilder->buildTag("input", array("class"=>"form-control allow_num","type"=>"text","placeholder"=>"Enter Number"), "single_num");?>					

				</div>

			</div>

			<div class="form-group row">

				<label class="col-sm-4">Subject</label>

				<div class="col-sm-8">

					<?php $this->htmlBuilder->buildTag("select", array("class"=>"form-control","values"=>$this->subject,"onchange"=>"get_sms_template(this.value);"), "subject_id");?>

					

				</div>

			</div>

			<div class="form-group row">

				<label class="col-sm-4">Select Language</label>

				<div class="col-sm-8">

					<?php $this->htmlBuilder->buildTag("input",array("type"=>"radio","value"=>"en","checked"=>"checked"),"language"); ?>

              &nbsp;English&nbsp;&nbsp;

              <?php $this->htmlBuilder->buildTag("input",array("type"=>"radio","value"=>"hn"),"language"); ?>

              &nbsp;Hindi&nbsp;&nbsp;

              <?php $this->htmlBuilder->buildTag("input",array("type"=>"radio","value"=>"gu"),"language"); ?>

            &nbsp;Gujarati 

				</div>

			</div>

			<div class="form-group row">

				<label class="col-sm-4">Message</label>

				<div class="col-sm-8">

					<textarea class="form-control" rows="12" id="message" name="message" ></textarea>

					

				</div>

			</div>

			<div class="form-group row">

				<div class="col-sm-4"></div>

				<div class="col-sm-8">

					<?php $this->htmlBuilder->buildTag("input", array("type"=>"submit", "value"=>"SEND SMS","style"=>"width:150px;","class"=>"btn btn-primary"), "submit");?>

				</div>

			</div>

		</div>

	</div>

	

	

    <?php $this->htmlBuilder->closeForm()?>

	</div>

    

  

	</div>

	

</div>

</div>

	

	<div id="push" ></div>







<?php include("includes/footer.php") ?>

<script type="text/javascript">

  $(document).on("click","input.check_all_contact",function(event){

   if($(this).prop('checked')){

    $('.all_contact:visible').prop('checked',$(this).prop('checked'));

  }else{

    $('.all_contact').prop('checked',$(this).prop('checked'));

  }

});

  $(document).on("click","input.all_contact",function(event){

   var member_checkbox=document.getElementsByName('contact[]');

   var member_len=member_checkbox.length;

   var count=0

   for(var i=0; i<member_len; i++){

     if(member_checkbox[i].checked==true){

      count++;

    }

  }

  if(count==member_len){

   $('.check_all_contact').prop('checked',true);

 }else{

   $('.check_all_contact').prop('checked',false);

 }

});

  $(document).on("click","input.check_all_contact,input.all_contact",function(event){

   var total_sel = $(".all_contact:checked:visible").length;

   $('.all_contact:checked:not(:visible)').attr('checked',false);

   $("#selected_count").html("Selected : <b>"+total_sel+"</b>");

 });

</script>