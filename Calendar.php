<?php

Class Calendar {
	var $facebook;

	public function __construct($facebook) {
		$this->facebook = $facebook;
	}

	public function send() {
		

		$user = $this->facebook->getUser();
		$access_token = $this->facebook->getAccessToken();

		echo $access_token;

		$response = $this->facebook->api(
			"/me/events",
			"POST",
			array (
				'name' => 'This is a test event',
				'start_time' => '2014-03-01T13:00:00-0800',
				#'end_time' => '',
				'description' => 'Event description',
				'location' => 'Evento location',
				#'location_id' => ''
				'privacy_type' => 'SECRET',
				'access_token' => $access_token,
				)
			);
	}

	public function perform() {
		$this->send();
	}

	public function sendLater() {
		DJJob::enqueue($this);
	}

}

?>