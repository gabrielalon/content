<?php

namespace N3ttech\Content\Application\Blog\Query\ReadModel;

use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Category implements Viewable
{
    /** @var VO\Identity\Uuid */
    private $uuid;

    /** @var VO\Intl\Language\Texts */
    private $names;

    /** @var VO\Identity\Uuids */
    private $sites;

    /** @var VO\Identity\Uuid */
    private $parental;

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Category
     */
    public static function fromUuid(string $uuid): Category
    {
        $category = new static();

        return $category->setUuid(VO\Identity\Uuid::fromIdentity($uuid));
    }

    /**
     * @return string
     */
    public function identifier()
    {
        return $this->uuid->toString();
    }

    /**
     * @return VO\Identity\Uuid
     */
    public function getUuid(): VO\Identity\Uuid
    {
        return $this->uuid;
    }

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Category
     */
    public function setUuid(VO\Identity\Uuid $uuid): Category
    {
        $this->uuid = $uuid;

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
     * @return Category
     */
    public function setNames(VO\Intl\Language\Texts $names): Category
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
     * @return Category
     */
    public function addName(string $locale, string $name): Category
    {
        if (null === $this->names) {
            $this->setNames(VO\Intl\Language\Texts::fromArray([]));
        }

        $this->names->addLocale($locale, $name);
    }

    /**
     * @return string[]
     */
    public function sites(): array
    {
        return $this->sites->raw();
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
     * @return Category
     */
    public function setSites(VO\Identity\Uuids $sites): Category
    {
        $this->sites = $sites;

        return $this;
    }

    /**
     * @return string
     */
    public function parental(): string
    {
        return $this->parental->toString();
    }

    /**
     * @return VO\Identity\Uuid
     */
    public function getParental(): VO\Identity\Uuid
    {
        return $this->parental;
    }

    /**
     * @param VO\Identity\Uuid $parental
     *
     * @return Category
     */
    public function setParental(VO\Identity\Uuid $parental): Category
    {
        $this->parental = $parental;

        return $this;
    }
}
