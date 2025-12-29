<script type="text/javascript">
$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#frm_app_user_addedit").validate({
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
<div class="content pt-2">
  <div class="card mb-0">
  <div class="card-body mb-0">
	<div class="table-responsive">
    <!-- start of main body -->
    <?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_app_user_addedit");?>
    <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>
    <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"addedit_data"), "act");?>
    <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">
      <tr>
        <td><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="main_table edit_table">
            <tr class="table_header">
              <td width="5%" height="50" align="left" valign="middle"><i class="fa fa-bars fa-2x titleicon"></i></td>
              <td width="90%" height="50" align="left" valign="middle" ><h3>
                  <?php echo ucfirst($this->manager_for)?> Manager [<?php echo $this->to_do;?>]</h3></td>
              <td width="" align="center" valign="middle" ><div class="iconclass">
                  <button class="btn" style="background-color: white"><i class="fa fa-save fa-2x"></i></button>
                  <span id='save_txt'>Save</span></div></td>              
              <td width="" align="center" valign="middle"><div class="iconclass" onclick="window.location.href='index.php?view=app_user_list<?php if($this->to_do=='Edit'){ echo "&pg_no=".$this->getGetVar("page_no"); } ?>'"><i class="fa fa-times-circle fa-2x" title="Close"></i><span>Close</span></div></td>
              <td width="" align="center" valign="middle"><div class="iconclass" onclick="javascript:location.reload(true)"><i class="fa fa-sync fa-2x" title="Refresh"></i><span>Refresh</span></div></td>              
            </tr>
          </table>
          <?php echo $this->utility->get_message()?>
          <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="data_table">
            <tr class="table_field_value">
              <td width="8%" height="35" align="left" valign="middle" style="padding-left:10px;">Name</td>
              <td width="25%" height="35" align="left" valign="middle" style="padding-left:10px;"><?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox","style"=>"text-transform: capitalize;"), "name");?></td>
              <td width="8%" height="35" align="left" valign="middle" style="padding-left:10px;">Name</td>
              <td width="25%" height="35" align="left" valign="middle" style="padding-left:10px;"><?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox","style"=>"text-transform: capitalize;"), "name");?></td>
              <td width="8%" height="35" align="left" valign="middle" style="padding-left:10px;">Name</td>
              <td width="24%" height="35" align="left" valign="middle" style="padding-left:10px;"><?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox","style"=>"text-transform: capitalize;"), "name");?></td>
            </tr>
			<tr class="table_field_value">
              <td width="100%" colspan="6" align="center"><input type="submit" id="save" name="save" value="SAVE" /></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <?php $this->htmlBuilder->closeForm()?>
    <!-- end of main body --> 
  </div>
  <div id="push" ></div>
</div>
</div>
</div>
<?php include("includes/footer.php") ?>