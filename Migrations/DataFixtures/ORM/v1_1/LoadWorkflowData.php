<?php

namespace OroCRM\Bundle\MagentoContactUsBundle\Migrations\DataFixtures\ORM\v1_1;

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
        $configProvider = $this->container->get('oro_entity_config.provider.workflow');

        $config = $configProvider->getConfig('OroCRM\Bundle\ContactUsBundle\Entity\ContactRequest');
        $config->set(
            'active_workflow',
            'orocrm_contact_us_contact_request'
        );
        $configProvider->persist($config);
        $configProvider->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
