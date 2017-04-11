<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
	</div>
   
    <div class="modal fade" id="modalConfirm" role="dialog">
    <div   class="modal-dialog modal-sm">
      <div style="background-color:#fff;" class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 style="color:#000;"  class="modal-title">Delete Thread</h4>
        </div>
        <div class="modal-body">
        <p style="text-align: center;">
            Are you sure want to delete this thread ?
            <br/>
            <span style="font-weight: bold;color:#ff0000;font-size: 14px;" >All posts in this thread will be deleted</span>
        </p>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <a href="#" class="btn btn-default" data-dismiss="modal">Cancel</a>
            <a href="#" class="btn btn-primary" id="btn-delete">Delete</a>
        </div>
       </div>
      </div>
    </div>
     <?php if (isset($tmp_success)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">Thread updated!</h4>
    </div>
    <?php endif; ?>
    <?php if (isset($tmp_success_del)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">Thread deleted!</h4>
    </div>
    <?php endif; ?>
    <style>table td {padding:7px !important;vertical-align: middle !important;}</style>
    <script>
    $(function() {
        $('.linkviewtip').tooltip();
    });
    </script>
    
    <div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading"> <?php echo $page_heading?> </div>
			<div class="table-responsive">
                <style>table td {padding:7px !important;}</style>
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center;">No</th>
                            <th width="75%">Threads</th>
                            <th width="10%"></th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($threads as $key => $thread): ?>
                        <tr>
                        <td style="text-align:center;"><?php echo $key + 1 + $start; ?></td>
                        <td>
                            <a class="linkviewtip" title="Go to: <?php echo $thread->title; ?>" href="<?php echo site_url('forum/thread/talk/'.urlencode($thread->slug)); ?>"><?php echo $thread->title; ?></a>
                            <span style="display:block;font-size: 10px;font-style: italic;"><?php echo $thread->cat_name; ?></span>
                        </td>
                        <td style="text-align: center;"><a title="edit" href="<?php echo site_url('admin/forum/admin/thread_edit').'/'.$thread->id; ?>"><img src="<?php echo base_url(); ?>assets/image/pencil.png"/></a> </td>
                        <td style="text-align: center;"><a title="delete" class="del" id="thread_id<?php echo $thread->id; ?>" href="<?php echo site_url('admin/forum/admin/thread_delete').'/'.$thread->id; ?>"><img src="<?php echo base_url(); ?>assets/image/delete.png"/></a> </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                       
                    <div class="pagination" style="text-align:center;">
                        <ul><?php echo $page; ?></ul>
                    </div>
               	</div>
		</div>
	</div>
          
</div>
    <script>
    $(function() {
        $('#modalConfirm').modal({
            keyboard: true,
            backdrop: true,
            show: false
        });
        
        var cat_id;
        
        $('.del').click(function() {
            thread_id = $(this).attr('id').replace("thread_id", "");
            $('#modalConfirm').modal('toggle');
            return false;
        });
        
        $('#btn-delete').click(function() {
           window.location = '<?php echo site_url('admin/forum/admin/thread_delete'); ?>/'+thread_id;
        });
    })
    </script>
    