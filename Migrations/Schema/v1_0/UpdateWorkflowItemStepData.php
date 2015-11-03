<?php

namespace OroCRM\Bundle\MagentoContactUsBundle\Migrations\Schema\v1_0;

use Psr\Log\LoggerInterface;

use Doctrine\DBAL\Types\Type;

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
        // Delete unused transition logs.
        $sql = 'DELETE FROM oro_workflow_transition_log' .
               ' WHERE workflow_item_id IN (' .
                   'SELECT i.id FROM oro_workflow_item i' .
                   ' WHERE i.workflow_name = \'orocrm_contact_us_contact_request\'' .
               ')' .
               ' AND transition IN (\'send_email\',\'log_call\')';
        $this->logQuery($logger, $sql);
        $this->connection->executeUpdate($sql);

        $openId = $this->getContactUsContactRequestOpenId($logger);
        $params = ['open_id' => $openId];
        $types  = ['open_id' => Type::INTEGER];

        // Update step_from_id for transition logs.
        $sql = 'UPDATE oro_workflow_transition_log' .
               ' SET step_from_id = :open_id' .
               ' WHERE step_from_id IN (' .
                   'SELECT s.id FROM oro_workflow_step s' .
                   ' WHERE s.workflow_name = \'orocrm_contact_us_contact_request\'' .
                   ' AND s.name = \'contacted\'' .
               ' )';
        $this->logQuery($logger, $sql, $params, $types);
        $this->connection->executeUpdate($sql, $params, $types);

        // Update current_step_id for workflow items.
        $sql = 'UPDATE oro_workflow_item' .
               ' SET current_step_id = :open_id' .
               ' WHERE workflow_name = \'orocrm_contact_us_contact_request\'' .
               ' AND current_step_id IN (' .
                   'SELECT s.id FROM oro_workflow_step s' .
                   ' WHERE s.workflow_name = \'orocrm_contact_us_contact_request\'' .
                   ' AND s.name = \'contacted\'' .
               ' )';
        $this->logQuery($logger, $sql, $params, $types);
        $this->connection->executeUpdate($sql, $params, $types);

        // Update workflow_step_id for orocrm_contactus_request.
        $sql = 'UPDATE orocrm_contactus_request ' .
               ' SET workflow_step_id = :open_id' .
               ' WHERE workflow_step_id IN (' .
                   'SELECT s.id FROM oro_workflow_step s' .
                   ' WHERE s.workflow_name = \'orocrm_contact_us_contact_request\'' .
                   ' AND s.name IN (\'contacted\')' .
               ' )';
        $this->logQuery($logger, $sql, $params, $types);
        $this->connection->executeUpdate($sql, $params, $types);
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return int
     */
    protected function getContactUsContactRequestOpenId(LoggerInterface $logger)
    {
        $sql = 'SELECT s.id FROM oro_workflow_step s' .
               ' WHERE s.workflow_name = \'orocrm_contact_us_contact_request\'' .
               ' AND s.name = \'open\'';
        $this->logQuery($logger, $sql);

        return $this->connection->fetchColumn($sql);
    }

}
