<?php
/*
Autor: Christian Riedler
*/
class Fragebogen{
	private $fragen;
	private $userId;
	private $lieferantId;
	
	public function __construct(int $userId, int $lieferantId, array $fragen){
		$this->fragen=$fragen;
		$this->userId=$userId;
		$this->lieferantId=$lieferantId;
	}
	
	public function getFragen(){
		return $this->fragen;
	}
	public function getUserId(){
		return $this->userId;
	}
	public function getLieferantId(){
		return $this->lieferantId;
	}
}