<?php

namespace Oro\Bundle\MagentoContactUsBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Oro\Bundle\MigrationBundle\Migration\ParametrizedMigrationQuery;
use Psr\Log\LoggerInterface;

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
        $params = [
            'workflow_name' => 'orocrm_contact_us_contact_request',
            'transitions'   => ['send_email', 'log_call']
        ];
        $types = [
            'workflow_name' => Type::STRING,
            'transitions'   => Connection::PARAM_STR_ARRAY
        ];
        $sql = 'DELETE FROM oro_workflow_transition_log' .
               ' WHERE workflow_item_id IN (' .
                   'SELECT i.id FROM oro_workflow_item i' .
                   ' WHERE i.workflow_name = :workflow_name' .
               ')' .
               ' AND transition IN (:transitions)';
        $this->logQuery($logger, $sql, $params, $types);
        $this->connection->executeUpdate($sql, $params, $types);

        $openId = $this->getContactUsContactRequestOpenId($logger);
        $params = [
            'open_id'       => $openId,
            'workflow_name' => 'orocrm_contact_us_contact_request',
            'name'          => 'contacted'
        ];
        $types = [
            'open_id'       => Type::INTEGER,
            'workflow_name' => Type::STRING,
            'name'          => Type::STRING
        ];

        // Update step_from_id for transition logs.
        $sql = 'UPDATE oro_workflow_transition_log' .
               ' SET step_from_id = :open_id' .
               ' WHERE step_from_id IN (' .
                   'SELECT s.id FROM oro_workflow_step s' .
                   ' WHERE s.workflow_name = :workflow_name' .
                   ' AND s.name = :name' .
               ' )';
        $this->logQuery($logger, $sql, $params, $types);
        $this->connection->executeUpdate($sql, $params, $types);

        // Update current_step_id for workflow items.
        $sql = 'UPDATE oro_workflow_item' .
               ' SET current_step_id = :open_id' .
               ' WHERE workflow_name = :workflow_name' .
               ' AND current_step_id IN (' .
                   'SELECT s.id FROM oro_workflow_step s' .
                   ' WHERE s.workflow_name = :workflow_name' .
                   ' AND s.name = :name' .
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
        $params = [
            'workflow_name' => 'orocrm_contact_us_contact_request',
            'name'          => 'open'
        ];
        $types  = [
            'workflow_name' => Type::STRING,
            'name'          => Type::STRING
        ];
        $sql = 'SELECT s.id FROM oro_workflow_step s' .
               ' WHERE s.workflow_name = :workflow_name' .
               ' AND s.name = :name';
        $this->logQuery($logger, $sql, $params, $types);

        return $this->connection->fetchColumn($sql, $params, 0, $types);
    }
}
