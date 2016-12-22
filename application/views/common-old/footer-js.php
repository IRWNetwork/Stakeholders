<script src="<?php echo base_url(); ?>assets/libs/jquery/bootstrap/dist/js/bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/jquery/jquery_appear/jquery.appear.js"></script> 
<script src="<?php echo base_url(); ?>assets/js/landing.js"></script>
<script type="text/javascript">
$(document).ready(function($) {
    $(window).scroll(function () {
		var height = $('.logo').height();
        if ($(this).scrollTop() > 30 && height!='50') {
            $('.logo').animate({
				height: "50px",
			  }, 100, function() {
				// Animation complete.
			  });
        }
		if($(this).scrollTop() < 30) {
           $('.logo').animate({
				height: "90px",
			  }, 100, function() {
				// Animation complete.
			});
        }
    });
});
</script>