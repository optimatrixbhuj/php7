<?php $this->addJS("js/jquery/pwstrength.js"); ?>
<script type="text/javascript">
	$(document).ready(function(){
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
		var validator = $("#frm_change_password").validate({
			rules: {
				password:{
					required: true,
				},
				new_password:{
					required: true,
				},
				retyped_password:{
					 equalTo: "#new_password",
				}
			},
			messages: {
				password:{
					required: "Please Enter Current Password",
				},
				new_password:{
					required: "Please Enter New Password",
				},
				retyped_password:{
					equalTo: "Please Enter Same As New Password",
				}
			},			
		});	
		$("input:button").button();
		$("input:submit").button();
	});
</script>
<style type="text/css">
#frm_change_password label.error {
	background: url("images/unchecked.gif") no-repeat 0px 0px;
	padding-left: 0;
	padding-bottom: 2px;
	font-weight: bold;
	color: #FF0000;
	display:block;
}
#frm_change_password label.checked {
	background: url("images/checked.gif") no-repeat 0px 0px;
	float: none;
}
</style>
<?php include("includes/header.php") ?>
<section class="content-header">
  <div class="container-fluid">
	<div class="row mb-2">
	  <div class="col-sm-12">
		<h1>Change Password</h1>
	  </div>
	  
	</div>
  </div><!-- /.container-fluid -->
</section>
<div class="content">
	<div class="container-fluid">
  <div class="card card-primary card-outline">
  
	<?php if(isset($_SESSION['change_pwd_msg'])){ ?>
		<div class="card-header pt-4 pb-4 text-center">
		<div class="blinking" align="center" style="font-size:18px;font-weight:bold;font-family: Verdana, Geneva, sans-serif;color: #cc3300;"><?php echo $_SESSION['change_pwd_msg']; ?></div>
		</div>
	<?php } ?>
  
  <div class="card-body"> 
    <!-- start of main body -->
    
          <?php $this->htmlBuilder->buildTag("form", array("autocomplete"=>"off","class"=>"frm_addedit"), "frm_change_password") ?>
          <?php echo $this->utility->get_message()?>
          
			<div class="form-group row">
				<label class="col-sm-3">Current Password</label>
				<div class="col-sm-9">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"password", "class"=>"form-control"), "password") ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3">New Password</label>
				<div class="col-sm-9">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"password", "class"=>"form-control password"), "new_password") ?>
					<div class="pwstrength_viewport_progress" style="padding-top:5px;"></div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3">Confirm Password</label>
				<div class="col-sm-9">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"password", "class"=>"form-control"), "retyped_password") ?>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-sm-3"></label>
				<div class="col-sm-9">
					<?php $this->htmlBuilder->buildTag("input", array("type"=>"submit", "value"=>"Change Password","class"=>"btn btn-primary"), "btn_submit") ?>
                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"change_password"), "act") ?>
                <?php $this->htmlBuilder->buildTag("input", array("type"=>"button", "value"=>"Cancel","class"=>"btn btn-secondary","onclick"=>"window.location='index.php'"), "btn_cencel") ?>
				</div>
			</div>
		  
		  
          <?php $this->htmlBuilder->closeForm() ?>
     
    <!-- end of main body --> 
  </div>
  <div id="push" ></div>
  </div>
  </div>
</div>

<?php include("includes/footer.php") ?>

<script type="text/javascript">
document.getElementById("password").focus();
</script>