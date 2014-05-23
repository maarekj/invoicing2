<?php

namespace Jma\Invoicing\AppBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Jma\Invoicing\AppBundle\Entity\Entrepreneur;

/**
 * Description of User
 *
 * @author Maarek
 */
class User implements UserInterface
{

    private $username;
    private $password;
    private $salt;
    private $roles;
    
    /**
     * @var Entrepreneur
     */
    private $entrepreneur;
    
    function __construct($username, $password, array $roles = array())
    {
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
        $this->salt = "";
    }
    
    public function setEntrepreneur(Entrepreneur $entrepreneur = null)
    {
        $this->entrepreneur = $entrepreneur;
        return $this;
    }
    
    /**
     * @return Entrepreneur
     */
    public function getEntrepreneur()
    {
        return $this->entrepreneur;
    }

    public function eraseCredentials()
    {
        
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function equals(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

}
