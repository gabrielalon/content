<?php

namespace N3ttech\Content\Application\Blog\Query\ReadModel;

use N3ttech\Messaging\Query\Query\Viewable;
use N3ttech\Valuing as VO;

class Entry implements Viewable
{
    /** @var VO\Identity\Uuid */
    private $uuid;

    /** @var VO\Date\Time */
    private $creationDate;

    /** @var VO\Date\Time */
    private $releaseDate;

    /** @var VO\Option\Check */
    private $hidden;

    /** @var VO\Intl\Language\Texts */
    private $names;

    /** @var VO\Intl\Language\Contents */
    private $contents;

    /** @var VO\Identity\Uuids */
    private $categories;

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return Entry
     */
    public static function fromUuid(string $uuid): Entry
    {
        $entry = new static();

        return $entry->setUuid(VO\Identity\Uuid::fromIdentity($uuid));
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
     * @return Entry
     */
    public function setUuid(VO\Identity\Uuid $uuid): Entry
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return string
     */
    public function creationDate(): string
    {
        return $this->creationDate->toString();
    }

    /**
     * @return VO\Date\Time
     */
    public function getCreationDate(): VO\Date\Time
    {
        return $this->creationDate;
    }

    /**
     * @param VO\Date\Time $creationDate
     *
     * @return Entry
     */
    public function setCreationDate(VO\Date\Time $creationDate): Entry
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function releaseDate(): \DateTime
    {
        return date_timestamp_set(date_create(), $this->releaseDate->raw());
    }

    /**
     * @return VO\Date\Time
     */
    public function getReleaseDate(): VO\Date\Time
    {
        return $this->releaseDate;
    }

    /**
     * @param VO\Date\Time $releaseDate
     *
     * @return Entry
     */
    public function setReleaseDate(VO\Date\Time $releaseDate): Entry
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden->raw();
    }

    /**
     * @return VO\Option\Check
     */
    public function getHidden(): VO\Option\Check
    {
        return $this->hidden;
    }

    /**
     * @param VO\Option\Check $hidden
     *
     * @return Entry
     */
    public function setHidden(VO\Option\Check $hidden): Entry
    {
        $this->hidden = $hidden;

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
     * @return Entry
     */
    public function setNames(VO\Intl\Language\Texts $names): Entry
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
     * @return Entry
     */
    public function addName(string $locale, string $name): Entry
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
     * @return Entry
     */
    public function setContents(VO\Intl\Language\Contents $contents): Entry
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
     * @return Entry
     */
    public function addContent(string $locale, string $content): Entry
    {
        if (null === $this->contents) {
            $this->setNames(VO\Intl\Language\Texts::fromArray([]));
        }

        $this->contents->addLocale($locale, $content);
    }

    /**
     * @return array
     */
    public function categories(): array
    {
        return $this->categories->toArray();
    }

    /**
     * @return VO\Identity\Uuids
     */
    public function getCategories(): VO\Identity\Uuids
    {
        return $this->categories;
    }

    /**
     * @param VO\Identity\Uuids $categories
     *
     * @return Entry
     */
    public function setCategories(VO\Identity\Uuids $categories): Entry
    {
        $this->categories = $categories;

        return $this;
    }
}
