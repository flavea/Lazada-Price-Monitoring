<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

		protected $data = array();
		function __construct()
		{
				parent::__construct();
				$this->load->helper("url");
		}

		protected function render($view_file = NULL, $template = 'master')
			{
				if($template == 'json' || $this->input->is_ajax_request())
				{
					header('Content-Type: application/json');
					echo json_encode($this->data);
				}
				elseif(is_null($template))
				{
					$this->load->view($view_file, $this->data);
				}
				else
				{
					$this->data['view'] = (is_null($view_file)) ? '' : $this->load->view('module/'.$view_file,$this->data, TRUE);
					$this->load->view('templates/'.$template.'_view', $this->data);
				}
			}
}
