<?php 
class servicos {
	
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
			// exibe o servico
			$this->tpl->setHide("servico");
			
			$id = $comum->injection($this->tpl->getInfo(1));
			
			$servico= $api->get("/web/servico/".$id);
			$this->tpl->setObjeto("nome",$servico['nome']);
			if(count($servico['fotos'])>0) {
				$this->tpl->setHide("fotos");
				$this->tpl->setObjeto("foto", $servico['fotos'][0]['url']);
				$this->tpl->setObjeto("fotos",$servico['fotos']);
			}
			$this->tpl->setObjeto("html",$servico['html']);
			
			if($servico['video']) {
				$this->tpl->setHide("video");
				$this->tpl->setObjeto("video", $servico['video']);
			}
						
			$titulo = $servico['nome'];
			$canonical = "https://www.agrovr.com.br/servicos/".$servico['codigo']."/".$comum->trataUrl($servico['nome']);
			$this->tpl->setObjeto("CANONICAL", $canonical);
		} else {
			// exibe lista de servicos
			$this->tpl->setHide("listar");
			
			$servicos = $api->get("/web/servico");
			$this->tpl->setObjeto("servicos",$servicos);
			
			$titulo = "Serviços";
			$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/servicos");
		}
		
		$this->tpl->setObjeto("TITULO", $titulo);
		$key = 'AgroVR - ' . $titulo;
		
		$this->tpl->setObjeto("KEYWORDS",$key);
		$this->tpl->setObjeto("DESCRIPTION","AgroVR - " . $titulo);
	}
}
?>