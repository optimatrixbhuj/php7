<link rel="stylesheet" href="js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
<style type="text/css">
.content-upload {
	min-height: 300px;
	height: auto;
	border: 1px dotted #ccc;
	padding: 10px;
	cursor: move;
	margin-bottom: 10px;
	position: relative;
}
h1, h5 {
	padding: 0px;
	margin: 0px;
}
h1.title {
	font-family: 'geneva', bold;
	padding: 10px;
}
h5 {
	width: 95%;
	line-height: 25px;
}
</style>
<script type="text/javascript" src="js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript">
$(function(){
	function log(){
		var str = "";
		plupload.each(arguments, function(arg){
			var row = "";
			if(typeof(arg) != "string"){
				plupload.each(arg, function(value, key){
					if(arg instanceof plupload.File){
						switch (value){
							case plupload.QUEUED:
								value = 'QUEUED';
								break;
							case plupload.UPLOADING:
								value = 'UPLOADING';
								break;
							case plupload.FAILED:
								value = 'FAILED';
								break;
							case plupload.DONE:
								value = 'DONE';
								break;
						}
					}
					if(typeof(value) != "function") {
						row += (row ? ', ': '') + key + '=' + value;
					}
				});
				str += row + " ";
			}else{ 
				str += arg + " ";
			}
		});
		$('#log').val($('#log').val() + str + "\r\n");
	}
	$("#uploader").pluploadQueue({
		// General settings
		runtimes: 'html5,gears,browserplus,silverlight,flash,html4',
		url: '../scripts/ajax/upload_trans_images.php',
		max_file_size: '10mb',
		chunk_size: '1mb',
		unique_names: true,
		
		filters: [
			{title: "Image files", extensions: "jpg,gif,png,jpeg"},
			{title: "Zip files", extensions: "zip"}
		],
		// Flash/Silverlight paths
		flash_swf_url: 'js/plupload.flash.swf',
		silverlight_xap_url: 'js/plupload.silverlight.xap',
		preinit: {
			Init:function(up, info){
				log('[Init]', 'Info:', info, 'Features:', up.features);
			},
			UploadFile: function(up, file){
				log('[UploadFile]', file);
			}
		},
		init: {
			Refresh: function(up){
				log('[Refresh]');
			},
			StateChanged: function(up){
				log('[StateChanged]', up.state == plupload.STARTED ? "STARTED": "STOPPED");
			},
			QueueChanged: function(up){
				log('[QueueChanged]');
			},
			UploadProgress: function(up, file) {
				log('[UploadProgress]', 'File:', file, "Total:", up.total);
			},
			FilesAdded: function(up, files){
				log('[FilesAdded]');
				plupload.each(files, function(file){
					log('  File:', file);
				});
			},
			FilesRemoved: function(up, files){
				log('[FilesRemoved]');
				plupload.each(files, function(file){
					log('  File:', file);
				});
			},
			FileUploaded: function(up, file, info) {
				var names;
				var files_name=$('#files_name').val();
				if(files_name!=''){
					names=files_name+","+info.response;
				}else{
					names=info.response;
				}
				$('#files_name').val(names);
				log('[FileUploaded] File:', file, "Info:", info);
			},
			ChunkUploaded: function(up, file, info){
				log('[ChunkUploaded] File:', file, "Info:", info);
			},
			Error: function(up, args){
				if(args.file){
					log('[error]', args, "File:", args.file);
				} else {
					log('[error]', args);
				}
			}
		}
	});
	$('#log').val('');
	$('#clear').click(function(e) {
		e.preventDefault();
		$("#uploader").pluploadQueue().splice();
		$('.plupload_buttons').css("display","block");
		$('.plupload_upload_status').css("display","none");
		$('.plupload_total_file_size').html("0 b");
		$('.plupload_total_status').css("0%");
	});
});
</script>
<div class="content-upload" id="content_upload">
  <h2>Multiple Drag and Drop Files Upload(Max size 1 MB)</h2>
  <div id="uploader">Your browser doesn't support upload.</div>
  <a id="clear" href="#">Clear queue</a></div>
