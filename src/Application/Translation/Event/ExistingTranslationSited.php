<?php

namespace N3ttech\Content\Application\Translation\Event;

use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

final class ExistingTranslationSited extends TranslationEvent
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return VO\Identity\Uuids
     */
    public function translationSites(): VO\Identity\Uuids
    {
        return VO\Identity\Uuids::fromArray($this->payload['sites'] ?? []);
    }

    /**
     * @param Translation $translation
     *
     * @throws \Assert\AssertionFailedException
     */
    public function populate(AggregateRoot $translation): void
    {
        $translation->setKey($this->translationKey());
        $translation->setSites($this->translationSites());
    }
}
