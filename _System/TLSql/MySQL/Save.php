<?php 
class Save {
	private $conexao;
	
	public function __construct($conexao) {
		$this->conexao = $conexao;
	}
	
	public function Save($objeto,$id) {
		if(is_object($objeto)) {
			if(count($objeto)>0) {				
				$tabela = str_replace($id,'',key($objeto));				
				$funcao = 'get' . ucfirst($id);				
				
				if($objeto->$funcao()) {
					//update
					$sql = "UPDATE " . trim($tabela) . " SET ";
					$codigo = '';
					$sqlValores = '';		
										
					if(count($objeto)>0) {
						
						do {
							$campo = str_replace($tabela,'',key($objeto));
								
							$funcao = 'get' . ucfirst($campo);
							
							if($campo!=$id)
								$sqlValores .= $campo . "='" . $objeto->$funcao() . "',";
							else
								$codigo = $objeto->$funcao();
							
							next($objeto);
						} while(key($objeto));
						
						$sqlValores = substr($sqlValores, 0, strlen($sqlValores)-1);
					}
					$sql .= $sqlValores	. ' WHERE ' . $id . '=' . $codigo;
					
					$query = mysqli_query($this->conexao, $sql);
					
					return $codigo;
				} else {
					//insert
					$sql = "INSERT INTO " . trim($tabela);
					$sqlCampos = '';
					$sqlValores = '';
					if(count($objeto)>0) {
						do {
							$campo = str_replace($tabela,'',key($objeto));						
							$funcao = 'get' . ucfirst($campo);
								
							if($campo!=$id) {
								$sqlCampos .= $campo . ',';
								$sqlValores .= "'".$objeto->$funcao()."',";								
							}
							
							next($objeto);
						} while(key($objeto));
						
						$sqlCampos = substr($sqlCampos, 0, strlen($sqlCampos)-1);
						$sqlValores = substr($sqlValores, 0, strlen($sqlValores)-1);
					}
					$sql .= ' (' . $sqlCampos .')' . ' VALUES (' . $sqlValores . ')';					
					$query = mysqli_query($this->conexao,$sql);
					
					return mysqli_insert_id($this->conexao);
				}
			}
		}
	}
	
}
?>