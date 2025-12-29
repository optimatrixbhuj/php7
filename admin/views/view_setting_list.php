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
            <div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i> <span>Refresh</span></div>
          </div>
        </div>
      </div>




        

    </div>

	<div class="card-header">

      <h3 class="card-title">

          <div class="form-inline mobile-block">

            <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_search");?>

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"search"), "act") ?>

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"setting_list"), "view") ?>

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "__search__") ?>

            

              

               <div class="small mr-1 d-inline">Search By</div>

               

                    

					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Setting Name"), "object_field") ?>

					

					<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Setting Value"), "object_value") ?>

					

                    <?php $this->htmlBuilder->buildTag("input",array("type"=>"button","class"=>"btn btn-primary mb-1 btn-sm", "onclick"=>"search_records()", "value"=>"Search"),"btn_search")?>

                    

					<?php $this->htmlBuilder->buildTag("input",array("type"=>"button","class"=>"btn btn-secondary mb-1 btn-sm", "value"=>"Reset", "onclick"=>"window.location.href='index.php?view=setting_list&destroy=1'"), "btn_reset")?>

					  

                    

                  <?php $this->htmlBuilder->closeForm()?>

      

          </div>

      </h3>     

      <div class="card-tools">

      <div class="paging">{PAGING}</div>

      </div>

    </div>

  <div class="card-body">

	<div class="table-responsive">  

    <!-- start of main body -->

    <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">

      <tr>

        <td>

          

          <?php echo $this->utility->get_message()?>

          <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_setting");?>

          <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "act");?>

          

          <!-- BEGIN: setting_table -->

          

          <table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="table table-hover table-bordered admintable table-sm">

            <thead>

			<tr>

              <th class="text-center" width="70" align="center" valign="middle">&nbsp;Sr No.&nbsp;</th>              

              <th class="text-center" width="" height="25" align="center" valign="middle"><a href="index.php?view=setting_list&order_by_field_name=object_field&order_by=<?php echo ($_SESSION['order_by_field_name']=='object_field' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Name</a></th>

              <th class="text-center" width="" height="25" align="center" valign="middle">&nbsp;Value&nbsp;</th>

              <th class="text-center" width="" height="25" align="center" valign="middle">&nbsp;Description&nbsp;</th>

             <th class="text-center" width="130" height="25" align="center" valign="middle">Option</th>

            </tr>

			</thead>

            <!-- BEGIN: setting_row -->

            <tr class="{ROW_CLASS} table_field_value">

              <td align="center" valign="middle">{SERIAL}</td>

              <td align="center" valign="middle">{setting.object_field}</td>

              <td align="center" valign="middle">{setting.object_value}</td>

              <td align="center" valign="middle">{setting.description}</td>

              <td align="center" valign="middle">

                <a class="btn btn-default btn-sm" onclick="window.location.href='index.php?view=setting_addedit&id={setting.id}&page_no={PAGE_NO}'"><i class="fa fa-pencil-alt" title="Edit Record"></i></a> </td>

            </tr>

            <!-- END: setting_row -->

            <tr class="even table_field_value" style="display:{SHOW_HIDE}">

              <td height="50" align="center" valign="middle" colspan="5">Records not found...</td>

            </tr>

            <tr class="records_table_header" >

              <td align="left" colspan="5" class="records_table_header" style="padding-left:5px">Records per page :

                <?php $this->htmlBuilder->buildTag("select", array("type"=>"text", "class"=>"textbox", "values"=>$this->record, "style"=>"width:70px; padding:2px;", "onchange"=>"document.frm_setting.submit();"), "record_per_page") ?>

                <div style="float:right; margin-right:5px;" class="paging">{PAGING}</div></td>

            </tr>

          </table>

          

          <!-- END: setting_table -->

          

          <?php $this->htmlBuilder->closeForm()?></td>

      </tr>

    </table>

    </div>

	<!-- end of main body --> 

  </div>

  </div>

  <div id="push" ></div>

	</div>

</div>

<?php include("includes/footer.php") ?>



<script type="text/javascript">

	function mulitple_delete(formname){

		var ellen=document.getElementById(formname).elements.length;

		var count=0;

		for(var i=0;i<ellen;i++){

			if(document.getElementById(formname).elements[i].name=="del[]"){	

				 if(document.getElementById(formname).elements[i].checked==true){

					count=count+1;

				 }

			}

		}

		if(count==0){

			jAlert("Please Select Record To Delete");

			return false;

		}else{

			jConfirm('Are you sure you want to delete records?', 'Confirmation Dialog', function(r) {

				if(r == true){

					document.frm_setting.act.value='multi_delete';

					document.frm_setting.submit();

				}

			});

		}

	}

</script>