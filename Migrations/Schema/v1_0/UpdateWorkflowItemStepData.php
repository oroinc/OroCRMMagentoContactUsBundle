<?php

namespace OroCRM\Bundle\MagentoContactUsBundle\Migrations\Schema\v1_0;

use Psr\Log\LoggerInterface;

use Oro\Bundle\MigrationBundle\Migration\ParametrizedMigrationQuery;

class UpdateWorkflowItemStepData extends ParametrizedMigrationQuery
{
    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'Update steps for b2c_flow_order_follow_up workflow.';
    }

    /**
     * {@inheritdoc}
     */
    public function execute(LoggerInterface $logger)
    {
        // Update call and email steps.
        $sql = 'UPDATE oro_workflow_transition_log SET transition = \'convert_to_contacted\'' .
               ' WHERE workflow_item_id IN(' .
                   ' SELECT i.id FROM oro_workflow_item i' .
                   ' WHERE i.workflow_name = \'orocrm_contact_us_contact_request\'' .
               ') AND transition IN(' .
                    '\'send_email\',\'log_call\'' .
               ')';
        $this->logQuery($logger, $sql);
        $this->connection->executeUpdate($sql);

        // Update workflow items.
        $sql = 'UPDATE oro_workflow_item' .
               ' SET data = \'[]\'' .
               ' WHERE workflow_name = \'orocrm_contact_us_contact_request\'' .
               ' AND data <> \'[]\'';
        $this->logQuery($logger, $sql);
        $this->connection->executeUpdate($sql);
    }
}
