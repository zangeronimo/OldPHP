<?php 
class anuncios {
	
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
			// exibe o anúncio
			$this->tpl->setHide("anuncio");
			
			$id = $comum->injection($this->tpl->getInfo(1));
			
			$anuncio = $api->get("/web/anuncio/".$id);
			$this->tpl->setObjeto("anuncio",$anuncio['nome']);
			if(count($anuncio['fotos'])>0) {
				$this->tpl->setHide("fotos");
				$this->tpl->setObjeto("foto", $anuncio['fotos'][0]['url']);
				$this->tpl->setObjeto("fotos",$anuncio['fotos']);
			}
			$this->tpl->setObjeto("html",$anuncio['html']);
			
			if($anuncio['video']) {
				$this->tpl->setHide("video");
				$this->tpl->setObjeto("video", $anuncio['video']);
			}
						
			$titulo = $anuncio['nome'];
			$canonical = "https://www.agrovr.com.br/anuncios/".$anuncio['codigo']."/".$comum->trataUrl($anuncio['nome']);
			$this->tpl->setObjeto("CANONICAL", $canonical);
		} else {
			// exibe lista de anúncios
			$this->tpl->setHide("listar");
			
			$anuncios = $api->get("/web/anuncio");
			$this->tpl->setObjeto("anuncios",$anuncios);
			
			$titulo = "Anúncios / Vendas";
			$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/anuncios");
		}
		
		$this->tpl->setObjeto("TITULO", $titulo);
		$key = 'AgroVR - ' . $titulo;
		
		$this->tpl->setObjeto("KEYWORDS",$key);
		$this->tpl->setObjeto("DESCRIPTION","AgroVR - " . $titulo);
	}
}
?>