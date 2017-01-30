<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Channel Marketplace</h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
        <div class="panel panel-default">
            <div class="panel-heading font-bold">Channel Marketplace</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50%">Channel Name</th>
                            <th width="50%">Subscription Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($channelData){
                         foreach($channelData as $value){ ?>
                        <tr>
                            <td width="50%"><?php echo $value['channel_name']; ?></td>
                            <td width="50%"><?php echo $value['channel_subscription_price']; ?>$</td>
                        </tr>
                        <?php } 
                        }
                        else{?>
                        <tr>
                            <td colspan="2">No Record Found.</td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
</div>