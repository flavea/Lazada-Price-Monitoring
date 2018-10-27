<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Scrapper_model');
        $this->data['title']   = 'Product Monitoring';
    }
    
    public function index($id = "") {
        if($id === "") $this->data["file"] = "products";
        else $this->data["file"] = "product_page";
        $this->render($this->data["file"], 'public_master');
    }

    public function add_new_product() {
        $link = $this->input->post("url");
        if(strpos($link, ".html")) $link = substr($link, 0, strpos($link, ".html") + 5);
        $data = $this->Scrapper_model->scrap_data($link);
        $id = 0;
        
        if($data != false && sizeof($data) != 0) {
            $id = $this->Product_model->add_new_product($link);
            $this->Product_model->update_product($id, $data['title'], $data['description'], $data['price']);
        }

        echo json_encode(array("id" => $id));
    }
    
    public function get_all_products() {
        $products = $this->Product_model->get_all_products();
        echo json_encode($products);
    }
    
    public function get_data($id, $update = "") {
        $data = [];
        $prices = [];
        $product = $this->Product_model->get_product($id);

        // get the data from the website
        foreach($product as $p) {
            $data = $this->Scrapper_model->scrap_data($p->product_url);
        }

        if($data != false && sizeof($data) != 0) {
            if($this->config->item('client_side_update') == true) $this->Product_model->update_product($id, $data['title'], $data['description'], $data['price']);
            $prices = $this->Product_model->get_price_history($id);
        }

        $ret = array(
            "product_data" => $data,
            "product_prices" => $prices
        );

        echo json_encode($ret);
    }
}