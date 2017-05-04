<?php

include( 'inc-daysarray.php' );
date_default_timezone_set( 'America/Los_Angeles' );
$dw = date( 'N' );//, $timestamp);  //  Today (numeric, 0-6)

echo '<select name="day" id="day">';
for ( $i = 0; $i < count( $days ); $i++ ) {
	$today = $i == $dw ? ' selected' : '';  //  Set today to SELECTED
	echo '<option value="' . strtoupper( substr( $days[$i], 0, 2 ) ) . '"' . $today . '>On ' . $days[$i] . ' evening</option>';  //  Options, with today selected
}
echo '</select>';

?>