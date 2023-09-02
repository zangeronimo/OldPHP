<?php 
class artigos {
	
	private $tpl;
	
	public function __construct($tpl) {
		$this->tpl = $tpl;
	}
	
	public function _tlPost() {
	}
	
	public function _tlGet() {
		global $comum;
		global $api;
		
		if (is_numeric($this->tpl->getInfo(1))) {
			// exibe o artigo
			$this->tpl->setHide("artigo");
			
			$id = $comum->injection($this->tpl->getInfo(1));
			
			$artigo = $api->get("/web/artigo/".$id);
			$this->tpl->setObjeto("nome",$artigo['nome']);
			if(count($artigo['fotos'])>0) {
				$this->tpl->setHide("fotos");
				$this->tpl->setObjeto("foto", $artigo['fotos'][0]['url']);
				$this->tpl->setObjeto("fotos",$artigo['fotos']);
			}
			$this->tpl->setObjeto("html",$artigo['html']);
			
			if($artigo['video']) {
				$this->tpl->setHide("video");
				$this->tpl->setObjeto("video", $artigo['video']);
			}
						
			$titulo = $artigo['nome'];
			$canonical = "https://www.agrovr.com.br/artigos/".$artigo['codigo']."/".$comum->trataUrl($artigo['nome']);
			$this->tpl->setObjeto("CANONICAL", $canonical);
		} else {
			// exibe lista de anúncios
			$this->tpl->setHide("listar");
			
			$artigos = $api->get("/web/artigo");
			$this->tpl->setObjeto("artigos",$artigos);
			
			$titulo = "Artigos";
			$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/artigos");
		}
		
		$this->tpl->setObjeto("TITULO", $titulo);
		$key = 'AgroVR - ' . $titulo;
		
		$this->tpl->setObjeto("KEYWORDS",$key);
		$this->tpl->setObjeto("DESCRIPTION","AgroVR - " . $titulo);
	}
}
?>