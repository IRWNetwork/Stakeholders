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
						<form method="post" name="frm" action="" id="demo-form2" class="form-horizontal form-label-left" novalidate>
                            <input type="hidden" name="id" value="<?php echo isset($pageDetail['id']) ? $pageDetail['id'] : '';?>">
                            <div class="form-group" style="display:none">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="type" id="type" class="form-control">
                                        <option value="header">Header</option>
                                        <option value="footer">Footer</option>
                                        <option value="hidden">Hidden</option>
                                        <option value="both">Both Header and Footer</option>
                                    </select>
                                    <?php if(isset($pageDetail['type'])){?>
                                    <script type="text/javascript">
                                        document.frm.type.value='<?php echo $pageDetail["type"] ?>';
                                    </script>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="title" name="title" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($pageDetail['title']) ? $pageDetail['title'] : '';?>" />
                                </div>
                            </div>
							 
							
                            
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Meta Keyword <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="meta_keyword" name="meta_keyword" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($pageDetail['meta_keyword']) ? $pageDetail['meta_keyword'] : '';?>" />
                                </div>
                            </div>
                            
                            
                                <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Meta Title <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="meta_title" name="meta_title" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($pageDetail['meta_title']) ? $pageDetail['meta_title'] : '';?>" />
                                </div>
                            </div>
                            
                            
                                <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Meta Description <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="meta_description" name="meta_description" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($pageDetail['meta_description']) ? $pageDetail['meta_description'] : '';?>" />
                                </div>
                            </div>
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Slug <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="title" name="slug" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($pageDetail['slug']) ? $pageDetail['slug'] : '';?>" />
                                </div>
                            </div>
							 
                            
                            <div class="item form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Description <span class="required">*</span></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea name="body" id="descr" class="form-control" style="height:300px"><?php echo isset($pageDetail['body']) ? $pageDetail['body'] : '';?></textarea>
                                </div>
                            </div>
						 
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>

                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url()?>assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>
