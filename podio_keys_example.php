<?
/**
* 
*/
class PodioKeys
{
	private $bialystok = array('my_app_id' => '11111111', 'my_app_token' => '11111fdsfsfasdf', 
		'client_secret' => 'client-secret-key-from-podio', 
		'client_id' => 'client-id-key-from-podio');
	private $gdansk = array('my_app_id' => '22222222', 'my_app_token' => '2222222dgffsdgdsfg', 
		'client_secret' => 'client-secret-key-from-podio', 
		'client_id' => 'client-secret-id-from-podio');
	


	public function getLCKeys($lcname)
	{
		$miasto = null;
		switch ($lcname) {
			
			case "gdansk":			
				$miasto = $this->gdansk;
				break;
			case "bialystok":		
				$miasto = $this->bialystok;
				break;
		}
		
		return $miasto;
	}
}

?>