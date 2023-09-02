<?php 
class Executa {
	private $conexao;
	
	public function __construct($conexao) {
		$this->conexao = $conexao;
	}
	
	public function Executa($sql,$retorna=null) {				
		$query = mysqli_query($this->conexao, $sql);
				
		if(strtolower(substr($sql,0,6))=='insert') {
			return mysqli_insert_id($this->conexao);
		}
		
		if($retorna) {
			$retorna = array();
			while($row = mysqli_fetch_assoc($query))
			{
				$retorna[] = $row;
 			}
 			
 			return $retorna;
		}
		
		return mysqli_affected_rows($this->conexao);
	}
}
?>