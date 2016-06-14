<?php

namespace OroCRM\Bundle\MagentoContactUsBundle\Migrations\Data\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadWorkflowData extends AbstractFixture implements ContainerAwareInterface
{
    /** @var ContainerInterface */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $configManager  = $this->container->get('oro_entity_config.config_manager');
        $configProvider = $configManager->getProvider('workflow');

        //todo change after BAP-10514 to active_workflows (investigate affections)
        $config = $configProvider->getConfig('OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest');
        $config->set(
            'active_workflow',
            'orocrm_contact_us_contact_request'
        );
        $configManager->persist($config);
        $configManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
