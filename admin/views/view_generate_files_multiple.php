<script type="text/javascript">
$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#frm_test_create").validate({
		rules: {
			filename: "required",
			'name[]': "required",
			'type[]': "required",
		},
		messages: {
			filename: "Please Enter Filename",
			'name[]': "Please Enter Name",
			'type[]': "Please Enter Type",
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
function add_row(){	
	var counter=$("#detail_tbl tbody").find("tr .name").length;
	var tr=$("#detail_tbl tbody tr:last");
	if(tr.find(".name").val()=='' || tr.find(".type").val()==''){
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"Please Make Sure You Have Entered Name & Type Both",
			theme: 'skin-blue',
			onDestroy: function(){ 
				tr.find(".name").focus();
			}
		});
	}else{		
		var new_tr = $("#detail_tbl tbody tr:last").clone()
						  .find("input:text").val("").end()
						  .find("select").prop('selectedIndex', 0).end()
						  .appendTo("#detail_tbl");	
	}
}

function remove_row(el){	
	var count = $("#detail_tbl tbody").find("tr .name").length;	
	if(count>1){		
		$.confirm({
			title: 'Confirmation Dialog',
			icon:'glyphicon glyphicon glyphicon-exclamation-sign',
			content: 'Do you really want to delete?',		
			theme: 'skin-blue',
			buttons: {
				confirm: function () {
					text: 'Proceed';											
					$(el).closest("tr").remove();						
				},
				cancel: function () {
					text: 'Cancel';
				},
			 }		
		});
				
	}else{
		$.alert({
			title: 'Alert!',
			icon:'glyphicon glyphicon-info-sign',
			content:"There must be atleast One Row. You can not delete it.",
			theme: 'skin-blue',
			confirm: function(){ }
		});
	}
}
</script>
<?php include("includes/header.php") ?>
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-12">
			<h1><?php echo ucfirst($this->manager_for);?> Manager [ <?php echo $this->to_do;?> ]</h1>
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
		<strong>Following Columns added by default:</strong>
		
		
	<div class="table-responsive"> 
    <!-- start of main body -->
    
	<table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="table table-hover table-bordered admintable table-sm content_table">
                  <tr>
                    <td width="40%" align="center" valign="middle"><strong>Name</strong></td>
                    <td width="20%" align="center" valign="middle"><strong>Type</strong></td>
                    <td width="20%" align="center" valign="middle"><strong>Length/Values</strong></td>
                  </tr>
                  <tr>
                    <td width="40%" align="center" valign="middle">id (Primary Key)</td>
                    <td width="20%" align="center" valign="middle">int</td>
                    <td width="20%" align="center" valign="middle">11</td>
                  </tr>
                  <tr>
                    <td width="40%" align="center" valign="middle">admin_user_id</td>
                    <td width="20%" align="center" valign="middle">int</td>
                    <td width="20%" align="center" valign="middle">11</td>
                  </tr>
                  <tr>
                    <td width="40%" align="center" valign="middle">status</td>
                    <td width="20%" align="center" valign="middle">enum</td>
                    <td width="20%" align="center" valign="middle">'Active','Inactive'</td>
                  </tr>
                  <tr>
                    <td width="40%" align="center" valign="middle">created</td>
                    <td width="20%" align="center" valign="middle">datetime</td>
                    <td width="20%" align="center" valign="middle"></td>
                  </tr>
                  <tr>
                    <td width="40%" align="center" valign="middle">updated</td>
                    <td width="20%" align="center" valign="middle">datetime</td>
                    <td width="20%" align="center" valign="middle"></td>
                  </tr>
                </table>
	
    <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">
      <tr>
        <td>
          
         
          <table width="98%" align="center" id="detail_tbl" border="0" cellspacing="1" cellpadding="1" class=" table table-hover table-bordered admintable table-sm">
            <thead>
			<tr height="30" class="" style="padding:5px;">
              <th class="text-center" width="10%" align="center" valign="top">Name</th>
              <th class="text-center" width="10%" align="center" valign="top">Type</th>
              <th class="text-center" width="15%" align="center" valign="top">Length/Values</th>
              <th class="text-center" width="8%" align="center" valign="top">Is Required?</th>
              <th class="text-center" width="8%" align="center" valign="top">Show in List?</th>
			  <th class="text-center" width="10%" align="center" valign="top">Order By Option?</th>
              <th class="text-center" width="8%" align="center" valign="top">Search Option?</th>
              <th class="text-center" width="5%" align="center" valign="top">Action</th>
            </tr>
			</thead>
            <tr height="25" class="table_field_value" style="padding:5px;">
              <td align="center" valign="top"><?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox name","style"=>"text-transform: lowercase;width:95%;"), "name[]");?></td>
              <td align="center" valign="top"><?php 
			  $type = array(""=>"-Select Type-","INT"=>"INT","VARCHAR"=>"VARCHAR","TEXT"=>"TEXT","DATE"=>"DATE","DATETIME"=>"DATETIME","ENUM"=>"ENUM","FLOAT"=>"FLOAT","DECIMAL"=>"DECIMAL","YEAR"=>"YEAR","TIME"=>"TIME");
			  $this->htmlBuilder->buildTag("select", array("class"=>"textbox type","values"=>$type,"style"=>"width:95%"), "type[]") ?></td>
              <td align="center" valign="top"><?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"textbox length","style"=>"width:95%"), "length[]") ?></td>
              <td align="center" valign="top"><?php 
			  $option = array("No"=>"No","Yes"=>"Yes");
			  $this->htmlBuilder->buildTag("select", array("class"=>"textbox type","values"=>$option,"style"=>"width:95%"), "required[]") ?></td>
              <td align="center" valign="top"><?php 			 
			  $this->htmlBuilder->buildTag("select", array("class"=>"textbox type","values"=>$option,"style"=>"width:95%"), "list[]") ?></td>              
              <td align="center" valign="top"><?php 
			  $this->htmlBuilder->buildTag("select", array("class"=>"textbox type","values"=>$option,"style"=>"width:95%"), "order_by[]") ?></td>
              <td align="center" valign="top"><?php 
			  $this->htmlBuilder->buildTag("select", array("class"=>"textbox type","values"=>$option,"style"=>"width:95%"), "search[]") ?></td>	
              <td align="center" valign="top"><a class="btn btn-default btn-sm" href="javascript:;" onclick="javascript:add_row(this);"><i class="fa fa-plus-circle" title="Add More"></i></a>&nbsp; <a class="btn btn-default btn-sm" href="javascript:;" onclick="javascript:remove_row(this);"><i class="fa fa-trash-alt" style="cursor:pointer;" title="Remove"></i></a></td>
            </tr>
          </table></td>
      </tr>
    </table>
     
    <!-- end of main body --> 
  </div>
  <div id="push" ></div>
</div>
</div>
<?php echo $this->htmlBuilder->closeForm();?>
</div>
</div>
<?php include("includes/footer.php") ?>
