<?php

namespace N3ttech\Content\Application\Translation\Event;

use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

final class ExistingTranslationUpdated extends TranslationEvent
{
    /**
     * @return VO\Intl\Language\Contents
     *
     * @throws \Assert\AssertionFailedException
     */
    public function translationValues(): VO\Intl\Language\Contents
    {
        return VO\Intl\Language\Contents::fromArray($this->payload['values'] ?? []);
    }

    /**
     * @param Translation $translation
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $translation): void
    {
        $translation->setKey($this->translationKey());
        $translation->setValues($this->translationValues());
    }
}
