<script type="text/javascript">

$(document).ready(function() {

	// validate signup form on keyup and submit

	var validator = $("#frm_FILENAME_addedit").validate({

		rules: {

			name: "required",

		},

		messages: {

			name: "Please Enter Name",

		},		

		submitHandler: function (form) {

			$(form).find("#save,input[type=submit]").attr("disabled", true)

		   	$(form).find("#save_txt").text("Wait...");

		   	form.submit();

		},

		// the errorPlacement has to take the table layout into account

		errorPlacement: function(error, element) {

			if ( element.is(":radio") )

				error.appendTo( element.parent());

			else if ( element.is(":checkbox") )

				error.appendTo( element.parent());

			else

				error.appendTo( element.parent());

		},

		

	});

	$("input:button").button();

	$("input:submit").button();

});

</script>

<?php include("includes/header.php") ?>

<div class="content pt-3">

	<div class="container-fluid">

	<?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_FILENAME_addedit");?>

    <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>

    <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"addedit_data"), "act");?>	

	<div class="card card-primary card-outline">


<div class="card-header">
      <div class="row mb-2">
        <div class="col-md-6">
                <h1><?php echo ucfirst($this->manager_for)?> Manager [<?php echo $this->to_do;?>]</h1>
              </div>
              <div class="col-md-6">
                <div class="actionBtns text-right">         
           			<button class="btn btn-o btn-sm btn-primary"><i class="fa fa-save mr-1"></i><span id='save_txt'>Save</span></button>	

					<div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=FILENAME_list<?php if($this->to_do=='Edit'){ echo "&pg_no=".$this->getGetVar("page_no"); } ?>'"><i class="fa fa-times-circle mr-1" title="Close"></i><span>Close</span></div>

					<div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>         
              </div>
      </div>
    </div>
</div>

		<div class="card-body ">

		<?php echo $this->utility->get_message()?>

		<div class="form-group row">

			<label class="col-sm-3">Name</label>

			<div class="col-sm-9">

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox","style"=>"text-transform: capitalize;"), "name");?>

			</div>

		</div>

		<div class="form-group row">

			<label class="col-sm-3">Name</label>

			<div class="col-sm-9">

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox","style"=>"text-transform: capitalize;"), "name");?>

			</div>

		</div>

		<div class="form-group row">

			<label class="col-sm-3">Name</label>

			<div class="col-sm-9">

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox","style"=>"text-transform: capitalize;"), "name");?>

			</div>

		</div>

		<div class="form-group row">

			<label class="col-sm-3"></label>

			<div class="col-sm-9">

				<input type="submit" id="save" class="btn btn-primary" name="save" value="SAVE">

			</div>

		</div>



  <div id="push" ></div>

</div>

</div>

<?php echo $this->htmlBuilder->closeForm();?>

</div>

</div>

<?php include("includes/footer.php") ?>