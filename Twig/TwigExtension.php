<?php

namespace Lone\SystempayBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return [new TwigFunction('systempayFields', [$this, 'systempayFields'])];
    }

    public function systempayFields($fields)
    {
        $inputs = '';
        foreach ($fields as $field => $value)
            $inputs .= sprintf('<input type="hidden" name="%s" value="%s">', $field, $value);
        return $inputs;
    }

}
