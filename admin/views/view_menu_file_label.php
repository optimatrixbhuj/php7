<script type="text/javascript">

	$(document).ready(function() {

		$("#add_menu_label").click(function(e) {                    

			$.fancybox({

				'width'       : '70%',

				'height'      : '70%',			

				'href'        : 'index.php?view=menu_file_label_addedit',

				'autoSize'     : false,

				'transitionIn'    : 'elastic',

				'transitionOut'   : 'elastic',

				'type'        : 'iframe',

			});

		});

		$("#search").on("keyup", function() {		

			var $rows = $("#files_table tr.table_field_value");		

			var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();    

			$rows.show().filter(function() {

				var text = $(this).find("td:eq(0)").text().replace(/\s+/g, ' ').toLowerCase();

				return !~text.indexOf(val);

			}).hide();		

		});

	});

	function update_file_label(el){

		var file_name=$(el).closest("tr").find(".page_name").val();

		var file_label=$(el).closest("tr").find(".file_label").val();

		var parameters=$(el).closest("tr").find(".parameters").val();

		$.ajax({

			url : '../scripts/ajax/index.php',		      			

			type: 'post',		

			data: "method=save_menu_file_label&file_name="+file_name+"&file_label="+file_label+"&parameters="+parameters,

			success: function(data) {

				console.log(data);

			},

			error: function(xhr, desc, err) {

				console.log(xhr);

				console.log("Details: " + desc + "\nError:" + err);

			}

		});

	}

</script>

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
	           				<div class="btn btn-o btn-sm btn-primary" id="add_menu_label"><i class="fa fa-plus-circle mr-1" title="Add"></i> <span>Add Label with Parameter</span></div>
										<div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i> <span>Refresh</span></div>       
	              </div>
	      </div>
	    </div>
	</div>



	

	<div class="card-header">

      <h3 class="card-title">

          <div class="form-inline mobile-block">

            

              

               <div class="small mr-1 d-inline mr-2"><strong>Search By Page Name</strong></div>

                

                

               <input class="form-control form-control-sm  mb-1 mr-sm-2" type="text" id="search" placeholder="Type to search" class="textbox">

                

      

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

				

				<table width="100%" align="center" border="0" cellspacing="1" cellpadding="1" class="table table-hover table-bordered admintable table-sm" id="files_table">

					<thead>

						<tr>

							<th class="text-center" width="25%" align="center" valign="middle">&nbsp;Page Name&nbsp;</th>

							<th class="text-left pl-2" width="70%" align="center" valign="middle">&nbsp;Page Label&nbsp;</th>

						</tr>

					</thead>

					<?php $path=ABS_PATH.DS.VIR_DIR.DS.'views';			

					if ($handle = opendir($path)) { 

						foreach(scandir($path) as $entry){

							if ($entry != "." && $entry != ".." && $entry!='index.html') {

								$file=substr($entry,5,-4); ?>

								<?php if(!in_array($file, array("access_denied","default","change_profile","change_password","forgot_password","reset_password","generate_files","mould_addedit","mould_list","generate_files_single","mould_single_addedit","mould_single_list","generate_files_multiple","mould_multiple_addedit","mould_multiple_list"))){

									// get page label

									$file_label="";

									$obj_model_access = $this->load_model("menu_file_label");

									$rs_access = $obj_model_access->execute("SELECT",false,"","file_name='".$file."' AND status='Active' AND parameters=''","id ASC LIMIT 1");

									if(count($rs_access)>0){

										$file_label = $rs_access[0]['file_label'];	

									}

									?>

									<tr class="table_field_value" style="height:30px;">

										<td align="center" valign="middle"><input type="hidden" name="page_name[]" class="page_name"  id="pagename" value="<?php echo $file;?>" />

											<input type="hidden" name="parameters[]" class="parameters"  id="parametername" value="" />

											<?php echo $file; ?></td>

											<td align="center" valign="middle"><input type="text" name="file_label[]" class="form-control form-control-sm file_label word_text"  id="file_label" value="<?php echo $file_label;?>" onchange="update_file_label(this)" /></td>

										</tr>

            			<?php // get label for parameters

            $obj_model_access_param = $this->load_model("menu_file_label");

            $rs_access_param = $obj_model_access_param->execute("SELECT",false,"","file_name='".$file."' AND status='Active' AND parameters!=''","id ASC");

            foreach($rs_access_param as $access_param){ ?>

            	<tr class="table_field_value" style="height:30px;">

            		<td align="center" valign="middle"><input type="hidden" name="page_name[]" class="page_name"  id="pagename" value="<?php echo $file;?>" />

            			<input type="hidden" name="parameters[]" class="parameters"  id="parametername" value="<?php echo $access_param['parameters']; ?>" />

            			<?php echo $file."&".$access_param['parameters']; ?></td>

            			<td align="center" valign="middle"><input type="text" name="file_label[]" class="textbox file_label word_text"  id="file_label" value="<?php echo $access_param['file_label']; ?>" onchange="update_file_label(this)" /></td>

            		</tr>

            	<?php }



            }

          }

        }?>

        <?php closedir($handle);

      } ?>

      

    </table></td>

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

