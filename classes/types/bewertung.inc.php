<?php
/*
	Autor: Christian Riedler
*/
class Bewertung{
	private $criteriaId;
	private $criteriaName;
	private $markSum;
	private $surveyCount;
	private $month;
	
	public function __construct(int $criteriaId,string $criteriaName,float $markSum, int $surveyCount, int $month){
		$this->criteriaId=$criteriaId;
		$this->criteriaName=$criteriaName;
		$this->markSum=$markSum;
		$this->surveyCount=$surveyCount;
		$this->month=$month;
	}
	public function getCriteriaId():int{
		return $this->criteriaId;
	}
	public function getCriteriaName():string{
		return $this->criteriaName;
	}
	public function getMarkSum():float{
		return $this->markSum;
	}
	public function setSurveyCount(int $surveyCount):void{
		$this->surveyCount=surveyCount;
	}
	public function getSurveyCount():int{
		return $this->surveyCount;
	}
	public function getAvg(){
		return $this->markSum/$this->surveyCount;
	}
	public function getMonth(){
		return $this->month;
	}
}