<?php

class NewsModel extends CI_Model {

	public function __construct() {
	    $this->load->database();
	}

	public function getAllNews() {

        $queryMaster = $this->db->query("
        	SELECT m.*,c.categoryName, cn.mainTitle, cn.subTitle, cn.contentNews 
        	FROM t_news_master m 
        	left JOIN t_news_category c ON c.id = m.categoryID 
        	left JOIN t_news_content cn ON cn.newsMasterId = m.id
		");

        foreach ($queryMaster->result() as $row) {
	        $row->urlImage = $this->queryImage($row->id);
	        $row->comments = $this->queryComment($row->id);
	        $result = $queryMaster->result();
         }

        return $result;

	}

	public function queryImage($newsId = '') {
        $queryImg = $this->db->query("
        	SELECT i.id, i.url 
        	FROM t_news_image i 
        	where i.newsMasterId = ".$newsId
        );
        return $queryImg->result();
	}

	public function queryComment($newsId = '') {
        $queryComment = $this->db->query("
        	SELECT c.*
        	FROM t_news_comment c
        	where c.newsMasterId = ".$newsId
        );
        return $queryComment->result();
	}


	public function updateNewsCounter($newsId = '', $counterType = '') {

        $queryMaster = $this->db->query("
        	SELECT m.* 
        	FROM t_news_master m 
        	where m.id = ".$newsId
		);

        $resultMaster = $queryMaster->result();

        if(count($resultMaster) > 0) {
	        $counter = $resultMaster[0]->$counterType;
			$queryUpdate = $this->db->query("UPDATE t_news_master SET ".$counterType." = ".($counter+1)." WHERE id = ".$newsId);
        	return 'success';
		}else{
        	return 'data not found';
		}

	}

}