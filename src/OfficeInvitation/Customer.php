<?php

namespace OfficeInvitation;

class Customer
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $latitude;
    /**
     * @var string
     */
    private $longitude;

    public function __construct(int $id, string $name, float $latitude, float $longitude)
    {
        $this->id = $id;
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getDistanceInKmTo(float $latitude, float $longitude): int
    {
        return $this->haversineGreatCircleDistance($latitude, $longitude);
    }

    /**
     * @param float $latitudeTo
     * @param float $longitudeTo
     * @param int   $earthRadius
     *
     * @return float
     */
    private function haversineGreatCircleDistance(float $latitudeTo, float $longitudeTo, $earthRadius = 6371000): float
    {
        // convert from degrees to radians
        $latitudeFrom = deg2rad($this->latitude);
        $longitudeFrom = deg2rad($this->longitude);
        $latitudeTo = deg2rad($latitudeTo);
        $longitudeTo = deg2rad($longitudeTo);

        $latitudeDelta = $latitudeTo - $latitudeFrom;
        $longitudeDelta = $longitudeTo - $longitudeFrom;

        $angle = 2 * asin(
                sqrt(
                    pow(sin($latitudeDelta / 2), 2) +
                    cos($latitudeFrom) * cos($latitudeTo) *
                    pow(sin($longitudeDelta / 2), 2)
                )
            );

        return ($angle * $earthRadius) / 1000;
    }

}
