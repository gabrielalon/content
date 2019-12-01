<?php

use N3ttech\Content\Application\Translation;

return [
    Translation\Event\ExistingTranslationRemoved::class => [\N3ttech\Content\Domain\Model\Translation\Projection\TranslationProjection::class],
    Translation\Event\ExistingTranslationUpdated::class => [\N3ttech\Content\Domain\Model\Translation\Projection\TranslationProjection::class],
    Translation\Event\ExistingTranslationSited::class => [\N3ttech\Content\Domain\Model\Translation\Projection\TranslationProjection::class],
    Translation\Event\NewTranslationCreated::class => [\N3ttech\Content\Domain\Model\Translation\Projection\TranslationProjection::class],
];
