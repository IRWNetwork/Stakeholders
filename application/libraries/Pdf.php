<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 

class Pdf {
    public function __construct() {
        //parent::__construct();
        require_once APPPATH."/third_party/mpdf/mpdf.php";
    }
}