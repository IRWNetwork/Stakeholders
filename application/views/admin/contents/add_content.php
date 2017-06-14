<link rel="stylesheet" media="all" type="text/css" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url()?>assets/css/jquery-ui-timepicker-addon.css" />
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading?></h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<form onsubmit="return my_submit(this)" class="bs-example form-horizontal" name="frm" method="post" enctype="multipart/form-data">
							<div class="col-md-12">
								<div class="form-group">
									<label class="col-lg-3 control-label">Title</label>
									<div class="col-lg-6">
										<textarea onkeyup="countCharacter('content_title','remaning_title_character','100')" id="content_title" maxlength="100" class="form-control" name="title"><?php if(isset($contentRow['title'])){ echo $contentRow['title']; }?></textarea>
                                        <div id="remaning_title_character">100</div> Character
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Type</label>
									<div class="col-lg-6">
										<select name="type" class="form-control m-b" id="type">
											<option value="'">Select Type</option>
											<option value="Video">Video</option>
											<!----<option value="Audio">Audio</option>----->
											<option value="Article">Article</option>
											<option value="Podcasts">Podcasts</option>
										</select>
										<?php if(isset($contentRow['type'])){?>
										<script type="text/javascript">
											document.frm.type.value='<?php echo $contentRow['type']?>';
										</script>
										<?php }?>
									</div>
								</div>
								<div class="form-group" id="video_type" style="display:none">
									<label class="col-lg-3 control-label">Video Type</label>
									<div class="col-lg-6">
										<div class="radio">
											<label class="i-checks">
												<input type="radio" name="video_type" required value="url" onchange="showVideo(this.value)" checked="checked">
												<i></i> File
											</label>
											<label class="i-checks">
												<input type="radio" name="video_type" required value="embed_code" onchange="showVideo(this.value)" <?php if(isset($contentRow['embed_code']) && $contentRow['embed_code']=='embed_code'){ echo "checked"; }?> >
												<i></i> Embed Code
											</label>
										</div>
									</div>
								</div>
                                <div class="form-group">
									<label class="col-lg-3 control-label">Show Date</label>
									<div class="col-lg-6">
										<input type="text" class="form-control" name="show_date" id="show_date" value="<?php if(isset($contentRow['show_date'])){ echo $contentRow['show_date']; }?>" placeholder="Show Date">
									</div>
								</div>
								<div class="form-group" id="is_premium">
									<label class="col-lg-3 control-label">Is Preimum</label>
									<div class="col-lg-6">
										<label class="i-switch i-switch-md bg-info m-t-xs m-r">
											<input type="checkbox" value="yes" name="is_premium" <?php if(isset($contentRow['is_premium'])){ echo "checked"; }?>>
											<i></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label">Is Featured</label>
									<div class="col-lg-6">
										<label class="i-switch i-switch-md bg-info m-t-xs m-r">
											<input type="checkbox" value="yes" name="is_featured" <?php if(isset($contentRow['is_featured'])){?> checked <?php }?> />
											<i></i>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">Content Thumbnail</label>
									<div class="col-sm-9">
										<input type="file" name="picture" />
									</div>
								</div>
								<div class="form-group" id="file">
									<label class="col-sm-3 control-label">Content File (Limit 5GB)</label>
									<div class="col-sm-9">
										<input type="file" name="file" />
									</div>
								</div>
								<div class="form-group" id="embed_code" style="display:none">
									<label class="col-sm-3 control-label">Youtube Embedcode</label>
									<div class="col-sm-9">
										<input type="text" name="embed_code" class="form-control" value="<?php if(isset($contentRow['embed_code'])){ echo $contentRow['embed_code']; }?>" />
									</div>
								</div>
                                <div class="form-group">
									<label class="col-lg-3 control-label">Content Text</label>
									<div class="col-lg-9">

										<textarea  id="description" class="form-control" placeholder="Give detail of video"><?php if(isset($contentRow['description'])){ echo $contentRow['description']; }?></textarea>
                                       <textarea name="description" style="display: none;" id="set_desp"></textarea>
									</div>
								</div>
                                <div class="form-group">
									<label class="col-sm-3 control-label">Meta Keywords</label>
									<div class="col-sm-9">
										<input type="text" name="meta_keywords" class="form-control" value="<?php if(isset($contentRow['meta_keywords'])){ echo $contentRow['meta_keywords']; }?>" />
                                        <span>separate meta tags with a comma</span>
									</div>
								</div>
                                <div class="form-group">
									<label class="col-sm-3 control-label">Meta Description</label>
									<div class="col-sm-9">
										<input type="text" name="meta_description" onkeyup="countCharacter('meta_description','remaning_meta_description_character','150')" id="meta_description" class="form-control" value="<?php if(isset($contentRow['meta_description'])){ echo $contentRow['meta_description']; }?>" />
                                        <span id="remaning_meta_description_character">150</span> Characters
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-offset-3 col-lg-1">
										<button type="submit" class="btn btn-sm btn-info" id="show_load">
											Save
										</button>
									</div>
								 <!--	<div class="col-lg-2">
										<div class="loader_div">
											<img src="<?php echo base_url(); ?>uploads/files/g_upload.gif" width="100">
											<span>Please Wait...</span>
										</div>
									</div>-->
                                    <div class="col-lg-6">

										<div class="form-group">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                                            </div>
                    
                                            <div class="msg"></div>
                                        </div>

									</div> 
                                    
									<!-- <div class="col-lg-2">
										<div class="loader_div">
											<progress></progress>
										</div>
									</div> -->
								</div>
                                <div class="form-group">
                                <div class="load_danger"></div>
                                </div>
                                
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="load_respons" style="display: none;"></div>
<script type="text/javascript" src="<?php echo base_url()?>assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
function countCharacter(fieldid,textid,total){
	var str = $("#"+fieldid).val();
	$("#"+textid).html(parseInt(total)-str.length);
}
countCharacter('content_title','remaning_title_character','100');
countCharacter('meta_description','remaning_meta_description_character','150');
tinymce.init({
    selector: "textarea#description",
    plugins: [
		"wordcount",
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
	statusbar: true,
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
<script type="text/javascript">
	$(document).ready(function(){
	   
        window.setTimeout(function(){
        console.log($("#description_ifr").contents().find("#tinymce").html());
        $("#description_ifr").contents().find("#tinymce").html("");
         console.log($("#description_ifr").contents().find("#tinymce").html());
       },1500);
	  
       
		$("#type").change(function(){
			var val = $("#type").val();
			showHideVideoContent(val);
			if(val=='Article'){
				$( "#file" ).fadeOut( 500, "linear" );
			}else{
				$( "#file" ).fadeIn( 200, "linear" );
			}
		});
		<?php if(isset($contentRow['type']) && $contentRow['type']!=''){?>
		$("#type").trigger("change");
		showVideo("<?php echo $contentRow['video_type'] ?>");
		<?php }?>
	});
	
	function showHideVideoContent(val){
		if(val=='Video'){
			$("#video_type").fadeIn( 500, "linear" );
		}else{
			$("#video_type").fadeOut( 500, "linear" );
		}
	}
	function showVideo(type){
		if(type=='embed_code'){
			$("#file").fadeOut( 500, "linear" );
			$("#is_premium").fadeOut(500, "linear");
			$("#embed_code").fadeIn( 500, "linear" );
		}else{
			$( "#file" ).fadeIn( 200, "linear" );
			$("#is_premium").fadeIn(500, "linear");
			$("#embed_code").fadeOut( 500, "linear" );
		}
	}

	$("#show_load").click(function() {
	    console.log("ahahah"+$("#description").val());
		$(".loader_div").show("slow");
       //	$(this).addClass('disabled');
	});
    function my_submit(obj) {
 	    var set_desp = $("#description_ifr").contents().find("#tinymce").html();
        $("#set_desp").val(set_desp);
		$('.myprogress').css('width', '0');
                    $('.msg').text('');
                   
                    var formData = new FormData(obj);
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: '<?php echo base_url(); ?>/admin/content/addcontent',
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 98);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css('width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').text('');
                            if(data!="true"){
                                $(".load_danger").html("<div class='alert alert-danger'>"+data+"</div>");
                                $(".load_danger").find(".app-header-fixed").remove();
                            }
                            if(data=="true"){
                                $(".load_danger").html("");
                                 window.location.href = '<?php echo base_url(); ?>admin/content';
                                 
                            }
                            $('.myprogress').text('100%');
                            $('.myprogress').css('width','100%');
                            //window.location.reload();
                            
                        }
                    });
	    return false;
	}
    
    
</script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#show_date').datepicker({
		dateFormat: 'mm-dd-yy'
	});
});
</script>


