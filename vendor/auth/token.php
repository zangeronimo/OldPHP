<?php 
class token {
	
	private $user = "xxx";
	private $pass = "xxx";
	private $url = "xxx";
	private $basic = "sss:xxx";
	
	public function __construct() {
		$this->login();
	}
	
	public function get($url) {
		$curl = curl_init();
		
		$curl = $this->basicCommands($curl, $url);
		
		$result = curl_exec($curl);
		curl_close($curl);
		
		return json_decode($result, true);
	}
	
	public function post($url, $data) {
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_POST, 1);
		
		if ($data)
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		
		$curl = $this->basicCommands($curl, $url);
		
		$result = curl_exec($curl);
		curl_close($curl);
		
		return json_decode($result, true);
	}
	
	private function login() {
		$dados = ['username'=>$this->user,'password'=>$this->pass,'grant_type'=>'password'];
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url . "/oauth/token");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->basic);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$server_output = curl_exec ($ch);
				
		curl_close ($ch);
		
		$result = json_decode($server_output, true);
		$this->setToken($result['access_token']);
	}
	
	private function setToken($token) {
		$_SESSION['access_token'] = $token;
	}
	
	private function getToken() {
		return $_SESSION['access_token'];
	}
	
	private function basicCommands($curl, $url) {
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, $this->basic);
		
		curl_setopt($curl, CURLOPT_URL, $this->url . $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		$authorization = "Authorization: Bearer ".$this->getToken();
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		return $curl;
	}
}
?>
