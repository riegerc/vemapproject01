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
		
			// begin outer form row
			$res="<div class='form-row'>";
			
				$res.="<li class='list-group-item'>$this->name\n";			

				// begin outer form col
				$res.="<div class='col-11'>";

					// begin inner form row
					$res.="<div class='form-row'>";
						$res.="<div class='col-1'>";
						$res.="<span>0</span>\n";
						$res.="</div>";
						$res.="<div class='col-10'>";
						$res.="<input type='range' class='custom-range' name='sld$this->id' id='sld{$this->id}' min='0' max='".$this->getPrzt()."' step='0.001' 
						value='0' onchange='setLabelText(".$this->getId().",".$this->getFkKriterium().")'>";			
						$res.="</div>";
						$res.="<div class='col-1'>";
						$res.= round($this->getPrzt(),0) . "\n";
						$res.="</div>";
					// end outer form row
					$res.="</div>";
			
				// end outer form col
				$res.="</div>";
			
				// moved the label outside list group
				$res.="<div class='col-1'>";
				$res.="<label class='badge badge-secondary' id='lbl".$this->getFkKriterium()."' for='lbl".$this->getFkKriterium()."'></label>\n";
				$res.="</div>";
			
				$res.="</li>\n";
			return $res;
		}
}