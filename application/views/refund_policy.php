<style>
@media (max-width:1024px){
  #footer{margin-top: 271px;}
}

@media (max-width: 414px){
#footer {margin-top: 0px;}
}

@media (max-width:414px){
	.w-md {
		width: 330px !important;
	}
  
	.clear {
		width: 70% !important;
	}
}

@media (max-width:320px){
	.clear {
		width: 60% !important;
	}
}

video::-internal-media-controls-download-button {
    display:none;
}

video::-webkit-media-controls-enclosure {
    overflow:hidden;
}

video::-webkit-media-controls-panel {
    width: calc(100% + 30px); /* Adjust as needed */
}

@media(max-width: 768px){
	.w-md {
		width: 538px;
	}
	
}

</style>
<br />
<div class="col-md-9">
	<div class="blog-post">
		<div class="panel no-border">
			<div class="wrapper-lg">
				<h3>Refund policy</h3>
				<p>All payments are final. You may cancel your subscriptions at any time on a prorated basis, But we cann't refund for subscription time already passed.</p><br>
				<p>For inquiries about your acounts or our policies Please contact us at CS@IRWNetwork.com</p>
			</div>
		</div>
	</div>
	
	
</div>
<div class="col-md-3">
	<div class="col w-md bg-light dker b-l bg-auto no-border-xs">
		<div class="wrapper-md">
			<div class="m-b-sm text-md">Wrestle Zone</div>
			<ul class="list-group no-bg no-borders pull-in">
				<?php $i=0;foreach($rss_data as $row){?>
				<li class="list-group-item">
					<a herf="<?php echo $row['link'];?>" class="pull-left thumb-sm m-r" style="width:60px" target="_blank"><img src="<?php echo $row['image']?>" style="width:300px; !important"></a>
					<div class="clear">
						<div><a href="<?php echo $row['link'];?>" target="_blank"><?php echo substr($row['title'],0,50);?></a></div>
					</div>
				</li>
				<?php }?>
			</ul>
		</div>
	</div>
	
</div>
