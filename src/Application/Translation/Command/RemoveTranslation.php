<?php

namespace N3ttech\Content\Application\Translation\Command;

final class RemoveTranslation extends Command
{
    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->setKey($key);
    }
}
