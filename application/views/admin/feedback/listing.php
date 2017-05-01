<!-- content -->
<script type="text/javascript">
    function formSubmit(e){
        if(e.keyCode === 13){
            $('#search').submit();

        }
    }
</script>
<div class="app-content-body ">
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3"><?php echo $page_heading;?></h1>
        <div style=" margin-top:-24px;float:right; width:40%" class="input-group">
          <span class="input-group-addon input-sm"><i class="fa fa-search"></i></span>
          <form id="search" method='post'>
          	<input name="name" onkeypress="formSubmit(event)"  class="form-control input-sm ng-pristine ng-valid ng-empty ng-touched" placeholder="search" aria-invalid="false" type="text">
          </form>  
        </div>
	</div>
	<div class="wrapper-md">
		<div class="panel panel-default">
			<div class="panel-heading"> <?php echo $page_heading?> </div>
			<div class="table-responsive">
				<div class="col-md-12"><br />
					<?php $this->load->view('admin/common/messages');?>
				</div>
				<table id="example" class="table table-striped responsive-utilities jambo_table">
					<thead>
						<tr class="headings">
							<th>&nbsp;</th>
							<th>From</th>
							<th>Subject</th>
							<th>Message</th>
							<th>Date</th>
							<th class=" no-link last"><span class="nobr">Action</span></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i=1;
							if(count($feedbacks)>0){
							foreach($feedbacks as $row){
						?>
						<tr class="odd pointer <?php if(!($row->is_read)){ ?>lead <?php }?>">
							<td><?php echo $i++;?></td>
							<td><?php echo $row->first_name." ".$row->last_name;?></td>
							<td><?php echo $row->subject?></td>
							<td><?php echo substr($row->message, 0, 50); ?>...</td>
							<td><?php echo date("m-d-Y", strtotime($row->date)); ?></td>
							<td class=" last" nowrap="nowrap">
                            	<?php if(!($row->is_read)){ ?>
                                <a href="<?php echo base_url()."admin/feedback/isRead/".$row->id; ?>" class="btn btn-primary btn-sm"> read </a>
                                <?php }?>
                                <a href="<?php echo base_url()."admin/feedback/detail/".$row->id; ?>" class="btn btn-primary btn-sm"> detail </a>
                           	</td>
						</tr>
						<?php }}else{?>
						<tr>
							<td colspan="7">No Record Found</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<div class="col-md-12"><?php echo $links; ?></div>
			</div>
		</div>
	</div>
</div>
