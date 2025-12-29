<style>

.page_link {

    position: relative;

    display: inline-block;

    cursor: pointer;

}

/* The actual popup (appears on top) */

.inserted_from {

   /* visibility: hidden;

    width: 160px;

    background-color: #555;

    color: #fff;

    text-align: center;

    border-radius: 6px;

    padding: 8px 0;

    position: absolute;

    z-index: 1;

    bottom: 125%;

    left: 50%;

    margin-left: -80px;*/

    visibility: hidden;

    position: absolute;

    width: 215px;

    background-color: #555;

    color: #fff;

    text-align: center;

    padding: 8px 5px;

    border-radius: 6px;

    z-index: 1;

    top: -15px;

    bottom: auto;

    right: 130%;

    word-break: break-all;

}

/* Popup arrow */

.inserted_from::after {

    /*content: "";

    position: absolute;

    top: 100%;

    left: 50%;

    margin-left: -5px;

    border-width: 5px;

    border-style: solid;

    border-color: #555 transparent transparent transparent;*/

    content: "";

    position: absolute;

    top: 20px;

    left: 100%;

    margin-top: -5px;

    border-width: 5px;

    border-style: solid;

    border-color: transparent transparent transparent #555;

}

/* Toggle this class when clicking on the popup container (hide and show the popup) */

.inserted_from.show {

    visibility: visible;

    -webkit-animation: fadeIn 1s;

    animation: fadeIn 1s

}



/* Add animation (fade in the popup) */

@-webkit-keyframes fadeIn {

    from {opacity: 0;} 

    to {opacity: 1;}

}



@keyframes fadeIn {

    from {opacity: 0;}

    to {opacity:1 ;}

}

</style>

<script type="text/javascript">

$(document).ready(function(e) {

   $(".page_link").click(function(e) {

	   $(".inserted_from").not($(this).closest("td").find(".inserted_from")).removeClass("show");

		var popup = $(this).closest("td").find(".inserted_from");

		popup.toggleClass("show");

	});

	$("#branch_id").change(function(e) {

    if($(this).val()!=""){

      if($(this).val()=="ALL"){

        get_dropdown('admin_user','id','full_name','user_id','Select User');    

      }else{

        get_dropdown('admin_user','id','full_name','user_id','Select User','branch_id='+$(this).val());     

      }      

    }else{

      get_dropdown('admin_user','id','full_name','user_id','Select User');    

    }

  });

});

</script>

<?php include("includes/header.php") ?>



<div class="content pt-3">

<div class="container-fluid">

  <div class="card card-primary card-outline">

<div class="card-header">
      <div class="row mb-2">
        <div class="col-md-6">
               <h1><?php echo ucfirst($this->manager_for)?>

                  Manager</h1>
              </div>
              <div class="col-md-6">
                <div class="actionBtns text-right">         
           <div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>        
              </div>
      </div>
    </div>
</div>


  

	<div class="card-header">

      <h3 class="card-title">

          <div class="form-inline mobile-block">

				<?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_search");?>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"search"), "act") ?>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"user_logs_list"), "view") ?>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "__search__") ?>

            

              

               <div class="small mr-1 d-inline">Search By</div>

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Table Name"), "table_name") ?>

				

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2 allow_num", "style"=>"","placeholder"=>"Table ID"), "table_id") ?>

				

				<?php 

					$action=array(""=>"-Action-","Insert"=>"Insert","Update"=>"Update","Delete"=>"Delete","Restore"=>"Restore");

					$this->htmlBuilder->buildTag("select", array("class"=>"form-control form-control-sm mb-1 mr-sm-2","values"=>$action ,"style"=>""), "action") ?>

					

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2 date", "style"=>"","placeholder"=>"Date"), "date") ?>

				

					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Description"), "description") ?>

					<?php if($_SESSION['admin_user_group_id']=='1'){ ?>

					<?php $this->htmlBuilder->buildTag("select", array("values"=>$this->branch, "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>""), "branch_id") ?>

					<?php } ?>

					<?php $this->htmlBuilder->buildTag("select", array("values"=>$this->users, "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>""), "user_id") ?>

			   

			  

				

				<?php $this->htmlBuilder->buildTag("input",array("type"=>"button", "class"=>"btn btn-primary mb-1 btn-sm","onclick"=>"search_records()", "value"=>"Search"),"btn_search")?>

                <?php $this->htmlBuilder->buildTag("input",array("type"=>"button", "class"=>"btn btn-secondary mb-1 btn-sm", "value"=>"Reset", "onclick"=>"window.location.href='index.php?view=user_logs_list&destroy=1'"), "btn_reset")?></td>

				<?php $this->htmlBuilder->closeForm()?>

          </div>

      </h3>     

      <div class="card-tools">

      <div class="paging">{PAGING}</div>

      </div>

    </div>

	<div class="card-body table-responsive">

	<?php echo $this->utility->get_message()?>

	

    <!-- start of main body -->

    <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">

      <tr>

        <td>

          

          

          <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_user_logs");?>

          <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "act");?>

          

          <!-- BEGIN: user_logs_table -->

          

          <table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="table-hover table-bordered admintable table-sm">

			<thead>

            <tr>

              <th class="text-center" width="2%" align="center" valign="middle"><a href="index.php?view=user_logs_list&order_by_field_name=user_logs.id&order_by=<?php echo ($_SESSION['order_by_field_name']=='user_logs.id' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">ID</a></th>

              <th class="text-center" width="8%" height="25" align="center" valign="middle"><a href="index.php?view=user_logs_list&order_by_field_name=admin_user.full_name&order_by=<?php echo ($_SESSION['order_by_field_name']=='admin_user.full_name' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">User Name</a></th>

              <th class="text-center" width="8%" height="25" align="center" valign="middle">&nbsp;IP Address&nbsp;</th>

              <th class="text-center" width="7%" height="25" align="center" valign="middle"><a href="index.php?view=user_logs_list&order_by_field_name=action&order_by=<?php echo ($_SESSION['order_by_field_name']=='action' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Action</a></th>

			  <th class="text-center" width="8%" height="25" align="center" valign="middle"><a href="index.php?view=user_logs_list&order_by_field_name=table_name&order_by=<?php echo ($_SESSION['order_by_field_name']=='table_name' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Table Name</a></th>

			  <th class="text-center" width="4%" height="25" align="center" valign="middle"><a href="index.php?view=user_logs_list&order_by_field_name=table_id&order_by=<?php echo ($_SESSION['order_by_field_name']=='table_id' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Table ID</a></th>

			  <th class="text-center" width="10%" height="25" align="center" valign="middle"><a href="index.php?view=user_logs_list&order_by_field_name=changed_on&order_by=<?php echo ($_SESSION['order_by_field_name']=='changed_on' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Changed On</a></th>

              <th class="text-center" width="47%" height="25" align="center" valign="middle">Description</th>

              <th class="text-center" width="3%" height="25" align="center" valign="middle">Page</th>

            </tr>

			</thead>

            <!-- BEGIN: user_logs_row -->

            <tr class="{ROW_CLASS} table_field_value">

              <td align="center" valign="middle">{user_logs.id}</td>

              <td height="25" align="center" valign="middle">{user_logs.admin_user_full_name}</td>

              <td height="25" align="center" valign="middle">{user_logs.ip_address}</td>

			  <td height="25" align="center" valign="middle">{user_logs.action}</td>

              <td height="25" align="center" valign="middle">{user_logs.table_name}</td>

			  <td height="25" align="center" valign="middle">{user_logs.table_id}</td>

			  <td height="25" align="center" valign="middle">{CHANGED_ON}</td>

			  <td height="25" align="left" valign="middle"><div style="width: 95%;display: inline-block; word-break: break-all;">{user_logs.description}</div></td>

			  <td height="25" align="center" valign="middle"><span class="page_link"><i class="fa fa-link fa-lg" title="View Page"></i><div class="inserted_from">{user_logs.inserted_from}</div></span></td>

            </tr>

            <!-- END: user_logs_row -->

            <tr class="even table_field_value" style="display:{SHOW_HIDE}">

              <td height="25" align="center" valign="middle" colspan="9">Records not found...</td>

            </tr>

            <tr height="30" >

              <td align="left" colspan="9" class="records_table_header" style="padding-left:5px">Records per page :

                <?php $this->htmlBuilder->buildTag("select", array("type"=>"text", "class"=>"textbox", "values"=>$this->record, "style"=>"width:70px; padding:2px;", "onchange"=>"document.frm_user_logs.submit();"), "record_per_page") ?>

                <div style="float:right; margin-right:5px;" class="paging">{PAGING}</div></td>

            </tr>

          </table>          

          <!-- END: user_logs_table -->          

          <?php $this->htmlBuilder->closeForm()?></td>

      </tr>

    </table>

    <!-- end of main body --> 



  <div id="push" ></div>

</div>

</div>

</div>

</div>

<?php include("includes/footer.php") ?>