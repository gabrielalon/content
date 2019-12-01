<?php

namespace N3ttech\Content\Application\Translation\Command;

final class CreateTranslation extends Command
{
    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->setKey($key);
    }
}
