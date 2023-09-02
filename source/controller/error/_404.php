<?php 
class _404 {
	
	private $tpl;
	
	public function __construct($tpl) {
		$this->tpl = $tpl;
	}
	
	public function _tlPost() {
		
	}
	
	public function _tlGet() {		
		$this->tpl->setObjeto("TITULO",'Error - 404');
		$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/error/_404");
		
		$key = 'AgroVR.com';
		
		$this->tpl->setObjeto("KEYWORDS",$key);
		$this->tpl->setObjeto("DESCRIPTION","AgroVr - Página não encontrada");
	}
}
?>