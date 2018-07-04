<?php

namespace AppBundle\Service;

class CheckDistance
{
    public function getDistance($userLat, $userLng, $eventLat, $eventLng, $unit = "K")
    {
        $lon1 = $userLng;
        $lon2 = $eventLng;
        $lat1 = $userLat;
        $lat2 = $eventLat;
        $theta = $lon1 - $lon2;
        $sin = sin(deg2rad($lat1)) * sin(deg2rad($lat2));
        $cos = cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = $sin + $cos;
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } elseif ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}
