<?php

include( 'inc-accesstoken.php' );
$city = $_GET['city'];
$url = 'https://api.whenhub.com/api/users/me/schedules/' . $city . '/events/?access_token=' . $accesstoken;
$jsonfile_events = file_get_contents( $url );
$jsondata_events = json_decode( $jsonfile_events );

?>