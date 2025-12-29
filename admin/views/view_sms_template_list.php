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

            <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=sms_template_addedit'"><i class="fa fa-plus-circle mr-1" title="Add"></i><span>Add</span></div>

      <!--<div class="btn btn-o btn-sm btn-info" onclick="copy_record('frm_sms_template');"><i class="far fa-file mr-1" title="Copy"></i><span>Copy</span></div> -->

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

            <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"sms_template_list"), "view") ?>

            <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "__search__") ?>

            

              

				<div class="small mr-1 d-inline">Search By</div>

				<?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Subject"), "subject") ?>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Message"), "message") ?>

                    

				<?php $this->htmlBuilder->buildTag("input",array("type"=>"button","class"=>"btn btn-primary mb-1 btn-sm", "onclick"=>"search_records()", "value"=>"Search"),"btn_search")?>

				

                <?php $this->htmlBuilder->buildTag("input",array("type"=>"button","class"=>"btn btn-secondary mb-1 btn-sm", "value"=>"Reset", "onclick"=>"window.location.href='index.php?view=sms_template_list&destroy=1'"), "btn_reset")?>

				

                <?php $this->htmlBuilder->closeForm()?>

      

          </div>

      </h3>     

      <div class="card-tools">

      <div class="paging">{PAGING}</div>

      </div>

    </div>

    <div class="card-body mb-0">

		<div class="mb-2"><font color="#FF0000"><b>Note : </b> Please Do Not Change or Delete Text Given in Curly {} Bracket.</font></div>

          <?php echo $this->utility->get_message()?>

          

	

	

	<div class="table-responsive">    

    <!-- start of main body -->

		

        

           <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">

      <tr>

        <td>

          

          <!-- BEGIN: sms_template_table -->

          <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_sms_template");?>

          <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "act");?>

          <table width="100%" align="center" border="0" cellspacing="2" cellpadding="0" class="table table-hover table-bordered admintable table-sm">

            <thead>

			<tr>

              <th class="text-center" width="70" align="center" valign="middle">&nbsp;Sr No.&nbsp;</th>

              <th class="text-center" width="40" align="center" valign="middle"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"checkAll"), "checkbox")?></th>

              <th class="text-center" width="" align="center" valign="middle"><a href="index.php?view=sms_template_list&order_by_field_name=subject&order_by=<?php echo ($_SESSION['order_by_field_name']=='subject' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Subject</a></th>

              <th class="text-center" width="" align="center" valign="middle">&nbsp;Message&nbsp;</th>

              <th class="text-center" width="150" align="center" valign="middle">Option</th>

            </tr>

			</thead>

            <!-- BEGIN: sms_template_row -->

            <tr class="{ROW_CLASS} table_field_value">

              <td align="center" valign="middle">{SERIAL}</td>

              <td align="center" valign="middle"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"delAll","value"=>"{sms_template.id}"),array("del{COUNT}"=>"del[]"))?></td>

              <td align="center" valign="middle">{sms_template.subject}</td>

              <td align="center" valign="middle">{sms_template.message}</td>

              <td align="center" valign="middle">&nbsp;



                <a class="btn btn-default btn-sm" onclick="window.location.href='index.php?view=sms_template_addedit&id={sms_template.id}&page_no={PAGE_NO}'"><i class="fa fa-pencil-alt" title="Edit Record"></i></a></td>

              </tr>

              <!-- END: sms_template_row -->

              <tr class="even table_field_value" style="display:{SHOW_HIDE}">

                <td height="25" align="center" valign="middle" colspan="5">Records not found...</td>

              </tr>

              <tr height="30" class="records_table_header" >

                <td align="left" colspan="5" class="records_table_header" style="padding-left:5px">Records per page :

                  <?php $this->htmlBuilder->buildTag("select", array("type"=>"text", "class"=>"textbox", "values"=>$this->record, "style"=>"width:70px; padding:2px;", "onchange"=>"document.frm_sms_template.submit();"), "record_per_page") ?>

                  <div style="float:right; margin-right:5px;" class="paging">{PAGING}</div></td>

                </tr>

              </table>

              

              <!-- END: sms_template_table -->

              

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

