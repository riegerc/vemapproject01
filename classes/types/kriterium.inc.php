<?php
/*
Autor: Christian Riedler
*/
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
			$res="<li>$this->name\n";
			$res.="<div>\n";
			$res.="<input type='range'  name='sld$this->id' id='sld{$this->id}' min='0' max='10' value='0' onchange='setLabelText(".$this->getId().",".$this->getFkKriterium().")'>\n";
			$res.="<label id='lbl".$this->getFkKriterium()."'></label>\n";
			$res.="</div></li>\n";
			return $res;
		}
}