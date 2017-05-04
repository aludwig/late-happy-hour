<?php

$day = $_GET[ 'day' ];
$location = $_GET[ 'location' ];
include( 'inc/inc-events.php' );
include( 'inc/inc-utcconversion.php' );  //  Handy utcconversion function switches start and end times from UTC to regular Los Angeles time

usort( $jsondata_events, function( $a, $b ) {  //  Sort results by city alphabetically  //  http://stackoverflow.com/questions/23779412/sort-json-object-in-php-by-a-key-value
    return $a->location->city < $b->location->city ? -1 : 1;
});

$itemcount = 0;  //  Init
for( $i = 0; $i < count( $jsondata_events ); $i++ ){
	
    $days = $jsondata_events[$i]->when->recurrenceRule;
	$name = $jsondata_events[$i]->name;
    $location = $jsondata_events[$i]->location->name;
    $city = $jsondata_events[$i]->location->city;
	$description = $jsondata_events[$i]->description;
	$id = $jsondata_events[$i]->id;
    
    $start = utcconversion( $jsondata_events[$i]->when->startDate );  //  Happy Hour start time
    if ( $jsondata_events[$i]->when->endDate == null ){  //  No end time has been specified, so Happy Hour continues until closing time
        $end = 'Close';
    } else {
        $end = utcconversion( $jsondata_events[$i]->when->endDate );  //  End time has been specified
    }
	
    if ( strpos( substr( $days, strripos( $days, '=')), $day ) !== false ) {  //  Check to see if day ("SU", "MO", etc) matches up with selected day
		$itemcount++;
        if ( $itemcount == 1 ){  //  At least one item is available, so open ul tag:
            echo '<ul data-role="listview" data-inset="true" id="listitems">';
        }
		echo '
			<li id="' . $id . '">
				<a href="#">
				<h3>' . $location . ' | ' . $city . '</h3>
				<p>' . $start . ' - ' . $end . '</p> | ' . $description . '
				</a>
			</li>';  //  List items
    }
}

if ( $itemcount < 1 ) {  //  Uh oh!  None available..
    include( 'inc/inc-schedules.php' );  //  (Cities)
    include( 'inc/inc-daysarray.php' );  //  Days of the week
    
    for ( $i = 0; $i < count( $jsondata_schedules ); $i++ ){  //  Get city
        if ( $location == $jsondata_schedules[$i]->id ) {
            $city = $jsondata_schedules[$i]->name;
        }
    }
    for ( $d = 0; $d < count( $days ); $d++ ){  //  Get day (fully spelled out)
        if ( strtolower(substr( $days[$d], 0, 2 )) == strtolower( $day ) ){
            $selectedday = $days[$d];
        }
    }
	echo '<h2>Damn it.</h2><p>Well, it looks like I\'ve got nothing in ' . $city . ' on ' . $selectedday . ' evenings.</p>';
    echo '<p>Please <a href="#page-home" data-transition="slide" data-direction="reverse">try a different location or day</a>, and <a href="mailto:aaron@latehappyhour.com">let me know</a> of any great Late Happy Hour deals that I\'ve missed!</p>';
} else {  //  List available!  Just closing off the ul here.
    echo '</ul>';
}

?>