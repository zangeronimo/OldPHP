<?php 
class comum {

	public function pagging($quantidade,$tpl) {
		$total = 0;
		if(isset($_SESSION['TLClass']['paginacao']['total'])) {
			$total = $_SESSION['TLClass']['paginacao']['total'];
		}
			
		$pagina = 1;
		if(isset($_REQUEST['pagina'])) {
			$pagina = $_REQUEST['pagina'];
		}
	
		$inicio = $quantidade * $pagina;
	
		$elemento = '?';
		//verifico se existe parametros já passados
		$query_string = $_SERVER['QUERY_STRING'];
		if(isset($_GET['pagina'])) {
			$query_string = str_replace('&pagina='.$_GET['pagina'],'',$query_string);
			$query_string = str_replace('pagina='.$_GET['pagina'],'',$query_string);
		}
	
		if($query_string)
			$elemento .= $query_string . '&';
	
			$previous = $elemento."pagina=".($pagina -1);
			$previous_disable = '';
	
			if($pagina<=1) {
				$previous = '';
				$previous_disable = 'class="disabled"';
			}
	
			$next = $elemento."pagina=".($pagina +1);
			$next_disabled = '';
	
			if($total <= (($pagina)*$quantidade)) {
				$next = '';
				$next_disabled = 'class="disabled"';
			}
				
			$html = '
<ul class="pagination">
    <li '.$previous_disable.'><a href="'.$previous.'" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
	
			$ctrl = 1;
			$active='';
			while($ctrl <= 5) {
				$view = $ctrl;
					
				if($pagina > 3) {
					$dif = ceil($total/$quantidade);
					$view = ($pagina - 3) + $ctrl;
	
					//verifico se são os 2 últimos
					if($dif - $pagina == 0)
						$view = $pagina - 5 + $ctrl;
						if($dif - $pagina == 1)
							$view = $pagina - 4 + $ctrl;
				}
	
				if($view==$pagina)
					$active = 'class="active"';
					else
						$active = '';
							
						$html .= '<li '.$active.'><a href="'.$elemento.'pagina='.$view.'">'.$view.'</a></li>';
	
						//verifico se o total é menor que a quantidade * $ctrl
						if($total <= ($quantidade * $ctrl)) {
							//die('oi');
							break;
						}
							
						$ctrl++;
			}
	
			$html .= '
    <li '.$next_disabled.'><a href="'.$next.'" aria-label="Next"><span aria-hidden="true">»</span></a></li>
</ul>';
	
			$de = ($quantidade * ($pagina-1))+1;
			$ate = $quantidade * $pagina;
	
			if($ate > $total)
				$ate = $total;
	
				$label = 'exibindo de <strong>'.$de.'</strong> até <strong>'.$ate.'</strong> no total de <strong>'.$total.'</strong> registros';
	
				$tpl->setObjeto('pagging',$html);
				$tpl->setObjeto('pagging_label',$label);
	}
	
	public function estaLogado() {
		if(isset($_SESSION['maisreceitas']['user']['codigo'])) {
			return true;
		}
	}
	
	public function checkLogin() {
		if(isset($_SESSION['maisreceitas']['user']['codigo'])) {
			return;
		} else {
			
			$_SESSION['maisreceitas']['user']['redirect'] = $_SERVER['REQUEST_URI'];
			
			header("Location: /user/login");
			exit;
		}
	}
	
	public function logOut() {
		if(isset($_SESSION['maisreceitas']['user'])) {
			unset($_SESSION['maisreceitas']['user']);
		}
		
		header("Location: /home/pagina-inicial");
		exit;
	}
	
	public function getFotosReceitas() {
		$return = array();
		if ( $handle = opendir($_SERVER['DOCUMENT_ROOT'].'/web/upload/receita/') ) {
			while ( $entry = readdir( $handle ) ) {
				if(is_numeric($entry))
					$return[] = $entry;
			}
			closedir($handle);
		}
		
		//arsort($return);
		
		return $return;
	}
	
	public function uploadFile($file,$name,$dir)
	{
		if(is_dir($dir))
		{
			if($file && $name)
			{
				@move_uploaded_file($file,$dir . '/' . $name);
				@chmod($dir . '/' . $name,0777);
			}
		}
	
		if(file_exists($dir . '/' . $name))
			return true;
			else
				return false;
	}
	
	private function _openImage ($imagem)
	{
		$im=@imagecreatefromjpeg($imagem);
		if($im!==false)
			return $im;
			$im=@imagecreatefromgif($imagem);
			if($im!==false)
				return $im;
				$im=@imagecreatefrompng($imagem);
				if($im!==false)
					return $im;
					$im=@imagecreatefromgd($imagem);
					if($im!==false)
						return $im;
						$im=@imagecreatefromgd2($imagem);
						if($im!==false)
							return $im;
							$im=@imagecreatefromwbmp($imagem);
							if($im!==false)
								return $im;
								$im=@imagecreatefromxbm($imagem);
								if($im!==false)
									return $im;
									$im=@imagecreatefromxpm($imagem);
									if($im!==false)
										return $im;
										$im=@imagecreatefromstring(file_get_contents($imagem));
										if($im!==false)
											return $im;
												
											return false;
	}
	
	public function imageResize($imagem,$width,$height,$para,$forca=false)
	{
		$imagem_orig = $this->_openImage($_SERVER['DOCUMENT_ROOT'].$imagem);
	
		$pontoX = ImagesX($imagem_orig);
		$pontoY = ImagesY($imagem_orig);
		$cria = false;
	
		//Cria imagem normal
		if($forca)
		{
			$largura = $width;
			$altura = $height;
		} else {
			if($pontoX > $width)
			{
				$largura = $width;
				$altura = round(($width * $pontoY) / $pontoX);
			} else {
				$largura = $pontoX;
				$altura = $pontoY;
			}
				
			if($altura > $height)
			{
				$largura = round(($height * $pontoX) / $pontoY);
				$altura = $height;
			}
		}
	
		$image_normal = ImageCreateTrueColor($largura, $altura);
	
		ImageCopyResampled($image_normal,$imagem_orig, 0, 0, 0 ,0, $largura, $altura, $pontoX, $pontoY);
		ImageJPEG($image_normal,$para,100);
	
		//Limpa mem�ria
		@chmod($para,0777);
		ImageDestroy($imagem_orig);
		ImageDestroy($image_normal);
	}
	


	public function getImagemExtensao($imagem)
	{
		$size = getimagesize($imagem);
		$tipo = $size[2];
	
		switch($tipo)
		{
			case(3):
				$extensao = 'png';
				break;
	
			case(2):
				$extensao = 'jpg';
				break;
	
			case(1):
				$extensao = 'gif';
				break;
					
			default:
				$extensao = '';
				break;
		}
	
		return $extensao;
	}	
	
	public function trataUrl($u)
	{
		$u = str_replace('/','_',$u);
		$u = str_replace('%','.',$u);
		
		if($u!='')
		{
			$com_acento = "à á â ã ä è é ê ë ì í î ï ò ó ô õ ö ù ú û ü À Á Â Ã Ä È É Ê Ë Ì Í Î Ò Ó Ô Õ Ö Ù Ú Û Ü ç Ç ñ Ñ";
			$sem_acento = "a a a a a e e e e i i i i o o o o o u u u u A A A A A E E E E I I I O O O O O U U U U c C n N";
			$c = explode(' ',$com_acento);
			$s = explode(' ',$sem_acento);
			$pattern = array();
			
			$i=0;
			foreach($c as $letra)
			{
				if(preg_match("/".$letra."/", $u))
				{
					$pattern[] = $letra;
					$replacement[] = $s[$i];
				}
				$i=$i+1;
			}
			
			if(isset($pattern))
			{
				$i=0;
				foreach($pattern as $letra)
				{
					$u = preg_replace("/".$letra."/", $replacement[$i], $u);
					$i=$i+1;
				}
			}
			
			return str_replace(' ','-',strtolower($u). '.htm');
		}
		return "";
	}
	
	public function injection($string)
	{
		return addslashes($string);
	}
	
	public function irPara($url)
	{
		header("Location: ".$url);
		exit;
	}
}
?>