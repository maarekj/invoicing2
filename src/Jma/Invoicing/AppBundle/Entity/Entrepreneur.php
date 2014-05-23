<?php

namespace Jma\Invoicing\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Description of Entrepreneur
 *
 * @author Maarek
 *
 * @ORM\Entity
 * @ORM\Table(name="entrepreneur")
 * @ORM\Entity(repositoryClass="Jma\Invoicing\AppBundle\Repository\EntrepreneurRepository")
 */
class Entrepreneur
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Client", mappedBy="entrepreneur")
     * @var ArrayCollection
     */
    protected $clients;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $siren;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $siret;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $street;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $complement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    protected $more;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    // ADDER / REMOVER

    /**
     * @param Client $client
     * @return Entrepreneur
     */
    public function addClient(Client $client)
    {
        $this->clients[] = ($client);

        return $this;
    }

    /**
     * @param Client $client
     * @return Entrepreneur
     */
    public function removeClient(Client $client)
    {
        $this->clients->removeElement($client);

        return $this;
    }

    // GETTER / SETTER

    /**
     * @param mixed $city
     * @return Entrepreneur
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $clients
     * @return Entrepreneur
     */
    public function setClients($clients)
    {
        $this->clients = $clients;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getClients()
    {
        return $this->clients;
    }

    /**
     * @param mixed $complement
     * @return Entrepreneur
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * @param mixed $firstname
     * @return Entrepreneur
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $id
     * @return Entrepreneur
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $lastname
     * @return Entrepreneur
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $more
     * @return Entrepreneur
     */
    public function setMore($more)
    {
        $this->more = $more;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMore()
    {
        return $this->more;
    }

    /**
     * @param mixed $phone
     * @return Entrepreneur
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $siren
     * @return Entrepreneur
     */
    public function setSiren($siren)
    {
        $this->siren = $siren;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSiren()
    {
        return $this->siren;
    }

    /**
     * @param mixed $siret
     * @return Entrepreneur
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param mixed $street
     * @return Entrepreneur
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $username
     * @return Entrepreneur
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $zipcode
     * @return Entrepreneur
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

}