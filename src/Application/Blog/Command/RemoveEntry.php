<?php

namespace N3ttech\Content\Application\Blog\Command;

final class RemoveEntry extends Command
{
    /**
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->setUuid($uuid);
    }
}
