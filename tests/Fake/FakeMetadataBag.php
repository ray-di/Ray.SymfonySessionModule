<?php

namespace Ray\SymfonySessionModule;

use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;

class FakeMetadataBag extends MetadataBag
{
    public function getLifetime()
    {
        // 1 day (in seconds)
        return 60 * 60 * 24;
    }

    public function getLastUsed()
    {
        // 2 days ago
        return (new \DateTime)->sub(new \DateInterval('P2D'))->getTimestamp();
    }
}
