<?php
namespace AppBundle\Repository;

use AppBundle\Entity\RideStamp;

interface RideStampRepositoryInterface
{
    public function add(RideStamp $stamp) : bool;
    public function remove(int $stampId) : bool;
    public function get(int $stampId) : RideStamp;
    public function find(array $searchArguments) : array;
    public function findAll() : array;
    public function removeAll() : bool;
}