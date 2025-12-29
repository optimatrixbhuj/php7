<script type="text/javascript">

  $(document).ready(function() {

	// validate signup form on keyup and submit

	var validator = $("#frm_menu_access_control").validate({

		rules: {

			group_id:"required",

			branch_master_id:"required",

			'page_name[]': "required",

		},

		messages: {

			group_id: "Please Select User Group",

			branch_master_id: "Please Select Branch",

			'page_name[]': "Please Select Pages",

		},

		// the errorPlacement has to take the table layout into account

		errorPlacement: function(error, element) {

			if ( element.is(":radio") )

				error.appendTo( element.parent().next());

			else if ( element.is(":checkbox") )

				error.appendTo( element.parents("div").parent("td"));

			else

				error.appendTo( element.parent());

		},

		submitHandler: function (form) {

			$(form).find("#save,input[type=submit]").attr("disabled", true)

      $(form).find("#save_txt").text("Wait...");

      form.submit();

    },

    

  });

	$("input:button").button();

	$("input:submit").button();		

	$("[name^=modlue_id]").change(function(e) {        

    var id=$(this).val();

    $('.page_'+id).prop('checked',$(this).prop('checked')).change()

		//$('.page_'+id).trigger("click");

  });

	$("[name^=page_name]").change(function(e) {        

    var id=$(this).closest("div.box").find("[name^=modlue_id]").val();

    if($('.page_'+id+':checked').length>0){

     $(this).closest("div.box").find("[name^=modlue_id]").prop('checked',true);

   }else{

     $(this).closest("div.box").find("[name^=modlue_id]").prop('checked',false);

   }

 });

});

</script>

<style>

  .box{

   margin-bottom:10px;	

   width: 80%;

   float: left;

   margin-right:10px;

 }

 .box-header{

  padding: 5px 10px;

  

}

.box-title{

	font-size:14px !important;

}

.box-header > .box-tools{

	top:0px;	

}

.box-body{

	padding-left:30px;

}

</style>

<?php include("includes/header.php") ?>



<div class="content pt-3">

<div class="container-fluid">

	<?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_menu_access_control");?>

    <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>

    <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"addedit_data"), "act");?>

  <div class="card card-primary card-outline">

<div class="card-header">
      <div class="row mb-2">
        <div class="col-md-6">
                <h1> <?php echo ucfirst($this->manager_for)?> Manager [

              <?php echo $this->to_do?>

            ]</h1>
              </div>
              <div class="col-md-6">
                <div class="actionBtns text-right">         
           <button class="btn btn-o btn-sm btn-primary"><i class="fa fa-save mr-1"></i><span id='save_txt'>Save</span></button>			

						

			<div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>	    
              </div>
      </div>
    </div>
</div>




 

  

  <div class="card-header">

      <h3 class="card-title">

          <div class="form-inline mobile-block">

           

            

              

               <div class="mr-2 d-inline">User Group</div>

               

			   

             <?php $this->htmlBuilder->buildTag("select", array("values"=>$this->user_group, "class"=>"min180 form-control mb-1 mr-sm-2","onchange"=>"re_group();","selected"=>$this->group_num), "group_id");?>

			 

              <div class="form-check ml-sm-2 pt-xs-2" style="">

                <?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"form-check-input checkAllAccess"), "select_all")?>

				<label class="form-check-label" for="select_all">Select All Pages</label>

              </div>

          

                

                

      

          </div>

      </h3>     

      

    </div>

  <div class="card-body">
<!-- <div class="row">
				<div class="col-md-6 mb-1">Left</div>
				<div class="col-md-6 mb-1">Right</div>
			</div> -->
   <?php echo $this->utility->get_message()?>

	
<div class="row">
	<?php 
	$count = count($this->access_menu);
	$mid = round($count/2);
	$i=1;	

	foreach($this->access_menu as $access_menu){ ?>
		<div class="col-md-6 mb-1">
		<?php if($i>$mid){ $i++ ?>
		</div>
			<div class="col-md-6 mb-1">
		<?php } ?>
	<div class="card">

		<div class="card-header bg-gray color-palette ">

			<h3 class="card-title mobile-float-left"><input type="checkbox" name="modlue_id[]" class="page_select"  id="modlue_id<?php echo $access_menu['id'];?>" value="<?php echo $access_menu['id'];?>" <?php if(in_array($access_menu['id'],$this->menu_check)){ echo "checked='checked'"; } ?>/> &nbsp; <label class="mb-0" for="modlue_id<?php echo $access_menu['id'];?>"><?php echo $access_menu['label']; ?></label></h3>

			<div class="card-tools">

			  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>

			  </button>

			</div>

			<!-- /.card-tools -->

		</div>

		<!-- /.card-header -->

		<div class="card-body" style="display: block;">

			

			<?php if(count($access_menu['children'])>0){ ?>                

                   <?php foreach($access_menu['children'] as $file){ ?>

                     <input type="checkbox" name="page_name[]" class="page_select page_<?php echo $access_menu['id'];?>"  id="pagename<?php echo $file['menu_file_label_id'];?>" value="<?php echo $file['menu_file_label_id'];?>" <?php if(in_array($file['menu_file_label_id'],$this->page_check)){ echo "checked='checked'"; } ?>/> &nbsp;

                     <label class="font-normal" for="pagename<?php echo $file['menu_file_label_id'];?>"><?php echo $file['menu_file_label_file_label']; ?></label><br>

                   <?php } ?>

                 <?php } ?>

		</div>

	  <!-- /.card-body -->

	</div>
</div>
	<?php } ?>

	</div>

	



    

         

        

        <div id="push" ></div>

      </div>

      </div>

	   <?php $this->htmlBuilder->closeForm()?>

      </div>

      </div>

        <?php include("includes/footer.php") ?>

     

      <script>

        function re_group(){

	//window.location="index.php?view=menu_access_control&group_id="+vals

	var branch_id=$("select#branch_master_id").val();

	var group_id=$("#group_id").val();	

	if(typeof(branch_id)!=='undefined'){

		if(branch_id>0 && group_id>0){

			window.location="index.php?view=menu_access_control&group_id="+group_id+"&branch_id="+branch_id;

		}

	}else{

		if(group_id>0){

			window.location="index.php?view=menu_access_control&group_id="+group_id;

		}

	}

}

function fill_usergroup_from_branch(to_branch_id){

  $.ajax({

    type: "POST",

    dataType: "text",

    url: "scripts/ajax/index.php",

    data: "method=fill_usergroup_from_branch&to_branch_id="+to_branch_id,

    success: function(data){

     $('#group_id').html(data);

     $("#group_id").val('<?php echo $this->group_num; ?>');

   }

 }); 

}



</script>