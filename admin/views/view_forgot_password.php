
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" type="text/javascript"></script>
	<script type="text/javascript">new WOW().init();</script>
<script type="text/javascript">
$(document).ready(function(){
	var validator = $("#frm_forgot_password").validate({
		rules: {
			get_pwd_by: "required",
			email: {
				required: {
					depends: function() {						
						return $('input[name=get_pwd_by]:checked').val() == 'by_email';
					} 
				},
				email: true,
			},
			mobile:{
				required: {
					depends: function() {
						return $('input[name=get_pwd_by]:checked').val() == 'by_mobile';
					} 
				},
				mobileNumber: true,
			},
		},
		messages: {			
			get_pwd_by: "Please Select Option",
			email: {
				required: "Please Enter Email",
				email: "Please Enter Valid Email"	
			},
			mobile: {
				required: "Please Enter Mobile Number",
				mobileNumber: "Please Enter Valid Mobile Number"	
			}
		},
		errorPlacement: function(error, element) {
			error.appendTo( element.parent());
		},
		
	});	
	set_fields_pwd();
	$("input[name='get_pwd_by']").click(function(e) {
       	set_fields_pwd();
    });
	$("input:submit").button();
});
function set_fields_pwd(){
	var get_pwd_by = $("#get_pwd_by:checked").val();
	if(get_pwd_by=="by_email"){
		$("#email").removeAttr("disabled");		
	}
	else{
		$("#email").attr("disabled","disabled");
	}
	if(get_pwd_by=="by_mobile"){
		$("#mobile").removeAttr("disabled");		
	}
	else{
		$("#mobile").attr("disabled","disabled");
	}
}
</script>
<style type="text/css">

.error {
border: 2px solid #ff0000 !important; font-size:inherit !important;
}
#frm_forgot_password label.error {
	border:none !important;
	color: #FF0000;
	font-size:16px; font-weight:400;
	display:block
}
body{height: 100%; margin: 0; padding: 0;font-weight: 400;  overflow-x: hidden;}
*{box-sizing: border-box;}
img{max-width: 100%}
.logo{text-align: center; max-width: 300px; margin: auto; }
.dflex{display: flex; height: 100vh; align-items: center; flex-direction: row; justify-content: space-between;}
.dLeft{padding: 2rem;   background: #fff; width:450px;    margin: auto;   }
.dRight{background-color: #ccc; height:100vh;background-image:
  linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0,0,0, 0.82)), url(images/slider-img1.jpg); background-size: cover; width:60%; float:right;display: flex;  align-items: center;  padding: 40px;}
.loginForm{padding: 20px 0;}
.loginForm .loginTitle{text-align: center; font-size: 1.5rem; color: #000; font-weight: 500; margin-bottom: 50px;}
.loginForm .field-group{margin-bottom: 15px;}
input[type="text"],input[type="password"]{height: 46px;border-radius: 0;border: 0; border-bottom: 1px solid rgba(235,237,242,.8); padding: 1rem ;color: #6c7293; width:100%; margin-bottom: 5px;	background-color:transparent !important;
}
input[type="text"]:disabled,input[type="email"]:disabled{
   opacity: .2 !important;
}
input:focus{outline:none;}
.error{color:#F00; font-size: 12px;}
.loginExtra{margin-top: :26px;    display: flex;
  -webkit-box-pack: justify;
  -ms-flex-pack: justify;
  justify-content: space-between; font-size: 14px; font-weight: 500 }
a{color:#6c7293; text-decoration: none; transition: all ease-in-out 0.5s;}
a:hover{color:#000;}
.loginAction{margin-top:35px; text-align: center;}
.form-group label{display:block}
h3{color:#fff; font-size: 42px; margin:0 0 15px; }
.companyDesc{color:#fff; display: block}
.wow{visibility: hidden;}

@media only screen and (max-width: 800px){
  .dflex{flex-direction: column;}
  .dRight{width:100%; text-align: center}
}
@media only screen and (max-width: 479px){
  .dLeft{width: 100% ;  padding: 30px 15px;}
  h3{font-size: 20px;}
  .dRight{padding: 40px 15px;}
}

</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"  />

<div class="dflex">
		<div class="dLeft">
			<div class="logo wow fadeInDown"><img src="images/logo.png" alt="Logo" /></div>
			<div class="loginForm wow fadeIn">
				<div class="loginTitle wow fadeInUp">Forgot Password</div>
				<?php $this->htmlBuilder->buildTag("form", array("autocomplete"=>"off"), "frm_forgot_password") ?>
     		<div class="form-group">
				<label for="exampleInputEmail1">Please enter your email address or mobile number to reset your password</label><br>
                </div>
                <div class="form-group">
                <?php $this->htmlBuilder->buildTag("input",array("type"=>"radio","value"=>"by_email"),"get_pwd_by"); ?>
                    &nbsp;Email Address&nbsp;&nbsp;
                    <?php $this->htmlBuilder->buildTag("input",array("type"=>"radio","value"=>"by_mobile"),"get_pwd_by"); ?>
                    &nbsp;Mobile Number
                </div>
                <div class="form-group">
				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox2 form-control","placeholder"=>"Email Address"), "email") ?>
				
			  </div>
              <div class="form-group">
				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox2 form-control allow_num","placeholder"=>"Mobile Number"), "mobile") ?>
				
			  </div>
	        <div class="form-group"><?php $this->htmlBuilder->buildTag("input", array("type"=>"submit", "value"=>"Reset Password", "class"=>"btn btn-primary login_btn btn-lg"), "btn_submit") ?>
                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"forgot_password"), "act") ?>
				</div>
				<div class="form-group">
				<div class="text-right mt-2"><a href="javascript:void(0);" onclick="history.back();">Back</a></div>
				</div>
                
          <?php $this->htmlBuilder->closeForm() ?>  
				
				
				

			</div>
		</div>
		<div class="dRight">
			<div>
				<h3 class="companyName wow fadeInUp">OptiMatrix</h3>
				<div class="companyDesc wow fadeInDown" data-wow-delay="0.2s">
					Software Development Company
				</div>
			</div>
		</div>
	</div>
	


<!--

<div class="login_page">
	<span></span>
	<div class="login_div">
		<div class="login_msg"><?php echo $this->utility->get_message()?></div>
		<div class="cmp_logo"><h2>FORGET PASSWORD</div>
     <div class="login_form">   
        <?php $this->htmlBuilder->buildTag("form", array("autocomplete"=>"off"), "frm_forgot_password") ?>
     		<div class="form-group">
				<label for="exampleInputEmail1">Please enter your email address or mobile number to reset your password</label><br>
                </div>
                <div class="form-group">
                <?php $this->htmlBuilder->buildTag("input",array("type"=>"radio","value"=>"by_email"),"get_pwd_by"); ?>
                    &nbsp;Email Address&nbsp;&nbsp;
                    <?php $this->htmlBuilder->buildTag("input",array("type"=>"radio","value"=>"by_mobile"),"get_pwd_by"); ?>
                    &nbsp;Mobile Number
                </div>
                <div class="form-group">
				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox2 form-control","placeholder"=>"Email Address"), "email") ?>
				
			  </div>
              <div class="form-group">
				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox2 form-control allow_num","placeholder"=>"Mobile Number"), "mobile") ?>
				
			  </div>
	        <div class="form-group"><?php $this->htmlBuilder->buildTag("input", array("type"=>"submit", "value"=>"Reset Password", "class"=>"btn-default"), "btn_submit") ?>
                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"forgot_password"), "act") ?>
				</div>
				<div class="form-group">
				<a class="forgot_pass2" href="javascript:void(0);" onclick="history.back();">Back</a>
				</div>
                
          <?php $this->htmlBuilder->closeForm() ?>          
      
    </div>
	</div>
</div> -->