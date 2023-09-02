<?php 
class contato {
	
	private $tpl;
	
	public function __construct($tpl) {
		$this->tpl = $tpl;
	}
	
	public function _tlPost() {
		global $api;
		global $comum;
		
		//Recebo os dados do formulário e instancio um objeto contato
		$nome = $comum->injection($_REQUEST['nome']);
		$email = $comum->injection($_REQUEST['email']);
		$assunto = $comum->injection($_REQUEST['assunto']);
		
		$registro = ['nome'=>$nome, 'email'=>$email, 'assunto'=>$assunto, 'cc'=>'arconsultoriaovinosecaprinos@gmail.com'];
		$api->post("/web/contato", json_encode($registro));
		
		$_SESSION['contato_ok'] = "ok";
		
		$comum->irPara("/contato");
	}
	
	public function _tlGet() {
		
		if(isset($_SESSION['contato_ok'])) {
			$this->tpl->setHide($_SESSION['contato_ok']);
			unset($_SESSION['contato_ok']);
		}
		
		$this->tpl->setObjeto("CANONICAL", "https://www.agrovr.com.br/contato");
		
		$this->tpl->setObjeto("TITULO",'Contato');
		
		$this->tpl->setObjeto("KEYWORDS","AgroVR - Contato, Produtos, Serviços, Galeria, Anúncios, Vendas, Artigos, Caprinos, Ovinos, Cabras, Ovelhas");
		$this->tpl->setObjeto("DESCRIPTION","AgroVR - Contato");
	}
}
?>