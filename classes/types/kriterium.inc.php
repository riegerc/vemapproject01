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
			for($i=1;$i<=10;$i++){
				$res.="<div>\n";
				$res.="<label class='cr-rb-label' for='{$this->id}-{$i}'>$i</label>\n";
				$res.="<input type='range'  name='rb$this->id' id='rb{$this->id}-{$i}' min='0' max='10' value='0'>\n";
				$res.="<span class='rb{$this->id}-{$i}'>0</span>\n";
				$res.="</div>\n";
			}
			return $res;
		}
}