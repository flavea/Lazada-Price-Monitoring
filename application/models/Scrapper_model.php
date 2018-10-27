<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scrapper_model extends CI_Model {
    
    function scrap_data($url) {
        $this->load->library('simple_html_dom');
        
        // load the html of the website
        $html = $this->simple_html_dom->file_get_html($url);

        $images = [];

        $ret = array();
        // scrapping the data through the html tags
        if($html->find('.pdp-product-title')) {
            $title = $html->find('.pdp-product-title')[0]->plaintext;
            $price = $html->find('.pdp-product-price')[0]->find('.pdp-price')[0]->plaintext;
            $price = str_replace("Rp", "", $price);
            $price = str_replace(".", "", $price);
            $description = "";
            if($html->find('.pdp-product-highlights')) $description .= $html->find('.pdp-product-highlights')[0];
            if($html->find('.detail-content')) $description .= '<p>'.$html->find('.detail-content')[0];

            // getting the product images with the real size
            foreach($html->find('.item-gallery__thumbnail-image') as $image) {
                $img = str_replace('_120x120q75.jpg', '', $image->src);
                $images[] = ['src' => $img];
            }
            
            // clear memory
            $html->clear();

            // returning the scrapping result
            $ret = array(
                "url" => $url,
                "title" => $title,
                "price" => $price,
                "description" => $description,
                "images" => $images
            );
        }

        return $ret;
    }
}
