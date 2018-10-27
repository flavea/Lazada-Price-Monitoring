<?php
class Migrate extends MY_Controller {
    public function index()
    {
        $this->load->library('migration');

        $strSQL = "CREATE DATABASE IF NOT EXISTS lazada_monitoring";
        $query = $this->db->query($strSQL);
        if (!$this->migration->current())
        {
            echo 'Error: <b>' . $this->migration->error_string();
        } else {
            echo 'Migrations succeed.';
        }   
    }    
}