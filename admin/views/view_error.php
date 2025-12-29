<?php include("includes/header.php") ?>
<style type="text/css">
</style>


<div class="content pt-2">
  <div class="card mb-0">
  <div class="card-body mb-0">
	<div class="table-responsive"> 
    <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">
      <tr>
        <td><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="main_table">
            <tr class="table_header">
              <td width="5%" height="50" align="left" valign="middle" style="color:#c2180e;"><i class="fa fa-exclamation-triangle fa-2x"></i></td>
              <td width="95%" height="50" align="left" valign="middle"><h3 style="color:#c2180e !important;">Oops! An Error Occurred</h3></td>
              <td width="10%" align="center" valign="middle"><div style="float:right; width:60px"> <img src="images/back_32.png" title="Back" alt="Back" style="cursor:pointer" border="0" onclick="history.back();"> <span class="icon_link">Back</span> </div></td>
            </tr>
          </table>
          <label>Page <a href="<?php echo $_SESSION['error_page']; ?>"><span style="color:#c2180e;"><?php echo $_SESSION['error_page']; ?></span> </a>Returned Error : </label>
          <div style="border-top:1px solid #c2180e;">
		  <?php 
		  if(isset($_SESSION['error_string'])){
		  echo $_SESSION['error_string'];
		 // unset($_SESSION['error_string']);
		  }
		   ?>
          </div>
        </td>
      </tr>
    </table>
  </div>
  <div id="push" ></div>
</div>
</div>
</div>
<?php include("includes/footer.php") ?>

