<?php if ($this->session->flashdata('success')) {?>
<div class="alert alert-success"> <?php echo $this->session->flashdata('success'); ?> </div>
<?php }if (validation_errors()) {?>
<div class="alert alert-danger"> <?php echo validation_errors(); ?> </div>
<?php }?>
<?php if ($this->session->flashdata('error')) {?>
<div class="alert alert-danger"> <?php echo $this->session->flashdata('error'); ?> </div>
<?php }?>