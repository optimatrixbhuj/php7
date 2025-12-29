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
                <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=admin_user_addedit<?php echo ($this->type!=''?"&type=".$this->type:""); ?>'"><i class="fa fa-plus-circle mr-1" title="Add"></i> <span>Add</span></div>
                <div class="btn btn-o btn-sm btn-primary" onclick="mulitple_delete('frm_admin_user');"><i class="fa fa-trash mr-1" title="Delete"></i><span>Delete</span></div>
                <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=admin_user_list<?php echo ($this->type!=''?"&type=".$this->type:""); ?>&recycle=true'"><i class="fa fa-recycle mr-1" title="Recycle Bin"></i> <span>Recycle Bin</span></div>
              <?php }else{ ?>
                <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=admin_user_list<?php echo ($this->type!=''?"&type=".$this->type:""); ?>'"><i class="fa fa-arrow-circle-left mr-1" title="Back"></i> <span>Back</span></div>
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
           <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"admin_user_list"), "view") ?>
           <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "__search__") ?>
           <div class="small mr-1 d-inline">Search By</div>
           <?php if($this->type!='' && $this->type=="application_user"){?>
           <?php }else{?>
             <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2 auto", "style"=>"","placeholder"=>"User Group Name","onfocus"=>"get_suggession('admin_user_group','group_name',this.value);"), "group_name") ?>
           <?php }?>
           <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2 auto", "style"=>"","placeholder"=>"Full Name","onfocus"=>"get_suggession('admin_user','full_name',this.value);"), "full_name") ?>
           <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Username"), "username") ?>
           <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Email ID"), "email") ?>
           <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Mobile Number"), "mobile") ?>
           <?php if($_SESSION['admin_user_group_id']=='1'){ ?>
             <?php $this->htmlBuilder->buildTag("select", array("class"=>"form-control form-control-sm mb-1 mr-sm-2","values"=>$this->branch,"style"=>""), "branch_id");?>
           <?php } ?>
           <?php $this->htmlBuilder->buildTag("input",array("type"=>"button",  "class"=>"btn btn-primary mb-1 btn-sm","onclick"=>"search_records()", "value"=>"Search"),"btn_search")?>
           <?php $this->htmlBuilder->buildTag("input",array("type"=>"button",  "class"=>"btn btn-secondary mb-1 btn-sm", "value"=>"Reset", "onclick"=>"window.location.href='index.php?view=admin_user_list".($this->type!=''?"&type=".$this->type:"")."&destroy=1'"), "btn_reset")?>
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
           <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_admin_user");?>
           <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "act");?>
           <!-- BEGIN: admin_user_table -->
           <table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="table-hover table-bordered admintable table-sm">
             <thead>
              <tr>
                <th class="text-center" width="5%" align="center" valign="middle">&nbsp;Sr No.&nbsp;</th>
                <th class="text-center" width="2%" height="25" align="center" valign="middle"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"checkAll"), "checkbox")?></th>
                <th class="text-center" width="10%" height="25" align="center" valign="middle"><a href="index.php?view=admin_user_list<?php echo ($this->type!=''?"&type=".$this->type:""); ?>&order_by_field_name=admin_user_group.group_name&order_by=<?php echo ($_SESSION['order_by_field_name']=='admin_user_group.group_name' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">User Group Name</a></th>
                <?php if($_SESSION['admin_user_group_id']=='1'){ ?>
                  <th class="text-center" width="10%" height="25" align="center" valign="middle"><a href="index.php?view=admin_user_list<?php echo ($this->type!=''?"&type=".$this->type:""); ?>&order_by_field_name=branch.name&order_by=<?php echo ($_SESSION['order_by_field_name']=='branch.name' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Branch</a></th>
                <?php } ?>
                <th class="text-center" width="10%" height="25" align="center" valign="middle"><a href="index.php?view=admin_user_list<?php echo ($this->type!=''?"&type=".$this->type:""); ?>&order_by_field_name=full_name&order_by=<?php echo ($_SESSION['order_by_field_name']=='full_name' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Full Name</a></th>
                <th class="text-center" width="10%" height="25" align="center" valign="middle"><a href="index.php?view=admin_user_list<?php echo ($this->type!=''?"&type=".$this->type:""); ?>&order_by_field_name=username&order_by=<?php echo ($_SESSION['order_by_field_name']=='username' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Username</a></th>
                <th class="text-center" width="10%" height="25" align="center" valign="middle">&nbsp;Email&nbsp;</th>
                <th class="text-center" width="10%" height="25" align="center" valign="middle">&nbsp;Mobile Number&nbsp;</th>
                <th class="text-center" width="10%" height="25" align="center" valign="middle">&nbsp;Photo&nbsp;</th>
                <th class="text-center" width="15%" height="25" align="center" valign="middle">Option</th>
              </tr>
            </thead>
            <!-- BEGIN: admin_user_row -->
            <tr height="25" class="{ROW_CLASS} table_field_value">
              <td align="center" valign="middle">{SERIAL}</td>
              <td align="center" valign="middle"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"delAll","value"=>"{admin_user.id}","style"=>"display:{option_show_hide}"),array("del{COUNT}"=>"del[]"))?></td>
              <td align="center" valign="middle">{admin_user.admin_user_group_group_name}</td>
              <?php if($_SESSION['admin_user_group_id']=='1'){ ?>
                <td align="center" valign="middle">{admin_user.branch_name}</td>
              <?php } ?>
              <td align="center" valign="middle">{admin_user.full_name}</td>
              <td align="center" valign="middle">{admin_user.username}</td>
              <td align="center" valign="middle">{admin_user.email}</td>
              <td align="center" valign="middle">{admin_user.mobile}</td>
              <td align="center" valign="middle">{photo}</td>
              <td align="center" valign="middle">&nbsp;
               <?php if($this->recycle==false) {?>
                <a class="btn btn-default btn-sm" onclick="window.location.href='index.php?view=admin_user_addedit<?php echo ($this->type!=''?"&type=".$this->type:""); ?>&id={admin_user.id}&page_no={PAGE_NO}'"><i class="fa fa-pencil-alt" title="Edit Record"></i></a>&nbsp;
                <a class="btn btn-default btn-sm" style="display: {SHOW_HIDE_DELETE}" onclick="javascript:confirm_del({'id':'{admin_user.id}', 'act':'single_delete','page_no':'{PAGE_NO}'})"><i class="fa fa-trash-alt" style="cursor:pointer;" title="Delete Record"></i></a>
              <?php }else{ ?>
                <a class="btn btn-default btn-sm" onclick="javascript:confirm_restore({'id':'{admin_user.id}', 'act':'recycle','page_no':'{PAGE_NO}'})"><i class="fa fa-undo" title='Restore Record'></i></a>
              <?php } ?>
            </td>
          </tr>
          <?php if($_SESSION['admin_user_group_id']=='1'){ $colspan=10; }else{ $colspan=9; }?>
          <!-- END: admin_user_row -->
          <tr class="even table_field_value" style="display:{SHOW_HIDE}">
            <td height="25" align="center" valign="middle" colspan="<?php echo $colspan;?>">Records not found...</td>
          </tr>
          <tr height="30" class="records_table_header" >
            <td align="left" colspan="<?php echo $colspan;?>" class="records_table_header" style="padding-left:5px">Records per page :
              <?php $this->htmlBuilder->buildTag("select", array("type"=>"text", "class"=>"textbox", "values"=>$this->record, "style"=>"width:70px; padding:2px;", "onchange"=>"document.frm_admin_user.submit();"), "record_per_page") ?>
              <div style="float:right; margin-right:5px;" class="paging">{PAGING}</div></td>
            </tr>
          </table>
          <!-- END: admin_user_table -->
          <?php $this->htmlBuilder->closeForm()?></td>
        </tr>
      </table>
      <!-- end of main body -->
    </div>
    <div id="push" ></div>
  </div>
</div>
</div>
<?php include("includes/footer.php") ?>