<?php

namespace N3ttech\Content\Application\Translation\Event;

use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Messaging\Aggregate\AggregateRoot;

final class ExistingTranslationRemoved extends TranslationEvent
{
    /**
     * @param Translation $translation
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $translation): void
    {
        $translation->setKey($this->translationKey());
    }
}
