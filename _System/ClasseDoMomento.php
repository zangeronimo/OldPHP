<?php
class ClasseDoMomento {
	private $tpl;
	private $classPath = '';
	private $classe = '';
	
	public function __construct($redirect_uri,$tpl) {
		$this->tpl = $tpl;
		$this->_setClasse($redirect_uri);
	}
	
	private function _setClasse($redirect_uri) {
		global $raiz_src;
		
		$self = str_replace("/index.php",'', $_SERVER['PHP_SELF'].'/');
		$redirect_uri = str_replace($self, "/", $redirect_uri);
				
		//Verifico se último caractere não é uma barra
		if(substr($redirect_uri,strlen($redirect_uri)-1,1)=='/')
			$redirect_uri = substr($redirect_uri, 0, strlen($redirect_uri)-1);
		
		if($redirect_uri == '') {
			$redirect_uri = '/home';
		}
		
		$filename = str_replace('//','/',$raiz_src . "/source/controller/" . $redirect_uri);
		$array = explode("/", $redirect_uri);
		$total = count($array);
		$_Info = array();
		
		while($total>1) {
			$total--;
			
			if(file_exists($filename . ".php")) {
				$this->classe = $array[$total];
				break;
			}
			$this->tpl->setInfo($array[$total]);			
			if($array[$total] != '') {
				$filename = substr($filename,0,strlen($filename) -strlen($array[$total]) - 1);
			}
		}
		
		if(!file_exists($filename . '.php')) {							
			header("Location: /error/_404");
			exit;
		}
		
		$this->classPath = $filename . '.php';
	}
	
	public function getClassPath() {
		return $this->classPath;
	}
	
	public function getClass() {
		return $this->classe;
	}
}
?>