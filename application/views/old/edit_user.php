<?php $this->load->view('admin/common/common-header');?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery.datetimepicker.css"/>
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
                    <?php if(isset($msg)){?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                    <?php }?>
                    <div class="x_content">
                        <div class="x_panel">
                        <?php
                            if(isset($success)){
                        ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php }
                            if(validation_errors() || isset($error)) {
                        ?>
                        <div class="clear"></div>
                        <div class="error_message"><?php echo validation_errors(); echo isset($error) ? $error : ''; ?></div>
                        <?php }?>
                        <form method="post" name="frm" action="" id="demo-form2" class="form-horizontal form-label-left" novalidate>
                            <input type="hidden" name="id" value="<?php echo isset($userDetail['id']) ? $userDetail['id'] : '';?>">
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="firstname" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($userDetail['firstname']) ? $userDetail['firstname'] : '';?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Last Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="lastname" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($userDetail['lastname']) ? $userDetail['lastname'] : '';?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="last-name" name="email" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($userDetail['email']) ? $userDetail['email'] : '';?>" />
                                </div>
                            </div>
                            
                            <div class="item form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="password" required="required" value="<?php echo isset($userDetail['password']) ? $userDetail['password'] : '';?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Address </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="address" value="<?php echo isset($userDetail['address']) ? $userDetail['address'] : '';?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Country </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="country" class="form-control" onChange="show_states(this.value)">
                                    <?php 
                                        $c = unserialize(COUNTRIES);
                                        foreach($c as $key=>$val){
                                    ?>
                                    <option value="<?php echo $key?>"><?php echo $val;?></option>
                                    <?php } ?>
                                    </select>
                                    <script type="text/javascript">
                                        <?php if(isset($userDetail['country'])){?>
                                        document.frm.country.value="<?php echo $userDetail['country']?>";
                                        <?php }else{?>
                                        document.frm.country.value='US';
                                        <?php }?>
                                    </script>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">City</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="city" value="<?php echo isset($userDetail['city']) ? $userDetail['city'] : '';?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">State </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="states_drop_down">
                                        <select name="state" class="form-control">
                                        <?php 
                                            $s = unserialize(STATES);
                                            foreach($s as $key=>$val){
                                        ?>
                                        <option value="<?php echo $key?>"><?php echo $val;?></option>
                                        <?php } ?>
                                        </select>
                                        <script type="text/javascript">
                                            <?php if(isset($userDetail['state'])){?>
                                            document.frm.state.value="<?php echo $userDetail['state']?>";
                                            <?php }else{?>
                                            document.frm.state.value='US';
                                            <?php }?>
                                        </script>
                                    </div>
                                    <div id="states_text_box" style="display:none">
                                        <input type="text" name="state2" class="form-control" placeholder="State" value="<?php echo isset($userDetail['state']) ? $userDetail['state'] : '';?>">
                                    </div>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Zipcode </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="zipcode" value="<?php echo isset($userDetail['zipcode']) ? $userDetail['zipcode'] : '';?>" />
                                </div>
                            </div>
                            <div class="item form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="phone" required="required" value="<?php echo isset($userDetail['phone']) ? $userDetail['phone'] : '';?>" />
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
<!-- chart js -->
<script src="<?php echo base_url()?>assets/js/chartjs/chart.min.js"></script>
<!-- bootstrap progress js -->
<script src="<?php echo base_url()?>assets/js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="<?php echo base_url()?>assets/js/nicescroll/jquery.nicescroll.min.js"></script>
<!-- icheck -->
<script src="<?php echo base_url()?>assets/js/icheck/icheck.min.js"></script>
<script src="<?php echo base_url()?>assets/js/custom.js"></script>
<script src="<?php echo base_url()?>assets/js/validator/validator.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.datetimepicker.full.js"></script>
<script src="<?php echo base_url()?>assets/js/validator/validator.js"></script>
<script>
    $(document).ready(function(){
        $('input[name="free_user"]').on('ifClicked', function (event) {
            if(this.value=='yes'){
                $("#trail_period").fadeIn();
            }else{
                $("#trail_period").fadeOut();
            }
        });
        // if($("#yo").pro("checked")){
        //     alert("welcome");
        // }
        //alert('adf');
        // $(".radio_trail").click(function(){
        //     alert('adf');
        // })
    });
    $('#single_cal4').datetimepicker({ 
        
        format: 'Y-m-d A g:i',
        formatTime: 'A g:i'
    });
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
    function show_states(val){
        if(val=='US'){
            $("#states_text_box").css('display','none');
            $("#states_drop_down").css('display','');
        }else{
            $("#states_text_box").css('display','');
            $("#states_drop_down").css('display','none');
        }
    }
    <?php if(isset($userDetail['country'])){?>
    show_states('<?php echo $userDetail["country"];?>');
    <?php }?>
</script>