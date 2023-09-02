<?php 
class mapa_do_site {
	
	private $tpl;
	private $comum;
	
	public function __construct($tpl) {
		$this->tpl = $tpl;
		$this->comum = new comum();
	}
	
	public function _tlPost() {
		
	}
	
	public function _tlGet() {
		global $api;		
		
		// Busca por produtos
		$produtos = $api->get('/web/produto');
		if(count($produtos)) {
			$this->tpl->setHide("produtos");
			$this->tpl->setObjeto("produtos", $produtos);
		}
		
		// Busca por servicos
		$servicos = $api->get('/web/servico');
		if(count($servicos)) {
			$this->tpl->setHide("servicos");
			$this->tpl->setObjeto("servicos", $servicos);
		}
		
		// Busca por galerias
		$galerias = $api->get('/web/album');
		if(count($galerias)) {
			$this->tpl->setHide("galerias");
			$this->tpl->setObjeto("galerias", $galerias);
		}
		
		// Busca por anuncios
		$anuncios = $api->get('/web/anuncio');
		if(count($anuncios)) {
			$this->tpl->setHide("anuncios");
			$this->tpl->setObjeto("anuncios", $anuncios);
		}
		
		// Busca por artigos
		$artigos = $api->get('/web/artigo');
		if(count($artigos)) {
			$this->tpl->setHide("artigos");
			$this->tpl->setObjeto("artigos", $artigos);
		}
				
		$this->tpl->setObjeto("TITULO",'Mapa do Site');
		
		$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/mapa_do_site");
		
		$key = 'AgroVR - Mapa do Site';
				
		$this->tpl->setObjeto("KEYWORDS",$key);
		$this->tpl->setObjeto("DESCRIPTION","AgroVR - Mapa do Site");
	}
}
?>