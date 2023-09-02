<?php 

class TLHide {
	private $template;
	private $tpl;
	
	public function __construct($template,$tpl) {
		$this->template = $template;
		$this->tpl = $tpl;
		
		$this->buscaHide();
	}
	
	public function getTemplate() {
		return $this->template;
	}
	
	private function buscaHide() {
		$tpl = $this->template;
		while (substr_count($tpl,'<hide_')) {			
			$posicao_inicial = strpos($tpl,'<hide_')+6;
			$posicao_final = strpos(substr($tpl,$posicao_inicial),'>');
			$hide = substr($tpl,$posicao_inicial,$posicao_final);
			
			//Trata hide
			$tpl = $this->trataHide($hide, $tpl);			 
		}
		
		$this->template = $tpl;
	}
	
	private function trataHide($hide, $tpl) {
		$inicio = strpos($tpl,'<hide_'.$hide.'>');
		$fim = strpos($tpl,'</hide_'.$hide.'>');
		$conteudo = substr($tpl,$inicio,$fim - $inicio + strlen('</hide_'.$hide.'>'));
		$conteudo_hide = '';
				
		if($this->tpl->isHide($hide)) {
			$conteudo_hide = str_replace('<hide_'.$hide.'>','',$conteudo);
			$conteudo_hide = str_replace('</hide_'.$hide.'>','',$conteudo_hide);
		}
		
		$tpl = str_replace($conteudo,$conteudo_hide,$tpl);
		
		return $tpl;
	}
	
	
}
?>