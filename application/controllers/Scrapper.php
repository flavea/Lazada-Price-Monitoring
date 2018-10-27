<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scrapper extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Scrapper_model');
    }
    
    // code to update all data, this code will be run on the server every one hour
    public function index() {
        $products = $this->Product_model->get_all_products();
        foreach($products as $p) {
            $data = $this->Scrapper_model->scrap_data($p->product_url);
            if(sizeof($data) != 0) {
                $this->Product_model->update_product($p->product_id, $data['title'], $data['description'], $data['price']);
                echo $data['title']." updated.<br>";
            }
        }
    }
}