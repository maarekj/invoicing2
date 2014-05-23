<?php

namespace Jma\Invoicing\AppBundle\Form;

use Jma\Invoicing\AppBundle\Repository\EntrepreneurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class TagType extends AbstractType
{
    /**
     * @var SecurityContext
     */
    protected $security;

    function __construct($security)
    {
        $this->security = $security;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entrepreneurRequired = !$this->security->isGranted("ROLE_ADMIN");

        $builder
            ->add('label')
            ->add('color')
            ->add('entrepreneur', 'entity', array(
                'required' => $entrepreneurRequired,
                'class' => 'InvoicingAppBundle:Entrepreneur',
                'property' => 'username',
                'query_builder' => function (EntrepreneurRepository $repo) {
                    return $repo->builderAllRestrict();
                }
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jma\Invoicing\AppBundle\Entity\Tag'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoicing_tag';
    }

}
