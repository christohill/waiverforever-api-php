# waiverforever-api-php
A PHP wrapper for the Waiver Forever API

# Waiver Forever API wrapper for PHP
========
This is a simple PHP SDK for interacting with the Waiver Forever API. All API documentation can be found at https://docs.waiverforever.com

Installation
------

`composer require christohill/waiverforever-api-php`

Usage
------
`Note: none of the API keys or ID below are valid`

#### Simple usage
```php
use WaiverForever\WaiverForever;
$waivers = new WaiverForever('edf59be9216e66eb17093574376d4c5f');
$user = $waivers->UserInfo(); // Get user info for the API key
$templates = $waivers->TemplateList(); // List all templates
$signed = $waivers->SignedWaiver('aWd898gfdsa789ddf'); // Get a signed waiver
```

Methods
------

| Method                                        	| Description							| Docs                                      |
| :---                                          	| :---                              	| :---                                      |
| UserInfo()                    					| Get user info for the API key    		| [Read docs](https://docs.waiverforever.com/#get-user-info) |
| AllSubscriptions()      							| Get all webhooks subscriptions   	 	| [Read docs](https://docs.waiverforever.com/#get-all-subscriptions) |
| CreateSubscription($target, $template, $event)	| Subscribe an event/webhook        	| [Read docs](https://docs.waiverforever.com/#subscribe-an-event) |
| DeleteSubscription($subscriptionID)   			| Unsubscribe an event    				| [Read docs](https://docs.waiverforever.com/#unsubscribe-an-event) |
| TemplateList()                           			| List all templates                	| [Read docs](https://docs.waiverforever.com/#get-template-list) |
| WaiverRequest($template, $expiry)          		| Request a waiver to sign          	| [Read docs](https://docs.waiverforever.com/#requeset-waiver) |
| TrackingWaiver($trackingID)                       | Query signed waiver by tracking id	| [Read docs](https://docs.waiverforever.com/#get-tracking-waiver) |
| SignedWaiver($waiver)                				| Get a signed waiver           		| [Read docs](https://docs.waiverforever.com/#get-signed-waiver) |
| SearchWaiver($filters)                            | Search waiver with keywords           | [Read docs](https://docs.waiverforever.com/#waiver-search) |
| WaiverPDF($waiver)                         		| Download waiver in pdf                | [Read docs](https://docs.waiverforever.com/#download-waiver-pdf) |
| WaiverPicture($waiver, $picture)                  | Download waiver pictures              | [Read docs](https://docs.waiverforever.com/#download-waiver-pictures) |