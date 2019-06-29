<?php
/*
	Autor: Christian Riedler
*/
class Bewertung{
	private $criteriaId;
	private $criteriaName;
	private $markSum;
	
	public function __construct($criteriaId,$criteriaName,$markSum){
		$this->$criteriaId=$criteriaId;
		$this->$criteriaName=$criteriaName;
		$this->$markSum=$markSum;
	}
}