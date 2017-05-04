<?php

$city = $_GET['city'];
include( 'inc-accesstoken.php' );

$url = 'https://api.whenhub.com/api/users/me/schedules/' . $city . '/events/?access_token=' . $accesstoken;
$jsonfile = file_get_contents( $url );
$jsondata = json_decode( $jsonfile );

?>