<?php

namespace Jma\Invoicing\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Description of Tag
 *
 * @author Maarek
 *
 * @ORM\Entity
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="Jma\Invoicing\AppBundle\Repository\TagRepository")
 */
class Tag
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @NotNull()
     */
    protected $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @NotNull()
     */
    protected $color;

    /**
     * @ORM\ManyToOne(targetEntity="Entrepreneur")
     * @ORM\JoinColumn(nullable=true)
     * @var Entrepreneur
     */
    protected $entrepreneur;

    // GETTER / SETTER

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     * @return Tag
     */
    public function setColor($color)
    {
        $this->color = $color;
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
     * @param mixed $id
     * @return Tag
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return Tag
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return Entrepreneur
     */
    public function getEntrepreneur()
    {
        return $this->entrepreneur;
    }

    /**
     * @param Entrepreneur $entrepreneur
     * @return Tag
     */
    public function setEntrepreneur($entrepreneur)
    {
        $this->entrepreneur = $entrepreneur;
        return $this;
    }
}