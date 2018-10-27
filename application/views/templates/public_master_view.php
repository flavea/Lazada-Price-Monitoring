<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('templates/_parts/public_master_header_view'); ?>
<?= $view;?>
<?php $this->load->view('templates/_parts/public_master_footer_view');?>