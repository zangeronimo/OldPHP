<?php 

class layoutPadrao {
	private $tpl;
	
	public function __construct($tpl) {
		$this->tpl = $tpl;
	}
	
	public function _tlPost() {

	}
	
	public function _tlGet() {
		global $api;
		
		$this->tpl->setObjeto("ANOATUAL", @date('Y'));
	}
}
?>