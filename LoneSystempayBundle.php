<?php

namespace Lone\SystempayBundle;

use Lone\SystempayBundle\DependencyInjection\LoneSystempayExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LoneSystempayBundle extends Bundle {

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new LoneSystempayExtension();
        }
        return $this->extension;
    }

}
