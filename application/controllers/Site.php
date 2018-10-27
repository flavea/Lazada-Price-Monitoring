<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site extends MY_Controller {
    function __construct() {
        parent::__construct();
        
    }
    
    public function index() {
        $this->data['title']   = 'Lazada Price Monitoring';
        $this->data["file"]    = "home";
        $this->render($this->data["file"], 'public_master');
    }
}