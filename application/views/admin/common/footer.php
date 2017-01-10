<footer id="footer" class="app-footer" role="footer">
	<div class="wrapper b-t bg-light"> <span class="pull-right">2.2.0 <a href ui-scroll="app" class="m-l-sm text-muted"><i class="fa fa-long-arrow-up"></i></a></span> &copy; 2017, IRW Network All Rights Reserved. </div>
</footer>
<script type="text/javascript">
$(document).ready(function(){
	$(".navbar-btn").click(function(){
		if($(this).hasClass("active")==true){
			$(".big_logo").show();
			$(".small_logo").hide();
		}else{
			$(".big_logo").hide();
			$(".small_logo").show();
		}
	});
});
</script>