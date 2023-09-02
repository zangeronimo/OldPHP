<?php 
class home {
	
	private $tpl;
	
	public function __construct($tpl) {
		$this->tpl = $tpl;
	}
	
	public function _tlPost() {
		global $api;
		global $comum;
		
		$nome = $comum->injection($_REQUEST['nome']);
		$email = $comum->injection($_REQUEST['email']);
		
		$registro = ['nome'=>$nome, 'email'=>$email, 'ativo'=>1];
		$api->post("/web/newsletter", json_encode($registro));
		
		$_SESSION['newsletter_ok'] = "newsletter_ok";
		
		$referer = "/home";
		
		if(isset($_SERVER['HTTP_REFERER'])) {
			$referer = $_SERVER['HTTP_REFERER'];
		}
		
		$comum->irPara($referer);
	}
	
	public function _tlGet() {
		global $api;
		
		if(isset($_SESSION['newsletter_ok'])) {
			$this->tpl->setHide($_SESSION['newsletter_ok']);
			unset($_SESSION['newsletter_ok']);
		} else {
			$this->tpl->setHide("newsletter");
		}
		
		$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/home");
		
		$this->tpl->setObjeto("TITULO",'bem-vindo');
		
		$this->tpl->setObjeto("KEYWORDS","AgroVR, produtos, serviços, fotos, cabra, ovelha, caprinos, ovinos, vendas");
		$this->tpl->setObjeto("DESCRIPTION","AgroVR - Assessoria e Consultoria Caprinos e Ovinos");
		
		//Retorna banners
		$banners = $api->get("/web/banner");
		if(count($banners)>0) {
			$this->tpl->setHide("banners");
			$this->tpl->setHider("banners","active",0);
			
			$ctrl = 0;
			foreach($banners as $values) {
				if($values['url']) {
					$this->tpl->setHider("banners","url",$ctrl);
				} else {
					$this->tpl->setHider("banners","sem_url",$ctrl);
				}
				$ctrl++;
			}
			
			$this->tpl->setObjeto("banners", $banners);			
		}
				
		//Retorna novidades
		$produtos = $api->get("/web/produto/destaque/4");		
		$this->tpl->setObjeto("produtos", $produtos);
		
		//Retorna artigos
		$artigos = $api->get("/web/artigo/destaque/5");
		$this->tpl->setObjeto("artigos", $artigos);
		
		//Retorna anúncios
		$anuncios = $api->get("/web/anuncio/destaque/2");
		$this->tpl->setObjeto("anuncios", $anuncios);
	}
}
?>