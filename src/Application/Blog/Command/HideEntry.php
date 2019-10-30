<?php

namespace N3ttech\Content\Application\Blog\Command;

class HideEntry extends Command
{
    /**
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->setUuid($uuid);
    }
}
