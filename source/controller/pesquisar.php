<?php 
class pesquisar {
	
	private $tpl;
	
	public function __construct($tpl) {
		$this->tpl = $tpl;
	}
	
	public function _tlPost() {
		
	}
	
	public function _tlGet() {
		global $comum;
		global $api;
		
		if(isset($_GET['k'])) {
			$comum->irPara("/pesquisar/" . $_GET['k']);
		}
		
		if(!$this->tpl->getInfo(1)) {
			$comum->irPara('/home');
			exit;
		}
		$k = $comum->injection($this->tpl->getInfo(1));
		
		if($k) {			
			$k = str_replace("apostila de ", '', strtolower($k));
			$this->tpl->setObjeto('k',urldecode($k));
			
			$total = 0;
			
			// Busca por produtos
			$produtos = $api->get('/web/produto?nome='.$k);
			if(count($produtos)) {
				$this->tpl->setHide("produtos");
				$this->tpl->setObjeto("produtos", $produtos);
			}
			$total += count($produtos);
			
			// Busca por servicos
			$servicos = $api->get('/web/servico?nome='.$k);
			if(count($servicos)) {
				$this->tpl->setHide("servicos");
				$this->tpl->setObjeto("servicos", $servicos);
			}
			$total += count($servicos);
			
			// Busca por galerias
			$galerias = $api->get('/web/album?nome='.$k);
			if(count($galerias)) {
				$this->tpl->setHide("galerias");
				$this->tpl->setObjeto("galerias", $galerias);
			}
			$total += count($galerias);
			
			// Busca por anuncios
			$anuncios = $api->get('/web/anuncio?nome='.$k);
			if(count($anuncios)) {
				$this->tpl->setHide("anuncios");
				$this->tpl->setObjeto("anuncios", $anuncios);
			}
			$total += count($anuncios);
			
			// Busca por artigos
			$artigos = $api->get('/web/artigo?nome='.$k);
			if(count($artigos)) {
				$this->tpl->setHide("artigos");
				$this->tpl->setObjeto("artigos", $artigos);
			}
			$total += count($artigos);
			
			$this->tpl->setObjeto("total", $total);
		}
		
		$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/pesquisar/".$k);
		
		$this->tpl->setObjeto("TITULO", "Resultado da pesquisa por " . $k);
		$key = 'AgroVR - Resultado da pesquisa por ' . $k;
		
		$this->tpl->setObjeto("KEYWORDS",$key);
		$this->tpl->setObjeto("DESCRIPTION","AgroVR - Resultado da pesquisa por " . $k);
	}
}
?>