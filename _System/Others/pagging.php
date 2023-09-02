<?php 
class pagging {
	private $sql;
	private $total;
	
	public function __construct($sql,$total) {
		$this->sql = $sql;
		$this->total = $total;	
	}
	
	public function getSql() {
		$this->trataPagging();
		
		return $this->sql;
	}
	
	private function trataPagging() {
		$pagina = 1;
		if(isset($_REQUEST['pagina'])) {
			$pagina = $_REQUEST['pagina'];
		}
		
		$inicio = $this->total * ($pagina-1);
		
		$this->sql .= ' LIMIT ' .$inicio . ', ' . $this->total;		
	}
}
?>