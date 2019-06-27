<?php
class Fragebogen{
	private $fragen;
	private $userId;
	private $reviewId;
	private $lieferantId;
	
	public function __construct(array $fragen, int $userId, int $reviewId, int $lieferantId){
		$this->fragen=$fragen;
		$this->userId=$userId;
		$this->reviewId=$reviewId;
		$this->lieferantId=$lieferantId;
	}
	
	public function getFragen(){
		return $this->fragen;
	}
	public function getUserId(){
		return $this->userId;
	}
	public function getReviewId(){
		return $this->reviewId;
	}
	public function getLieferantId(){
		return $this->lieferantId;
	}
}