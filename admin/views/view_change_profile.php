<script type="text/javascript">
$(document).ready(function(){		
	var validator = $("#frm_change_profile").validate({
		rules: {
			full_name: "required",
			username: {
				required: true,
				remote:{
					type:"post",
					url:"../scripts/ajax/check_exist.php?field_name=username&table_name=admin_user&id=<?php echo $_SESSION['admin_user_id']; ?>"
				}
			},
			email:{
				required: true,
				email: true,					
				remote:{
					type:"post",
					url:"../scripts/ajax/check_exist.php?field_name=email&table_name=admin_user&id=<?php echo $_SESSION['admin_user_id']; ?>"
				},
			},
			mobile: {
				mobileNumber: true,
				remote:{
					type:"post",
					url:"../scripts/ajax/check_exist.php?field_name=mobile&table_name=admin_user&id=<?php echo $_SESSION['admin_user_id']; ?>"
				},
			}
		},
		messages: {
			full_name: "Please Enter Full Name",
			username: {
				required: "Please Enter Username",
				remote: "Username already exist.",
			},
			email:{
				required: "Please Enter New Email Address",
				email: "Please Enter Valid Email Address",
				remote: "Email already exist",
			},
			mobile: {
				mobileNumber:"Please Enter Valid Mobile Number",
				remote: "Mobile Number Already Exist",
			}
		},
				
	});	
	$("input:submit").button();
});
</script>
<style type="text/css">
#frm_change_profile label.error {
	background: url("images/unchecked.gif") no-repeat 0px 0px;
	padding-left: 0;
	padding-bottom: 2px;
	font-weight: bold;
	color: #FF0000;
	display:block
}
#frm_change_profile label.checked {
	background: url("images/checked.gif") no-repeat 0px 0px;
	float: none;
}
</style>
<?php include("includes/header.php") ?>
<section class="content-header">
  <div class="container-fluid">
	<div class="row mb-2">
	  <div class="col-sm-12">
		<h1>Change Profile</h1>
	  </div>
	  
	</div>
  </div><!-- /.container-fluid -->
</section>
<div class="content">
	<div class="container-fluid">
	<div class="card card-primary card-outline">
        
        <div class="card-body">
          
		
			<?php $this->htmlBuilder->buildTag("form", array("autocomplete"=>"off","class"=>"frm_addedit"), "frm_change_profile") ?>
			<?php echo $this->utility->get_message()?>
			
			<div class="form-group row">
				<label class="col-sm-3">Username</label>
				<div class="col-sm-9">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "username");?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3">Full Name</label>
				<div class="col-sm-9">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "full_name");?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3">Email</label>
				<div class="col-sm-9">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "email") ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3">Phone Number</label>
				<div class="col-sm-9">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "mobile");?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3">Photo</label>
				<div class="col-sm-9">
				
				
				
				<div class="custom-file mb-3">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"file", "class"=>"custom-file-input"), "photo");?><label class="custom-file-label" for="photo"></label>
				</div>
                &emsp;
                <?php echo $this->photo;?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3"></label>
				<div class="col-sm-9">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"submit", "value"=>"Change Profile","class"=>"btn btn-primary"), "btn_submit") ?>
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"change_profile"), "act") ?>
					
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"button", "value"=>"Cancel","class"=>"btn btn-secondary","onclick"=>"window.location='index.php'"), "btn_cencel") ?>
				</div>
			</div>
			
			
			
			
           
          <?php $this->htmlBuilder->closeForm() ?>
      
	<div id="push" ></div>
        </div>
        <!-- /.card-body -->
        
        <!-- /.card-footer-->
      </div>

	</div>
  <div class="clear"></div>
  
  
</div>

  <?php include("includes/footer.php") ?>

<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>