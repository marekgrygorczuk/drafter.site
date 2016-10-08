<?php
namespace AppBundle\Entity;

class User
{
    /**
     * @var int
     */
    private $id;

    public function __construct()
    {
        $this->id = mt_rand();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}