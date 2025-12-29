<?php if($this->me=="logout"){?>

	<script>window.localStorage.setItem('logged_in', false);

	location.href = "index.php";

</script>

<?php }else{ ?>

	<script>window.localStorage.setItem('logged_in', true);

	//location.href = "index.php";

</script>

<?php } ?>

<script type="text/javascript">

	$(document).ready(function(){

		var validator = $("#frm_login").validate({

			rules: {

				username: "required",

				password: "required"

			},

			messages: {

				username: "",

				password: ""

			},

			success: function(label) {

				//label.html("&nbsp;").addClass("checked");

			}

		});	

		$("input:submit").button();

	});

</script>

<style type="text/css">

.error {

border: 2px solid #ff0000 !important;

}
#frm_login label.error {

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





input:focus{outline:none;}

.error{color:#F00; font-size: 12px;}

.loginExtra{margin-top: :26px;    display: flex;

  -webkit-box-pack: justify;

  -ms-flex-pack: justify;

  justify-content: space-between; font-size: 14px; font-weight: 500 }

a{color:#6c7293; text-decoration: none; transition: all ease-in-out 0.5s;}

a:hover{color:#000;}

.loginAction{margin-top:35px; text-align: center;}

.btn-default{ font-family: 'Poppins', sans-serif;  background-color: #FF2222; border:1px solid #FF2222; color: #fff;height: 46px;padding-left: 25px;    padding-right:25px; font-weight: 500; border-radius: 30px; cursor: pointer; transition: all ease-in-out 0.5s;}

.btn-default:hover{background-color: #000; border-color: #000; color:#fff}

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
			<?php echo $this->utility->get_message(); ?>
			<div class="logo wow fadeInDown"><img src="images/logo.png" alt="Logo" /></div>

			<div class="loginForm wow fadeIn">

				

				<?php $this->htmlBuilder->buildTag("form", array("autocomplete"=>"off","class"=>"frm_login"), "frm_login") ?>

			  <div class="form-group">

				<label for="exampleInputEmail1">Username</label>

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox2 form-control", "placeholder"=>"Username"), "username") ?>

				

			  </div>

			  <div class="form-group">

				<label for="exampleInputPassword1">Password</label>

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"password", "class"=>"textbox2 form-control", "placeholder"=>"Password"), "password") ?>

			  </div>

			  <div class="form-group">

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"do_login"), "act") ?>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"submit", "value"=>"Login", "class"=>"btn btn-primary login_btn btn-lg"), "btn_submit") ?>

				<div class="text-right mt-2"><a class="forgotlink" href="index.php?view=forgot_password">Forgot Password</a></div>

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

<!-- 	<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
 -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js" type="text/javascript"></script>

	<script type="text/javascript">new WOW().init();</script>