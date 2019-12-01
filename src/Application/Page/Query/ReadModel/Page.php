<?php

namespace N3ttech\Content\Application\Page\Query\ReadModel;

use N3ttech\Content\Domain\Model\Page\Page\Key;
use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Page implements Viewable
{
    /** @var Key */
    private $key;

    /** @var VO\Intl\Language\Texts */
    private $names;

    /** @var VO\Intl\Language\Contents */
    private $contents;

    /** @var VO\Identity\Uuids */
    private $sites;

    /**
     * @param string $key
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Page
     */
    public static function fromKey(string $key): Page
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
     * @return Page
     */
    public function setKey(Key $key): Page
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string[]
     */
    public function names(): array
    {
        return $this->names->raw();
    }

    /**
     * @return VO\Intl\Language\Texts
     */
    public function getNames(): VO\Intl\Language\Texts
    {
        return $this->names;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     *
     * @return Page
     */
    public function setNames(VO\Intl\Language\Texts $names): Page
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param string $locale
     * @param string $name
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Page
     */
    public function addName(string $locale, string $name): Page
    {
        if (null === $this->names) {
            $this->setNames(VO\Intl\Language\Texts::fromArray([]));
        }

        $this->names->addLocale($locale, $name);
    }

    /**
     * @return string[]
     */
    public function contents(): array
    {
        return $this->contents->raw();
    }

    /**
     * @return VO\Intl\Language\Contents
     */
    public function getContents(): VO\Intl\Language\Contents
    {
        return $this->contents;
    }

    /**
     * @param VO\Intl\Language\Contents $contents
     *
     * @return Page
     */
    public function setContents(VO\Intl\Language\Contents $contents): Page
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * @param string $locale
     * @param string $content
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Page
     */
    public function addContent(string $locale, string $content): Page
    {
        if (null === $this->contents) {
            $this->setContents(VO\Intl\Language\Contents::fromArray([]));
        }

        $this->contents->addLocale($locale, $content);
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
     * @return Page
     */
    public function setSites(VO\Identity\Uuids $sites): Page
    {
        $this->sites = $sites;

        return $this;
    }
}
