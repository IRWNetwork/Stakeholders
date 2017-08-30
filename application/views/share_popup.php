<div class="modal-dialog">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
	<div class="modal-content">
		<div class="modal-body">
			<div class="request-quote">
				<div class="pop-holder">
					<div class="js-preview share-dialog__preview">
						<div class="preview preview--album"> <img class="preview__image preview__image--album" id="popup_image" src="<?php echo base_url()?>uploads/listing/thumb_153_<?php echo $dataRow['picture']?>" data-bind-image="albumCover" width="65" height="65">
							<div class="preview__meta-data">
								<div class="preview__title">
									<div class="h6 preview__name" data-bind="title" id="popup_title"><?php echo $dataRow['title']?></div>
								</div>
								<div class="preview__number-of-items js-number-of-items"></div>
							</div>
						</div>
					</div>
					<div class="share-dialog__content">
						<?php 
								if($dataRow['type']=='Video'){
									$url = base_url()."home/playvideo?id=".$dataRow['id'];
								}else if($dataRow['type']=='Text'){
									$url = base_url()."home/showArticle?id=".$dataRow['id'];
								}else{ 
									$url = base_url()."home/playaudio?id=".$dataRow['id'];
								}
							?>
						<input type="text" id="popup_textbox" value="<?php echo $url;?>" placeholder="<?php echo $url;?>" class="share-dialog__copiable">
						<ul class="link-holder">
							<li>
								<a href="javascript:void(0)" onclick='window.open("https://www.facebook.com/share.php?u=<?php echo $url?>&title=<?php echo str_replace("'", "", $dataRow['title']);?>&picture=<?php echo base_url()?>uploads/listing/thumb_469_<?php echo $dataRow['picture']?>", "sharer", "toolbar=0,status=0,width=548,height=325")'> <button type="submit" class="btn">Facebook</button></a>
							</li>
							<li>
								<!-- <a class="btn" href="http://twitter.com/intent/tweet?text=<?php echo $dataRow['title']; ?>+<?php echo $url?>" >Twitter</a> -->
								<a class="btn" href="http://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo urlencode($dataRow['title'])?>" >Twitter</a>
							</li>
                            <li>
								<a href="javascript:void(0)" onclick="show_code();" > <button type="submit" class="btn">Embed Code</button></a>
							</li>
							<!--<li>
								<button type="submit" class="btn">Embed</button>
							</li>-->
						</ul>
                        <div id="embed_code" style=" display:none; text-align:center;color:#fff;">
                        	&lt;iframe width="100%" height="450" scrolling="no" frameborder="no" src="<?php echo base_url()?>embed/play/<?php echo $dataRow['id'];?>"&gt;&lt;/iframe&gt;
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		function show_code(){
			$("#embed_code").hide(1000);
		}
	});
</script>
<script type="text/javascript">

$(".close").on("click", function(){
    $("#share-pop").css("display", "none");
});
</script>
<script>
  window.fbAsyncInit = function(){
FB.init({
    appId: '114379515845260', status: true, cookie: true, xfbml: true }); 
};
(function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    if(d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; 
    js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
    ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));
function postToFeed(title, desc, url, image){
var obj = {method: 'feed',link: url, picture: image,name: title,description: desc};
function callback(response){}
FB.ui(obj, callback);
}

  $('.btnShare').click(function(){
elem = $(this);
postToFeed(elem.attr('data-title'), elem.attr('data-desc'), elem.attr('my-href'), elem.attr('data-image'));

return false;
});
</script>
