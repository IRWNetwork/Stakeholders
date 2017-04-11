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
						<form class="form-horizontal" method="post" action="">
                         <input type="hidden" name="row[id]" value="<?php echo $category->id; ?>"/>
                         <input type="hidden" name="row[name_c]" value="<?php echo $category->name; ?>"/>
                         <input type="hidden" name="row[slug_c]" value="<?php echo $category->slug; ?>"/>
						   <?php if (isset($error)): ?>
                            <div class="alert alert-error">
                                <a class="close" data-dismiss="alert" href="#">&times;</a>
                                <h4 class="alert-heading">Error!</h4>
                                <?php if (isset($error['name'])): ?>
                                    <div>- <?php echo $error['name']; ?></div>
                                <?php endif; ?>
                                <?php if (isset($error['slug'])): ?>
                                    <div>- <?php echo $error['slug']; ?></div>
                                <?php endif; ?>  
                            </div>
                            <?php endif; ?>  
                            <?php if (isset($tmp_success)): ?>
                            <div class="alert alert-success">
                                <a class="close" data-dismiss="alert" href="#">&times;</a>
                                <h4 class="alert-heading">Category updated!</h4>
                            </div>
                            <?php endif; ?>

                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" value="<?php echo $category->name; ?>" name="row[name]" required="required" class="form-control col-md-7 col-xs-12" />
                                </div>
                            </div>
                            
                             <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Slug<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" value="<?php echo $category->slug; ?>" name="row[slug]" id="slug" required="required" class="form-control col-md-7 col-xs-12" />
                                	 <p class="help-block">for url friendly address</p>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label for="select01" class="control-label col-md-3 col-sm-3 col-xs-12">Parent</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="select01" name="row[parent_id]" class="form-control">
										<option <?php if ($category->id == 0): ?>selected="selected"<?php endif; ?> value="0">-- none --</option>  
										<?php foreach ($categories as $cat): ?>
                                        <?php if ($category->id != $cat['id']): ?>
                                        <option <?php if ($category->parent_id == $cat['id']): ?>selected="selected"<?php endif; ?> value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                        <?php else: ?>
                                        <option disabled style="background:#d3d3d3;" value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if(isset($pageDetail['type'])){?>
                                    <script type="text/javascript">
                                        document.frm.row[parent_id].value='<?php echo $pageDetail["type"] ?>';
                                    </script>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <input type="submit" name="btn-edit" class="btn btn-primary" value="Save"/>
                                </div>
                            </div>
                          </form>
					</div>
				</div>
			</div>
		</div>
	</div>
        
</div>