<?php

namespace OroCRM\Bundle\MagentoContactUsBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use OroCRM\Bundle\MagentoContactUsBundle\DependencyInjection\Compiler\ContactRequestFormPass;

class OroCRMMagentoContactUsBundle extends Bundle
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
