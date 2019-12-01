<?php

use N3ttech\Content\Application\Page;

return [
    Page\Event\ExistingPageRemoved::class => [\N3ttech\Content\Domain\Model\Page\Projection\PageProjection::class],
    Page\Event\ExistingPageTranslated::class => [\N3ttech\Content\Domain\Model\Page\Projection\PageProjection::class],
    Page\Event\ExistingPageSited::class => [\N3ttech\Content\Domain\Model\Page\Projection\PageProjection::class],
    Page\Event\NewPageCreated::class => [\N3ttech\Content\Domain\Model\Page\Projection\PageProjection::class],
];
