<?php

namespace Oro\Bundle\MagentoContactUsBundle;

use Oro\Bundle\MagentoContactUsBundle\DependencyInjection\Compiler\ContactRequestFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * The MagentoContactUsBundle bundle class.
 */
class OroMagentoContactUsBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ContactRequestFormPass());
    }
}
