<?php
/*
 * This file contains a set of global helper functions
 */

use Carbon\Carbon;

/**
 * Returns a data string of the day one month ago
 *
 * @return string
 */
function oneMonthAgo(){
    return Carbon::now()->subMonth()->format('Y-m-d');
}

/**
 * Returns the current date string
 *
 * @return string
 */
function getToday(){
    return Carbon::now()->format('Y-m-d');
}

?>
