<?php

namespace OroCRM\Bundle\MagentoContactUsBundle;

use OroCRM\Bundle\MagentoContactUsBundle\DependencyInjection\Compiler\ContactRequestFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OroCRMMagentoContactUsBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ContactRequestFormPass());

        parent::build($container);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'OroCRMContactUsBundle';
    }
}
