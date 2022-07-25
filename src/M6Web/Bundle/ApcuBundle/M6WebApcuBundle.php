<?php

namespace M6Web\Bundle\ApcuBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle class
 */
class M6WebApcuBundle extends Bundle
{
    /**
     * Allow bypassing the Bundle::getContainerExtension check on getAlias
     *
     * @return object DependencyInjection\M6WebApcuExtension
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DependencyInjection\M6WebApcuExtension();
    }
}
