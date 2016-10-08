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

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
