<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 01.01.17
 * Time: 20:55
 */

namespace tests\AppBundle\Service;


use AppBundle\Service\GpsLocation;
use AppBundle\Service\StravaJsonMapper;

class StravaJsonMapperTest extends \PHPUnit_Framework_TestCase
{
    /** @var StravaJsonMapper $jsonMapper */
    private $jsonMapper;
    private $testRouteStream;

    public function setUp()
    {
        $this->testRouteStream = json_decode('[
    {
        "type": "latlng",
        "data": [
            [
                52.220510000000004,
                21.01835
            ],
            [
                52.221230000000006,
                21.018870000000003
            ],
            [
                52.22203333568446,
                21.019403314002442
            ],
            [
                52.22283666896521,
                21.019936647300433
            ],
            [
                52.22364,
                21.020470000000003
            ]
        ]
    },
    {
        "type": "distance",
        "data": [
            0.0,
            87.62594726646202,
            184.14500191072992,
            280.6640565546932,
            377.18313017006324,
            32370.98213305391
        ]
    },
    {
        "type": "altitude",
        "data": [
            117.66000000000001,
            119.12,
            120.0,
            118.54,
            119.0
        ]
    }
]
', true);
        $this->jsonMapper = new StravaJsonMapper();

    }

    public function testReturnsBeginningOfStravaRouteStreamArray()
    {
        $gpsLocation = $this->jsonMapper->beginningOfRouteStream($this->testRouteStream);
        $expectedGpsLocation = new GpsLocation(52.220510000000004, 21.01835);
        $this->assertEquals($expectedGpsLocation->getLat(), $gpsLocation->getLat());
        $this->assertEquals($expectedGpsLocation->getLon(), $gpsLocation->getLon());
    }

    public function testReturnsDistanceOfStravaRouteArray()
    {
        $distance = $this->jsonMapper->distanceOfRouteStream($this->testRouteStream);
        $this->assertEquals(32,$distance);
    }
}
