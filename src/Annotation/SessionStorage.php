<?php

namespace Ray\SymfonySessionModule\Annotation;

use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Target("METHOD")
 * @Qualifier
 */
final class SessionStorage
{
    public $value;
}
