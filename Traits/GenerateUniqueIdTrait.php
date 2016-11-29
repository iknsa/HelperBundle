<?php

namespace IKNSA\HelperBundle\Traits;

trait GenerateUniqueIdTrait
{
    public function generateUniqueId ($prefix=null, $suffix=null, $cryptAlgorithm=null)
    {
        $date = new \DateTime();
        $date = (string) $date->getTimestamp();

        $aRandomNumber = rand(1e5, 1e15);
        $anotherRandomNumber = rand(1e5, 25e15);

        $uniqueId = $aRandomNumber . $date . $anotherRandomNumber;

        if ($cryptAlgorithm !== null) {
            $uniqueId = bcrypt($uniqueId);
        }

        if ($prefix !== null) {
            $uniqueId = $prefix . $uniqueId;
        }

        if ($suffix !== null) {
            $uniqueId = $uniqueId . $suffix;
        }

        return $uniqueId;
    }
}
