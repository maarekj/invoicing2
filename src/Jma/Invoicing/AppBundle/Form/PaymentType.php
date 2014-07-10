<?php

namespace Jma\Invoicing\AppBundle\Form;

use Jma\Invoicing\AppBundle\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaymentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'number', [])
            ->add('type', 'choice', [
                'required' => true,
                'choices' => [
                    Payment::TYPE_CARD => 'carte',
                    Payment::TYPE_CASH => 'cash',
                    Payment::TYPE_PAYPAL => 'paypal',
                    Payment::TYPE_TRANSFER => 'virement',
                    Payment::TYPE_CHECK => 'chèque',
                ]
            ])
            ->add('description', 'textarea', [])
            ->add('created', 'date', [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'required' => false,
            ]);

        $builder->get('amount')->resetViewTransformers();
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'Jma\Invoicing\AppBundle\Entity\Payment']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoicing_payment';
    }
}
