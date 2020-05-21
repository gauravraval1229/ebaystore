<?php
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

$this->load->view('includes/header');
$this->load->view($page);
$this->load->view('includes/footer');
?>