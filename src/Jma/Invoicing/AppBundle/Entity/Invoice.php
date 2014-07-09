<?php

namespace Jma\Invoicing\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Valid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of Invoice
 *
 * @author Maarek
 *
 * @ORM\Entity
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="Jma\Invoicing\AppBundle\Repository\InvoiceRepository")
 */
class Invoice
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $number;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     */
    protected $footer;

    /**
     * @ORM\ManyToOne(targetEntity="Entrepreneur")
     * @NotNull()
     * @var Entrepreneur
     */
    protected $entrepreneur;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @NotNull()
     * @var Client
     */
    protected $client;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="InvoiceLine", mappedBy="invoice", cascade={"all"}, orphanRemoval=true)
     * @Valid()
     * @var ArrayCollection<InvoiceLine>
     */
    protected $lines;

    /**
     * @ORM\OneToMany(targetEntity="Payment", mappedBy="invoice", cascade={"all"}, orphanRemoval=true)
     * @Valid()
     * @var ArrayCollection<Payment>
     */
    protected $payments;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist", "merge"})
     * @var ArrayCollection<Tag>
     */
    protected $tags;

    public function __construct()
    {
        $this->lines = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    // ADDER / REMOVER

    /**
     * @param InvoiceLine $line
     * @return Invoice
     */
    public function addLine(InvoiceLine $line)
    {
        $line->setInvoice($this);
        $this->lines[] = $line;

        return $this;
    }

    /**
     * @param InvoiceLine $line
     * @return Invoice
     */
    public function removeLine(InvoiceLine $line)
    {
        $this->lines->removeElement($line);
        $line->setInvoice(null);

        return $this;
    }

    /**
     * @param Payment $payment
     * @return $this
     */
    public function addPayment(Payment $payment)
    {
        $payment->setInvoice($this);
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * @param Payment $payment
     * @return $this
     */
    public function removePayment(Payment $payment)
    {
        $this->payments->removeElement($payment);
        $payment->setInvoice(null);

        return $this;
    }


    // GETTER / SETTER

    /**
     * @param \Jma\Invoicing\AppBundle\Entity\Client $client
     * @return Invoice
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return \Jma\Invoicing\AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \Jma\Invoicing\AppBundle\Entity\Entrepreneur $entrepreneur
     * @return Invoice
     */
    public function setEntrepreneur($entrepreneur)
    {
        $this->entrepreneur = $entrepreneur;
        return $this;
    }

    /**
     * @return \Jma\Invoicing\AppBundle\Entity\Entrepreneur
     */
    public function getEntrepreneur()
    {
        return $this->entrepreneur;
    }

    /**
     * @param mixed $footer
     * @return Invoice
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param mixed $id
     * @return Invoice
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
     * @param \Jma\Invoicing\AppBundle\Entity\Line[] $lines
     * @return Invoice
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return ArrayCollection
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param ArrayCollection $payments
     * @return Invoice
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
        return $this;
    }

    /**
     * @param mixed $number
     * @return Invoice
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    public function getTotal()
    {
        return array_reduce($this->getLines()->map(function (InvoiceLine $line) {
            return $line->getTotal();
        })->getValues(), function ($a, $b) {
            return $a + $b;
        }, 0);
    }

    /**
     * @param datetime $created
     * @return Invoice
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }


    /**
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param datetime $updated
     * @return Invoice
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     * @return Invoice
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    public function addTag(Tag $tag)
    {
        if (false === $this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

}