<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function apiResponse($status = '99', $message = null, $data = null)
	{
		$response['responseCode'] = $status;
		$response['responseMessage'] = $message;
		$response['responseData'] = $data;
    	echo json_encode($response);
	}

	public function getMapData()
	{
		return json_decode($this->input->raw_input_stream, true);
	}

	public function getAllNews()
	{
    	$this->load->model('NewsModel');
        $data = $this->NewsModel->getAllNews();
        $this->apiResponse('00', 'ok', $data);
	}

	public function updateCounter()
	{
    	$this->load->model('NewsModel');
    	$mapCounterType = ['readCounter', 'likeCounter', 'unlikeCounter', 'reportCounter', 'shareCounter'];
    	$mapData = $this->getMapData();
    	if (in_array($mapData['countType'], $mapCounterType)) {
    		if ($mapData) {
	        	$data = $this->NewsModel->updateNewsCounter($mapData['newsId'], $mapData['countType']);
	    		$this->apiResponse('00', 'ok', $data);
	    	} else {
	        	$this->apiResponse('01', 'required newsId', '');
	    	}
	    } else {
	        $this->apiResponse('01', 'check countType, should one of responseData', $mapCounterType);
	    }

	}

}
