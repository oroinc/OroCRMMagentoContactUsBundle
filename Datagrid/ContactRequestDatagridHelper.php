<?php

namespace OroCRM\Bundle\ContactUsBundle\Datagrid;

use Doctrine\ORM\EntityManager;

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
}
