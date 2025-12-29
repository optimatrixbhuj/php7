<?php include("includes/header.php") ?>



<div class="content pt-3">

<div class="container-fluid">

  <div class="card card-primary card-outline">


<div class="card-header">
      <div class="row mb-2">
        <div class="col-md-6">
                <h1><?php echo ucfirst($this->manager_for)?> Manager</h1>
              </div>
              <div class="col-md-6">
                <div class="actionBtns text-right">         
           <a class="btn btn-o btn-sm btn-primary" href="javascript:" onClick="get_balance()"><i class="fa fa-rupee-sign mr-1" title="Show "></i> Show Balance</a>         
              </div>
      </div>
    </div>
</div>


	

	<div class="card-header">

      <h3 class="card-title">

	  

          <div class="form-inline mobile-block">

            <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_search");?>

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"search"), "act") ?>

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"message_log_list"), "view") ?>

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "__search__") ?>

            

			<div class="small mr-1 d-inline">Search By</div>

			

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"To Number"), "to_number") ?>

        	

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2 date", "style"=>"","placeholder"=>"Date"), "datetime") ?>

            

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Message"), "message") ?>

                  <?php if($_SESSION['admin_user_group_id']=='1'){ ?>

            

			<?php $this->htmlBuilder->buildTag("select", array("class"=>"form-control mb-1 mr-sm-2 allbranch","values"=>$this->branch,"style"=>"width:160px"), "branch_id");?>

            <?php } ?>

            

			<?php $this->htmlBuilder->buildTag("input",array("type"=>"button","class"=>"btn btn-primary mb-1 btn-sm", "onclick"=>"search_records()", "value"=>"Search"),"btn_search")?>

			

            <?php $this->htmlBuilder->buildTag("input",array("type"=>"button","class"=>"btn btn-secondary mb-1 btn-sm", "value"=>"Reset", "onclick"=>"window.location.href='index.php?view=message_log_list&destroy=1'"), "btn_reset")?>

					

				

                <?php $this->htmlBuilder->closeForm()?>

      

          </div>

      </h3>     

      <div class="card-tools">

      <div class="paging">{PAGING}</div>

      </div>

    </div>

  

  <div class="card-body mb-0">

		<?php echo $this->utility->get_message()?>

	

	<div class="table-responsive"> 

    <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">

      <tr>

        <td>

          

          

          <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_message_log");?>

          

          <!-- BEGIN: message_log_table -->

          

          <table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="table table-hover table-bordered admintable table-sm">

			<thead>

            <tr >

              <th class="text-center" width="70" align="center" valign="middle">Sr No.</th>		

              <?php if($_SESSION['admin_user_group_id']=='1'){ ?>

                <th class="text-center" width="" height="25" align="center" valign="middle"><a href="index.php?view=message_log_list&order_by_field_name=branch.name&order_by=<?php echo ($_SESSION['order_by_field_name']=='branch.name' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Branch</a></th>

              <?php } ?>	  

              <th class="text-center" width="" height="25" align="center" valign="middle"><a href="index.php?view=message_log_list&order_by_field_name=message&order_by=<?php echo ($_SESSION['order_by_field_name']=='message' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Message</a></th>

              <th class="text-center" width="" height="25" align="center" valign="middle"><a href="index.php?view=message_log_list&order_by_field_name=to_number&order_by=<?php echo ($_SESSION['order_by_field_name']=='to_number' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">To Number</a></th>

              <th class="text-center" width="" height="25" align="center" valign="middle"><a href="index.php?view=message_log_list&order_by_field_name=datetime&order_by=<?php echo ($_SESSION['order_by_field_name']=='datetime' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Date-Time</a></th>

              <th class="text-center" width="" height="25" align="center" valign="middle">&nbsp;Delivery Report&nbsp;</th>

            </tr>

			</thead>

            <!-- BEGIN: message_log_row -->

            <tr height="25" class="{ROW_CLASS} table_field_value">

              <td align="center" valign="middle">{SERIAL}</td>			  

              <?php if($_SESSION['admin_user_group_id']=='1'){ ?>

              <td align="center" valign="middle">{message_log.branch_name}</td>

              <?php } ?>

              <td align="center" valign="middle">{message_log.message}</td>

              <td align="center" valign="middle">{message_log.to_number}</td>

              <td align="center" valign="middle">{message_log.datetime}</td>

              <td align="center" valign="middle">{delivery_report}</td>

            </tr>            

            <!-- END: message_log_row -->

            <?php if($_SESSION['admin_user_group_id']=='1'){ $colspan=6; }else{ $colspan=5; }?>

            <tr class="even table_field_value" style="display:{SHOW_HIDE}">

              <td height="25" align="center" valign="middle" colspan="<?php echo $colspan;?>">Records not found...</td>

            </tr>

            <tr height="30" class="records_table_header" >

              <td align="left" colspan="<?php echo $colspan;?>" class="records_table_header" style="padding-left:5px">Records per page :

                <?php $this->htmlBuilder->buildTag("select", array("type"=>"text", "class"=>"textbox", "values"=>$this->record, "style"=>"width:70px; padding:2px;", "onchange"=>"document.frm_message_log.submit();"), "record_per_page") ?>

                <div style="float:right; margin-right:5px;" class="paging">{PAGING}</div></td>

            </tr>

          </table>

          

          <!-- END: message_log_table -->

          

          <?php $this->htmlBuilder->closeForm()?></td>

      </tr>

    </table>

    <!-- end of main body --> 

  </div>

  <div id="push" ></div>

</div>

</div>

</div>

</div>

<?php include("includes/footer.php") ?>



