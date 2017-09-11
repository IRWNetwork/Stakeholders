<header id="header" class="app-header navbar" role="menu"> 
		<!-- navbar header -->
		<div class="navbar-header bg-dark">
			<button class="pull-right visible-xs dk" ui-toggle-class="show" target=".navbar-collapse"> <i class="glyphicon glyphicon-cog"></i> </button>
			<button class="pull-right visible-xs" ui-toggle-class="off-screen" target=".app-aside" ui-scroll="app"> <i class="glyphicon glyphicon-align-justify"></i> </button>
			<!-- brand --> 
			<a href="<?php echo base_url();?>" class="navbar-brand text-lt">
				<span class="big_logo"><img src="<?php echo base_url()?>assets/images/logo.png" /></span>
				<span class="small_logo" style="display:none"><img src="<?php echo base_url()?>assets/images/logo-small.png" /></span>
			</a> 
			<!-- / brand --> 
		</div>
		<!-- / navbar header --> 
		
		<!-- navbar collapse -->
		<div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only"> 
			<!-- buttons -->
			<div class="nav navbar-nav hidden-xs"> 
				<a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="app-aside-folded" target=".app"> <i class="fa fa-dedent fa-fw text"></i> <i class="fa fa-indent fa-fw text-active"></i> </a> 
				<!-- <a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="show" target="#aside-user"> <i class="icon-user fa-fw"></i> </a>  -->
			</div>
			<!-- / buttons --> 
			
			<!-- link and dropdown -->
			
			<!-- / link and dropdown --> 
			
			<!-- search form -->
			<div class="navbar-form navbar-form-sm navbar-left shift" <?php if($this->router->fetch_class() == 'forum'){?> action="<?php echo site_url('home') ?>" <?php }?>>
				<div class="form-group">
					<div class="input-group">
						<input id="search" type="text" name="search" class="form-control input-sm bg-light no-border rounded padder" placeholder="Search">
						<span class="input-group-btn">
							<a class="btn btn-sm bg-light rounded">
								<i class="fa fa-search"></i>
							</a>
						</span>
					</div>
				</div>
			</div>
			<!-- / search form --> 
			<?php if (!$this->ion_auth->logged_in()) {?>
			<ul class="nav navbar-nav navbar-right">
				
				<li>
					<div class="m-t-sm"> 
						<a href="<?php echo base_url()?>user/login" class="btn btn-link btn-sm">Sign in</a> or 
						<a href="<?php echo base_url()?>user/register/1" class="btn btn-sm btn-success btn-rounded m-l"><strong>Sign up</strong></a> &nbsp;
					</div>
				</li>
			</ul>
            
			<?php }else{?>
			<!-- nabar right -->
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown"> 
					<a href="#" data-toggle="dropdown" class="dropdown-toggle clear">
					<?php if($this->session->userdata('profile_pic')!=''){?>
					<span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
					<img src="<?php echo base_url().'uploads/profile_pic/'.$this->session->userdata('profile_pic'); ?>" alt="..."> <i class="on md b-white bottom"></i>
					</span> 
					<?php }?>
					<span class="hidden-sm hidden-md"><?php echo $this->session->userdata('uname');?></span> <b class="caret"></b>
					</a> 
					<!-- dropdown -->
					<ul class="dropdown-menu animated fadeInRight w">
						<li> <a href="<?php echo base_url()?>user/profile">Profile</a> </li>
						<?php if ($this->session->userdata('userGroup') != 4) { ?>
	                        <li>
	                        	<a href="<?php echo base_url()?>user/dashboard">Dashboard</a>
	                        </li>
	                        <!-- <li> 
	                        	<a href="<?php echo base_url()?>user/upgradepackage">Become Permium User</a>
	                        </li> -->
	                        <li>
	                        	<a href="<?php echo base_url()?>user/paymenthistory">Payment History </a>
	                        </li>
                            <?php if ($this->session->userdata('userGroup') != 2) { ?>
	                        <li>
	                        	<a href="<?php echo base_url()?>user/subscribechannel">Your Subscriptions
	                        	</a>
	                        </li> 
                            <?php }?>
                        <li>
                        	<a href="<?php echo base_url()?>feedback">Feedback</a>
                        </li>
                        <?php } ?>
                        <?php if ($this->session->userdata('userGroup') == 4) { ?>
                        	<li>
	                        	<a href="<?php echo base_url()?>advertisement/addAdvertisement">
	                        		Add Advertisement
	                        	</a>
	                        </li>
                        	<li>
	                        	<a href="<?php echo base_url()?>advertisement">Your Ads</a>
	                        </li>
	                        <li>
	                        	<a href="<?php echo base_url()?>feedback">Your Billing</a>
	                        </li>
                        <?php } ?>

                        <?php if($this->ion_auth->get_users_groups()->row()->id == 3){ ?>
                            <li> <a href="<?php echo base_url()?>content">Your Content</a> </li>
                            <li> <a href="<?php echo base_url()?>content/addcontent">Add Content</a> </li>
                            <li><a href="<?php echo base_url()?>stats/Analytics">Analytics</a></li>
                            <!--<li> <a href="<?php echo base_url()?>user/payment_report">Royalities</a> </li>-->

                            <li> <a href="<?php echo base_url()?>stats/analytics_list">Analytics List</a></li>
                            <li> <a href="<?php echo base_url()?>content/addContentByCsv">Batch Upload</a></li>

                            <!--<li> <a href="<?php echo base_url()?>user/bankingInformation">Banking information</a></li>-->
                            <li> <a href="<?php echo base_url()?>user/connectStrip">Connect Stripe for payment</a></li>
                        <?php } ?>

						<?php if($this->ion_auth->in_group(3) && $this->ion_auth->get_users_groups()->row()->id == 2 && $this->session->userdata('is_approved') == 1){ ?>
							<li> <a href="<?php echo base_url()?>content">Your Content</a> </li>
							<li> <a href="<?php echo base_url()?>content/addcontent">Add Content</a> </li>
							<li> <a href="<?php echo base_url()?>stats/Analytics">Analytics</a> </li>
						<?php } ?>


						<li> <a href="<?php echo base_url()?>user/changepassword">Change Password </a> </li>
						<li class="divider"></li>
						<li> <a href="<?php echo base_url()?>user/logout">Logout</a> </li>
					</ul>
					<!-- / dropdown --> 
				</li>
			</ul>
			<!-- / navbar right --> 
			<?php }?>
		</div>
		<!-- / navbar collapse --> 
	</header>
	<script>
	$(function() {
		$('body').click(function(e) {
			if($( document ).width()<790){
			$(".app-aside").removeClass('off-screen');
			}
		});

		//Ajax Search

		$('#search').keypress(function(e) {
	        if (e.which == 13) {
	        	var search_item = $(this).val();
	            $.ajax({
			        url: BASE_URL+"home",
			        type: "get",
			        data: {search:search_item, flag:1},
			        success: function (response) {
			        	 if (response != "") {
			        	 	if (response != "") {
			        	 		$("#content").empty();
								$(".loader").show().delay(2000).fadeOut();
								$("#content").append(response);
							}
			        	 }
			        }
			    });
	        }
	    });
	});
	</script>