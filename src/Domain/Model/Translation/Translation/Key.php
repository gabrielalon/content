<?php

namespace N3ttech\Content\Domain\Model\Translation\Translation;

use Assert\Assertion;
use N3ttech\Valuing as VO;
use N3ttech\Valuing\Identity\AggregateId;
use Underscore\Types\Strings;

final class Key extends VO\VO implements VO\Char\Char, AggregateId
{
    /**
     * @param string $key
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Key
     */
    public static function fromString(string $key): Key
    {
        return new self($key);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($key): void
    {
        Assertion::string($key, 'Invalid Key string: '.$key);
        Assertion::maxLength(
            $key,
            $this->maxLength(),
            sprintf('Invalid Key string length (%d)', $this->maxLength())
        );
    }

    /**
     * @return int
     */
    protected function maxLength(): int
    {
        return pow(2, 8);
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value): void
    {
        $trimmed = trim($value);
        $lowered = Strings::lower($trimmed);

        parent::setValue(Strings::toSnakeCase($lowered));
    }
}
