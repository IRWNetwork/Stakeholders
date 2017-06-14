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
				<p>You can reach IRWNetwork for most purposes at CS@IRWNetwork.com</p>
				<p>IRW network is a subsidiary of Binge Indy, LLC</p>
				Columbia, TN 38401 PH 9316262045
				<form>
				<table class="table">
					<tr>
						<td>
							Name
						</td>
						<td>
							<input required="required" type="text" class="form-control" name="name">
						</td>
					</tr>
					<tr>
						<td>
							Email
						</td>
						<td>
							<input type="email" required="required" class="form-control" name="name">
						</td>
					</tr>
					<tr>
						<td>
							Subject
						</td>
						<td>
							<input type="text" class="form-control" name="name">
						</td>
					</tr>
					<tr>
						<td>
							Message
						</td>
						<td>
							<textarea name="message" required="required" class="form-control"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;
						</td>
						<td>
							<input type="submit" name="send" value="Send" class="btn btn-info btn-sml">
						</td>
					</tr>
				</table>
				</form>
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
