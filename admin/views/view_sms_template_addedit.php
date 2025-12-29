<?php $this->addJS("js/jquery/jquery-smshelper.min.js"); ?>

<script type="text/javascript">

$(document).ready(function() {

	$("#subject").focus();

	var validator = $("#frm_sms_template_addedit").validate({

		rules: {

			subject:{

				required: true,

				remote:{

						type:"post",

						url:"../scripts/ajax/check_exist.php?field_name=subject&table_name=sms_template&id=<?php echo $this->id; ?>"

					}

			},

			message: "required",

		},

		messages: {

			subject:{

				required: "Please Enter Subject",

				remote: "Subject Already Exist.",

			},

			message: "Please Enter Message",

		},

		// the errorPlacement has to take the table layout into account

		errorPlacement: function(error, element) {

			if ( element.is(":radio") )

				error.appendTo( element.parent().next());

			else if ( element.is(":checkbox") )

				error.appendTo( element.parent().next());

			else

				error.appendTo( element.parent().next() );

		},

		submitHandler: function (form) {

			$(form).find("#save,input[type=submit]").attr("disabled", true)

		   	$(form).find("#save_txt").text("Wait...");

		   	form.submit();

		},

		

	});	

	$("input:button").button();

	$("input:submit").button();

	$('.message').smsHelper({lastBracket: ' SMS Credit)'});

	<?php if($this->to_do=='Edit'){ ?>

		$("#subject").attr("readonly","readonly");

	<?php } ?>

});

</script>

<?php include("includes/header.php") ?>



<div class="content pt-3">

<div class="container-fluid">

	<?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_sms_template_addedit");?>

  <div class="card card-primary card-outline">


<div class="card-header">
			<div class="row mb-2">
				<div class="col-md-6">
            		<h1><?php echo ucfirst($this->manager_for)?> Manager [

                  <?php echo $this->to_do?>

                  ]</h1>
            	</div>
            	<div class="col-md-6">
            		<div class="actionBtns text-right">

				<button class="btn btn-o btn-sm btn-primary"><i class="fa fa-save mr-1"></i> <span id='save_txt'>Save</span></button>                  

				<div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=sms_template_list'"><i class="fa fa-times-circle mr-1" title="Close"></i><span>Close</span></div>

				<div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>

			</div>
            	</div>
			</div>
		</div>





  

	<div class="card-body mb-0">

		<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>

		<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"addedit_data"), "act");?>

		<div class="mb-2"> <font color="#FF0000"><b>Note : </b> Please Do Not Change or Delete Text Given in Curly {} Bracket.</font> <?php echo $this->utility->get_message()?></div>

		<hr>

		<div class="form-group row">

			<label class="col-sm-3">Subject</label>

			<div class="col-sm-9">

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control","style"=>"text-transform: uppercase;"), "subject");?>

			</div>

		</div>

		

		<div class="form-group row">

			<label class="col-sm-3">Message</label>

			<div class="col-sm-9">

				<?php $this->htmlBuilder->buildTag("textarea", array("cols"=>"90","rows"=>"10","class"=>"form-control"), "message");?>

			</div>

		</div>

		

		<div class="form-group row">

			<label class="col-sm-3"></label>

			<div class="col-sm-9">

				<input type="submit" class="btn btn-primary" id="save" name="save" value="SAVE" />

			</div>

		</div>

			

		

	

    <!-- start of main body -->

    

    

    

    <!-- end of main body --> 

 

  <div id="push" ></div>

</div>

</div>

<?php $this->htmlBuilder->closeForm()?>

</div>

</div>

<?php include("includes/footer.php") ?>



