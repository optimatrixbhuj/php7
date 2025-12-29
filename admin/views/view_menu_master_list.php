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

                      <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=menu_master_addedit'"><i class="fa fa-plus-circle mr-1" title="Add"></i> <span>Add</span></div>

                      <div class="btn btn-o btn-sm btn-primary" onclick="mulitple_delete('frm_menu_master');"><i class="fa fa-trash mr-1" title="Delete"></i><span>Delete</span></div>              

                      <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=menu_master_list&recycle=true'"><i class="fa fa-recycle mr-1" title="Recycle Bin"></i> <span>Recycle Bin</span></div>

                    <?php }else{ ?>

                      <div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=menu_master_list'"><i class="fa fa-arrow-circle-left mr-1" title="Back"></i> <span>Back</span></div>

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

          <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"menu_master_list"), "view") ?>

          <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "__search__") ?>



          <div class="small mr-1 d-inline">Search By</div>



          <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control form-control-sm mb-1 mr-sm-2", "style"=>"","placeholder"=>"Label"), "label") ?>



          <?php $this->htmlBuilder->buildTag("input",array("type"=>"button","class"=>"btn btn-primary mb-1 btn-sm", "onclick"=>"search_records()", "value"=>"Search"),"btn_search")?>

          <?php $this->htmlBuilder->buildTag("input",array("type"=>"button","class"=>"btn btn-secondary mb-1 btn-sm", "value"=>"Reset", "onclick"=>"window.location.href='index.php?view=menu_master_list&destroy=1'"), "btn_reset")?>



          <?php $this->htmlBuilder->closeForm()?>



        </div>

      </h3>     

      

    </div>

    <div class="card-body mb-0">

     <div class="table-responsive">  

      <!-- start of main body -->

      <table border="0" width="100%" cellpadding="0" cellspacing="2" align="center" class="content_table">

        <tr>

          <td>



            <?php echo $this->utility->get_message()?>

            <?php $this->htmlBuilder->buildTag("form", array("action"=>""), "frm_menu_master");?>

            <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden","value"=>""), "act");?>



            <!-- BEGIN: menu_master_table -->



            <table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="table table-hover table-bordered admintable table-sm">

              <thead>

                <tr>

                  <th class="text-center" width="5%" align="center" valign="middle">&nbsp;Sr No.&nbsp;</th>

                  <th class="text-center" width="2%" height="25" align="center" valign="middle"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"checkAll"), "checkbox")?></th>

                  <th class="text-center" width="20%" height="25" align="center" valign="middle"><a href="index.php?view=menu_master_list&order_by_field_name=label&order_by=<?php echo ($_SESSION['order_by_field_name']=='label' && $this->order_by!='' ?$this->order_by:'ASC') ; ?>">label</a></th>

                  <th class="text-center" width="15%" height="25" align="center" valign="middle">Icon</th>



                  <th class="text-center" width="10%" height="25" align="center" valign="middle">Option</th>

                </tr>

              </thead>

              <tbody>

                <!-- BEGIN: menu_master_row -->

                <tr height="25" class="{ROW_CLASS} table_field_value" {OWN_ID_CLASS} {PARENT_ID_CLASS} id="{menu_master.sort_order}">

                  <td align="center" valign="middle">{SERIAL}</td>

                  <td align="center" valign="middle"><?php $this->htmlBuilder->buildTag("input",array("type"=>"checkbox", "class"=>"delAll","value"=>"{menu_master.id}"),array("del{COUNT}"=>"del[]"))?></td>

                  <td {align} valign="middle">{menu_master.label}</td>

                  <td align="center" valign="middle"><i class="{menu_master.icon_class} fa-2x" aria-hidden="true"></i></td>



                  <td align="center" valign="middle">&nbsp;

                   <?php if($this->recycle==false) {?>

                    <a class="btn btn-default btn-sm" onclick="window.location.href='index.php?view=menu_master_addedit&id={menu_master.id}&page_no={PAGE_NO}'"><i class="fa fa-pencil-alt" title="Edit Record"></i></a>&nbsp;

                    <a class="btn btn-default btn-sm" onclick="javascript:confirm_del({'id':'{menu_master.id}', 'act':'single_delete','page_no':'{PAGE_NO}'})"><i class="fa fa-trash-alt" style="cursor:pointer;display:{SHOW_HIDE_DELETE}" title="Delete Record"></i></a>

                  <?php }else{ ?>

                    <a onclick="javascript:confirm_restore({'id':'{menu_master.id}', 'act':'recycle','page_no':'{PAGE_NO}'})"><i class="fa fa-undo fa-lg" title='Restore Record'></i></a>

                  <?php } ?>

                </td>

              </tr>

              <!-- END: menu_master_row -->

            </tbody>

            <tr class="even table_field_value" style="display:{SHOW_HIDE}">

              <td height="25" align="center" valign="middle" colspan="7">Records not found...</td>

            </tr>

            

          </table>

          

          <!-- END: menu_master_table -->

          

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





<script type="text/javascript">

  $(document).ready(function(e) {

    var old_position='';

    $(".table tbody").sortable({

      cursor: "move",

      placeholder: "ui-state-active",

      opacity: 0.7,

      start: function(e, ui) {

      // creates a temporary attribute on the element with the old index

      $(this).attr('data-previndex', ui.item.index());

      old_position = $(this).sortable('toArray');

      ui.placeholder.height(ui.item.height());

    },

    update: function( event, ui ) {

      var newIndex = ui.item.index();

      var oldIndex = $(this).attr('data-previndex');

      var element_id = ui.item.find(".delAll").val();

      var new_position = $(this).sortable('toArray');

      /*console.log(old_position);

      console.log(new_position);

      console.log("oI : "+oldIndex);

      console.log("nI : "+newIndex);

      console.log("id : "+element_id);

      return false;*/

      $(this).removeAttr('data-previndex');

      $.ajax({

       type: "POST",

       data: {  method: 'change_sort_order',

       table_name:'menu_master',

       old_position:old_position,

       new_position:new_position,

       old_in: oldIndex,

       new_in: newIndex,

       id: element_id,

     },

     url: "../scripts/ajax/index.php",

     success: function(msg){

           //console.log(msg);

           if(msg=='OK'){

             location.reload(true);

           }else{

             $.alert({

              title: 'Alert!',

              icon:'glyphicon glyphicon-info-sign',

              content:"\nERROR!! \n\n\Ooops some problem occurred. \n\n\ Please try again",

              theme: 'skin-blue',

              confirm: function(){ }

            });

             return false;

           }

         }

       });

    },    

  });

  });

</script>