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

			$res="<li class='list-group-item'>$this->name\n";
			
			$res.="<div class='form-group'>\n";
			
			// begin outer form row
			$res.="<div class='row'>";
			
			// begin outer form col
			$res.="<div class='col-md-11 align-items-center'>";
			
			// begin inner form row
			$res.="<div class='row'>";
			
			$res.="<span>0</span>\n";
			
			// begin inner form col
			$res.="<div class='col-md-10'>";
			
			$res.="<input type='range' class='custom-range' name='sld$this->id' id='sld{$this->id}' min='0' max='".$this->getPrzt()."' step='0.001' 
			value='0' onchange='setLabelText(".$this->getId().",".$this->getFkKriterium().")'>";			
			
			// end inner form col
			$res.="</div>";
			
			$res.= round($this->getPrzt(),0) . "\n";
			
			// end innerform col
			$res.="</div>";
			
			// end inner form row
			$res.="</div>";
			
			// moved the label outside list group
			$res.="<div class='col-md-1'>";
			$res.="<label class='badge badge-secondary' id='lbl".$this->getFkKriterium()."' for='lbl".$this->getFkKriterium()."'></label>\n";
			$res.="</div'>";
			
			// end outer form row
			$res.="</div>";
			
			$res.="</div>\n";
			$res.="</li>\n";
			return $res;
		}
}