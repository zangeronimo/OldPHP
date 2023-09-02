<?php 
class produtos {
	
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
			// exibe o produto
			$this->tpl->setHide("produto");
			
			$id = $comum->injection($this->tpl->getInfo(1));
			
			$produto = $api->get("/web/produto/".$id);
			$this->tpl->setObjeto("categoria",$produto['categoria']);
			$this->tpl->setObjeto("nome",$produto['nome']);
			$this->tpl->setObjeto("fabricante",$produto['fabricante']);
			$this->tpl->setObjeto("preco",$produto['preco']);
			$this->tpl->setObjeto("descricao",$produto['descricao']);
			
			if(count($produto['fotos'])>0) {
				$this->tpl->setHide("fotos");
				$this->tpl->setObjeto("foto", $produto['fotos'][0]['url']);
				$this->tpl->setObjeto("fotos",$produto['fotos']);
			}
						
			$titulo = $produto['nome'];
			$canonical = "https://www.agrovr.com.br/produtos/".$produto['codigo']."/".$comum->trataUrl($produto['nome']);
			$this->tpl->setObjeto("CANONICAL", $canonical);
		} else {
			// exibe lista de produtos
			$this->tpl->setHide("listar");
			
			$produtos = $api->get("/web/produto");
			$this->tpl->setObjeto("produtos",$produtos);
			
			$titulo = "Produtos";
			$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/produtos");
		}
		
		$this->tpl->setObjeto("TITULO", $titulo);
		$key = 'AgroVR - ' . $titulo;
		
		$this->tpl->setObjeto("KEYWORDS",$key);
		$this->tpl->setObjeto("DESCRIPTION","AgroVR - " . $titulo);
	}
}
?>