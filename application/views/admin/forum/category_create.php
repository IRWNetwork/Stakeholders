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
						<?php $this->load->view('admin/common/messages');?>
						<form class="form-horizontal" method="post" action="">
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
                                <h4 class="alert-heading">New category added!</h4>
                            </div>
                            <?php endif; ?>
                            <script>
                            $(function() {
                                $('#name').change(function() {
                                    var name = $('#name').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                                    $('#slug').val(name);
                                });
                            });
                            </script>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" name="row[name]" required="required" class="form-control col-md-7 col-xs-12" />
                                </div>
                            </div>
                            
                             <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Slug<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="row[slug]" id="slug" required="required" class="form-control col-md-7 col-xs-12" />
                                </div>
                            </div>
                            <div class="form-group" >
                                <label for="select01" class="control-label col-md-3 col-sm-3 col-xs-12">Parent</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="select01" name="row[parent_id]" class="form-control">
                                        <option value="0">-- none --</option>  
										<?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
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
                                    <input type="submit" name="btn-create" class="btn btn-primary" value="Create Category"/>
                                </div>
                            </div>
                          </form>
					</div>
				</div>
			</div>
		</div>
	</div>
    
          
</div>