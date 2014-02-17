<?php

namespace OroCRM\Bundle\MagentoContactUsBundle\Datagrid;

use Doctrine\ORM\EntityManager;

use Oro\Bundle\DataGridBundle\Event\BuildBefore;
use Oro\Bundle\DataGridBundle\Extension\Formatter\Configuration;
use Oro\Bundle\WorkflowBundle\Entity\WorkflowStep;

class ContactRequestDatagridHelper
{
    /** @var EntityManager */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return callable
     */
    public function getStatusChoices()
    {
        $steps = $this->em->getRepository('OroWorkflowBundle:WorkflowStep')
            ->findByRelatedEntityByName('OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest');

        $choices = array_map(
            function (WorkflowStep $workflowStep) {
                return $workflowStep->getLabel();
            },
            $steps
        );

        return $choices;
    }

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
