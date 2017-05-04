<?php

//include( 'inc-accesstoken.php' );
include( 'inc-schedules.php' );

/*$url_schedules = 'https://api.whenhub.com/api/users/me/schedules/?access_token=' . $accesstoken;
$jsonfile_schedules = file_get_contents( $url_schedules );
$jsondata_schedules = json_decode( $jsonfile_schedules );*/

echo '<select name="city" id="city">';
for( $i = 1; $i < count( $jsondata_schedules ); $i++ ){
	$name = $jsondata_schedules[$i]->name;
	$id = $jsondata_schedules[$i]->id;
	echo '<option value="' . $id . '">in ' . $name . '.</option>';
}
echo '</select>';

?>