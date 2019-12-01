<?php

namespace N3ttech\Content\Domain\Common;

use Assert\Assertion;
use N3ttech\Valuing as VO;

class Content extends VO\VO
{
    /** @var VO\Intl\Language\Texts */
    private $names;

    /** @var VO\Intl\Language\Contents */
    private $texts;

    /**
     * @param array $names
     * @param array $texts
     *
     * @return Content
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function fromData(array $names, array $texts = []): Content
    {
        return self::fromArray([
            'names' => $names,
            'texts' => $texts,
        ]);
    }

    /**
     * @param array $data
     *
     * @return Content
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function fromArray(array $data): Content
    {
        return new self($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($value): void
    {
        Assertion::isArray($value, 'Invalid Content array');
        Assertion::keyIsset($value, 'names', 'Invalid Content array');
        Assertion::keyIsset($value, 'texts', 'Invalid Content array');
    }

    /**
     * @param Content $other
     *
     * @return bool
     */
    public function equals($other): bool
    {
        if (false == $other instanceof self) {
            return false;
        }

        return
            $this->names->equals($other->names())
            &&
            $this->texts->equals($other->texts())
        ;
    }

    /**
     * @return array
     */
    public function raw(): array
    {
        return [
            'names' => $this->names->raw(),
            'texts' => $this->texts->raw(),
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    protected function setValue($data): void
    {
        $this->names = VO\Intl\Language\Texts::fromArray($data['names']);
        $this->texts = VO\Intl\Language\Contents::fromArray($data['texts']);
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function name(string $locale): string
    {
        return $this->names->getLocale($locale)->toString();
    }

    /**
     * @return VO\Intl\Language\Texts
     */
    public function names(): VO\Intl\Language\Texts
    {
        return $this->names;
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function text(string $locale): string
    {
        return $this->texts->getLocale($locale)->toString();
    }

    /**
     * @return VO\Intl\Language\Contents
     */
    public function texts(): VO\Intl\Language\Contents
    {
        return $this->texts;
    }
}
