<?php

namespace Jma\BootstrapBundle\Serializer;

use JMS\Serializer\GraphNavigator;
use JMS\Serializer\JsonSerializationVisitor;
use Pagerfanta\Pagerfanta;
use JMS\Serializer\Context;

/**
 * Description of PagerfantaHandler
 *
 * @author Maarek
 */
class PagerfantaHandler
{
    /**
     * @var string type 
     */
    private $type;

 
    /**
     * @param type $type Le type de la sérialisation.
     * Peut être "full" ou "default"
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    public function serializePagerfantaToJson(JsonSerializationVisitor $visitor, Pagerfanta $pager, array $type, Context $context)
    {
        // We change the base type, and pass through possible parameters.
        $type['name'] = 'array';

        $items = iterator_to_array($pager->getIterator());

        $array = $items;

        if ($this->type === 'full') {
            $array = array(
                'items' => $items,
                'currentPage' => $pager->getCurrentPage(),
                'nbPages' => $pager->getNbPages(),
                'maxPerPage' => $pager->getMaxPerPage(),
                'nbResults' => $pager->getNbResults(),
            );
        }

        return $visitor->visitArray($array, $type, $context);
    }

}