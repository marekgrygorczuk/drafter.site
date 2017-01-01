<?php

namespace AppBundle\Type;

use AppBundle\Service\GpsLocation;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;


/**
 * My custom datatype.
 */
class GpsLocationType extends Type
{
    const GPSLOCATION = 'gpslocation'; // modify to match your type name

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'GpsLocation';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) return null;
        $gpsArray = explode(',', $value);
        return new GpsLocation($gpsArray[0], $gpsArray[1]);
    }

    /**
     * @param GpsLocation $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) return null;
        $string = implode(',', [$value->getLat(), $value->getLon()]);
        return $string;
    }

    public function getName()
    {
        return self::GPSLOCATION;
    }
}