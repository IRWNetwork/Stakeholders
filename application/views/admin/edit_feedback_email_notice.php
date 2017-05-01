<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading?></h1>
	</div>
	<div class="wrapper-md" >
    
		<div class="row">
        
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
					<div class="panel-body">
					<?php if(isset($msg) && $msg!=''){?>
                        <div class="success_message"><?php echo $msg; ?></div>
                        <?php }?>
                        <div class="x_content">
                            <div class="x_panel">
                            <?php if(isset($success) && $success!=''){?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                            <?php }if(validation_errors() || isset($error)) {?>
                            <div class="clear"></div>
                            <div class="alert alert-danger"><?php echo validation_errors(); echo isset($error) ? $error : ''; ?></div>
                            <?php }?>
                            <form method="post" action="" id="demo-form2" class="form-horizontal form-label-left">
                                 <div class="item form-group">
                                        <label for="notice" class="control-label col-md-3 col-sm-3 col-xs-12">Notice Email</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="email" required="required" name="email_notice" id="notice"  value="<?php echo isset($feed_back_notice_email) ? $feed_back_notice_email : '';?>" class="form-control">
                                        </div>
                                    </div>
           
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="sumbit" class="btn btn-success">Update</button>
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

	