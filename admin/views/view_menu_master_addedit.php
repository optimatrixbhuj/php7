<script type="text/javascript">
	$(document).ready(function() {
	// validate signup form on keyup and submit
	var validator = $("#frm_menu_master_addedit").validate({
		rules: {
			label: {
				required: true,
				remote:{
					type:"post",
					url:"../scripts/ajax/check_exist.php?field_name=label&table_name=menu_master&id=<?php echo $this->id; ?>"
				}
			},
			icon_class: {
				remote:{
					type:"post",
					url:"../scripts/ajax/check_exist.php?field_name=icon_class&table_name=menu_master&id=<?php echo $this->id; ?>"
				}
			},
			file_name: {
				remote:{
					type:"post",
					url:"../scripts/ajax/check_exist.php?field_name=file_name&table_name=menu_master&id=<?php echo $this->id; ?>"
				}
			},
		},
		messages: {
			label: {
				required: "please enter menu label",
				remote: "menu label already exist",
			},
			icon_class:{
				remote: "icon class already exist",
			},
			file_name:{
				remote: "link already exist",
			},
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
	set_order_arrow();
	$(document).on("change","[name^='show_menu']",function(e) {
		$(this).closest("td").find(".show_in_menu").val(($(this).is(':checked')?'Yes':'No'));
	});
	$("#menu_detail_table tbody").sortable({
		cursor: "move",
		placeholder: "ui-state-highlight",
		opacity: 0.7,
		update: function( event, ui ) {
			set_order_arrow();
		},
	});
});
	function set_order_arrow(){
		$(".arrow_up:first").hide();
		$(".arrow_down:last").hide();
		$(".arrow_up:not(:first)").show();
		$(".arrow_down:not(:last)").show();
		$('.sort_order').each(function(i) {
			this.value = i+1;
			$(this).closest("td").find(".sort_order_lbl").text($(this).val());
		});
	}
	function add_menu_detail_row(){
		var tr=$("#menu_detail_table tbody tr:last");
		if(tr.find(".menu_file_label_id").val()!=''){
			tr.find("select").each(function(i,el){
				if($(this)[0].selectize){
					var value = $(this).val(); // store the current value of the select/input
					$(this)[0].selectize.destroy(); // destroys selectize()
					$(this).val(value);  // set back the value of the select/input
				}
			});
			var new_tr = $("#menu_detail_table tbody tr:last").clone()
			.find("input:text,select,textarea").val("").end()
			.appendTo("#menu_detail_table");
			new_tr.find(".menu_file_label_id").focus();
			new_tr.find(".detail_id").val("");
			if(tr.find("[name^='show_menu']").is(':checked')){
				new_tr.find("[name^='show_menu']").trigger("click");
			}
			tr.find("select").selectize({
				openOnFocus:true,
			});
			new_tr.find("select").selectize({
				openOnFocus:true,
			});
			set_order_arrow();
		}else{
			$.alert({
				title: 'Alert!',
				icon:'glyphicon glyphicon-info-sign',
				content:"Please Select Page Label",
				theme: 'skin-blue',
				onDestroy: function(){ tr.find(".menu_file_label_id").focus(); }
			});
		}
	}
	function delete_menu_detail_row(el){
		var detail_id = $(el).closest("tr").find(".detail_id").val();
		var count = $("#menu_detail_table tbody").find("tr .menu_file_label_id").length;
		if(count>1){
			if(typeof detail_id != 'undefined' && detail_id>0){
				confirm_del({'detail_id':detail_id, 'act':'single_delete'});
			}else{
				$.confirm({
					title: 'Confirmation Dialog',
					icon:'glyphicon glyphicon glyphicon-exclamation-sign',
					content: 'Do you really want to delete?',
					theme: 'skin-blue',
					buttons: {
						confirm: function () {
							text: 'Proceed';
							$(el).closest("tr").remove();
							set_order_arrow();
						},
						cancel: function () {
							text: 'Cancel';
						},
					}
				});
			}
		}else{
		}
	}
	function change_sort_order(el){
		var row = $(el).parents("tr:first");
		if ($(el).hasClass("arrow_up")) {
			row.insertBefore(row.prev());
		} else {
			row.insertAfter(row.next());
		}
		set_order_arrow();
	}
</script>
<?php include("includes/header.php") ?>

<div class="content pt-3">
<div class="container-fluid">
	<!-- start of main body -->
	<?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_menu_master_addedit");?>
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
					<div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=menu_master_list<?php if($this->to_do=='Edit'){ echo "&pg_no=".$this->getGetVar("page_no"); } ?>'"><i class="fa fa-times-circle mr-1"></i><span>Close</span></div>
					<div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>         
              </div>
      </div>
    </div>
</div>



	
  <div class="card-body">
	<?php echo $this->utility->get_message()?>
	<div class="form-group row">
		<label class="col-sm-3">Label</label>
		<div class="col-sm-9">
			<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control","style"=>"text-transform: capitalize;"), "label");?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3">Icon</label>
		<div class="col-sm-9">
			<div class="form-inline">
			<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control col-sm-12 col-md-4 mb-2 mr-2","placeholder"=>"fa fa-home"), "icon_class");?> <i class="<?php echo $this->icon ?> fa-2x" aria-hidden="true"></i>
			<a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" class=" btn btn-secondary mb-2"><div style="font-size: 17px;">Search Icon </div></a>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3">Link</label>
		<div class="col-sm-9">
			<?php $this->htmlBuilder->buildTag("select", array("values"=>$this->files, "class"=>"form-control"), "file_name");?>
		</div>
	</div>
	<div class="form-group">
		<div class=" callout callout-warning rounded p-1 pl-3 pr-3">Pages In Menu</div>
	</div>
	<div class="table-responsive">
		<table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">
			<tr>
				<td>
				<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" id="menu_detail_table" class="table table-hover table-bordered admintable table-sm">
								<tbody>
									<?php if(count($this->menu_detail)>0){
										foreach($this->menu_detail as $detail){
											$checked=($detail['show_in_menu']=='Yes'?"checked":""); ?>
											<tr class="table_field_value">
												<td class="text-center" valign="top" width="7%">
													&emsp;<a href="javascript:" onClick="change_sort_order(this)" class="arrow_up"><i class="fa fa-arrow-circle-down fa-lg" title="Add More"></i></a>
													&nbsp;<a href="javascript:" onClick="change_sort_order(this)" class="arrow_down"><i class="fa fa-arrow-circle-up fa-lg" title="Add More"></i></a>
												</td>
												<td class="text-center" valign="middle" width="5%"><label class="sort_order_lbl"><?php echo $detail['sort_order']; ?></label><?php $this->htmlBuilder->buildTag("input",array("type"=>"hidden","class"=>"sort_order","value"=>$detail['sort_order']),"sort_order[]")?></td>
												<td class="text-left pl-2" valign="top" width="30%"><?php $this->htmlBuilder->buildTag("select", array("values"=>$this->sub_menu, "class"=>"form-control form-control-sm menu_file_label_id","selected"=>$detail['menu_file_label_id']), "menu_file_label_id[]");?></td>
												<td class="text-center" valign="middle" width="12%"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox",$checked=>$checked),"show_menu[]")?>
												<?php $this->htmlBuilder->buildTag("input",array("type"=>"hidden","class"=>"show_in_menu","value"=>$detail['show_in_menu']),"show_in_menu[]")?>&nbsp; Show in Menu ? </td>
												<td class="text-center" width="10%" valign="middle" align="center"><a href="javascript:" onClick="add_menu_detail_row();" class="btn btn-default btn-sm"><i class="fa fa-plus-circle" title="Add More"></i></a>&emsp; <a href="javascript:" onclick="javascript:delete_menu_detail_row(this);" class="btn btn-default btn-sm"><i class="fa fa-trash-alt fa-lg" title="Delete"></i></a></td>
											</tr>
										<?php  }
									} ?>
									<tr class="table_field_value">
										<td class="text-center" valign="top" width="7%">
											&emsp;<a href="javascript:" onClick="change_sort_order(this)" class="arrow_up"><i class="fa fa-arrow-circle-down fa-lg" title="Add More"></i></a>
											&nbsp;<a href="javascript:" onClick="change_sort_order(this)" class="arrow_down"><i class="fa fa-arrow-circle-up fa-lg" title="Add More"></i></a>
										</td>
										<td class="text-center" valign="middle" width="5%"><label class="sort_order_lbl"></label><?php $this->htmlBuilder->buildTag("input",array("type"=>"hidden","class"=>"sort_order"),"sort_order[]")?></td>
										<td class="text-left pl-2" valign="top" width="30%"><?php $this->htmlBuilder->buildTag("select", array("values"=>$this->sub_menu, "class"=>"form-control form-control-sm menu_file_label_id"), "menu_file_label_id[]");?></td>
										<td class="text-center" valign="middle" width="12%"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox"),"show_menu[]")?>
										<?php $this->htmlBuilder->buildTag("input",array("type"=>"hidden","class"=>"show_in_menu","value"=>"No"),"show_in_menu[]")?>&nbsp; Show in Menu ? </td>
										<td class="text-center" width="10%" valign="middle" align="center"><a href="javascript:" onClick="add_menu_detail_row();" class="btn btn-default btn-sm"><i class="fa fa-plus-circle fa-lg" title="Add More"></i></a>&emsp; <a href="javascript:" onclick="javascript:delete_menu_detail_row(this);" class="btn btn-default btn-sm"><i class="fa fa-trash-alt fa-lg" title="Delete"></i></a></td>
									</tr>
								</tbody>
							</table>
				</td>
			</tr>
		</table>
		<div class="text-center"><input type="submit" id="save" name="save" value="SAVE" class="btn-primary btn" /></div>
		<!-- end of main body -->
	</div>
	<div id="push" ></div>
</div>
</div>
<?php $this->htmlBuilder->closeForm()?>
</div>
</div>
<?php include("includes/footer.php") ?>
