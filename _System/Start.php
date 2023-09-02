<?php 
class Start {

	private $Tpl;
	private $_ClasseDoMomento;

	public function __construct() {
		global $raiz_src;
		
		$this->Tpl = new TLClass();
		
		$uri = $_SERVER['REQUEST_URI'];
		
		if(strstr($uri, '?') && isset($_SERVER['REDIRECT_QUERY_STRING'])) {
			$uri = str_replace('?' . $_SERVER['REDIRECT_QUERY_STRING'], '', $uri);
		}
				
		$this->_ClasseDoMomento = new ClasseDoMomento($uri,$this->Tpl);		
		
		//instancio classe do momento
		$include_class = $this->_ClasseDoMomento->getClassPath();
		$ClasseInstanciada = $this->instanciaClasseMomento($this->Tpl,$include_class);
		
		$tpl = str_replace($raiz_src.'/source/controller/','/',$include_class);
		$tpl = str_replace(".php",".html",$tpl);
		$this->Tpl->setObjeto('CONTEUDO',$this->_carregaTemplate($ClasseInstanciada,$tpl));
		
		//instancio template padrão
		$layoutPadrao = $this->instanciaClassePadrao($this->Tpl);
		$tpl = "/layoutPadrao.html";
		echo $this->_carregaTemplate($layoutPadrao,$tpl);
	}
	
	private function _carregaTemplate($instancia,$tpl) {
		//Chamo método _tlPost ou _tlGet
		if($_SERVER['REQUEST_METHOD']=='POST') {
			$instancia->_tlPost();
		} else {
			$instancia->_tlGet();
		}
		
		//instancia template da classe
		$this->Tpl->setTemplateAtivo($tpl);
		//exibo o template
		return $this->Tpl->showTemplate();
	}
	
	private function instanciaClassePadrao($tpl) {
		global $raiz_src;
		
		include_once $raiz_src . "/source/layoutPadrao.php";
		return new layoutPadrao($tpl);		
	}
	
	private function instanciaClasseMomento($tpl,$include_class) {
		include_once $include_class;
		$class = $this->_ClasseDoMomento->getClass();
		
		return new $class($tpl);
	}
}
?>