<?php

namespace Fulcrum\Custom\Shortcode\Stub;

use Fulcrum\Custom\Shortcode\Shortcode;

class FooShortcode extends Shortcode
{
    public static $concreteConfig = [
        'autoload'  => true,
        'classname' => __CLASS__,
        'config'    => [
            'shortcode' => 'fooStub',
            'noView'    => true,
            'defaults'  => [
                'class' => 'foobar',
            ],
        ],
    ];

    protected function render()
    {
        return 'stubbed foo';
    }
}
