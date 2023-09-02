<?php 

class TLView {
	private $template;
	
	public function __construct($template,$tpl) {
		global $raiz;
		//verifico a ocorrencia de <hide_
		include_once $raiz . '/_System/TLView/TLHide.php';
		$hide = new TLHide($template,$tpl);
		$template = $hide->getTemplate();
		
		//verifico a ocorrencia de <repeat_
		include_once $raiz . '/_System/TLView/TLRepeat.php';
		$repeat = new TLRepeat($template,$tpl);
		$template = $repeat->getTemplate();
				
		//verifico a ocorrencia de <param_
		include_once $raiz . '/_System/TLView/TLParam.php';
		$param = new TLParam($tpl);
		$param->setTemplate($template);
		$this->template = $param->getTemplate();
	}
	
	public function getTemplate() {
		return $this->template;
	}
}

?>