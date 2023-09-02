<?php 
class galerias {
	
	private $tpl;
	
	public function __construct($tpl) {
		$this->tpl = $tpl;
	}
	
	public function _tlPost() {
		
	}
	
	public function _tlGet() {
		global $comum;
		global $api;
		
		if(is_numeric($this->tpl->getInfo(1))) {
			$id = $comum->injection($this->tpl->getInfo(1));
			$this->tpl->setHide("galeria");
			
			$fotos = $api->get("/web/album/foto/". $id);
			$this->tpl->setObjeto("album", $fotos['album']);
			$this->tpl->setObjeto("fotos", $fotos['fotos']);
						
			$title = $fotos['album'];
			
			
			$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/galerias/".$id."/".$comum->trataUrl($fotos['album']));
		} else {
			$title = "Galerias";
				
			// Busco galerias
			$this->tpl->setHide("listar");
			$galerias = $api->get("/web/album/");
			$this->tpl->setObjeto("galerias", $galerias);
							
			$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/galerias");
		}
		
		$this->tpl->setObjeto("TITULO", $title);
		
		$key = 'AgroVR ' . $title;
		
		$this->tpl->setObjeto("KEYWORDS",$key);
		$this->tpl->setObjeto("DESCRIPTION","AgroVR - " . $title);
	}
}
?>