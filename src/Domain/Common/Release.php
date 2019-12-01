<?php

namespace N3ttech\Content\Domain\Common;

use Assert\Assertion;
use N3ttech\Valuing as VO;

class Release extends VO\VO
{
    /** @var VO\Date\Time */
    private $releaseDate;

    /** @var VO\Option\Check */
    private $hidden;

    /**
     * @param int $releaseDate
     *
     * @return Release
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function fromDate(int $releaseDate): Release
    {
        return self::fromData($releaseDate, false);
    }

    /**
     * @param bool $hidden
     *
     * @return Release
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function fromBoolean(bool $hidden): Release
    {
        return self::fromData(time(), $hidden);
    }

    /**
     * @param int  $releaseDate
     * @param bool $hidden
     *
     * @return Release
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function fromData(int $releaseDate, bool $hidden): Release
    {
        return self::fromArray(['release_date' => $releaseDate, 'hidden' => $hidden]);
    }

    /**
     * @param array $data
     *
     * @return Release
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): Release
    {
        return new static($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($value): void
    {
        Assertion::isArray($value, 'Invalid Release array');
        Assertion::keyIsset($value, 'release_date', 'Invalid Release array');
        Assertion::keyIsset($value, 'hidden', 'Invalid Release array');
    }

    /**
     * @param Release $other
     *
     * @return bool
     */
    public function equals($other): bool
    {
        if (false == $other instanceof self) {
            return false;
        }

        return
            $this->releaseDate->equals($other->releaseDate())
            &&
            $this->hidden->equals($other->hidden())
        ;
    }

    /**
     * @return array
     */
    public function raw(): array
    {
        return [
            'release_date' => $this->releaseDate->raw(),
            'hidden' => $this->hidden->raw(),
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    protected function setValue($data): void
    {
        $this->releaseDate = VO\Date\Time::fromTimestamp($data['release_date']);
        $this->hidden = VO\Option\Check::fromBoolean($data['hidden']);
    }

    /**
     * @return VO\Date\Time
     */
    public function releaseDate(): VO\Date\Time
    {
        return $this->releaseDate;
    }

    /**
     * @return VO\Option\Check
     */
    public function hidden(): VO\Option\Check
    {
        return $this->hidden;
    }
}
