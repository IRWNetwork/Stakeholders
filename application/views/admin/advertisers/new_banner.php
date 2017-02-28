<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading?></h1>
	</div>
	<div class="wrapper-md" ng-controller="FormDemoCtrl">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading font-bold"><?php echo $page_heading;?></div>
					<div class="panel-body">
						<?php $this->load->view('admin/common/messages');?>
						<form method="post" name="frm" class="form-horizontal form-label-left"  enctype="multipart/form-data" novalidate>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullname"><?php echo $advertiser_name; ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left">
                                       <b>Jhon</b>
                                       <input type="hidden" name="advertiserid" value="<?php echo $advertiser_id; ?>">
                                    </label>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullname">Banner Type</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="radio" name="type" value="image" checked="checked" onclick="show('image')"/> Image Banner
                                    <input type="radio" name="type" value="flash"  onclick="show('flash')"/> Flash Banner
                                    <input type="radio" name="type" value="adsense"  onclick="show('adsense')"/> Google Adsense
                                     <input type="radio" name="type" value="video"  onclick="show('video')"/> Video
                                </div>
                            </div>
                            <div class="item form-group" id="name">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fullname">Name</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" placeholder="Name" name="name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($advertiser['name']) ? $advertiser['name'] : '';?>" />
                                </div>
                            </div>
                            <div class="item form-group" id="url">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">URL</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="url" placeholder="URL" value="<?php if(isset($advertiser['url'])){ echo $advertiser['url']; }?>" class="form-control"  required>
                                </div>
                            </div>
                            <div class="item form-group" id="target">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="target">Targer</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                   <!--  <input type="text" name="url" placeholder="URL" value="<?php if(isset($advertiser['url'])){ echo $advertiser['url']; }?>" class="form-control"  required> -->
                                    <select name="target" class="form-control">
                                        <option value="_blank">_blank</option>
                                        <option value="_parent">_parent</option>
                                        <option value="_self">_self</option>
                                        <option value="_top">_top</option>
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group" id="alt">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alt">ALT</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="alt" placeholder="ALT" value="<?php if(isset($advertiser['alt'])){ echo $advertiser['alt']; }?>" class="form-control">
                                </div>
                            </div>
                            <div class="item form-group"  id="file">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="banner_file">Banner File</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="banner_file" placeholder="Address" value="<?php if(isset($advertiser['banner_file'])){ echo $advertiser['banner_file']; }?>" class="form-control">
                                </div>
                            </div>
                            <div class="item form-group" id="adsense" style="display: none;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="banner_file">Adsense Code</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="adsense_code" rows="10" style="width:370px"></textarea>
                                </div>
                            </div>
                            <div class="item form-group" id="size" style="display: none;">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="banner_file">Size: </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="width" value="" size="3" maxlength="3" /> X <input type="text" name="height" value="" size="3" maxlength="3" /> (Pixels)
                                </div>
                            </div>
                            <div class="item form-group" id="video_type" style="display: none">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="banner_file">Video Type: </label>
                                <div class="radio">
                                    <label class="i-checks">
                                        <input type="radio" name="video_type" required value="video_file" onchange="showVideo(this.value)" checked="checked">
                                        <i></i> Video File
                                    </label>
                                    <label class="i-checks">
                                        <input type="radio" name="video_type" required value="embed_code" onchange="showVideo(this.value)">
                                        <i></i> Embed Code
                                    </label>
                                </div>
                            </div>
                            <div class="item form-group" id="video_file" style="display: none">
                                <label class="col-sm-3 control-label">Video File</label>
                                <div class="col-sm-9">
                                    <input type="file" name="video_file" />
                                </div>
                            </div>
                            <div class="item form-group" id="embed_code" style="display:none">
                                <label class="col-sm-3 control-label">Youtube Embedcode</label>
                                <div class="col-sm-9">
                                    <textarea name="embed_code" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url()?>assets/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    function show(what){

        var adv=document.getElementById('advertiser');
        var name=document.getElementById('name');
        var url=document.getElementById('url');
        var target=document.getElementById('target');
        var alt=document.getElementById('alt');
        var file=document.getElementById('file');
        var adsense=document.getElementById('adsense');
        var size=document.getElementById('size');
        var video=document.getElementById('video');
        var video_type=document.getElementById('video_type');
        var video_file=document.getElementById('video_file');
        
        if(what=='adsense'){
            url.style.display='none';
            target.style.display='none';
            alt.style.display='none';
            file.style.display='none';
            adsense.style.display='';
            size.style.display='';
            video_file.style.display='none';
            video_type.style.display='none';
        }
        else if(what=='flash'){
            url.style.display='';
            target.style.display='';
            alt.style.display='';
            file.style.display='';
            adsense.style.display='none';            
            size.style.display='';
            video_file.style.display='none';
            video_type.style.display='none';
        }
        else if(what=='video'){
            url.style.display='none';
            target.style.display='none';
            alt.style.display='none';
            file.style.display='none';
            adsense.style.display='none';
            video_type.style.display='';
            video_file.style.display='';
        }
        else{
            url.style.display='';
            target.style.display='';
            alt.style.display='';
            file.style.display='';
            adsense.style.display='none';           
            size.style.display='none';
            video_type.style.display='none';
            video_file.style.display='none';
        }
        //document.form1.name.focus();
    }

    function showVideo(type){
        if(type=='embed_code'){
            $("#video_file").fadeOut( 500, "linear" );
            $("#embed_code").fadeIn( 500, "linear" );
        }else{
            $( "#video_file" ).fadeIn( 200, "linear" );
            $("#embed_code").fadeOut( 500, "linear" );
        }
    }
</script>