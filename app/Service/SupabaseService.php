<?php

namespace App\Service;

use GuzzleHttp\Client;

class SupabaseService
{
	protected $client;
	protected $url;
	protected $serviceKey;
	protected $bucket;

	public function __construct()
	{
		$this->client = new Client();
		$this->url = "https://xszdnqlritwdtczttnkz.supabase.co";

		$this->serviceKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhzemRucWxyaXR3ZHRjenR0bmt6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTUxNzE3NjAsImV4cCI6MjA3MDc0Nzc2MH0.H4ALxp5dufYV3Ur3QFhSadNRshIsbPqOLK48WMIpTmY";

		$this->bucket = "events-images";
	}

	/**
	 * Fetch all events from Supabase.
	 * Filters events based on the current date.
	 * Display images associated with active events.
	 */
	public function getAllEvents()
	{
		$response = $this->client->request('GET', "{$this->url}/rest/v1/events", [
			'headers' => [
				'Authorization' => "Bearer {$this->serviceKey}",
				'apikey' => $this->serviceKey,
				'Content-Type' => 'application/json',
			],
		]);

		if ($response->getStatusCode() === 200) {
			$data = json_decode($response->getBody()->getContents(), true);
			return $data;
		}
	}


}
