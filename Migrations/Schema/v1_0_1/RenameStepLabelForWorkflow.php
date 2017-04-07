<?php

namespace Oro\Bundle\MagentoBundle\Migrations\Schema\v1_0_1;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\ParametrizedSqlMigrationQuery;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class RenameStepLabelForWorkflow implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $sql = 'UPDATE oro_workflow_step' .
            ' SET label = :label' .
            ' WHERE workflow_name = :workflow_name'.
            ' AND  name = :name';

        $queries->addQuery(
            new ParametrizedSqlMigrationQuery(
                $sql,
                [
                    'workflow_name' => 'orocrm_contact_us_contact_request',
                    'name' => 'converted_to_opportunity',
                    'label' => 'Converted to Opportunity'
                ]
            )
        );

        $queries->addQuery(
            new ParametrizedSqlMigrationQuery(
                $sql,
                [
                    'workflow_name' => 'orocrm_contact_us_contact_request',
                    'name' => 'converted_to_lead',
                    'label' => 'Converted to Lead'
                ]
            )
        );
    }
}
