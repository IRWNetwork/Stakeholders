<link rel="stylesheet" href="<?php echo base_url(); ?>assets/resources/jquery/css/froala_editor.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/resources/jquery/css/froala_style.css"/>
<script src="<?php echo base_url(); ?>assets/resources/jquery/js/froala_editor.min.js" charset="utf-8"></script>
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Create New Thread</h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
        <div class="panel panel-default">
            <div class="panel-heading font-bold">Create New Thread</div>
            <div class="panel-body">
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
                <form class="well form-horizontal" action="" method="post">
                <script type="text/javascript">
                    $(function() {
                        $('#title').change(function() {
                            var title = $('#title').val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                            $('#slug').val(title);
                        });
                    });
                </script>
                <label>Title</label>
                <input type="text" id="title" name="row[title]"  placeholder="">
                <label>Slug (url friendly)</label>
                <input type="text" id="slug" name="row[slug]"  placeholder="">
                <label>Category</label>
                <select  name="row[category_id]">
                    <option value="0">-- none --</option>  
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
               	<div style="padding-top:6px;">
                <label>First Post</label>
                <textarea name="row_post[post]" id="firstpost"  rows="8" ></textarea>
                <input type="submit" style="margin-top:15px;font-weight: bold;" name="btn-create" class="btn btn-primary btn-large" value="Create Thread"/>
                </div>
                </form>
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