<?php

namespace OroCRM\Bundle\MagentoContactUsBundle\Datagrid;

use Doctrine\ORM\EntityManager;

use Oro\Bundle\DataGridBundle\Event\BuildBefore;
use Oro\Bundle\DataGridBundle\Extension\Formatter\Configuration;
use Oro\Bundle\WorkflowBundle\Entity\WorkflowStep;

class ContactRequestDatagridHelper
{
    /**
     * Change columns sort order
     *
     * @param BuildBefore $event
     */
    public function buildBefore(BuildBefore $event)
    {
        $columns = $event->getConfig()->offsetGetOr(Configuration::COLUMNS_KEY, []);

        $createdAt = $columns['createdAt'];
        unset($columns['createdAt']);
        $columns['createdAt'] = $createdAt;

        $event->getConfig()->offsetSet(Configuration::COLUMNS_KEY, $columns);
    }
}
