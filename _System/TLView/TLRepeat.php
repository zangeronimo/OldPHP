<?php 

class TLRepeat {
	private $template;
	private $tpl;
	private $count = 0;
	
	public function __construct($template,$tpl) {
		$this->template = $template;
		$this->tpl = $tpl;
		
		$this->buscaRepeat();
	}
	
	public function getTemplate() {
		return $this->template;
	}
	
	private function buscaRepeat() {
		$tpl = $this->template;
		while (substr_count($tpl,'<repeat_')) {			
			$posicao_inicial = strpos($tpl,'<repeat_')+8;
			$posicao_final = strpos(substr($tpl,$posicao_inicial),'>');
			$repeat = substr($tpl,$posicao_inicial,$posicao_final);
						
			$tpl = $this->trataRepeat($repeat, $tpl);
		}
		
		$this->template = $tpl;
	}
	
	private function trataRepeat($repeat, $tpl) {
		global $raiz;
		
		$inicio = strpos($tpl,'<repeat_'.$repeat.'>');
		$fim = strpos($tpl,'</repeat_'.$repeat.'>');
		$conteudo = substr($tpl,$inicio,$fim - $inicio + strlen('</repeat_'.$repeat.'>'));
				
		$conteudo_repeat = str_replace('<repeat_'.$repeat.'>','',$conteudo);
		$conteudo_repeat = str_replace('</repeat_'.$repeat.'>','',$conteudo_repeat);
		$conteudo_return = '';
		
		$lista = $this->tpl->getObjeto($repeat);
				
		if($lista) {
			if(count($lista)>0) {

				include_once $raiz . '/_System/TLView/TLParam.php';
				$param = new TLParam($this->tpl);
				
				include_once $raiz . '/_System/TLView/TLHideR.php';
				
				foreach($lista as $value) {
					//$this->tpl->setObjeto("campo",$value);
					
					//verifico a ocorrencia de <hider_
					$hider = new TLHideR($conteudo_repeat, $this->tpl);
					$hider->setRepeat($repeat);
					$hider->setPosicao($this->count);
					$tratado = $hider->getTemplate();

					//verifico a ocorrencia de <param_
					$conteudo_return .= $param->trataRepeat($tratado, $value);
					
					$this->count++;
				}
			}
		}
		$tpl = str_replace($conteudo,$conteudo_return,$tpl);		
		return $tpl;
	}
	
	
}
?>