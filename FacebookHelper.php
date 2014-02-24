<?php

class FacebookHelper {

	var $facebook;

	public function __construct() {
		$facebook = new Facebook(array(
			'appId'  => '1467516106805128',
			'secret' => 'cc7930046fcab2b3139e7b48ad739225',
			));
		$this->facebook = $facebook;
	}

	public function login() {
		$user = $this->facebook->getUser();
		if (!$user) {
			$this->facebook->destroySession();
			$params = array(
				'scope' => 'create_event,rsvp_event',
				'redirect_uri' => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
				);
			$loginUrl = $this->facebook->getLoginUrl($params);
			echo "<a href='$loginUrl'>Conectar no aplicativo</a><br />";
			echo "<strong><em>Voc&ecirc; n&atilde;o esta conectado..</em></strong>";
		}
	}
	

}

?>