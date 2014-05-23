<?php

namespace Jma\BootstrapBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;

/**
 * Description of Select2TypeExtension
 *
 * @author Maarek
 */
class Select2ChoiceTypeExtension extends AbstractTypeExtension
{

    public function getExtendedType()
    {
        return 'choice';
    }

}
