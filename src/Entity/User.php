<?php
//App/src/Entity/User.php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    protected $gravatar;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Return gravatar URL
     */
    public function getGravatar()
    {
            $gravatar = md5($this->getEmail());
            return 'https://www.gravatar.com/avatar/'.$gravatar;
    }
}
