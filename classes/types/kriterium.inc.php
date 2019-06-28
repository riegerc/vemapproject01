<?php
class Kriterium{
	private $id;
	private $name;
	private $gewichtung;
	private $przt;
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
	public function getPrzt(){
		return $this->przt;
	}
	public function setPrzt(float $przt){
		$this->przt=$przt;
	}
	public function __toString(){
			$res="<li>$this->name</li>\n";
			$res.="<div>\n";
			$res.="\t<input type='range' class='slider' name='sld$this->id' id='sld$this->id' min='0' max='10' value='0'>\n";
			$res.="\t<label for='sld$this->id'>0</label>\n";
			$res.="</div>\n";
			return $res;
		}
}