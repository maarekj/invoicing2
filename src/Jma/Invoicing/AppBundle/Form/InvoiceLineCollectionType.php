<?php

namespace Jma\Invoicing\AppBundle\Form;

use Jma\Invoicing\AppBundle\Repository\ClientRepository;
use Jma\Invoicing\AppBundle\Repository\EntrepreneurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceLineCollectionType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'type' => "invoicing_invoice_line",
            'prototype' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'horizontal_input_wrapper_class' => 'col-sm-9',
            'options' => array(
                'horizontal' => false,
                'label_render' => false,
                'horizontal_input_wrapper_class' => false,
            ),
        ));
    }

    public function getParent()
    {
        return 'collection';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoicing_invoice_line_collection';
    }
}
