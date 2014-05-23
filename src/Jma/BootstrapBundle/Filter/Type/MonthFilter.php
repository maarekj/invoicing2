<?php

namespace Jma\BootstrapBundle\Filter\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\OptionsResolver\Options;

/**
 * Description of MonthFilter
 *
 * @author Maarek
 * 
 * @DI\FormType()
 */
class MonthFilter extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('month', 'choice', array(
            'choices' => $options['month_choices'],
            'empty_value' => ''
        ))->add('year', 'choice', array(
            'choices' => $options['year_choices'],
            'empty_value' => ''
        ));
    }

    protected function listYears($centerYear, $numberYear)
    {
        $result = array();

        foreach (range($centerYear - $numberYear / 2, $centerYear + $numberYear / 2) as $year) {
            $result[$year] = $year;
        }

        return $result;
    }

    protected function listMonths()
    {
        $result = array(
            '1' => 'Janvier',
            '2' => 'Février',
            '3' => 'Mars',
            '4' => 'Avril',
            '5' => 'Mai',
            '6' => 'Juin',
            '7' => 'Juillet',
            '8' => 'Août',
            '9' => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Decembre'
        );

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $self = $this;

        $resolver
                ->setDefaults(array(
                    'required' => false,
                    'data_extraction_method' => 'default',
                    'month_choices' => $this->listMonths(),
                    'number_year' => 30,
                    'number_year' => 30,
                    'center_year' => function(Options $options) {
                        $now = new \DateTime();
                        return (int) $now->format('Y');
                    },
                    'year_choices' => function(Options $options) use ($self) {
                        if ($options['center_year'] !== null && $options['number_year'] !== null) {
                            return $self->listYears($options['center_year'], $options['number_year']);
                        }
                    }
                ))
                ->setAllowedValues(array(
                    'data_extraction_method' => array('default'),
                ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'filter_month';
    }

}
