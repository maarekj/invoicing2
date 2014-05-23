<?php

namespace Jma\Invoicing\AppBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Jma\Invoicing\AppBundle\Entity\Client;
use Jma\Invoicing\AppBundle\Entity\Entrepreneur;
use Jma\Invoicing\AppBundle\Entity\Invoice;
use Jma\Invoicing\AppBundle\Entity\InvoiceLine;
use Jma\Invoicing\AppBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportV1Command extends ContainerAwareCommand
{
    protected $json;
    protected $labels = array();
    protected $entrepreneurs = array();
    protected $clients = array();
    protected $invoices = array();

    /**
     * @var OutputInterface
     */
    protected $output;

    protected function configure()
    {
        $this->setName("invoicing:importv1")
            ->addArgument("in", InputArgument::REQUIRED, "Le fichier json à importer");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $in = $input->getArgument("in");
        $this->json = json_decode(file_get_contents($in));
        $this->labels = array();

        foreach ($this->json->labels as $label) {
            $this->getOrCreateTag($label->id);
        }

        foreach ($this->json->entrepreneur as $entrepreneur) {
            $this->getOrCreateEntrepreneur($entrepreneur->id);
        }

        foreach ($this->json->clients as $client) {
            $this->getOrCreateClient($client->id);
        }

        foreach ($this->json->invoices as $invoice) {
            $this->getOrCreateInvoice($invoice->id);
        }

        $this->getEntityManager()->flush();
        $output->writeln("Import with success");
    }

    protected function getOrCreateTag($id)
    {
        if (false === isset($this->labels[$id])) {
            $labels = new ArrayCollection($this->json->labels);
            $label = $labels->filter(function ($label) use ($id) {
                return $label->id === $id;
            })->first();

            $tag = $this->getTagRepository()->createNew();
            /* @var $tag Tag */
            $tag->setLabel($label->title);
            $tag->setColor($label->color);
            $this->getEntityManager()->persist($tag);

            $this->output->writeln(sprintf("<info>Tag{label=%s; color=%s}</info>", $tag->getLabel(), $tag->getColor()));

            $this->labels[$id] = $tag;
        }

        return $this->labels[$id];
    }

    protected function getOrCreateEntrepreneur($id)
    {
        if (false === isset($this->entrepreneurs[$id])) {
            $entrepreneurs = new ArrayCollection($this->json->entrepreneur);
            $entrepreneur = $entrepreneurs->filter(function ($entrepreneur) use ($id) {
                return $entrepreneur->id === $id;
            })->first();

            $entity = $this->getEntrepreneurRepository()->createNew();
            /* @var $entity Entrepreneur */
            $entity
                ->setUsername($entrepreneur->firstname . " " . $entrepreneur->lastname)
                ->setFirstname($entrepreneur->firstname)
                ->setLastname($entrepreneur->lastname)
                ->setSiren($entrepreneur->siren)
                ->setSiret($entrepreneur->siret)
                ->setCity($entrepreneur->address_city)
                ->setStreet($entrepreneur->address_street)
                ->setZipcode($entrepreneur->address_zipcode)
                ->setComplement($entrepreneur->address_complement)
                ->setPhone($entrepreneur->telephone)
                ->setMore($entrepreneur->more);

            $this->getEntityManager()->persist($entity);

            $this->output->writeln(sprintf("<info>Entrepreneur{username=%s; ...}</info>", $entity->getUsername()));

            $this->entrepreneurs[$id] = $entity;
        }

        return $this->entrepreneurs[$id];
    }

    protected function getOrCreateClient($id)
    {
        if (false === isset($this->clients[$id])) {
            $clients = new ArrayCollection($this->json->clients);
            $client = $clients->filter(function ($client) use ($id) {
                return $client->id === $id;
            })->first();

            $entity = $this->getClientRepository()->createNew();
            /* @var $entity Client */
            $entity
                ->setEntrepreneur($this->getOrCreateEntrepreneur($client->entrepreneur_id))
                ->setName($client->name)
                ->setCity($client->address_city)
                ->setStreet($client->address_street)
                ->setZipcode($client->address_zipcode)
                ->setComplement($client->address_complement)
                ->setLegalForm($client->legal_form)
                ->setMore($client->more);

            $this->getEntityManager()->persist($entity);

            $this->output->writeln(sprintf("<info>Client{name=%s; ...}</info>", $entity->getName()));

            $this->clients[$id] = $entity;
        }

        return $this->clients[$id];
    }

    protected function getOrCreateInvoice($id)
    {
        if (false === isset($this->clients[$id])) {
            $invoices = new ArrayCollection($this->json->invoices);
            $invoice = $invoices->filter(function ($invoice) use ($id) {
                return $invoice->id === $id;
            })->first();

            $entity = $this->getInvoiceRepository()->createNew();
            /* @var $entity Invoice */
            $entity
                ->setEntrepreneur($this->getOrCreateEntrepreneur($invoice->entrepreneur_id))
                ->setClient($this->getOrCreateClient($invoice->client_id))
                ->addTag($this->getOrCreateTag($invoice->label_id))
                ->setCreated(new \DateTime($invoice->created_at))
                ->setUpdated(new \DateTime($invoice->updated_at))
                ->setFooter($invoice->footer)
                ->setNumber($invoice->number);

            foreach ($invoice->Items as $position => $item) {
                $line = new InvoiceLine();
                $line
                    ->setDescription($item->description)
                    ->setQuantity((float)$item->quantity)
                    ->setUnitPrice((float)$item->unit_price)
                    ->setPosition($position)
                    ->setOptions($item->options)
                    ->setUnit($item->unit);
                $entity->addLine($line);
            }

            $this->getEntityManager()->persist($entity);

            $this->output->writeln(sprintf("<info>Invoice{number=%s; ...}</info>", $entity->getNumber()));

            $this->clients[$id] = $entity;
        }

        return $this->clients[$id];
    }


    /**
     * @return \Jma\Invoicing\AppBundle\Repository\TagRepository
     */
    protected function getTagRepository()
    {
        return $this->getContainer()->get("invoicing.repository.tag");
    }

    /**
     * @return \Jma\Invoicing\AppBundle\Repository\EntrepreneurRepository
     */
    protected function getEntrepreneurRepository()
    {
        return $this->getContainer()->get("invoicing.repository.entrepreneur");
    }

    /**
     * @return \Jma\Invoicing\AppBundle\Repository\ClientRepository
     */
    protected function getClientRepository()
    {
        return $this->getContainer()->get("invoicing.repository.client");
    }

    /**
     * @return \Jma\Invoicing\AppBundle\Repository\InvoiceRepository
     */
    protected function getInvoiceRepository()
    {
        return $this->getContainer()->get("invoicing.repository.invoice");
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get("doctrine.orm.entity_manager");
    }
} 