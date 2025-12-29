<?php include("includes/header.php") ?>

<!-- Content Header (Page header) -->
<div class="btnwrap">
	<?php if($this->recycle==false) {?>
	<a class="iconlink text-primary" href="javascript:;" onclick="window.location.href='index.php?view=branch_addedit'" title="Add"><i class="fas fa-plus-circle"></i></a>
	<a class="iconlink text-danger" href="javascript:;" onclick="mulitple_delete('frm_branch');" title="Delete"><i class="fas fa-trash"></i></a>
	<a class="iconlink text-info" href="javascript:;" onclick="window.location.href='index.php?view=branch_list&recycle=true'" title="Recycle"><i class="fas fa-recycle"></i></a>
	<?php }else{ ?>
		<a class="iconlink text-info" href="javascript:;" onclick="window.location.href='index.php?view=branch_list'" title="Back"><i class="fas fa-chevron-left"></i></a>
           

    <?php }?>

	<a class="iconlink text-warning" href="javascript:;" onclick="javascript:location.reload(true)" title="Refresh"><i class="fas fa-sync"></i></a>
           

        
</div>
<div class="showhidebtn active"><i class="fa fa-angle-left"></i></div>
<div class="hasSideButtons opened">


<section class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-12">

            <h1><?php echo ucfirst($this->manager_for)?> <?php if($this->recycle==false){ ?>Manager<?php }else{ ?>Recycle Bin<?php } ?></h1>

          </div>

          

        </div>

      </div><!-- /.container-fluid -->

    </section>	

<div class="content">

<div class="container-fluid">

  <div class="card card-primary card-outline">

   
    <div class="card-header">

      <h3 class="card-title">

          <div class="form-inline mobile-block">

            <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_search");?>

            <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"search"), "act") ?>

            <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"branch_list"), "view") ?>

            <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "__search__") ?>

            

              

               <div class="small mr-1 d-inline">Search By</div>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Name"), "name") ?>

                

                <?php $this->htmlBuilder->buildTag("input",array("type"=>"button", "class"=>"btn btn-primary mb-1 btn-sm", "onclick"=>"search_records()", "value"=>"Search"),"btn_search")?>

                <?php $this->htmlBuilder->buildTag("input",array("type"=>"button", "class"=>"btn btn-secondary mb-1 btn-sm", "value"=>"Reset", "onclick"=>"window.location.href='index.php?view=branch_list&destroy=1'"), "btn_reset")?>

                <?php $this->htmlBuilder->closeForm()?>

                

                

      

          </div>

      </h3>     

      <div class="card-tools">

      <div class="paging">{PAGING}</div>

      </div>

    </div>

    <div class="card-body pad table-responsive">

    <?php echo $this->utility->get_message()?>

    <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table ">

    <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_branch");?>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>""), "act");?>

      <tr>

        <td>

		

       

      



      <!-- BEGIN: branch_table -->



      <table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="table table-hover table-bordered admintable table-sm">

        <thead>

          <tr>

            <th width="70"  class="text-center" valign="middle">&nbsp;Sr No.&nbsp;</th>

            <th width="40"  class="text-center" valign="middle"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"checkAll"), "checkbox")?></th>

            <th width="250"  class="text-center" valign="middle"><a href="index.php?view=branch_list&order_by_field_name=name&order_by=<?php echo ($_SESSION['order_by_field_name']=='name' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Name</a></th>

            <th width="350" class="text-center" valign="middle">Address</th>

            <th class="text-center" valign="middle"><a href="index.php?view=branch_list&order_by_field_name=person_name&order_by=<?php echo ($_SESSION['order_by_field_name']=='person_name' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Contact Person</a></th>

            <th class="text-center" valign="middle"><a href="index.php?view=branch_list&order_by_field_name=contact_number&order_by=<?php echo ($_SESSION['order_by_field_name']=='contact_number' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Contact Number</a></th>

            <th class="text-center" valign="middle"><a href="index.php?view=branch_list&order_by_field_name=email&order_by=<?php echo ($_SESSION['order_by_field_name']=='email' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">Email</a></th>

            <th width="130" class="text-center" valign="middle">Option</th>

          </tr>  

        </thead>





        

        

        <!-- BEGIN: branch_row -->

        <tr class="{ROW_CLASS} table_field_value">

          <td width="50" align="center" valign="middle">{SERIAL}</td>

          <td width="40" align="center" valign="middle"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"delAll","value"=>"{branch.id}"),array("del{COUNT}"=>"del[]"))?></td>

          <td width="250" align="center" valign="middle">{branch.name}</td> 

          <td width="350"  align="center" valign="middle">{branch.address}</td>

          <td align="center" valign="middle">{branch.person_name}</td>

          <td align="center" valign="middle">{branch.contact_number}</td>

          <td align="center" valign="middle">{branch.email}</td>         

          <td width="160" align="center" valign="middle">&nbsp;

           <?php if($this->recycle==false) {?>

            <script type="text/javascript">

              $(document).ready(function() {

                $("#city_{branch.id}").fancybox({

                  'width'       : '95%',

                  'height'      : '95%',

                  'autoScale'     : false,

                  'transitionIn'    : 'elastic',

                  'transitionOut'   : 'elastic',

                  'type'        : 'iframe',

                  'href'        : 'index.php?view=branch_addedit&id={branch.id}&update=city',

                });

              });

            </script>





            <a class="btn btn-default btn-sm" onclick="window.location.href='index.php?view=branch_addedit&id={branch.id}&page_no={PAGE_NO}'"><i class="fa fa-pencil-alt" title="Edit Record"></i></a>&nbsp;

            <a class="btn btn-default btn-sm" onclick="javascript:confirm_del({'id':'{branch.id}', 'act':'single_delete','page_no':'{PAGE_NO}'})"><i class="fa fa-trash-alt" style="cursor:pointer;display:{SHOW_HIDE_DELETE}" title="Delete Record"></i></a>

          <?php }else{ ?>

            <a class="btn btn-default btn-sm" onclick="javascript:confirm_restore({'id':'{branch.id}', 'act':'recycle','page_no':'{PAGE_NO}'})"><i class="fa fa-undo" title='Restore Record'></i></a>

          <?php } ?>

        </td>

      </tr>

      <!-- END: branch_row -->

      <tr class="even table_field_value" style="display:{SHOW_HIDE}">

        <td height="25" align="center" valign="middle" colspan="8">Records not found...</td>

      </tr>

      <tr height="30" class="records_table_header" >

        <td align="left" colspan="8" class="records_table_header" style="padding-left:5px">Records per page :

          <?php $this->htmlBuilder->buildTag("select", array("type"=>"text", "class"=>"textbox", "values"=>$this->record, "style"=>"width:70px; padding:2px;", "onchange"=>"document.frm_branch.submit();"), "record_per_page") ?>

          <div style="float:right; margin-right:5px;" class="paging">{PAGING}</div></td>

        </tr>

      </table>      

      <!-- END: branch_table -->



      </td>

    </tr>

    <?php $this->htmlBuilder->closeForm()?>

  </table>      

    </div>

  </div>

</div>

<div id="push" ></div>

</div>

</div>

<?php include("includes/footer.php") ?>

