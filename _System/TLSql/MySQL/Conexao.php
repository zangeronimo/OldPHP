<?php 
class Conexao {	
	public function _connect($host,$base,$user,$pass) {
		return mysqli_connect($host,$base,$user,$pass);
	}
	public function _close($conexao) {
		mysqli_close($conexao);
	}
}
?>