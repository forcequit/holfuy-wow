<?php

//
// Post Holfuy to WOW
// 
// Steps:
// 1 Create wow a/c on wow.metoffice.gov.uk
// 2 Note the Siteid & 6 digit pin via Edit Site.
// 3 Get Holfuy stationid & pw via https://api.holfuy.com/
//
// wow api reference: https://wow.metoffice.gov.uk/support/dataformats#automatic
//
// By @ventryweather

$h1 = file_get_contents('https://api.holfuy.com/live/?s=xxx&pw=xxx&m=JSON&tu=F&su=mph&utc&avg=2&daily');

$h2 = json_decode($h1);

$dt	= urlencode($h2->dateTime);

$temp 	 = $h2->temperature;
$maxtemp = $h2->daily->max_temp;
$mintemp = $h2->daily->min_temp;

$inch = (($h2->pressure) * 0.029529983071445); //convert hPa to Inches.

$wd	= $h2->wind->direction;
$ws	= $h2->wind->speed;
$wg = $h2->wind->gust;

$rain 	 = $h2->rain;
$sumrain = $h2->daily->sum_rain;

//convert mm to inches
$rain_in 	= ($rain / 25.4);
$sumrain_in = ($sumrain / 25.4);

$wow = "https://wow.metoffice.gov.uk/automaticreading?siteid=xxx&siteAuthenticationKey=xxx";

$wow .= '&dateutc=' . $dt . '&baromin=' . $inch . '&tempf=' . $temp . '&winddir=' . $wd . '&windspeedmph=' . $ws . '&windgustmph=' . $wg . '&rainin=' . $rain_in . '&dailyrainin=' . $sumrain_in . '&softwaretype=API';

$ch = curl_init($wow);
curl_exec($ch);

?>