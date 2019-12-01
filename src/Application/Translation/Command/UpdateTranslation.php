<?php

namespace N3ttech\Content\Application\Translation\Command;

final class UpdateTranslation extends Command
{
    /** @var string[] */
    private $values;

    /**
     * @param string   $key
     * @param string[] $values
     */
    public function __construct(string $key, array $values)
    {
        $this->setKey($key);
        $this->values = $values;
    }

    /**
     * @return string[]
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
