<?php

namespace Oro\Bundle\MagentoContactUsBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Oro\Bundle\MagentoContactUsBundle\DependencyInjection\Compiler\ContactRequestFormPass;

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

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'OroCRMContactUsBundle';
    }
}
