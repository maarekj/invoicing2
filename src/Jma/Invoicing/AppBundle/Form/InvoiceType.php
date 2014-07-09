<?php

namespace Jma\Invoicing\AppBundle\Form;

use Jma\Invoicing\AppBundle\Repository\ClientRepository;
use Jma\Invoicing\AppBundle\Repository\EntrepreneurRepository;
use Jma\Invoicing\AppBundle\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', 'number', [])
            ->add('entrepreneur', 'entity', [
                'class' => 'InvoicingAppBundle:Entrepreneur',
                'property' => 'username',
                'query_builder' => function (EntrepreneurRepository $repository) {
                    return $repository->builderAllRestrict();
                }
            ])
            ->add('client', 'select2_entity', [
                'class' => 'InvoicingAppBundle:Client',
                'property' => 'name',
                'query_builder' => function (ClientRepository $repository) {
                    return $repository->builderAllRestrictByCurrentEntrepreneur();
                }
            ])
            ->add('tags', 'select2_entity', [
                'class' => 'InvoicingAppBundle:Tag',
                'property' => 'label',
                'multiple' => true,
                'query_builder' => function (TagRepository $repository) {
                    return $repository->builderAllRestrictByCurrentEntrepreneur();
                }
            ])
            ->add('created', 'date', [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('footer', 'textarea', [
                'required' => false
            ])
            ->add('lines', 'invoicing_invoice_line_collection', [])
            ->add('payments', 'invoicing_payment_collection', []);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Jma\Invoicing\AppBundle\Entity\Invoice'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoicing_invoice';
    }
}
