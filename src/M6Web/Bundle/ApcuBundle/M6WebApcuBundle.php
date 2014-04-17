<?php

namespace M6Web\Bundle\ApcuBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle class
 */
class M6WebApcuBundle extends Bundle
{
    /**
    * Allow bypassing the Bundle::getContainerExtension check on getAlias
    *
    * @return Object DependencyInjection\M6WebApcuExtension
     */
    public function getContainerExtension()
    {
        return new DependencyInjection\M6WebApcuExtension();
    }
}
