<?php
class Kriterium{
	private $id;
	private $name;
	private $gewichtung;
	private $fkKriterium;
	
	public function __construct(string $name, int $gewichtung, int $id=0, int $fkKriterium=0){
		$this->id=$id;
		$this->name=$name;
		$this->gewichtung=$gewichtung;
		$this->fkKriterium=$fkKriterium;
	}
	public function getId(){
		return $this->id;
	}
	public function getName(){
		return $this->name;
	}
	public function getGewichtung(){
		return $this->gewichtung;
	}
	public function getFkKriterium(){
		return $this->fkKriterium;
	}
	public function __toString(){
		$res="<li>$this->name</li>";
		for($i=1;$i<=10;$i++){
			$res.="<span class='cr-rb-label'>$i</span><input type='radio' name='rb$this->id' value='$i'>";
		}
		return $res;
	}
}