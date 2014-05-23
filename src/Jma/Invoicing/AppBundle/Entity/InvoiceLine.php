<?php

namespace Jma\Invoicing\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * Description of InvoiceLine
 *
 * @author Maarek
 *
 * @ORM\Entity
 * @ORM\Table(name="invoice_line")
 */
class InvoiceLine
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="lines")
     * @NotNull()
     * @var Invoice
     */
    protected $invoice;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $quantity;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    protected $unitPrice;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $unit;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $options;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $position;


    public function getTotal()
    {
        return $this->quantity * $this->getUnitPrice();
    }

    // GETTER / SETTER

    /**
     * @param mixed $description
     * @return InvoiceLine
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $id
     * @return InvoiceLine
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
     * @param \Jma\Invoicing\AppBundle\Entity\Invoice $invoice
     * @return InvoiceLine
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
        return $this;
    }

    /**
     * @return \Jma\Invoicing\AppBundle\Entity\Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @param mixed $options
     * @return InvoiceLine
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $position
     * @return InvoiceLine
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $quantity
     * @return InvoiceLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $unitPrice
     * @return InvoiceLine
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     * @return InvoiceLine
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
        return $this;
    }

}