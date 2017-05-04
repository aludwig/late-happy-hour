<?php

require_once('yelp-oauth.php');
	
function jsondata_yelp ( $url ) {
	
	$unsigned_url = 'https://api.yelp.com/v2/business/' . $url;
	
	// Set your keys here
	$consumer_key = "C3dSqbXTTCeFjb07q4rKrg";
	$consumer_secret = "ka2IJKRByWP-JZd9RPc9doHqkSU";
	$token = "a_tmCDlbh7Wm_ophmSnCIgkojBrXC9J_";
	$token_secret = "U7280tzNcxFaTYRqqhfA0s20Sko";

	// Token object built using the OAuth library
	$token = new OAuthToken($token, $token_secret);

	// Consumer object built using the OAuth library
	$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

	// Yelp uses HMAC SHA1 encoding
	$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

	// Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
	$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

	// Sign the request
	$oauthrequest->sign_request($signature_method, $consumer, $token);

	// Get the signed URL
	$signed_url = $oauthrequest->to_url();

	// Send Yelp API Call
	$ch = curl_init($signed_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$data = curl_exec($ch); // Yelp response
	curl_close($ch);

	// Handle Yelp response data	
	$response = json_decode($data);
    
	return $response;
    //echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT) . '</pre>';  //  Show json (testing)
		
}

function yelpimage ( $yelplink ) {
	$yelpbiz = substr( $yelplink, strrpos($yelplink, '/') + 1 );  //  lazy-dog-restaurant-and-bar-irvine
	$json = jsondata_yelp( $yelpbiz );  //  https://api.yelp.com/v2/business/lazy-dog-restaurant-and-bar-irvine
	$yelpimage = $json->image_url;
	$yelpimagelarge = substr( $yelpimage, 0, strrpos($yelpimage, '/') + 1 ) . 'ls.jpg';
	return $yelpimagelarge;
}

//yelpimage('https://www.yelp.com/biz/lazy-dog-restaurant-and-bar-irvine');

?>