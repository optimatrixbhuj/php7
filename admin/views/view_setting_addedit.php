<?php $this->addJS("js/jquery/croppie.js");

  $this->addCSS("js/jquery/croppie.css"); ?>

<script type="text/javascript">

  $(document).ready(function() {

	// validate signup form on keyup and submit

	var validator = $("#frm_setting_addedit").validate({

		rules: {

			object_value: "required",

		},

		messages: {

			object_value: "Please Enter Value",

		},

		submitHandler: function (form) {

      $(form).find("#save,input[type=submit]").attr("disabled", true)

      $(form).find("#save_txt").text("Wait...");

      <?php if(in_array($this->setting[0]['id'],array(10,11))){ ?>

      if($("#object_value").val()!=''){

        $uploadCrop.croppie('result', {

          type: 'canvas',

          size: 'viewport',

          format: $("#image_type").val()

        }).then(function (resp) {       

          $(form).find("#photo").val(resp); 

          form.submit();      

        });

      }else{

        form.submit();

      }

    <?php }else{ ?>

			form.submit();

    <?php } ?>

    },

		// the errorPlacement has to take the table layout into account

		errorPlacement: function(error, element) {

			if ( element.is(":radio") )

				error.appendTo( element.parent().next());

			else if ( element.is(":checkbox") )

				error.appendTo( element.parent().next());

			else

				error.appendTo( element.parent().next() );

		},

		

	});

	$("input:button").button();

	$("input:submit").button();

  $("#object_value").focus();

});

</script>

<?php include("includes/header.php") ?>







<div class="content pt-3">

	<div class="container-fluid">

		<div class="card card-primary card-outline">

			

			<?php $this->htmlBuilder->buildTag("form", array("action"=>"","class"=>"frm_addedit"), "frm_setting_addedit");?>

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>$this->id), "id");?>

			<?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden", "value"=>"addedit_data"), "act");?>

		

		

				<div class="card-header">
					<div class="row mb-2">
						<div class="col-md-6">
				        		<h1><?php echo ucfirst($this->manager_for)?> Manager [<?php echo $this->to_do;?>]</h1>
				        	</div>
				        	<div class="col-md-6">
				        		<div class="actionBtns text-right">				  

				   

				   <button class="btn btn-o btn-sm btn-primary"><i class="fa fa-save mr-1"></i> <span id='save_txt'>Save</span></button>

					

					<div class="btn btn-o btn-sm btn-primary" onclick="window.location.href='index.php?view=setting_list'"><i class="fa fa-times-circle mr-1" title="Close"></i><span>Close</span></div>

					

					<div class="btn btn-o btn-sm btn-primary" onclick="javascript:location.reload(true)"><i class="fa fa-sync mr-1" title="Refresh"></i><span>Refresh</span></div>

				   

				   

				   

				</div>
				        	</div>
					</div>
				</div>





		

		

		

  <div class="card-body mb-0">

	<?php echo $this->utility->get_message()?>

	<div class="form-group row">

		<label class="col-sm-3">Field</label>

		<div class="col-sm-9">

			<?php echo $this->setting[0]['object_field']; ?>

		</div>

	</div>

	

	<div class="form-group row">

		<label class="col-sm-3">Value</label>

		<div class="col-sm-9">

			<?php if(in_array($this->setting[0]['id'],array(10,11))){ ?>

              <?php $this->htmlBuilder->buildTag("input", array("type"=>"file", "class"=>"form-control","onchange"=>"event.preventDefault(); read_url_croppie(this);"), "object_value");?>

			  

              

			  <div id="upload-icon" style="width:350px;display:none;"></div>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "photo");?>

                <?php $this->htmlBuilder->buildTag("input", array("type"=>"hidden"), "image_type");?>

                <div id="show_image"><?php if($this->icon!=''){ echo $this->icon; } ?></div>

             

            <?php }else if(in_array($this->setting[0]['id'], array("7","8"))){ ?>

              <?php 

              $object_value=array("On"=>"On","Off"=>"Off");

              $this->htmlBuilder->buildTag("select", array("values"=>$object_value, "class"=>"form-control"), "object_value");?>

            

          <?php }else{ ?>

            <?php $this->htmlBuilder->buildTag("input", array("type"=>"text", "class"=>"form-control".(!in_array($this->setting[0]['id'],array("2","3"))?" allow_num":"")), "object_value");?>

              <?php if(in_array($this->setting[0]['id'], array("2","3"))){ ?><code>Please Enter Comma Separated Value for multiple Values</code><?php } ?>

            

          <?php } ?>

		</div>

	</div>

	

	<div class="form-group row">

		<label class="col-sm-3">Description</label>

		<div class="col-sm-9">

			<?php $this->htmlBuilder->buildTag("textarea", array("class"=>"form-control","style"=>"text-transform: capitalize;"), "description");?>

		</div>

	</div>

	

	<div class="form-group row">

		<label class="col-sm-3"></label>

		<div class="col-sm-9">

			<input class="btn btn-primary" type="submit" id="save" name="save" value="SAVE" />

		</div>

	</div>

  

	

    

    

  <?php $this->htmlBuilder->closeForm()?>

 



	<div id="push" ></div>

</div>

</div>

	</div>

</div>

<?php include("includes/footer.php") ?>

<?php if(in_array($this->setting[0]['id'],array(10,11))){ ?>

<script type="text/javascript">

  $uploadCrop = $('#upload-icon').croppie({

    enableExif: true,

    viewport: {

      width: 300,

      height: 300,       

    },

    boundary: {

      width: 400,

      height: 400

    }

  });

  function read_url_croppie(input) {  

    var files = !!input.files ? input.files : []; 

  if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support



  if (/^image/.test( files[0].type)){ // only image file

    $('#upload-icon').show();

    var type=(files[0].type).split("/").pop();

    //alert(type);

    var reader = new FileReader(); // instance of the FileReader

    reader.readAsDataURL(files[0]); // read the local file



    reader.onload = function(e){ 

      $uploadCrop.croppie('bind', {

        url: e.target.result

      }).then(function(){

        //console.log('jQuery bind complete');

        $("#image_type").val(type);

      });

    }   

  }else{

    $.alert({

      title: 'Alert!',

      icon:'glyphicon glyphicon-info-sign',

      content:"Please Upload only Image",

      theme: 'skin-blue',

      confirm: function(){        

      }});

    input.value="";

  }

}

</script>

<?php } ?>