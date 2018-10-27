<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comment extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Comment_model');
    }
    
    function get_comments($id)
    {
        $ip = $this->input->ip_address();
        $comments = $this->Comment_model->get_comments($id, $ip);
        echo json_encode($comments);
    }

    function get_comment_children($id) {
        $ip = $this->input->ip_address();
        $result = $this->Comment_model->get_comments_children($id, $ip);
        echo json_encode($result);
    }

    public function add_comment() {
        $alias = $this->input->post('alias');
        $product_id = $this->input->post('product_id');
        $comment = $this->input->post('comment');
        $ip = $this->input->ip_address();

        $id = $this->Comment_model->add_new_comment($product_id, $alias, $comment, $ip);
        echo json_encode(array("id" => $id));
    }

    public function upvote() {
        $comment_id = $this->input->post('comment_id');
        $ip = $this->input->ip_address();

        $id = $this->Comment_model->upvote($comment_id, $ip);
        echo json_encode(array("id" => $id));
    }

    public function delete_upvote() {
        $comment_id = $this->input->post('comment_id');
        $ip = $this->input->ip_address();

        $id = $this->Comment_model->delete_upvote($comment_id, $ip);
        echo json_encode(array("id" => $id));
    }

    public function downvote() {
        $comment_id = $this->input->post('comment_id');
        $ip = $this->input->ip_address();

        $id = $this->Comment_model->downvote($comment_id, $ip);
        echo json_encode(array("id" => $id));
    }

    public function delete_downvote() {
        $comment_id = $this->input->post('comment_id');
        $ip = $this->input->ip_address();

        $id = $this->Comment_model->delete_downvote($comment_id, $ip);
        echo json_encode(array("id" => $id));
    }

    public function reply_comment() {
        $alias = $this->input->post('alias');
        $parent_id = $this->input->post('parent_id');
        $product_id = $this->input->post('product_id');
        $comment = $this->input->post('comment');
        $ip = $this->input->ip_address();

        $id = $this->Comment_model->reply_comment($product_id, $parent_id, $alias, $comment, $ip);
        echo json_encode(array("id" => $id));
    }
}