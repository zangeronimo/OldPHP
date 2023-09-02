<?php

class TLClass {
	private $_Info = array();
	private $_Objeto = array();
	private $templateAtivo;
	private $hide = array();
	private $hideR = array();
	
	public function __construct() {
	}
	
	public function setObjeto($nome,$objeto) {
		$this->_Objeto[$nome]=$objeto;
	}
	
	public function getObjeto($nome) {
		if(isset($this->_Objeto[$nome]))
			return $this->_Objeto[$nome];
	}
	
	public function setHideR($repeat,$valor,$posicao) {
		$this->hideR[$repeat][$valor][] = $posicao;
	}
	
	public function isHideR($repeat,$valor,$posicao) {		
		if(isset($this->hideR[$repeat])) {
			if(isset($this->hideR[$repeat][$valor])) {
				return in_array($posicao,$this->hideR[$repeat][$valor]);
			}
		}
	}
	
	public function setHide($valor) {
		$this->hide[] = $valor;
	}
	
	public function isHide($valor) {
		return in_array($valor,$this->hide);
	}
	
	public function setInfo($valor) {
		$this->_Info[] = $valor;
	}
	
	public function getInfo($posicao = null) {
		$info = array_reverse($this->_Info);
		
		if($posicao)
			return @$info[$posicao-1];
		else 
			return @$info;
	}
	
	public function setTemplateAtivo($tpl) {
		$this->templateAtivo = $tpl;
	}
	
	private function getFile($file) {
		$texto = '';
		
		if(file_exists($file)) {
			$fo = fopen($file,'r');
			while(!feof($fo)) {
				$texto .= fgetc($fo);
			}
		} else {
			die("template não encontrado");
		}
		return $texto;
	}
	
	public function showTemplate() {
		global $raiz;
		global $raiz_src;
		
		//tratamento necessário
		$file = $raiz_src . '/web/templates/' . $this->templateAtivo;
		$file = str_replace("//","/",$file);
		$template = $this->getFile($file);

		
		//Envia para o motor de templates
		include_once $raiz . '/_System/TLView/TLView.php';
		$tlView = new TLView($template,$this);
		$template = $tlView->getTemplate();
				
		//Exibe na tela
		return $template;
	}
}
?>