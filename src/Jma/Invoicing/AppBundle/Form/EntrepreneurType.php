<?php

namespace Jma\Invoicing\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntrepreneurType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('firstname')
            ->add('lastname')
            ->add('siren')
            ->add('siret')
            ->add('street')
            ->add('city')
            ->add('zipcode')
            ->add('complement')
            ->add('phone')
            ->add('more')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jma\Invoicing\AppBundle\Entity\Entrepreneur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoicing_entrepreneur';
    }
}
