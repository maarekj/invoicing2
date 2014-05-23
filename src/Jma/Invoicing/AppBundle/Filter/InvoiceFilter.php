<?php

namespace Jma\Invoicing\AppBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\FormType;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

/**
 * @FormType
 */
class InvoiceFilter extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', 'filter_text', array(
                'condition_pattern' => FilterOperands::STRING_BOTH
            ))
            ->add('client', 'filter_entity', array(
                'required' => false,
                'class' => 'InvoicingAppBundle:Client',
                'property' => 'name',
                'label' => 'Client',
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'validation_groups' => array('filtering')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoicing_invoice_filter';
    }

}
