<?php

//$city = $_GET['city'];
include( 'inc-accesstoken.php' );

$url_schedules = 'https://api.whenhub.com/api/users/me/schedules/?access_token=' . $accesstoken;
$jsonfile_schedules = file_get_contents( $url_schedules );
$jsondata_schedules = json_decode( $jsonfile_schedules );

?>