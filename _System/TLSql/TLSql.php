<?php 
class TLSql {
	private $banco = 'MySQL';
	private $conexao;
	private $class;
	private $id;
	
	public function __construct($class,$id) {
		global $raiz;
		
		$this->class = $class;
		$this->id = $id;
				
		include_once $raiz . "/_System/TLSql/".$this->banco.'/Conexao.php';
		$this->conexao = new Conexao();	
	}
	
	private function sqlConnect() {
		
		if($_SERVER['SERVER_ADMIN']=='luciano@tudolinux.com.br') {
			//Desenvolvimento
			$host = '127.0.0.1';
			$base = '';
			$user = '';
			$pass = '';
		} else {
			//Produção
			$host = 'localhost';
			$base = '';
			$user = '';
			$pass = '';
		}		
		
		$conexao = $this->conexao->_connect($host,$user,$pass,$base);
		mysqli_query($conexao,"SET CHARACTER SET utf8 ");
		
		return $conexao;
	}
	
	private function sqlClose($conexao) {
		$this->conexao->_close($conexao);
	}
	
	public function select($sql,$pagging=null) {
		global $raiz;
		
		include_once $raiz . "/_System/TLSql/".$this->banco.'/Select.php';
		$conexao = $this->sqlConnect();
		$select = new Select($conexao);		
		$return = $select->Select($sql,$this->class,$pagging);
		$this->sqlClose($conexao);		
		return $return;
	}
	
	public function save($objeto) {
		global $raiz;
		
		include_once $raiz . "/_System/TLSql/".$this->banco.'/Save.php';
		$conexao = $this->sqlConnect();
		$save = new Save($conexao);		
		$return = $save->Save($objeto,$this->id);
		$this->sqlClose($conexao);		
		return $return;
	}
	
	public function delete($codigo) {
		global $raiz;
		
		include_once $raiz . "/_System/TLSql/".$this->banco.'/Delete.php';
		$conexao = $this->sqlConnect();
		$delete = new Delete($conexao);
		$return = $delete->Delete($this->class,$codigo,$this->id);
		$this->sqlClose($conexao);
		return $return;
	}
	
	public function executa($sql,$retorna=null) {
		global $raiz;
				
		include_once $raiz . "/_System/TLSql/".$this->banco.'/Executa.php';
		$conexao = $this->sqlConnect();
		$executa = new Executa($conexao);
		$return = $executa->Executa($sql,$retorna);
		$this->sqlClose($conexao);
		return $return;
	}
}
?>