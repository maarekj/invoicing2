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
class ClientFilter extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'filter_text', array(
                    'condition_pattern' => FilterOperands::STRING_BOTH
                ))
                ->add('zipcode', 'filter_text', array(
                    'condition_pattern' => FilterOperands::STRING_BOTH
                ))
                ->add('legalForm', 'filter_text', array(
                    'condition_pattern' => FilterOperands::STRING_BOTH
                ))
        ;
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
        return 'invoicing_client_filter';
    }

}
