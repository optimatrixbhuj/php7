<script type="text/javascript">
$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#frm_test_create").validate({
		rules: {
			filename: "required",
		},
		messages: {
			filename: "Please Enter Filename",
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			if ( element.is(":radio") )
				error.appendTo( element.parent().next());
			else if ( element.is(":checkbox") )
				error.appendTo( element.parent().next());
			else
				error.appendTo( element.parent() );
		},
		// set this class to error-labels to indicate valid fields
		/*success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("checked");
		}*/
	});
	$("input:button").button();
		$("input:submit").button();
});
</script>
<?php include("includes/header.php") ?>
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-12">
			<h1><?php echo ucfirst($this->manager_for);?> Manager [
                  <?php echo $this->to_do;?>
                  ]</h1>
			</div>
			
		</div>
	</div><!-- /.container-fluid -->
</section>
<div class="content">
	<div class="container-fluid">
	 <?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_test_create");?>
    <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"create_data"), "act");?>
  <div class="card card-primary card-outline">
		<div class="card-header text-right">
			<div class="actionBtns">					
				
                  <button class="btn btn-o btn-sm btn-success"><i class="fa fa-save mr-1"></i><span id='save_txt'>Create</span></button>	
				  <?php
                  $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"create_data"), "act");
                  ?>
				<div class="btn btn-o btn-sm btn-danger" onclick="window.location.href='index.php?view=home'"><i class="fa fa-times-circle mr-1" title="Close"></i><span>Close</span></div>
							
				
			
			<div class="btn btn-o btn-sm btn-secondary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>
			</div>
		</div>
  <div class="card-body">
  <?php echo $this->utility->get_message();?>
	<div class="form-group row">
			<label class="col-sm-3">File Name</label>
			<div class="col-sm-9">
				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "filename");?>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3">Table Name</label>
			<div class="col-sm-9">
				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control"), "tablename");?> 
				<p class="text-danger">Note: Enter table name if only one table is used.</p>
			</div>
		</div>
	
	
  <div id="push" ></div>
</div>
</div>
<?php echo $this->htmlBuilder->closeForm();?>
</div>
</div>
<?php include("includes/footer.php") ?>