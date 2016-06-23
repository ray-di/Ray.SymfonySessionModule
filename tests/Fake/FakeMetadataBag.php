<?php

namespace Ray\SymfonySessionModule;

use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;

class FakeMetadataBag extends MetadataBag
{
    public function getLifetime()
    {
        // 1day (in seconds)
        return 60 * 60 * 24;
    }

    public function getLastUsed()
    {
        // 2days ago
        return (new \DateTime)->sub(new \DateInterval('P2D'))->getTimestamp();
    }
}
