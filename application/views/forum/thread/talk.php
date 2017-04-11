<link rel="stylesheet" href="<?php echo base_url(); ?>assets/resources/jquery/css/froala_editor.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/resources/jquery/css/froala_style.css"/>
<script src="<?php echo base_url(); ?>assets/resources/jquery/js/froala_editor.min.js" charset="utf-8"></script>
                    
<script>
	$(document).ready(function(){
		$('#textpost').froalaEditor();
	});
</script>

<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<ul class="nav">
            <script>
            $(function() {
                $('#btn-new-thread').click(function() {
                    window.location = '<?php echo site_url('forum/thread/create'); ?>';
                });
            });
            </script>
            <li><button id="btn-new-thread" class="btn btn-primary btn-mini">New Thread</button></li>
     </ul>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
        <div class="panel panel-default">
            <div class="panel-heading font-bold">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo site_url('forum/thread'); ?>">Home</a> <span class="divider"></span>
                    </li>
                    <?php $cat_total = count($cat); foreach ($cat as $key => $c): ?>
                    <li>
                        <a href="<?php echo site_url('thread/category/'.$c['slug']); ?>"><?php echo $c['name']; ?></a> 
                        <?php if ($key+1 != $cat_total): ?>
                        <span class="divider"></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
           <?php if (isset($tmp_success)): ?>
            <div class="alert alert-success">
                <a class="close" data-dismiss="alert" href="#">&times;</a>
                <h4 class="alert-heading">Reply posted!</h4>
            </div>
            <?php endif; ?>
            <?php if (isset($tmp_success_new)): ?>
            <div class="alert alert-success">
                <a class="close" data-dismiss="alert" href="#">&times;</a>
                <h4 class="alert-heading">New thread created!</h4>
            </div>
            <?php endif; ?>
    
            <div class="page-header">
                <h3 style="padding-left:10px;"><?php echo $thread->title; ?></h3>
            </div>
             
           <div class="panel-body">
           
           	<div class="row-fluid">
                <div class="col-sm-9">
            
                    <div class="page-header">
                        <h3><?php echo $thread->title; ?></h3>
                    </div>
                    
                    <?php
                    function time_ago($date) {
            
                        if(empty($date)) {
                            return "No date provided";
                        }
            
                        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
                        $lengths = array("60","60","24","7","4.35","12","10");
                        $now = time();
                        $unix_date = strtotime($date);
            
                        // check validity of date
            
                        if(empty($unix_date)) {
                            return "Bad date";
                        }
            
                        // is it future date or past date
                        if($now > $unix_date) {
                            $difference = $now - $unix_date;
                            $tense = "ago";
                        } else {
                            $difference = $unix_date - $now;
                            $tense = "from now";
                        }
                        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
                            $difference /= $lengths[$j];
                        }
                        $difference = round($difference);
                        if($difference != 1) {
                            $periods[$j].= "s";
                        }
            
                        return "$difference $periods[$j] {$tense}";
                    }
                    ?>
                       <?php foreach ($posts as $post): ?>
                        <div class="well" style="background-color:#fff;">
                            <?php echo $post->post; ?><br/><br/>    
                            
                            <ul class="nav nav-pills" style="float:left;">
                            <li class="dropdown" id="menu<?php echo $post->id; ?>">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#menu<?php echo $post->id; ?>" style="border: 1px solid #d9d9d9;font-size: 11px;">
                            Quote / Reply
                            <b class="caret"></b>
                            </a>
                            <ul class="active dropdown-menu">
                            
                            <li><form class="well" action="" method="post" style=" background-color:#fff;margin: 5px 10px;width: 600px;text-align: left;">
                                    <input type="hidden" name="row[thread_id]" value="<?php echo $thread->id; ?>"/>
                                    <input type="hidden" name="row[reply_to_id]" value="<?php echo $post->id; ?>"/>
                                    <input type="hidden" name="row[author_id]" value="<?php echo $this->ion_auth->user()->row()->id; ?>"/>
                                    <input type="hidden" name="row[date_add]" value="<?php echo date('Y-m-d H:i:s'); ?>"/>
                                    <textarea name="row[post]" class="textpostreply" cols="72" style="height:180px;" class="span12">                                 	<div style='font-size:11px; background: #e3e3e3;padding:5px;'>
                                            posted by <b>@<?php echo $post->username; ?></b>
                                            <p>
                                            	<i><?php echo preg_replace("/&#?[a-z0-9]+;/i","", strip_tags($post->post)); ?></i>
                                            </p>
                                        </div>
                                        <br/><br/>
 									</textarea>
                                    <input type="submit" style="margin-top:15px;font-weight: bold;" name="btn-post" class="btn btn-primary" value="Reply Post"/>
                                </form></li>
                            </ul>
                            </li>
                            </ul>
                            
                            <span style="font-size:11px;float:right;position: relative;top:14px;">
                                posted by <?php echo $post->username; ?>, <?php echo time_ago($post->date_add); ?>
                            </span>
                            <div class="clearfix" style="height: 30px;"></div>
            
                        </div>
                    <?php endforeach; ?>
            
            
                    <div class="pagination" style="text-align:center;">
                        <ul><?php echo $page; ?></ul>
                    </div>
            
                    <div class="page-header">
                        <h4>Reply Thread</h4>
                    </div>
                    
                    <form class="well" action="" method="post" >
                        <input type="hidden" name="row[thread_id]" value="<?php echo $thread->id; ?>"/>
                        <input type="hidden" name="row[reply_to_id]" value="0"/>
                        <input type="hidden" name="row[author_id]" value="<?php echo $this->ion_auth->user()->row()->id; ?>"/>
                        <input type="hidden" name="row[date_add]" value="<?php echo date('Y-m-d H:i:s'); ?>"/>
                        <textarea name="row[post]" class="span12" style="height:150px;"></textarea>
                        <input type="submit" style="margin-top:15px;font-weight: bold;" name="btn-post" class="btn btn-primary" value="Reply Post"/>
                    </form>
                </div>
            
                <div class="col-sm-3">
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="active">
                        <a href="javascript://"><b>Categories</b></a>
                        </li>
                        <?php foreach($categories as $cat): ?>
                        <li><a href="<?php echo site_url('forum/thread/category/'.$cat['slug']); ?>"><?php echo $cat['name']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>     
           </div>
        </div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url()?>assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript">

tinymce.init({
	selector: "textarea",
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste"
	],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>