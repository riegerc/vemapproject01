<?php
class Chart{
	private $supplierId;
	private $supplierName;
	private $bewertungen;
	
	public function __construct(int $supplierId, string $supplierName, array $bewertungen){
		$this->supplierId=$supplierId;
		$this->supplierName=$supplierName;
		$this->bewertungen=$bewertungen;
	}
	public function getSupplierId():int{
		return $this->supplierId;
	}
	public function getSupplierName():string{
		return $this->supplierName;
	}
	public function getBewertungen():array{
		return $this->bewertungen;
	}
}