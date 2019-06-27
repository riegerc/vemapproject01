<?php
class Frage{
	private $id;
	private $gewichtung;
	private $name;
	private $kriterien;
	
	public function __construct(int $id, int $gewichtung, string $name, array $kriterien){
		$this->id=$id;
		$this->gewichtung=$gewichtung;
		$this->name=$name;
		$this->kriterien=$kriterien;
	}
	public function getId(){
		return $this->id;
	}
	public function getGewichtung(){
		return $this->gewichtung;
	}
	public function getName(){
		return $this->name;
	}
	public function getKriterien(){
		return $this->kriterien;
	}
}