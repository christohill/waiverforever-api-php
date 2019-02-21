<?php

namespace WaiverForever;

/**
 * Super-simple, Waiver Forever API wrapper
 * Waiver Forever API: https://docs.waiverforever.com/
 *
 * @author  Chris Tohill <chris@visualoverdose.ca>
 * @version 1.0
 */

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class WaiverForever {

	protected $client;
	protected $api_key;
	protected $api_base = "https://api.waiverforever.com/openapi";
	protected $api_version = "v1";



	/**
	 * Create a new instance
	 * @param String $key Application API key
	 */
	public function __construct($key = NULL) {

		// Set the API key
		if($key != NULL) {
			$this->setApiKey($key);
		}

		// Set the client object
		$this->client = new Client([
			'base_uri' => $this->getApiUrl(),
			'headers' => [
				"Accept" => "application/json",
	  			"X-API-Key" => $this->getApiKey()
			]
		]);

	}



	/**
	 * Send request to API
	 * @param  String $verb     The HTTP verb to use (GET, POST, etc)
	 * @param  String $endpoint Waiver Forever API endpoint
	 * @param  Array  $data     The data to send to the endpoint
	 * @param  Array  $headers  Headers to include with the request
	 * @return Object           Return an instance of createResponse()
	 */
	protected function performRequest(string $verb, string $endpoint, $data = NULL, $headers = array()) {

		$client = $this->getClient();
		$request = $client->$verb($endpoint, [
			'headers' => $headers,
			'json' => $data
		]);

		return $this->createResponse($request->getBody());

	}



	/**
	 * Create a response object 
	 * @param  Object $response The Client object
	 * @return Object           The final response object
	 */
	protected function createResponse($request) {

		$data = json_decode($request);

		if($data->result === true && isset($data->data)) {
			return $data->data;
		}else {
			return $request;
		}

	}



	/**
	 * Get user info for the API key
	 *
	 * @link https://docs.waiverforever.com/#get-user-info
	 */
	public function UserInfo() {
		return $this->performRequest('get', 'auth/userInfo');
	}



	/**
	 * Get all webhooks subscriptions.
	 *
	 * @link https://docs.waiverforever.com/#get-all-subscriptions
	 */
	public function AllSubscriptions() {
		$response = $this->performRequest('get', 'webhooks/');
		return $response[0];
	}



	/**
	 * Subscribe an event/webhook
	 * @param string $target   Callback URL
	 * @param string $template Template ID
	 * @param string $event    Event/webhook name
	 *
	 * @link https://docs.waiverforever.com/#subscribe-an-event
	 */
	public function CreateSubscription(string $target, string $template, string $event) {

		$data = [
			'target_url' => $target,
			'template_id' => $template,
			'event' => $event
		];

		return $this->performRequest('post', 'webhooks/', $data);

	}



	/**
	 * Unsubscribe an event
	 * @param String $subscriptionID Subscription ID
	 *
	 * @link https://docs.waiverforever.com/#unsubscribe-an-event
	 */
	public function DeleteSubscription($subscriptionID) {
		return $this->performRequest('delete', "webhooks/{$subscriptionID}/");
	}



	/**
	 * List all templates
	 *
	 * @link https://docs.waiverforever.com/#get-template-list
	 */
	public function TemplateList() {
		return $this->performRequest('get', 'templates');
	}



	/**
	 * Request a waiver to sign
	 * @param String  $template Template ID
	 * @param integer $expiry   Request waiver expiration time (in seconds)
	 *
	 * @link https://docs.waiverforever.com/#requeset-waiver
	 */
	public function WaiverRequest($template, $expiry = 86400) {
		return $this->performRequest('get', "template/{$template}/requestWaiver?ttl={$expiry}");
	}



	public function TrackingWaiver($trackingID) {
		return $this->performRequest('get', "waiver/tracking/{$trackingID}");
	}



	/**
	 * Get a signed waiver
	 * @param String $waiver Waiver ID
	 *
	 * @link https://docs.waiverforever.com/#get-signed-waiver
	 */
	public function SignedWaiver($waiver) {
		return $this->performRequest('get', "waiver/{$waiver}");
	}



	/**
	 * Search waiver with keywords.
	 * @param Array $filters Filters for the search
	 *
	 * @link https://docs.waiverforever.com/#waiver-search
	 */
	public function SearchWaiver($filters = array()) {
		return $this->performRequest('post', 'waiver/search', $filters);
	}



	/**
	 * Download waiver in pdf
	 * @param String $waiver Waiver ID
	 *
	 * @link https://docs.waiverforever.com/#download-waiver-pdf
	 */
	public function WaiverPDF($waiver) {
		return $this->performRequest('get', "waiver/{$waiver}/pdf");
	}



	/**
	 * Download waiver pictures
	 * @param String $waiver  Waiver ID
	 * @param String $picture Picture ID
	 *
	 * @link https://docs.waiverforever.com/#download-waiver-pictures
	 */
	public function WaiverPicture($waiver, $picture) {
		return $this->performRequest('get', "waiver/{$waiver}/picture/{$picture}");
	}



	/**
	 * Get client object
	 */
	public function getClient() {
		return $this->client;
	}



	/**
	 * Get current API key
	 */
	protected function getApiKey() {
		return $this->api_key;
	}



	/**
	 * Set API key
	 */
	public function setApiKey($key) {
		$this->api_key = $key;
	}



	/**
	 * Get base URL for Waiver Forever API
	 */
	public function getApiBase() {
		return $this->api_base;
	}



	/**
	 * Get the API version
	 */
	public function getApiVersion() {
		return $this->api_version;
	}



	/**
	 * Set API version
	 */
	public function setApiVersion($version) {
		$this->api_version = $version;
	}



	/**
	 * Get full API URI for requests
	 */
	public function getApiUrl() {
		return implode('/', array($this->getApiBase(), $this->getApiVersion())) . "/";
	}

}