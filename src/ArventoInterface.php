<?php

namespace YG\Arvento;

interface ArventoInterface
{
    public function getNodeFromLicensePlate(string $licensePlate): ?string;

    /**
     * @param string $node
     *
     * @return object|null
     *
     * Example:
     * [strNode] => K1200098807
     * [dtGMTDateTime] => 2023-06-01T03:42:23
     * [dLatitude] => 40.97681
     * [dLongitude] => 34.810963
     * [dSpeed] => 0
     * [strAddress] => Ömer Derindere Blv., Cumhuriyet Mh., Osmancık, Çorum, Türkiye
     * [strRegion] =>
     * [nCourse] => 0
     * [dOdometer] => 24507
     * [nAltitude] => 0
     */
    public function getVehicleStatusByNodeV3(string $node): ?object;
}