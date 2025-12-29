<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<?php
	$this->addJS("../resources/fancybox/jquery.fancybox-1.3.1.js");
	$this->addCSS("../resources/fancybox/jquery.fancybox-1.3.1.css");
?>
<div class="wrapper">
  <!-- Main Header -->
	<!-- Header Navbar -->
    <nav class="main-header navbar navbar-expand  navbar-light navbar-white" role="navigation">
		<!-- Sidebar toggle button-->
		<ul class="navbar-nav"><li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li></ul>
		<!-- Navbar Right Menu -->
		<ul class="navbar-nav ml-auto">
			<!-- User Account Menu -->
			<li class="user user-menu  nav-item dropdown">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle btn-admin nav-link" style="border-left:0px !important;" data-toggle="dropdown"  id="navbarDropdown">
              <!-- The user image in the navbar-->
              <img src="<?php echo !empty($_SESSION['user_photo'])?$_SESSION['user_photo']:"images/user2-160x160.jpg";?>" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="d-xs-none hide-360"><?php echo !empty($_SESSION['admin_user_id'])?"".$_SESSION['user_name']:"Guest User";?></span>
            </a>
			<ul class="dropdown-menu" >
              <!-- The user image in the menu -->
              <li class="user-header bg-primary">
                <img src="<?php echo !empty($_SESSION['user_photo'])?$_SESSION['user_photo']:"images/user2-160x160.jpg";?>" class="img-circle" alt="User Image">
                <p>
                 <?php echo !empty($_SESSION['admin_user_id'])?"Welcome ".$_SESSION['user_name']:"Welcome Guest";?>
                 <small>Last Login : <?php echo $this->utility->get_string_time($_SESSION['last_login_time']); ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col text-center">
					<a href="index.php?view=change_profile" class="btn btn-default btn-sm">Profile</a>
					<a href="index.php?view=change_password" class="btn btn-default btn-sm"> Password</a>
					<a href="index.php?act=do_logout" class="btn btn-default btn-sm" >Logout</a>
				  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
            </ul>
		</li>
		<li class="user user-menu col-xs-12"><a href="javascript:search_sp_vehicle()" class="btn btn-o btn-sm btn-primary mt-1">F9 [ Search ]</a></li>
            <li class="user user-menu col-xs-12"><a href="index.php?act=do_logout" class="btn btn-o btn-sm btn-danger ml-1 mt-1">Logout</a></li>
		</ul>
	</nav>
<!---------------------------------------------------------------------------------------------------------------------->
<?php if(!empty($_SESSION['admin_user_id']) && !empty($_SESSION['admin_user_id']) && !empty($_SESSION['admin_user_id'])){ ?>
	<?php include("includes/left_sidebar.php") ?>
<?php } ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">