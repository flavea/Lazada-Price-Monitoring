<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comment_model extends CI_Model {

    function get_upvotes($id) {
        $this->db->where('comment_id', $id);
        $this->db->from('upvotes');
        $query = $this->db->count_all_results();
        return $query;
    }

    function get_downvotes($id) {
        $this->db->where('comment_id', $id);
        $this->db->from('downvotes');
        $query = $this->db->count_all_results();
        return $query;
    }

    function check_upvote_ownership($id, $ip) {
        $this->db->where('comment_id', $id)->where('ip_address', $ip);
        $this->db->from('upvotes');
        $query = $this->db->count_all_results();
        return $query;
    }

    function check_downvote_ownership($id, $ip) {
        $this->db->where('comment_id', $id)->where('ip_address', $ip);
        $this->db->from('downvotes');
        $query = $this->db->count_all_results();
        return $query;
    }
    
    function get_comments($id, $ip) {
        $this->db->select('comments.comment_id, comments.name, comments.comment');
        $this->db->where('product_id', $id)->where('parent_id', null);
        $query = $this->db->get('comments')->result();
        for($i = 0; $i < sizeof($query); $i++) {
            $query[$i]->upvotes = $this->Comment_model->get_upvotes($query[$i]->comment_id);
            $query[$i]->own_upvote = $this->Comment_model->check_upvote_ownership($query[$i]->comment_id, $ip);
            $query[$i]->downvotes = $this->Comment_model->get_downvotes($query[$i]->comment_id);
            $query[$i]->own_downvote = $this->Comment_model->check_downvote_ownership($query[$i]->comment_id, $ip);
            $query[$i]->score = $query[$i]->upvotes - $query[$i]->downvotes;
        }
        return $query;
    }

    function get_comments_children($parent_id, $ip) {
        $this->db->select('comments.comment_id, comments.parent_id, comments.name, comments.comment');
        $this->db->where('parent_id', $parent_id);
        $query = $this->db->get('comments')->result();
        for($i = 0; $i < sizeof($query); $i++) {
            $query[$i]->upvotes = $this->Comment_model->get_upvotes($query[$i]->comment_id);
            $query[$i]->own_upvote = $this->Comment_model->check_upvote_ownership($query[$i]->comment_id, $ip);
            $query[$i]->downvotes = $this->Comment_model->get_downvotes($query[$i]->comment_id);
            $query[$i]->own_downvote = $this->Comment_model->check_downvote_ownership($query[$i]->comment_id, $ip);
            $query[$i]->score = $query[$i]->upvotes - $query[$i]->downvotes;
        }
        return $query;
    }
    
    function upvote($comment_id, $ip_address) {
        $this->db->where('comment_id', $comment_id)->where('ip_address', $ip_address);
        $upvotes = $this->db->get('upvotes')->result();
        $this->db->where('comment_id', $comment_id)->where('ip_address', $ip_address);
        $downvotes = $this->db->get('downvotes')->result();
        if(sizeof($upvotes) != 0) return -1;
        if(sizeof($downvotes) != 0) return -2;
        else {
            $data = array(
                'comment_id' => $comment_id,
                'ip_address' => $ip_address,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->trans_start();
            $this->db->insert('upvotes', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }
    }

    function delete_upvote($comment_id, $ip_address) {
        $data = array(
            'comment_id' => $comment_id,
            'ip_address' => $ip_address
        );
        return $this->db->delete('upvotes', $data);
    }
    
    function downvote($comment_id, $ip_address) {
        $this->db->where('comment_id', $comment_id)->where('ip_address', $ip_address);
        $upvotes = $this->db->get('upvotes')->result();
        $this->db->where('comment_id', $comment_id)->where('ip_address', $ip_address);
        $downvotes = $this->db->get('downvotes')->result();
        if(sizeof($upvotes) != 0) return -2;
        if(sizeof($downvotes) != 0) return -1;
        else {
            $data = array(
                'comment_id' => $comment_id,
                'ip_address' => $ip_address,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->trans_start();
            $this->db->insert('downvotes', $data);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        };
    }

    function delete_downvote($comment_id, $ip_address) {
        $data = array(
            'comment_id' => $comment_id,
            'ip_address' => $ip_address
        );
        return $this->db->delete('downvotes', $data);
    }

    function reply_comment($product_id, $parent_id, $alias, $comment, $ip_address) {
        $data = array(
            'product_id' => $product_id,
            'parent_id' => $parent_id,
            'name' => $alias,
            'comment' => $comment,
            'ip_address' => $ip_address,
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->insert('comments', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function add_new_comment($product_id, $alias, $comment, $ip_address) {
        $data = array(
            'product_id' => $product_id,
            'name' => $alias,
            'comment' => $comment,
            'ip_address' => $ip_address,
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->trans_start();
        $this->db->insert('comments', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
}
