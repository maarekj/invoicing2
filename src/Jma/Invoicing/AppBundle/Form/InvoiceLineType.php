<?php

namespace Jma\Invoicing\AppBundle\Form;

use Jma\Invoicing\AppBundle\Entity\InvoiceLine;
use Jma\Invoicing\AppBundle\Repository\ClientRepository;
use Jma\Invoicing\AppBundle\Repository\EntrepreneurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InvoiceLineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text', ['required' => true])
            ->add('quantity', 'number', ['required' => true])
            ->add('unitPrice', 'number', ['required' => true])
            ->add('options', 'choice', array(
                'required' => true,
                'choices' => [
                    InvoiceLine::OPTIONS_POSITIVE => "+",
                    InvoiceLine::OPTIONS_NEGATIVE => "-",
                    InvoiceLine::OPTIONS_FREE => "offert",
                ]
            ))
            ->add('unit', 'text', ['required' => true])
            ->add('position', 'integer', ['required' => true]);

        $builder->get('quantity')->resetViewTransformers();
        $builder->get('unitPrice')->resetViewTransformers();
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(['data_class' => 'Jma\Invoicing\AppBundle\Entity\InvoiceLine']);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'invoicing_invoice_line';
    }
}
