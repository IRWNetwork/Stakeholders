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
                        <?php $this->load->view('common/messages');?><br />
						<p>IRW Network is proud to offer Stripe as our payment platform, which allows us to automatically calculate and distribute royalties from the payment processor level. Click Below button to connect with Stripe so you can get paid from your content!</p>
                        <?php if($user_row->stripe_user_id!=''){?><p class="alert alert-success">You already Connect Stripe Account</p><?php }?>
                        <?php if($url){?>
                        <a href="<?php echo $url;?>"><img src="<?php echo base_url()?>assets/images/stripe.png" /></a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>