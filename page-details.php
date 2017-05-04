<?php

$selectedlistitem = $_GET['selectedlistitem'];
include( 'inc/inc-events.php' );
include( 'inc/inc-utcconversion.php' );  //  utcconversion function because start and end times are provided in UTC
include( 'inc/inc-daysarray.php' );  //  Days of the week
include( 'inc/yelp-functions.php' );

for( $i = 0; $i < count( $jsondata_events ); $i++ ){
	
	$id = $jsondata_events[$i]->id;
	$name = $jsondata_events[$i]->name;
	$location_name = $jsondata_events[$i]->location->name;
    $location_address = $jsondata_events[$i]->location->address;
    $location_city = $jsondata_events[$i]->location->city;
    $location_zip = $jsondata_events[$i]->location->postalCode;
    $location_region = $jsondata_events[$i]->location->region;
    $location_lat = $jsondata_events[$i]->location->geolocation->lat;
    $location_lng = $jsondata_events[$i]->location->geolocation->lng;
	$description = $jsondata_events[$i]->description;
    $start = utcconversion( $jsondata_events[$i]->when->startDate );
    
    if ( $jsondata_events[$i]->when->endDate == null ){  //  If deal end time is not defined, the bar/restaurant has specified that it goes "until close"
        $end = 'Close';
    } else {
        $end = utcconversion( $jsondata_events[$i]->when->endDate );
    }
    
    $daysavailable = $jsondata_events[$i]->when->recurrenceRule;
    $daysavailable = substr( strrchr( $daysavailable, '=' ), 1 );
	
	$customfields = get_object_vars( $jsondata_events[$i]->customFieldData );  //  Get customFieldData (a different unique code for each city (Schedule)
	foreach ( $customfields as $key => $value ) {
		if ( strpos( $jsondata_events[$i]->customFieldData->{$key}->value, 'yelp' ) == false ) {
			$customfielddata_website = $key;
		} else {
			$customfielddata_yelp = $key;
		}
	}
    $link_directions = 'https://www.google.com/maps/place/' . $location_address . ',' . $location_city . ',' . $location_region . '+' . $location_zip . '/@' . $location_lat . ',' . $location_lng;
	$link_yelp = $jsondata_events[$i]->customFieldData->{$customfielddata_yelp}->value;  //  $link_yelp = 'http://yelp.com/biz/' . $jsondata_events[$i]->customFieldData->{'896ecc72-751f-42d3-bc3d-3ce4c7c872b3'}->value;
    $link_website = $jsondata_events[$i]->customFieldData->{$customfielddata_website}->value;  //  $link_website = $jsondata_events[$i]->customFieldData->{'6892e5dd-c058-41fe-a7ec-8e852da82637'}->value;
	
    
	if ( $id == $selectedlistitem ) {
        
		echo '<h2>' . $name . '</h2>';
		echo $description;
        
        $array_daysavailable = explode( ',', $daysavailable );  //  Put available days into an array
        for ( $a = 0; $a <= count( $array_daysavailable ); $a++ ) {  //  Loop through available days
            for ( $w = 0; $w <= count( $days ); $w++ ) {  //  Loop through all days of the week
                if ( strtolower(substr( $days[$w], 0, 2 )) == strtolower($array_daysavailable[$a]) ){  //  If the first 2 chars of fully spelled out days match with available (abbreviated) days, replace them with fully spelled out version
                    array_splice( $array_daysavailable, $a, 1, $days[$w] );
                }
            }
        }
        if ( count($array_daysavailable) == 7 ){
            $daysconverted = '| 7 nights a week';
        } else {
            $daysconverted = 'on ' . implode( ', ', $array_daysavailable );  //  Write out all fully spelled out days, comma delimited
        }
        
        echo '<p><strong>' . $start . ' - ' . $end . '</strong> ' . $daysconverted . '.</p>';
		
		$image_yelp = '<img src="' . yelpimage( $link_yelp ) . '" class="image-yelp" />';
		$image_googlemap = '<img src="https://maps.googleapis.com/maps/api/staticmap?center=' . $location_lat . ',+' . $location_lng . '&zoom=14&scale=false&size=250x250&maptype=roadmap&format=gif&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C' . $location_lat . ',+' . $location_lng . '&key=AIzaSyA2bjJCFglTXGTUjiqSOw0u4sG-3SgLKTI" class="image-googlemap" />';
        //echo '<img src="https://maps.googleapis.com/maps/api/staticmap?center=' . $location_lat . ',+' . $location_lng . '&zoom=14&scale=false&size=500x200&maptype=roadmap&format=gif&visual_refresh=true&markers=size:mid%7Ccolor:0xff0000%7Clabel:%7C' . $location_lat . ',+' . $location_lng . '&key=AIzaSyA2bjJCFglTXGTUjiqSOw0u4sG-3SgLKTI" class="googleimage" />';
		
		echo '<div class="ui-grid-a">';
		echo '<div class="ui-block-a">' . $image_yelp . '</div>';
		echo '<div class="ui-block-b">' . $image_googlemap . '</div>';
		echo '</div>';
		
		echo '<h4>' . $location_name . '</h4><p>' . $location_address . '<br />' . $location_city . ', ' . $location_region . ' ' . $location_zip . '</p>';
        echo '<div class="ui-grid-b ui-responsive">
                <div class="ui-block-a">
                    <a href="' . $link_directions . '" class="ui-btn ui-corner-all" data-rel="external" target="_blank">Get Directions</a>
                </div>
                <div class="ui-block-b">
                    <a href="' . $link_website . '" class="ui-btn ui-corner-all" data-rel="external" target="_blank">Visit Website</a>
                </div>
                <div class="ui-block-c">
                    <a href="' . $link_yelp . '" class="ui-btn ui-corner-all" data-rel="external" target="_blank">Reviews on Yelp</a>
                </div>
            </div>';
        
        echo '<p>Is this deal no longer valid?  Got a hot tip on a great Late Happy Hour deal that I\'ve missed? <a href="mailto:aaron@latehappyhour.com">Let me know</a>!</p>';
        echo '<hr />
        <p>Don\'t drink &amp; drive! Use promo code <a href="https://get.uber.com/invite/uber-happyhour" data-rel="external" target="_blank">UBER-HAPPYHOUR</a> to claim your FREE first ride with Uber!</p>';
		echo '<p class="disclaimer">Photo courtesy of <a href="' . $link_yelp . '" data-rel="external" target="_blank">Yelp</a>.</p>';
    }
	
}

?>