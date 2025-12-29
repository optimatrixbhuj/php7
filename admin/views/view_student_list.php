<?php include("includes/header.php") ?>



<div class="content pt-3">

  <div class="container-fluid">

  <div class="card card-primary card-outline">


<div class="card-header">
      <div class="row mb-2">
        <div class="col-md-6">
                <h1><?php echo ucfirst($this->manager_for)?> <?php if($this->recycle==false){ ?>Manager<?php }else{ ?>Recycle Bin<?php } ?></h1>
              </div>
              <div class="col-md-6">
                <div class="actionBtns text-right">         
                   <?php if($this->recycle==false) {?>

                      <div class="btn btn-o btn-sm btn-primary" onclick="excel_export('student List','student List')"><i class="fa fa-file-excel" title="Excel"></i> <span>Excel</span></div>

                      <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=student_addedit'"><i class="fa fa-plus-circle mr-1" title="Add"></i> <span>Add</span></div>

                      <div class="btn btn-o btn-sm btn-primary" onclick="mulitple_delete('frm_student');"><i class="fa fa-trash mr-1" title="Delete"></i><span>Delete</span></div>              

                     <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=student_list&recycle=true'"><i class="fa fa-recycle mr-1" title="Recycle Bin"></i> <span>Recycle Bin</span></div>

                    <?php }else{ ?>

                    <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=student_list'"><i class="fa fa-arrow-circle-left mr-1" title="Back"></i> <span>Back</span></div>

                   <?php }?>

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

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"student_list"), "view") ?>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "__search__") ?>

            

              

               <div class="small mr-1 d-inline">Search By</div>

			   

			   <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Name"), "name") ?>

                    

				

					

                

                <?php $this->htmlBuilder->buildTag("input",array("type"=>"button", "class"=>"btn btn-primary mb-1 btn-sm", "onclick"=>"search_records()", "value"=>"Search"),"btn_search")?>

                <?php $this->htmlBuilder->buildTag("input",array("type"=>"button", "class"=>"btn btn-secondary mb-1 btn-sm", "value"=>"Reset", "onclick"=>"window.location.href='index.php?view=student_list&destroy=1'"), "btn_reset")?>

                <?php $this->htmlBuilder->closeForm()?>

                

                

      

          </div>

      </h3>     

      <div class="card-tools">

      <div class="paging">{PAGING}</div>

      </div>

    </div>

  <div class="card-body pad table-responsive">

	<?php echo $this->utility->get_message()?>

    <!-- start of main body -->

    <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">

      <tr>

        <td>

                    

          <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_student");?>

          <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>""), "act");?>

          

          <!-- BEGIN: student_table -->

          

          <table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="table table-hover table-bordered admintable table-sm records_table" id="tblExport">

            <thead>

				<tr>

              <th class="text-center" width="5%" align="center" valign="middle">&nbsp;Sr No.&nbsp;</th>

              <th class="text-center hide_print" width="2%" height="25" align="center" valign="middle"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"checkAll"), "checkbox")?></th>

              <th class="text-center" width="20%" height="25" align="center" valign="middle"><a href="index.php?view=student_list&order_by_field_name=name&order_by=<?php echo ($_SESSION['order_by_field_name']=='name' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Name</a></th>

              <th class="text-center" width="15%" height="25" align="center" valign="middle">Address&nbsp;</th>

              <th class="text-center" width="15%" height="25" align="center" valign="middle">&nbsp;</th>

              <th class="text-center" width="8%" align="center" valign="middle">&nbsp;</th>

              <th class="text-center hide_print" width="10%" height="25" align="center" valign="middle">Option</th>

            </tr>

			</thead>

            <!-- BEGIN: student_row -->

            <tr height="25" class="{ROW_CLASS} table_field_value">

              <td align="center" valign="middle">{SERIAL}</td>

              <td align="center" valign="middle" class="hide_print"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"delAll","value"=>"{student.id}"),array("del{COUNT}"=>"del[]"))?></td>

              <td align="center" valign="middle">{student.name}</td>

              <td align="center" valign="middle">{student.address}&nbsp;</td>

              <td align="center" valign="middle">&nbsp;</td>

              <td align="center" valign="middle">&nbsp;</td>

              <td align="center" valign="middle" class="hide_print">&nbsp;

			  <?php if($this->recycle==false) {?>

        <a class="btn btn-default btn-sm" onclick="window.location.href='index.php?view=student_addedit&id={student.id}&page_no={PAGE_NO}'"><i class="fa fa-pencil-alt" title="Edit Record"></i></a>&nbsp;

        <a class="btn btn-default btn-sm" onclick="javascript:confirm_del({'id':'{student.id}', 'act':'single_delete','page_no':'{PAGE_NO}'})"><i class="fa fa-trash-alt" style="cursor:pointer;display:{SHOW_HIDE_DELETE}" title="Delete Record"></i></a>

			  <?php }else{ ?>

        <a class="btn btn-default btn-sm" onclick="javascript:confirm_restore({'id':'{student.id}', 'act':'recycle','page_no':'{PAGE_NO}'})"><i class="fa fa-undo" title='Restore Record'></i></a>

			  <?php } ?>

			  </td>

            </tr>

            <!-- END: student_row -->

            <tr class="even table_field_value hide_print" style="display:{SHOW_HIDE}">

              <td height="25" align="center" valign="middle" colspan="7">Records not found...</td>

            </tr>

            <tr height="30" class="records_table_header hide_print" >

              <td align="left" colspan="7" class="records_table_header hide_print" style="padding-left:5px">Records per page :

                <?php $this->htmlBuilder->buildTag("select", array("type"=>"text", "class"=>"textbox", "values"=>$this->record, "style"=>"width:70px; padding:2px;", "onchange"=>"document.frm_student.submit();"), "record_per_page") ?>

                <div style="float:right; margin-right:5px;" class="paging hide_print">{PAGING}</div></td>

            </tr>

          </table>

          

          <!-- END: student_table -->

          

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