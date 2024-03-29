<?php

declare(strict_types=1);

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
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DependencyInjection\M6WebApcuExtension();
    }
}
