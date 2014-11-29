<?php

namespace Tlconseil\SystempayBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class TwigExtension
 * @package Tlconseil\SystempayBundle\Twig
 */
class TwigExtension extends Twig_Extension
{
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('systempayForm', array($this, 'systempayForm')),
        );
    }

    /**
     * @param $fields
     * @return string
     */
    public function systempayForm($fields)
    {
        $inputs = '';
        foreach ($fields as $field => $value)
            $inputs .= sprintf('<input type="hidden" name="%s" value="%s">', $field, $value);
        return $inputs;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'systempay_twig_extension';
    }
}