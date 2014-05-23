<?php

namespace Jma\Invoicing\AppBundle\Form;

use Jma\Invoicing\AppBundle\Repository\EntrepreneurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('entrepreneur', 'entity', array(
                'class' => 'InvoicingAppBundle:Entrepreneur',
                'property' => 'username',
                'query_builder' => function(EntrepreneurRepository $repo) {
                        return $repo->builderAllRestrict();
                    }
            ))
            ->add('street')
            ->add('city')
            ->add('zipcode')
            ->add('complement')
            ->add('legalForm')
            ->add('more');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jma\Invoicing\AppBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoicing_client';
    }

}
