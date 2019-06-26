<?php
require_once("include/db.php");
class Repository{
	private $db;
	
	public function __construct(){
		$this->db=connectDB();
	}
	
	public function readKriterien():array{
		$kriterien=array();
		$sql="SELECT objectID,name,weighting FROM criteria";
		$stmt=$this->db->prepare($sql);
		try{
			$stmt->execute();
		}catch(Exception $e){
			throw new PDOException($e);
		}
		while($row=$stmt->fetch()){
			array_push($kriterien, new Kriterium($row["name"],$row["weighting"],$row["objectID"]));
		}
		return $kriterien;
	}
	public function readUnterKriterien(int $id):array{
		$kriterien=array();
		$sql="SELECT objectID,name,weighting FROM subcriteria WHERE criteriaFID=:id";
		$stmt=$this->db->prepare($sql);
		$stmt->bindParam(":id",$id);
		try{
			$stmt->execute();
		}catch(Exception $e){
			throw new PDOException($e);
		}
		while($row=$stmt->fetch()){
			array_push($kriterien, new Kriterium($row["name"],$row["weighting"],$row["objectID"]));
		}
		return $kriterien;
	}
	public function create(Kriterium $k):void{
		$name=$k->getName();
		$gewichtung=$k->getGewichtung();
		$sql="INSERT INTO criteria(name,weighting)VALUES(:name,:gewichtung)";
		$stmt=$this->db->prepare($sql);
		$stmt->bindParam(":name", $name);
		$stmt->bindParam(":gewichtung", $gewichtung);
		try{
			$stmt->execute();
		}catch(Exception $e){
			throw new PDOException($e);
		}
	}
	public function createUnterKriterium(Kriterium $k):void{
		$name=$k->getName();
		$gewichtung=$k->getGewichtung();
		$kid=$k->getFkKriterium();
		$sql="INSERT INTO subcriteria(criteriaFID,name,weighting)VALUES(:kid,:name,:gewichtung)";
		$stmt=$this->db->prepare($sql);
		$stmt->bindParam(":name", $name);
		$stmt->bindParam(":gewichtung", $gewichtung);
		$stmt->bindParam(":kid", $kid);
		try{
			$stmt->execute();
		}catch(Exception $e){
			throw new PDOException($e);
		}
	}
	public function update(array $kriterien, $kid=0){
		foreach($kriterien as $key=>$val){
				if($kid>0){
					$sql="UPDATE subcriteria SET weighting=$val WHERE objectID=$key AND criteriaFID=$kid";
				}else{
					$sql="UPDATE criteria SET weighting=$val WHERE objectID=$key";
				}
				$stmt=$this->db->prepare($sql);
				try{
					$stmt->execute();
				}catch(Exception $e){
					throw new PDOException($e);
				}
		}
	}
}