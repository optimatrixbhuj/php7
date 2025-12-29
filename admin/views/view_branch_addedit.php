<script type="text/javascript">

	$(document).ready(function() {

	// validate signup form on keyup and submit

	var validator = $("#frm_branch_addedit").validate({

		rules: {

			name: {

				required: true,

				remote:{

					type:"post",

					url:"../scripts/ajax/check_exist.php?field_name=name&table_name=branch&id=<?php echo $this->id; ?>"

				}

			},

			contact_number: {

				mobileNumber: true,

			},

			email: {

				email: 	true,

			},

		},

		messages: {

			name: {

				required: "Please Enter Branch / Company Name",

				remote: "Branch / Company Name already exist.",

			},

			contact_number:{

				mobileNumber:"Please Enter Valid Contact Number",

			}, 

			email: {

				email: 	"please enter valid email",

			},

		},		

		submitHandler: function (form) {

			var isInIframe = self != top;

			if(isInIframe) {

				$('<input>').attr({

					type: 'hidden',

					id: 'is_child_page',

					name: 'is_child_page',

					value:"yes",

				}).appendTo('form');

			}

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

		<?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_branch_addedit");?>

		<div class="card card-primary card-outline">

		<div class="card-header">
			<div class="row mb-2">
				<div class="col-md-6">
            		<h1><?php echo ucfirst($this->manager_for);?> Manager [<?php echo $this->to_do;?>]</h1>
            	</div>
            	<div class="col-md-6">
            		<div class="actionBtns text-right">					
						<button class="btn btn-o btn-sm btn-primary"><i class="fa fa-save mr-1"></i><span id='save_txt'>Save</span></button>				
						<div class="btn btn-o btn-sm btn-primary" onclick="var isInIframe = self != top; if(isInIframe) {parent.jQuery.fancybox.close();}else{window.location.href='index.php?view=branch_list<?php if($this->to_do=='Edit'){ echo "&pg_no=".$this->getGetVar("page_no"); } ?>'}"><i class="fa fa-times-circle mr-1"></i><span>Close</span></div>
						<div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>
					</div>
            	</div>
			</div>
		</div>

  			<div class="card-body">

	 

		<!-- start of main body -->

		

		<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>

		<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"addedit_data"), "act");?>





		<div class="card-body p-0">

			<?php echo $this->utility->get_message()?>



			<div class="form-group row">

				<label class="col-sm-3">Branch / Company Name</label>

				<div class="col-sm-9">

					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "name");?>

				</div>

			</div>



			<div class="form-group row">

				<label class="col-sm-3">Branch / Company Address</label>

				<div class="col-sm-9">

					<?php $this->htmlBuilder->buildTag("textarea", array("type"=>"textarea", "class"=>"form-control ","cols"=>"20","rows"=>"4"), "address");?>

				</div>

			</div>



			<div class="form-group row">

				<label class="col-sm-3">Contact Person Name</label>

				<div class="col-sm-9">

					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control "), "person_name");?>

				</div>

			</div>



			<div class="form-group row">

				<label class="col-sm-3">Contact Number</label>

				<div class="col-sm-9">

					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control allow_num"), "contact_number");?>

				</div>

			</div>



			<div class="form-group row">

				<label class="col-sm-3">Email Address</label>

				<div class="col-sm-9">

					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "email");?>

				</div>

			</div>



			<div class="form-group row">

				<label class="col-sm-3"></label>

				<div class="col-sm-9">

					<input type="submit" id="save" class="btn btn-primary" name="save" value="SAVE" />

				</div>

			</div>



			

				

				

		</div>







		

		<!-- end of main body --> 

	

	

</div>

</div>

<?php $this->htmlBuilder->closeForm()?>

</div>

<div id="push" ></div>

</div>

<?php include("includes/footer.php") ?>