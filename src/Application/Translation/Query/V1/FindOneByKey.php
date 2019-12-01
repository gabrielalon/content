<?php

namespace N3ttech\Content\Application\Translation\Query\V1;

final class FindOneByKey extends Query
{
    /** @var string */
    private $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
