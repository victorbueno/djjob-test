<?php

Class Calendar {
	var $facebook;
	var $eventName;
	var $eventStartTime;
	var $eventDescription;
	var $eventLocation;
	var $privacyType;

	public function __construct($facebook, $eventName, $eventStartTime, $eventDescription, $eventLocation, $privacyType) {
		$this->facebook = $facebook;
		$this->eventName = $eventName;
		$this->eventStartTime = $eventStartTime;
		$this->eventDescription = $eventDescription;
		$this->eventLocation = $eventLocation;
		$this->privacyType = $privacyType;
	}

	public function send() {
		$user = $this->facebook->getUser();
		$access_token = $this->facebook->getAccessToken();

		$response = $this->facebook->api(
			"/me/events",
			"POST",
			array (
				'name' => $this->eventName,
				'start_time' => $this->eventStartTime,
				#'end_time' => '',
				'description' => $this->eventDescription,
				'location' => $this->eventLocation,
				#'location_id' => ''
				'privacy_type' => $this->privacyType,
				'access_token' => $access_token,
				)
			);

			#save the event id!
			#$response['id'];
	}

	public function perform() {
		$this->send();
	}

	public function sendLater() {
		DJJob::enqueue($this);
	}

}

?>