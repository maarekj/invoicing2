<?php

namespace Jma\BootstrapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Description of Select2EntityType
 *
 * @author Maarek
 */
class Select2EntityType extends AbstractType
{

    public function getName()
    {
        return 'select2_entity';
    }

    public function getParent()
    {
        return 'entity';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['select2_config'] = $options['select2_config'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'select2_config' => array(),
        ));
    }

}
