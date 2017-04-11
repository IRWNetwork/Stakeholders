
<?php if(count($contents)){ ?>
<?php $count=0;foreach($contents as $row){?>
<li class="list-group-item">
    <!-- <div class="pull-right m-l"> <a ><i class="icon-close"></i></a> </div> -->
    <?php 
       $url = $this->Common_model->getUrl($row);
       $data_for = $url;
       $my_href = 'javascript:void(0)';
       $item_play = 'item_play';
        if($row->type=='Video' || $row->type=='Text'){
    ?>
        <a class="m-r-sm pull-left play_list_song <?php echo $item_play; ?>" type="<?php echo $row->type; ?>" data-for="<?php echo $data_for; ?>" href="<?php echo $my_href; ?>"> <i class="icon-control-play text" style="position: absolute;left: 22px;top: 22px;color:#fff"></i> <i class="icon-control-pause text-active" style="position: absolute;left: 22px;top: 22px;color:#fff"></i>
        <img src="<?php echo base_url() ."uploads/listing/".$row->picture; ?>" width="30">
        </a>
        <div class="clear text-ellipsis"><a class="m-r-sm pull-left play_list_song <?php echo $item_play; ?>" type="<?php echo $row->type; ?>" data-for="<?php echo $data_for; ?>"  href="<?php echo $my_href; ?>"><span><?php echo substr($row->title,0,35)?></span></a></div>
    <?php }else{?>
    <a class="m-r-sm pull-left play_list_song <?php echo $item_play; ?>" data-image="<?php echo $row->picture; ?>" data-title="<?php echo $row->title; ?>" data-song="<?php echo $row->file_url; ?>" href="<?php echo $my_href; ?>" type="<?php echo $row->type; ?>" type="<?php echo $row->type; ?>" data-for="<?php echo $data_for; ?>" data-fullText="<?php echo $row->title; ?>" ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }"> <i class="icon-control-play text" style="position: absolute;left: 22px;top: 22px;color:#fff"></i> <i class="icon-control-pause text-active" style="position: absolute;left: 22px;top: 22px;color:#fff"></i><img src="<?php echo base_url() ."uploads/listing/".$row->picture; ?>"  width="30"></a>
    <div class="clear text-ellipsis"><a class="m-r-sm pull-left play_list_song <?php echo $item_play; ?>" data-image="<?php echo $row->picture; ?>" data-title="<?php echo $row->title; ?>" type="<?php echo $row->type; ?>" data-for="<?php echo $data_for; ?>"   data-song="<?php echo $row->file_url; ?>" href="<?php echo $my_href; ?>" data-fullText="<?php echo $row->title; ?>" ng-click="mediaPlayer.playPause(<?php echo $count; ?>)" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }"><span><?php echo substr($row->title,0,35)?></span></a></div>
    <?php }?>
</li>
<?php ++$count;}?>
<?php }else{
    echo "<li class=\"list-group-item\"><p style='padding-left:15px;'> No Record Found.</p></li>";
}?>
       