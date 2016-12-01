<?php

namespace Oro\Bundle\MagentoContactUsBundle\Migrations\Data\ORM;

use Oro\Bundle\DemoDataBundle\Migrations\Data\ORM\LoadAclRolesData;

/**
 * Loads orocrm_contact_us_contact_request workflow ACL data
 */
class LoadWorkflowAclData extends LoadAclRolesData
{
    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            'Oro\Bundle\DemoDataBundle\Migrations\Data\ORM\LoadRolesData',
            'Oro\Bundle\MagentoContactUsBundle\Migrations\Data\ORM\LoadWorkflowData'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getDataPath()
    {
        return '@OroMagentoContactUsBundle/Migrations/Data/ORM/CrmRoles/workflows.yml';
    }
}
