<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model {
    
    function get_all_products() {
        $query = $this->db->get('products');
        return $query->result();
    }
    
    function get_product($id) {
        $this->db->where('product_id', $id);
        $query = $this->db->get('products');
        return $query->result();
    }
    
    function get_price_history($id) {
        $this->db->where('product_id', $id);
        $query = $this->db->get('price_history');
        return $query->result();
    }

    function add_new_product($url) {
        
        $this->db->where('product_url', $url);
        $query = $this->db->get('products');

        if($query->num_rows() >  0) {
            foreach($query->result() as $q) {
                return $q->product_id;
            } 
        } else {
            $data = array(
                'product_name' => '',
                'product_description' => '',
                'product_url' => $url,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->trans_start();
            $this->db->insert('products', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }
    }
    
    function update_product($id, $name, $description, $price) {
        $data = array(
            'product_name' => $name,
            'product_description' => $description
        );
        
        $this->db->trans_start();
        $this->db->where('product_id', $id);
        $this->db->update('products', $data);
        $this->db->trans_complete();

        $data = array(
            'product_id' => $id,
            'price' => $price,
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->trans_start();
        $this->db->insert('price_history', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;


    }
}
