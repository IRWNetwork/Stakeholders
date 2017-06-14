<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url()?>assets/css/jquery-ui-timepicker-addon.css" />
<style>
.fl { float: left !important; }
.fr { float: right !important; }
.clear { clear: both !important; height: 0 !important; }
label { line-height: 43px; font-size:20px;padding-right:20px; color:#000 !important } /*vertical-align: 14px;*/
.about-me { width:969px /*1000px*/; margin: 0px auto; background: #fff; padding: 40px 0 }
.about-me h1 { padding: 0px 0 0px 40px; color: #626262; font-size: 35px; font-weight: normal !important; }
.about-me h2 { padding: 15px 0 0px 40px; color: #666; font-weight: normal !important }
.about-name { width: 1003px; margin: 0px auto; background: #FFE6CD; padding: 30px 0 }
.about-name h1 { padding: 0px 0 20px 40px; color: #666969; font-weight: bold; }
.size-desc { padding: 40px 0 70px 0px; background: #fff }
.size-desc h1 { padding: 0px 0 20px 40px; color: #666969; font-weight: bold; }
.about-name input[type="text"] { padding: 5px 10px; border: solid 1px #a9a9a9; transition: box-shadow 0.3s, border 0.3s; }
.about-name textarea { padding: 10px; border: solid 1px #878787; transition: box-shadow 0.3s, border 0.3s; height: 140px; }
.about-name input[type="text"].focus { border: solid 1px #878787; }
.about-name p { font-size: 15px; line-height: 20px }

</style>
<div class="app-content-body">
    <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3"><?php echo $page_heading?></h1>
    </div>
    <div class="wrapper-md" ng-controller="FormDemoCtrl">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading font-bold"><?php echo $page_heading;?></div>
                    <div class="panel-body">
                        <?php $this->load->view('common/messages');?>
                        <form class="bs-example form-horizontal" name="frm" method="post" >
                            <div class="col-md-12">
                            	<div class="form-group">
                                	<label class="col-lg-3 control-label">&nbsp;</label>
                                    <?php ini_set('dispaly_errors',0);error_reporting(0);$member_merchent_row = array();?>
                                	<div class="col-lg-6">
                                        <input type="radio" name="account" class="individual" value="individual" onClick="show_individual()" <?php if ($member_merchent_row['account_type']=='individual' || $_REQUEST['account']=='individual') {echo "checked='checked'";}?> />
                                        Individual
                                        <input type="radio" name="account" class="business" value="business" <?php if ($member_merchent_row['account_type']=='business' || $_REQUEST['account']=='business') {echo "checked='checked'";}?> onClick="show_business()" />
                                        Business
                                    </div>
                                </div>
                               	<div class="individual_account">
                                	<h1>Individual&#58 </h1>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">First</label>
                                        <div class="col-lg-6">
                                            <input type="text" name="firstname" class="form-control" value="<?php if (isset($_REQUEST['firstname'])) {echo $_REQUEST['firstname'];} else {echo $row['fname'];}?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Lastname</label>
                                        <div class="col-lg-6">
                                            <input type="text" name="lastname" class="form-control" value="<?php if (isset($_REQUEST['lastname'])) {echo $_REQUEST['lastname'];} else {echo $row['lastname'];}?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Birthdate</label>
                                        <div class="col-lg-6">
                                            <input type="text" name="birth_day" id="show_date" class="form-control" value="<?php if (isset($_REQUEST['birth_day'])) {echo $_REQUEST['birth_day'];} else {echo $row['birth_day'];}?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Email</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="email" class="form-control" value="<?php if (isset($_REQUEST['email'])) {echo $_REQUEST['email'];} else {echo $row['email'];}?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Phone</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="buss_mobile" class="form-control" value="<?php if (isset($_REQUEST['buss_mobile'])) {echo $_REQUEST['buss_mobile'];} else {echo $row['buss_mobile'];}?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">SSN</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="ssn" class="form-control" placeholder="XXX-XXX-XXXX" value="<?php if (isset($_REQUEST['ssn'])) {echo $_REQUEST['ssn'];} ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Street Address</label>
                                        <div class="col-lg-6">
                                           <input type="tet" name="street_address" class="form-control" placeholder="" value="<?php if (isset($_REQUEST['street_address'])) {echo $_REQUEST['street_address'];} ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">City</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="city" class="form-control" value="<?php if (isset($_REQUEST['city'])) {echo $_REQUEST['city'];} ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">State</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="state" class="form-control" value="<?php if (isset($_REQUEST['state'])) {echo $_REQUEST['state'];} ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Zip</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="zip" class="form-control" value="<?php if (isset($_REQUEST['zip'])) {echo $_REQUEST['zip'];} ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Country</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="country" class="form-control" value="<?php if (isset($_REQUEST['country'])) {echo $_REQUEST['country'];} ?>" />
                                        </div>
                                    </div>
								</div>
                                <div class="business_account">
                                	<h1>Business&#58 </h1>
                               	 	<div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Legal Name</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="legal_name" class="form-control" value="<?php if (isset($_REQUEST['legal_name'])) {echo $_REQUEST['legal_name'];} else {echo $row['legal_name'];}?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">DBA Name</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="dba_name" class="form-control" value="<?php if (isset($_REQUEST['dba_name'])) {echo $_REQUEST['dba_name'];} else {echo $row['dba_name'];}?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Tax Id</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="tax_id" class="form-control" value="<?php if (isset($_REQUEST['tax_id'])) {echo $_REQUEST['tax_id'];} else {echo $row['tax_id'];}?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Street Address</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="buss_street_address" class="form-control" value="<?php if (isset($_REQUEST['buss_street_address'])) {echo $_REQUEST['buss_street_address'];} else {echo $row['buss_street_address'];}?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">State</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="buss_state" class="form-control" value="<?php if (isset($_REQUEST['buss_state'])) {echo $_REQUEST['buss_state'];} ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Zip</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="buss_zip" class="form-control" value="<?php if (isset($_REQUEST['buss_zip'])) {echo $_REQUEST['buss_zip'];} ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="message" class="col-lg-3 control-label">Country</label>
                                        <div class="col-lg-6">
                                           <input type="text" name="buss_country" class="form-control" value="<?php if (isset($_REQUEST['buss_country'])) {echo $_REQUEST['buss_country'];} ?>" />
                                        </div>
                                    </div>
                                </div>
                                <h1>Payout Information&#58 </h1>
                                <div class="form-group">
                                    <label for="message" class="col-lg-3 control-label">Email</label>
                                    <div class="col-lg-6">
                                       <input type="text" name="buss_email" class="form-control" value="<?php if (isset($_REQUEST['buss_email'])) {echo $_REQUEST['buss_email'];} ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="message" class="col-lg-3 control-label">Mobile Phone</label>
                                    <div class="col-lg-6">
                                       <input type="text" name="phone" class="form-control" value="<?php if (isset($_REQUEST['phone'])) {echo $_REQUEST['phone'];} ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="message" class="col-lg-3 control-label">Account Number</label>
                                    <div class="col-lg-6">
                                       <input type="text" name="buss_acc_num" class="form-control" value="<?php if (isset($_REQUEST['buss_acc_num'])) {echo $_REQUEST['buss_acc_num'];} ?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="message" class="col-lg-3 control-label">Routing Number</label>
                                    <div class="col-lg-6">
                                       <input type="text" name="buss_routing_num" class="form-control" value="<?php if (isset($_REQUEST['buss_routing_num'])) {echo $_REQUEST['buss_routing_num'];} ?>" />
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <div class="col-lg-offset-3 col-lg-1">
                                        <button type="submit" class="btn btn-sm btn-info" id="show_load">Save</button>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="loader_div">
                                            <img src="<?php echo base_url(); ?>uploads/files/g_upload.gif" width="100">
                                            <span>Please Wait...</span>
                                        </div>
                                    </div>
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
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script> 
<script type="text/javascript">
	function validate(f){
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		if(f.firstname.value==''){
			alert("Please Enter First name");
			f.firstname.focus();
			return false;
		}else if(f.lastname.value==''){
			alert("Please Enter Last name");
			f.lastname.focus();
			return false;
		}else if(f.month.value==''){
			alert("Please Enter Month");
			f.month.focus();
			return false;
		}else if(f.day.value==""){
			alert("Please Enter Day");
			f.day.focus();
			return false;
		}else if(f.year.value==""){
			alert("Please Enter year");
			f.year.focus();
			return false;
		}else if(f.email.value==''){
			alert("Please enter email");
			f.email.focus();
			return false;
		}else if(!filter.test(f.email.value)){
			alert("Please Enter a valid E-mail address");
			f.email.focus();
			return false;
		}else if(f.phone.value==''){
			alert("Please enter Phone");
			f.phone.focus();
			return false;
		}else if (f.address.value=='') {
			alert("Please enter address");
			f.address.focus();
			return false;
		}else if (f.state.value=='') {
			alert("Please enter State");
			f.state.focus();
			return false;
		}else if (f.zip.value=='') {
			alert("Please Enter Zip");
			f.zip.focus();
			return false;
		}else if (f.country.value=='') {
			alert("Please Enter Country");
			f.country.focus();
			return false;
		}/*else if (f.descriptor.value=='') {
			alert("Please Enter Funding descriptor");
			f.descriptor.focus();
			return false;
		}*/else if (f.funding_email.value=='') {
			alert("Please Enter Funding Email");
			f.funding_email.focus();
			return false;
		}else if (!filter.test(f.funding_email.value)) {
			alert("Please Enter Valid Funding Email Address");
			f.funding_email.focus();
			return false;
		}else if (f.mobile_phone.value=='') {
			alert("Please Enter Mobile Phone");
			f.mobile_phone.focus();
			return false;
		}else if (f.account_number.value=='') {
			alert("Please Enter Account Number");
			f.account_number.focus();
			return false;
		}else if (f.routing_number.value=='') {
			alert("Please Enter Routing Number");
			f.routing_number.focus();
			return false;
		}else{
			f.command.value='add';
			return true;
		}
	}	
</script>
<script type="text/javascript">
	$('.individual_account').hide();
	function show_individual() {
		var n=$('.individual').is(':checked');
		if (n) {
			$('.individual_account').css("display", "block");
			$('.both_type').css("display", "block");
			$('.business_account').css("display", "none");
			$('.social_security_number').css("display", "block");
		} else {
			$('.individual_account').css("display", "none");
			$('.both_type').css("display", "none");
			$('.business_account').css("display", "none");
		}
	}
	function show_business() {
		var n=$('.business').is(':checked');
		if (n) {
			$('.business_account').css("display", "block");
			$('.individual_account').css("display", "block");
			$('.both_type').css("display", "block");
			$('.social_security_number').css("display", "none");
		} else {
			$('.individual_account').css("display", "none");
			$('.both_type').css("display", "none");
			$('.business_account').css("display", "none");
		}
	}
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#show_date').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script>
