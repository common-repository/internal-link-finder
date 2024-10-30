<?php 
/**
 * Get the impact a has from a page (link juice).
 *
 * @param string   $link_count The number of links on the page.
 * 
 * @return int The impact of the page.
 */
function wilo_calculate_impact($link_count){

    if($link_count > 10):
        $impact = 5;
    elseif($link_count > 9):
        $impact = 10;
    elseif($link_count > 8):
        $impact = 20;
    elseif($link_count > 7):
        $impact = 30;
    elseif($link_count > 6):
        $impact = 40;
    elseif($link_count > 5):
        $impact = 45;
    elseif($link_count > 4):
        $impact = 50;
    elseif($link_count > 3):
        $impact = 60;
    elseif($link_count > 2):
        $impact = 75;
    elseif($link_count > 1):
        $impact = 80;
    else:
        $impact = 100;
    endif;

    $impact = round($impact, 0);

    return $impact;

}