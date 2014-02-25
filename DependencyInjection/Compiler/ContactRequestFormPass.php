<?php

namespace OroCRM\Bundle\MagentoContactUsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ContactRequestFormPass implements CompilerPassInterface
{
    const HANDLER_SERVICE_ID = 'orocrm_contact_us.contact_request.form.handler';
    const FORM_SERVICE_ID    = 'orocrm_magento_contact_us.contact_request.form';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition(self::HANDLER_SERVICE_ID)) {
            $definition = $container->getDefinition(self::HANDLER_SERVICE_ID);
            $definition->replaceArgument(0, new Reference(self::FORM_SERVICE_ID));
        }
    }
}
