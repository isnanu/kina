<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
    	$this->load->model('NewsModel');
        $data = $this->NewsModel->getAllNews();
		// print_r($data);
		echo json_encode($data);
		$this->load->view('welcome_message', $data);
	}

}
