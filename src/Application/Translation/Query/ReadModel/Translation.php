<?php

namespace N3ttech\Content\Application\Translation\Query\ReadModel;

use N3ttech\Content\Domain\Model\Translation\Translation\Key;
use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Translation implements Viewable
{
    /** @var Key */
    private $key;

    /** @var VO\Intl\Language\Contents */
    private $values;

    /** @var VO\Identity\Uuids */
    private $sites;

    /**
     * @param string $key
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Translation
     */
    public static function fromKey(string $key): Translation
    {
        $entry = new static();

        return $entry->setKey(Key::fromString($key));
    }

    /**
     * @return string
     */
    public function identifier()
    {
        return $this->key->toString();
    }

    /**
     * @return Key
     */
    public function getKey(): Key
    {
        return $this->key;
    }

    /**
     * @param Key $key
     *
     * @return Translation
     */
    public function setKey(Key $key): Translation
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string[]
     */
    public function values(): array
    {
        return $this->values->raw();
    }

    /**
     * @return VO\Intl\Language\Contents
     */
    public function getValues(): VO\Intl\Language\Contents
    {
        return $this->values;
    }

    /**
     * @param VO\Intl\Language\Contents $values
     *
     * @return Translation
     */
    public function setValues(VO\Intl\Language\Contents $values): Translation
    {
        $this->values = $values;

        return $this;
    }

    /**
     * @param string $locale
     * @param string $content
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Translation
     */
    public function addValue(string $locale, string $content): Translation
    {
        if (null === $this->values) {
            $this->setValues(VO\Intl\Language\Contents::fromArray([]));
        }

        $this->values->addLocale($locale, $content);
    }

    /**
     * @return array
     */
    public function sites(): array
    {
        return $this->sites->toArray();
    }

    /**
     * @return VO\Identity\Uuids
     */
    public function getSites(): VO\Identity\Uuids
    {
        return $this->sites;
    }

    /**
     * @param VO\Identity\Uuids $sites
     *
     * @return Translation
     */
    public function setSites(VO\Identity\Uuids $sites): Translation
    {
        $this->sites = $sites;

        return $this;
    }
}
