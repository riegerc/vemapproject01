<?php
/*
Autoren: Christian Riedler, Theo Isporidi
*/
require_once("include/database.php");
require_once("classes/types/kriterium.inc.php");
require_once("classes/types/frage.inc.php");
class Repository{
	private $db;
	
	public function __construct(){
		$this->db=connectDB();
	}
	
	public function readKriterien():array{
		$kriterien=array();
		$sql="SELECT objectID,name,weighting FROM criteria WHERE deleted=0";
		$stmt=$this->db->prepare($sql);
		try{
			$stmt->execute();
		}catch(Exception $e){
			throw new PDOException($e);
		}
		while($row=$stmt->fetch()){
			array_push($kriterien, new Kriterium($row["name"],$row["weighting"],$row["objectID"]));
		}
		$this->przt($kriterien);
		return $kriterien;
	}
	public function readUnterKriterien(int $id):array{
		$kriterien=array();
		$sql="SELECT objectID,name,weighting,criteriaFID FROM subcriteria WHERE criteriaFID=:id AND deleted=0";
		$stmt=$this->db->prepare($sql);
		$stmt->bindParam(":id",$id);
		try{
			$stmt->execute();
		}catch(Exception $e){
			throw new PDOException($e);
		}
		while($row=$stmt->fetch()){
			array_push($kriterien, new Kriterium($row["name"],$row["weighting"],$row["objectID"],$row["criteriaFID"]));
		}
		$this->przt($kriterien);
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
public function deleteKriterium(int $kid, bool $is_subcriteria=false){
		if($is_subcriteria){
			$sql = "UPDATE subcriteria SET deleted=1 WHERE objectID=:objectID";
			$stmt=$this->db->prepare($sql);
			$stmt->bindParam(":objectID",$kid);
			try{
				$stmt->execute();
			}catch(Exception $e){
				throw new PDOException($e);
			}

		}else{
			$sql = "UPDATE criteria SET deleted=1 WHERE objectID=:objectID";
			$stmt=$this->db->prepare($sql);
			$stmt->bindParam(":objectID",$kid);
			try{
				$stmt->execute();
			}catch(Exception $e){
				throw new PDOException($e);
			}

			$sql = "UPDATE subcriteria SET deleted=1 WHERE criteriaFID=:criteriaFID";
			$stmt=$this->db->prepare($sql);
			$stmt->bindParam(":criteriaFID",$kid);
			try{
				$stmt->execute();
			}catch(Exception $e){
				throw new PDOException($e);
			}

		}
	}
	public function readFragebogen():array{
		$fragen=array();
		$unterkriterien=array();
		$kriterien=$this->readKriterien();
		foreach($kriterien as $kriterium){
			$unterkriterien=$this->readUnterKriterien($kriterium->getId());
			array_push($fragen, new Frage($kriterium->getId(), $kriterium->getGewichtung(), $kriterium->getName(), $unterkriterien));
		}
		return $fragen;
	}
	public function createReview(int $userid, int $supplierId, int $month):int{
		$reviewId=0;
		$sql="INSERT INTO reviews(userFID, supplierUserFID,datetime) VALUES(:userFid, :supplierId, '2019-0$month-05 08:59:09')";
		$stmt=$this->db->prepare($sql);
		$stmt->bindParam(":userFid",$userid);
		$stmt->bindParam(":supplierId",$supplierId);
		try{
			$stmt->execute();
			$reviewId=$this->db->lastInsertId('reviews');
		}catch(Exception $e){
			throw new PDOException($e);
		}
		return $reviewId;
	}
	public function createAnswers(Fragebogen $fb, int $month):void{
		$userFid=$fb->getUserId();
		$lieferantFid=$fb->getLieferantId();
		$reviewId=$this->createReview($userFid,$lieferantFid, $month);
		$kriterien=$fb->getFragen();
		$sql="INSERT INTO reviewsmark(reviewsFID,undercriteriaFID,mark, datetime) VALUES";
	
		foreach($kriterien as $key=>$val){
			$sql.="($reviewId,$key,$val,'2019-0$month-05 08:59:09'),";
		}
		$sql=rtrim($sql, ",");
		$stmt=$this->db->prepare($sql);
		try{
			$stmt->execute();
		}catch(Exception $e){
			throw new PDOException($e);
		}
	}
	private function przt(array $kriterien):array{
		$sum=0;
		foreach($kriterien as $kriterium){
			$sum+=$kriterium->getGewichtung();
		}
		foreach($kriterien as $kriterium){
			$faktor=(100/$sum);
			$przt=$faktor*$kriterium->getGewichtung();
			$kriterium->setPrzt($przt);
		}
		return $kriterien;
	}
	private function surveyCount(int $month):int{
		$res=array();
		$sql="SELECT count(objectID) as 'surveyCount' FROM reviews WHERE MONTH(datetime)=:month";
		$stmt=$this->db->prepare($sql);
		$stmt->bindParam(":month", $month);
		try{
			$stmt->execute();
		}catch(Exception $e){
			throw new PDOException($e);
		}
		$row=$stmt->fetch();
		return $row["surveyCount"];
	}
	public function readBewertungen(int $lieferantFid=0):array{
		$bewertungen=array();
		$sql="SELECT c.objectID as 'criteriaId', c.name as 'criteraName', MONTH(rm.datetime) as 'month',sum(rm.mark) as 'sum'
			FROM criteria c
				JOIN subcriteria sc
					ON c.objectID = sc.criteriaFID
				JOIN reviewsmark rm
					ON sc.objectID = rm.undercriteriaFID ";
					if($lieferantFid>0){
						$sql.="JOIN reviews r
							ON rm.reviewsFID=r.objectID
						WHERE r.supplierUserFid=$lieferantFid ";
					}
			$sql.="GROUP BY c.objectID, c.name, month"; 
		$stmt=$this->db->prepare($sql);
		try{
			$stmt->execute();
		}catch(Exception $e){
			throw new PDOException($e);
		}
		while($row=$stmt->fetch()){
			$surveyCount=$this->surveyCount($row['month']);
			array_push($bewertungen, new Bewertung($row["criteriaId"],$row["criteraName"],$row["sum"],$surveyCount,$row['month']));
		}
		return $bewertungen;
	}
	public function readLieferant(int $lieferantId):string{
		$sql="SELECT branchName FROM user WHERE rolesFID=4 AND objectID=:lieferantId";
		$stmt=$this->db->prepare($sql);
		$stmt->bindParam(":lieferantId",$lieferantId);
		$stmt->execute();
		$row=$stmt->fetch();
		return $row["branchName"];
	}
	public function readChart(int $lieferantFid=0):Chart{
		$bewertungen=$this->readBewertungen($lieferantFid);
		$branchName=$this->readLieferant($lieferantFid);
		return new Chart($lieferantFid,$branchName,$bewertungen);
	}
}