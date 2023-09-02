<?php 
class Delete {
	private $conexao;
	
	public function __construct($conexao) {
		$this->conexao = $conexao;
	}
	
	public function Delete($tabela,$codigo,$id) {
				
		$sql = "DELETE FROM " . $tabela . " WHERE " . $id . " = " . $codigo;
		$query = mysqli_query($this->conexao, $sql);
		
		return mysqli_affected_rows($this->conexao);
	}
}
?>