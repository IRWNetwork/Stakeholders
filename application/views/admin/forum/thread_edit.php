<div class="app-content-body">  
    <div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
	</div>
    <div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
					<div class="panel-body">
                    <?php if (isset($tmp_success)): ?>
                        <div class="alert alert-success">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <h4 class="alert-heading">User created!</h4>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($error)): ?>
                        <div class="alert alert-error">
                            <a class="close" data-dismiss="alert" href="#">&times;</a>
                            <h4 class="alert-heading">Error!</h4>
                            <?php if (isset($error['title'])): ?>
                                <div>- <?php echo $error['title']; ?></div>
                            <?php endif; ?>
                            <?php if (isset($error['slug'])): ?>
                                <div>- <?php echo $error['slug']; ?></div>
                            <?php endif; ?>  
                            <?php if (isset($error['category'])): ?>
                                <div>- <?php echo $error['category']; ?></div>
                            <?php endif; ?>  
                            <?php if (isset($error['post'])): ?>
                                <div>- <?php echo $error['post']; ?></div>
                            <?php endif; ?>  
                        </div>
                        <?php endif; ?>
						<form name="frm" class="form-horizontal" method="post" action="">
                        <input type="hidden" name="row[id]" value="<?php echo $thread->id; ?>"/>
						<script>
                        $(function() {
                            $('#title').change(function() {
                                var title = $('#title').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                                $('#slug').val(title);
                            });
                        });
                        </script>
                        
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="title" name="row[title]" value="<?php echo $thread->title; ?>" required="required" class="form-control col-md-7 col-xs-12" />
                                </div>
                            </div>
                            
                             <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Slug (url friendly)<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="slug" name="row[slug]" title="<?php echo site_url('thread/talk/'.$thread->slug); ?>" value="<?php echo $thread->slug; ?>" disabled="disabled" class="form-control col-md-7 col-xs-12" />
                                </div>
                            </div>
                            <div class="form-group" >
                                <label for="select01" class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="select01" name="row[category_id]" class="form-control">
                                        <option value="0">-- none --</option>  
										<?php foreach ($categories as $cat): ?>
										<?php if ($cat['id'] == $thread->category_id): ?>
                                            <option selected="selected" value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                        <?php endif; ?>
                                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <input type="submit" name="btn-save" class="btn btn-primary" value="Save Thread"/>
                                </div>
                            </div>
                          </form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
