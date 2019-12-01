<?php

namespace N3ttech\Content\Application\News\Command;

final class CreateNews extends Command
{
    /**
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->setUuid($uuid);
    }
}
