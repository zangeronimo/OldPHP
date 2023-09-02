<?php 

class TLParam {
	private $template;
	private $tpl;
	
	public function __construct($tpl) {
		$this->tpl = $tpl;
	}
	
	public function setTemplate($template) {
		$this->template=$template;
	}
	
	public function getTemplate() {		
		
		$this->buscaText();
		
		return $this->template;
	}
	
	private function buscaText() {
		$tpl = $this->template;
				
		while (substr_count($tpl,'<param_')) {
			$posicao_inicial = strpos($tpl,'<param_')+7;
			$posicao_final = strpos(substr($tpl,$posicao_inicial),'>');
			$param = substr($tpl,$posicao_inicial,$posicao_final);
						
			//Trata param
			$valor = $this->trataParam($param);
			
			$tpl = str_replace('<param_'.$param.'>', $valor, $tpl);			
		}
		
		$this->template = $tpl;
	}
	
	private function trataParam($param) {		
		$explode = explode('.',$param);
				
		if(count($explode) > 1) {
			$class = $this->tpl->getObjeto($explode[0]);
			$valor='';
			if(is_object($class)) {
				$funcao = 'get' . ucfirst($explode[1]);
				$valor = $class->$funcao();
			}
			$param = str_replace($param,$valor,$param);
		} else {
			$texto = $this->tpl->getObjeto($explode[0]);
			$param = str_replace($param, $texto ,$param);
		}
		
		return $param;
	}
	
	public function trataRepeat($template,$campo) {
		
		while (substr_count($template,'<param_')) {
			$posicao_inicial = strpos($template,'<param_')+7;
			$posicao_final = strpos(substr($template,$posicao_inicial),'>');
			$param = substr($template,$posicao_inicial,$posicao_final);

			if(is_object($campo))
			{
				$funcao = 'get' . ucfirst($param);
				$valor = $campo->$funcao();
			} else {
				$valor = $campo[$param];
			}
						
			$template = str_replace('<param_'.$param.'>', $valor, $template);
		}
		
		return $template;
	}
	
	
}
?>