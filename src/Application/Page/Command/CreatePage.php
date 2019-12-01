<?php

namespace N3ttech\Content\Application\Page\Command;

final class CreatePage extends Command
{
    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->setKey($key);
    }
}
