<?php 

class TLHideR {
	private $template;
	private $tpl;
	private $repeat;
	private $posicao;
	
	public function __construct($template,$tpl) {
		$this->template = $template;
		$this->tpl = $tpl;
	}
	
	public function setRepeat($repeat) {
		$this->repeat = $repeat;
	}
	
	public function setPosicao($posicao) {
		$this->posicao = $posicao;
	}
	
	public function getTemplate() {		
		$this->buscaHideR();
		
		return $this->template;
	}
	
	private function buscaHideR() {		
		$tpl = $this->template;
		while (substr_count($tpl,'<hider_')) {			
			$posicao_inicial = strpos($tpl,'<hider_')+7;
			$posicao_final = strpos(substr($tpl,$posicao_inicial),'>');
			$hider = substr($tpl,$posicao_inicial,$posicao_final);
			
			//Trata hide
			$tpl = $this->trataHideR($hider, $tpl);			 
		}
		
		$this->template = $tpl;
	}
	
	private function trataHideR($hider, $tpl) {
		$inicio = strpos($tpl,'<hider_'.$hider.'>');
		$fim = strpos($tpl,'</hider_'.$hider.'>');
		$conteudo = substr($tpl,$inicio,$fim - $inicio + strlen('</hider_'.$hider.'>'));
		$conteudo_hider = '';
		
		if($this->tpl->isHideR($this->repeat,$hider,$this->posicao)) {
			$conteudo_hider = str_replace('<hider_'.$hider.'>','',$conteudo);
			$conteudo_hider = str_replace('</hider_'.$hider.'>','',$conteudo_hider);
		}
		
		$tpl = str_replace($conteudo,$conteudo_hider,$tpl);
		
		return $tpl;
	}
	
	
}
?>