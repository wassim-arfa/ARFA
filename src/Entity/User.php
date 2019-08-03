<?php
//App/src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="following")
     */
    private $followers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="followers")
     * @ORM\JoinTable(name="following",
     *              joinColumns={ @ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *              inverseJoinColumns={ @ORM\JoinColumn(name="following_user_id", referencedColumnName="id")}             
     * )
     */
    private $following;

    public function __construct()
    {
        parent::__construct();
        
        $this->roles[] = 'ROLE_USER';
        $this->followers = new ArrayCollection();
        $this->following = new ArrayCollection();
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

    /**
     * @return Collection|self[]
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollower(self $follower): self
    {
        if (!$this->followers->contains($follower)) {
            $this->followers[] = $follower;
        }

        return $this;
    }

    public function removeFollower(self $follower): self
    {
        if ($this->followers->contains($follower)) {
            $this->followers->removeElement($follower);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getfollowing(): Collection
    {
        return $this->following;
    }

    public function addUser(self $user): self
    {
        if (!$this->following->contains($user)) {
            $this->following[] = $user;
            $user->addFollower($this);
        }

        return $this;
    }

    public function removeUser(self $user): self
    {
        if ($this->following->contains($user)) {
            $this->following->removeElement($user);
            $user->removeFollower($this);
        }

        return $this;
    }

    


}
