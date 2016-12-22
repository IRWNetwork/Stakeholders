<?php $this->load->view('admin/common/common-header');?>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <?php $this->load->view('admin/common/left-nav');?>
            <!-- top navigation -->
            <?php $this->load->view('admin/common/top-nav');?>           
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="x_content content">
                    <div class="page-title">
                        <div class="title_left">
                            <h3><?php echo $page_heading;?></h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
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
                        <form method="post" action="" id="demo-form2" class="form-horizontal form-label-left"  enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo isset($userDetail['id']) ? $userDetail['id'] : '';?>">
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="prepaid_expiry_duration">Prepaid Expire Duration<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="prepaid_expiry_duration" name="prepaid_expiry_duration" class="form-control col-md-7 col-xs-12" value="<?php echo $prepaid_expiry_duration;?>" />
                                </div>
                            </div>
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="text_message_reply_limit">Text Message Limit<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="text_message_reply_limit" name="text_message_reply_limit" class="form-control col-md-7 col-xs-12" value="<?php echo $text_message_reply_limit;?>" />
                                </div>
                            </div>
							<div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="live_streaming_cost_per_mint">Live streaming cost per mint $<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="live_streaming_cost_per_mint" name="live_streaming_cost_per_mint" class="form-control col-md-7 col-xs-12" value="<?php echo $live_streaming_cost_per_mint;?>" />
                                </div>
                            </div>
							
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="email" name="email" required class="form-control col-md-7 col-xs-12" value="<?php echo $email;?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="phone" name="phone" required class="form-control col-md-7 col-xs-12" value="<?php echo $phone;?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="address" name="address" required class="form-control col-md-7 col-xs-12" value="<?php echo $address;?>" />
                                </div>
                            </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="file_size_limit">File Size Limit in MB <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="file_size_limit" name="file_size_limit" required class="form-control col-md-7 col-xs-12" value="<?php echo $file_size_limit;?>" />
                                </div>
                            </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="audio_size_limit">Audio Size Limit in MB <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="audio_size_limit" name="audio_size_limit" required class="form-control col-md-7 col-xs-12" value="<?php echo $audio_size_limit;?>" />
                                </div>
                            </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="video_size_limit">Video Size Limit in MB <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="video_size_limit" name="video_size_limit" required class="form-control col-md-7 col-xs-12" value="<?php echo $video_size_limit;?>" />
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
                <div class="clear"></div>
                <!-- footer content -->
                <?php $this->load->view('admin/common/footer');?>
                <!-- /footer content -->
            </div>
            <!-- /page content -->
        </div>
    </div>
    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>
</body>
</html>
<script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
<!-- bootstrap progress js -->
<script src="<?php echo base_url()?>assets/js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="<?php echo base_url()?>assets/js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="<?php echo base_url()?>assets/js/icheck/icheck.min.js"></script>
<script src="<?php echo base_url()?>assets/js/custom.js"></script>
<!-- dropzone -->
<script src="<?php echo base_url()?>assets/js/validator/validator.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/dropzone/dropzone.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery.colorbox-min.js"></script>
<script>
    // initialize the validator function
    validator.message['date'] = 'not a real date';
    // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
    $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);
    $('.multi.required')
        .on('keyup blur', 'input', function () {
            validator.checkField.apply($(this).siblings().last()[0]);
        });
    // bind the validation to the form submit event
    //$('#send').click('submit');//.prop('disabled', true);
    $('form').submit(function (e) {
        e.preventDefault();
        var submit = true;
        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
            submit = false;
        }
        if (submit)
            this.submit();
        return false;
    });
    /* FOR DEMO ONLY */
    $('#vfields').change(function () {
        $('form').toggleClass('mode2');
    }).prop('checked', false);
    $('#alerts').change(function () {
        validator.defaults.alerts = (this.checked) ? false : true;
        if (this.checked)
            $('form .alert').remove();
    }).prop('checked', false);
</script>
<script type="text/javascript">
     $(document).ready(function(){
        //Examples of how to assign the Colorbox event to elements
        $(".group1").colorbox({rel:'group1'});
    });
</script>
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