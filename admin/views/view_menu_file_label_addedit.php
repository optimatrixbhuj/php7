<script type="text/javascript">

	$(document).ready(function() {

	// validate signup form on keyup and submit

	var validator = $("#frm_menu_file_label_addedit").validate({

		rules: {

			file_name: {

				required: true,

				remote: {

					type: "post",

					url: "../scripts/ajax/check_exist.php?field_name=file_name&table_name=menu_file_label&id=<?php echo $this->id; ?>",

					data: {           

						parameters: function() { return $( "#parameters" ).val(); },

					},

				},

			},

			parameter_name: "required",

			parameter_value: "required",

			file_label: "required",

		},

		messages: {

			file_name: {

				required: "Please select page Name",

				remote: "page label Already Exist for selected page and parameters",

			},

			parameters: "please enter parameters",

			file_label: "please enter page label",

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

	$("#parameters").on("change",function(){    

		$("#file_name").removeData("previousValue"); //clear cache when changing group

		$("#frm_menu_file_label_addedit").data('validator').element('#file_name'); //retrigger remote call

	});

	$("input:button").button();

	$("input:submit").button();

});

</script>

<?php include("includes/header.php") ?>

<div class="container-fluid side-collapse-container" id="content">

	<section class="content-header">

	<div class="container-fluid">

		<div class="row mb-2">

			<div class="col-sm-6 mb-10">

			<h1><?php echo ucfirst($this->manager_for)?> Manager [<?php echo $this->to_do;?>]</h1>

			</div>

			<div class="col-sm-6">

				<div class="actionBtns text-right sm-mt-2">					

				<button class="btn btn-o btn-sm btn-primary"><i class="fa fa-save mr-1"></i><span id='save_txt'>Save</span></button>

				<div class="btn btn-o btn-sm btn-primary" onclick="parent.$.fancybox.close();"><i class="fa fa-times-circle mr-1" title="Close" id="btn_close"></i><span>Close</span></div>

				<div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>

			</div>

			</div>

		</div>

	</div><!-- /.container-fluid -->

</section>



	

	

	<div class="content">

		<?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_menu_file_label_addedit");?>

		<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>

		<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"addedit_data"), "act");?>

		<div class="card card-primary card-outline">

			<div class="card-body">

				<?php echo $this->utility->get_message()?>

				<div class="form-group row">

					<label class="col-sm-3">Page Name</label>

					<div class="col-sm-9"><?php $this->htmlBuilder->buildTag("select", array("values"=>$this->files, "class"=>"form-control"), "file_name");?>

					</div>

				</div>

				<div class="form-group row">

					<label class="col-sm-3">Parameters</label>

					<div class="col-sm-9"><?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "parameters");?>

					</div>

				</div>

				<div class="form-group row">

					<label class="col-sm-3">Page Label</label>

					<div class="col-sm-9"><?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control","style"=>"text-transform: capitalize;"), "file_label");?>

					</div>

				</div>

				<div class="form-group row">

					<div class="col-sm-3"></div>

					<div class="col-sm-9"><input class="btn btn-primary" type="submit" id="save" name="save" value="SAVE" /></div>

				</div>

			</div>

		</div>

		<?php $this->htmlBuilder->closeForm()?>

		<!-- start of main body -->

		

		

				

				<!-- end of main body --> 

			</div>

			<div id="push" ></div>

		</div>

		<div id="footer">

			<?php include("includes/footer.php") ?>

		</div>