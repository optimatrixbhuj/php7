<?php $this->addJS("js/jquery/pwstrength.js"); ?>
<script type="text/javascript">
	$(document).ready(function() {
		<?php if($this->to_do == "Add"){?>
			password_checker();
		<?php }else{?>
			$("#password").attr("readonly","readonly");
		<?php }?>
	// validate signup form on keyup and submit
	var validator = $("#frm_admin_user_addedit").validate({
		rules: {
			admin_user_group_id: {
				required:true,
				valueNotEquals: 0,
			},
			branch_id: {
				required:  function() {
					return $('#admin_user_group_id').val()>1;
				},
			},
			full_name: "required",
			username: {
				required: true,
				remote:{
					type:"post",
					url:"../scripts/ajax/check_exist.php?field_name=username&table_name=admin_user&id=<?php echo $this->id; ?>"
				}
			},
			password: "required",
			email: {
				email:true,
				remote:{
					type:"post",
					url:"../scripts/ajax/check_exist.php?field_name=email&table_name=admin_user&id=<?php echo $this->id; ?>"
				},
			},
			mobile: {
				required:true,
				mobileNumber:true,
				remote:{
					type:"post",
					url:"../scripts/ajax/check_exist.php?field_name=mobile&table_name=admin_user&id=<?php echo $this->id; ?>"
				},
			},
		},
		messages: {
			admin_user_group_id: {
				required:"Please Select User Group Name",
				valueNotEquals: "Please Select User Group Name",
			},
			full_name: "Please Enter Full Name",
			username: {
				required: "Please Enter Username",
				remote: "Username already exist.",
			},
			password: "Please Enter Password",
			email: {
				email:"Please Enter Valid Email",
				remote: "Email already exist",
			},
			mobile: {
				required:"Please Enter Mobile Number",
				mobileNumber:"Please Enter Valid Mobile Number",
				remote: "Mobile Number Already Exist",
			},
			branch_id: "Please Select Branch",
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo( element.parent());
			else if ( element.is(":checkbox") )
				error.appendTo( element.parent());
			else
				error.appendTo( element.parent() );
		},
		submitHandler: function (form) {
			$(form).find("#save,input[type=submit]").attr("disabled", true)
			$(form).find("#save_txt").text("Wait...");
			form.submit();
		},
	});
	$("input:button").button();
	$("input:submit").button();
	$("#admin_user_group_id").selectize({
		openOnFocus:false,
		onChange: function(value){
			if(value!=''){
				show_hide_branch();
			}
		}
	})[0].selectize.focus();
	<?php if($_SESSION['admin_user_group_id']=='1'){ ?>
		$("#branch_id").selectize({
			openOnFocus:true,
		})[0].selectize;
	<?php } ?>
	<?php if($this->id==1){ ?>
		$('#admin_user_group_id')[0].selectize.lock();
	<?php } ?>
	<?php if($this->to_do=='Edit'){ ?>
		show_hide_branch();
	<?php } ?>
});
	function change_password(){
		document.getElementById('password').removeAttribute('readonly');
		$('#password').val("");
		if($(".progress").length==0){
			password_checker();
		}
		document.getElementById('password').focus();
	}
	function password_checker(){
		"use strict";
		var options = {};
		options.ui = {
			bootstrap3: true,
			container: "#pwd-container",
			showVerdictsInsideProgressBar: true,
			viewports: {
				progress: ".pwstrength_viewport_progress"
			},
			progressBarExtraCssClasses: "progress-bar-striped active"
		};
		options.common = {
			debug: true,
			onLoad: function () {
				$('#messages').text('Start typing password');
			}
		};
		$('.password').pwstrength(options);
	}
	function show_hide_branch(){
		if($("#admin_user_group_id").val()>1){
			$(".branch_row").show();
			$(".branch_row").find("input,select").removeAttr("disabled");
			$(".branch_row").find("select").each(function(e){
				var is_selectize='no';
				if ($(this)[0].selectize) {
					$(this)[0].selectize.enable();
				}
			});
		}else{
			$(".branch_row").hide();
			$(".branch_row").find("input,select").attr("disabled","disabled");
		}
	}
</script>
<?php include("includes/header.php") ?>
<div class="content pt-3">
<div class="container-fluid">
	<?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit","autocomplete"=>"off"), "frm_admin_user_addedit");?>
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
			<div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=admin_user_list<?php echo ($this->type!=''?"&type=".$this->type:""); ?>'"><i class="fa fa-times-circle mr-1" title="Close"></i><span>Close</span></div>
			<div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>
              </div>
      </div>
    </div>
</div>
  <div class="card-body">
	<?php echo $this->utility->get_message()?>
	<div class="form-group row">
		<label class="col-md-2">User Group Name</label>
		<div class="col-md-3">
			<?php $this->htmlBuilder->buildTag("select", array("values"=>$this->user_group, "class"=>"form-control"), "admin_user_group_id");?>
		</div>
		<div class="col-md-1 mb-3"></div>
		<label class="col-md-2">Full Name</label>
		<div class="col-md-3">
			<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control","style"=>"text-transform:capitalize;"), "full_name");?>
		</div>
	</div>
	<?php if($_SESSION['admin_user_group_id']=='1'){ ?>
	<div class="form-group row">
		<label class="col-md-2">Branch</label>
		<div class="col-md-3"><?php $this->htmlBuilder->buildTag("select", array("values"=>$this->branch, "class"=>"form-control"), "branch_id");?></div>
		<div class="col-md-1 mb-3"></div>
	</div>
	<?php  }else{ $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$_SESSION['branch_id']), "branch_id");  }?>
	<div class="form-group row">
		<label class="col-md-2">Username</label>
		<div class="col-md-3">
			<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "username");?>
		</div>
		<div class="col-md-1 mb-3"></div>
		<label class="col-md-2">Password</label>
		<div class="col-md-3">
			<?php $this->htmlBuilder->buildTag("input", array("type"=>"password", "class"=>"form-control password ", "style"=>""), "password");?><?php if($this->to_do == "Edit"){?>&nbsp;<a class="btn btn-default mt-1" onclick="change_password();"><i class="fa fa-pencil-alt ml-1" title="Edit Record"></i></a><?php }?><div class="pwstrength_viewport_progress" style="padding-top:5px;"></div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-2">Email </label>
		<div class="col-md-3">
			<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "email");?>
		</div>
		<div class="col-md-1 mb-3"></div>
		<label class="col-md-2">Mobile Number</label>
		<div class="col-md-3">
			<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control allow_num"), "mobile");?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-2">Photo(450x450)</label>
		<div class="col-md-3">
			<div class="custom-file mb-3">
			<?php $this->htmlBuilder->buildTag("input", array("type"=>"file", "class"=>"custom-file-input"), "photo");?>
			<label class="custom-file-label" for="photo"></label>
			</div>
			<?php echo $this->photo ?>
		</div>
		<div class="col-md-1 mb-3"></div>
	</div>
	<div class="text-center">
		<input class="btn btn-primary" type="submit" id="save" name="save" value="SAVE" />
	</div>
	<div id="push" ></div>
	<?php $this->htmlBuilder->closeForm()?>
</div>
</div>
</div>
</div>
<?php include("includes/footer.php") ?>
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>