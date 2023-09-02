<?php 
class Select {
	private $conexao;
	
	public function __construct($conexao) {
		$this->conexao = $conexao;
	}
	
	public function Select($sql,$objeto=null,$pagging=null) {
		$return = array();
		
		//paginação
		if(is_numeric($pagging)) {
			$total = mysqli_query($this->conexao, $sql);
			$_SESSION['TLClass']['paginacao']['total'] = $total->num_rows;
						
			$paginacao = new pagging($sql,$pagging);
			$sql = $paginacao->getSql();
		}
		
		$query = mysqli_query($this->conexao, $sql);

		while($row = mysqli_fetch_assoc($query))
		{
			if($objeto) {
				$obj = new $objeto();
				if(count($row)>0)
				{
					foreach($row as $key=>$value) {
						$funcao = 'set' . ucfirst($key);
						$obj->$funcao($value);
					}
				}
				
				$return[] = $obj;
			} else {
				$return[] = $row;
			}
		}
		
		return $return;
	}
}
?>