<?php

namespace Jma\Invoicing\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of Client
 *
 * @author Maarek
 *
 * @ORM\Entity
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="Jma\Invoicing\AppBundle\Repository\ClientRepository")
 */
class Client
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Entrepreneur", inversedBy="clients")
     * @var ArrayCollection
     */
    protected $entrepreneurs;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

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
    protected $legalForm;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    protected $more;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $phone;

    // GETTER / SETTER

    /**
     * @param mixed $city
     * @return Client
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
     * @param mixed $complement
     * @return Client
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
     * @param mixed $id
     * @return Client
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
     * @param mixed $legalForm
     * @return Client
     */
    public function setLegalForm($legalForm)
    {
        $this->legalForm = $legalForm;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLegalForm()
    {
        return $this->legalForm;
    }

    /**
     * @param mixed $more
     * @return Client
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
     * @param mixed $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $street
     * @return Client
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
     * @param mixed $zipcode
     * @return Client
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

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     * @return Client
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEntrepreneurs()
    {
        return $this->entrepreneurs;
    }

    /**
     * @param ArrayCollection $entrepreneurs
     * @return Client
     */
    public function setEntrepreneurs($entrepreneurs)
    {
        $this->entrepreneurs = $entrepreneurs;
        return $this;
    }

    /**
     * @param Entrepreneur $entrepreneur
     * @return $this
     */
    public function addEntrepreneur(Entrepreneur $entrepreneur)
    {
        if (false === $this->entrepreneurs->contains($entrepreneur)) {
            $this->entrepreneurs->add($entrepreneur);
        }

        $entrepreneur->addClient($this);

        return $this;
    }

    /**
     * @param Entrepreneur $entrepreneur
     * @return $this
     */
    public function removeEntrepreneur(Entrepreneur $entrepreneur)
    {
        if (true === $this->entrepreneurs->contains($entrepreneur)) {
            $this->entrepreneurs->removeElement($entrepreneur);
        }

        $entrepreneur->removeClient($this);

        return $this;
    }
}