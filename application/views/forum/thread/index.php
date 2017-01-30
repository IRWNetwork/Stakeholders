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
					<?php if ($type == 'category'): ?>
                    <li>
                        <a href="<?php echo site_url('forum/thread'); ?>">Home</a>
                        <span class="divider"></span>
                    </li>
                    <?php $cat_total = count($cat); foreach ($cat as $key => $c): ?>
                    <li>        
                        <a href="<?php echo site_url('forum/thread/category/'.$c['slug']); ?>"><?php echo $c['name']; ?></a> 
                        <?php if ($key+1 != $cat_total): ?>
                        <span class="divider"></span>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <li>
                        <a href="<?php echo site_url('forum/thread'); ?>">Home</a>
                    </li>
                    <?php endif; ?>
               </ul>
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
            <div class="panel-body">
                <table class="table table-bordered table-striped table-condensed">
                    <thead>
                        <tr>
                            <th width="70%">All Threads</th>
                            <th width="10%">Posts</th>
                            <th width="10%">Topics</th>
                            <th width="10%">Last Updates</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($threads as $thread): ?>
                        <tr>
                        <td style="font-size:12px;">
                            <a style="font-family: verdana;" href="<?php echo site_url('forum/thread/talk/'.$thread->slug); ?>"><?php echo $thread->title; ?></a>
                            <span style="display: block">
                                <a href="<?php echo site_url('forum/thread/category/'.$thread->category_slug); ?>" class="cat">Category: <?php echo $thread->category_name; ?></a>
                            </span>
                        </td>
                        <td> {Posts}</td>
                        <td>{topices}</td>
                        <td style="font-size:12px;color:#999;vertical-align: middle;">
                            <!-- <?php echo date("m/d/y g:i A", strtotime($thread->date_add)); ?> -->
                            <?php echo time_ago($thread->date_add); ?>
                        </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                    <div class="col-md-12"><?php echo $page; ?></div>
                </div>
        </div>
	</div>
</div>