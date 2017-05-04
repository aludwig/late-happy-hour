<?php

function utcconversion( $datetime ){
    $UTC = new DateTimeZone("UTC");
    $newTZ = new DateTimeZone("America/Los_Angeles");
    $date = new DateTime( $datetime, $UTC );
    $date->setTimezone( $newTZ );
    return $date->format('g:ia');
}

?>